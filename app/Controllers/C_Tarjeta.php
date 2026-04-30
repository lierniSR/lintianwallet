<?php

namespace App\Controllers;

use App\Models\M_Cuentas;
use App\Models\M_Usuario;
use App\Models\M_Categoria;
use App\Models\M_Ingreso;

// Controlador principal que maneja todo lo relacionado con las tarjetas (Cuentas) de la aplicación
class C_Tarjeta extends BaseController
{
    protected $modeloCuentas;
    protected $modeloUsuario;
    protected $modeloCategorias;
    protected $modeloIngreso;

    public function __construct()
    {
        // Instanciamos los modelos para poder interactuar con las tablas correspondientes
        $this->modeloCuentas    = new M_Cuentas();
        $this->modeloUsuario    = new M_Usuario();
        $this->modeloCategorias = new M_Categoria();
        $this->modeloIngreso    = new M_Ingreso();
    }

    // Pantalla de inicio de las tarjetas
    public function index()
    {
        // Comprobamos si hay un DNI guardado en la sesión (es decir, si hemos hecho login)
        if (session()->get('dni') == null) {
            return redirect()->to('/login'); // Si no, ¡fuera de aquí! Al login
        }
        
        // 1. Nos traemos la lista de cuentas que tiene este usuario
        $cuentas = $this->modeloCuentas->where('id_usuario', session()->get('dni'))->findAll();
        $data['cuentas'] = $cuentas;
        
        // 2. Nos traemos todos los datos del usuario (para pintar su nombre arriba por ejemplo)
        $data['usuario'] = $this->modeloUsuario->where('dni', session()->get('dni'))->first();
        
        // 3. Nos traemos las categorías (para saber qué icono/nombre tiene cada tarjeta en visualización)
        $data['categorias'] = $this->modeloCategorias->findAll();
        
        // Enviamos este lote de datos a la vista HTML para que pueda dibujar algo dinámico
        return view('tarjetas/v_tarjetas', $data);
    }

    // Pantalla con el formulario para registrarse una cuenta bancaria/tarjeta nueva
    public function nuevaCuenta()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Truco: Averiguamos qué categorías ya tiene ocupadas este usuario (ej: Si ya tiene cuenta principal banco X, no le dejamos crear otro X)
        $categoriasUsadas = $this->modeloCuentas->where('id_usuario', $dni)->findColumn('id_categoria') ?: [0];

        // Filtramos y le pasamos solo las categorías que TODAVÍA NO están escogidas ni usadas
        $data['categorias'] = $this->modeloCategorias->whereNotIn('id', $categoriasUsadas)->findAll();
        $data['usuario'] = $this->modeloUsuario->where('dni', $dni)->first();

        return view('tarjetas/v_new_tarjetas', $data);
    }

    // El motor que recoge lo que el usuario envía rellenado y validado
    public function crearCuenta()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Si el usuario eligió "Otro...", creamos o reutilizamos la categoría al vuelo
        $id_categoria_final = null;

        if ($this->request->getPost('id_categoria') === 'otro') {
            $nombreNuevo = trim($this->request->getPost('nueva_categoria') ?? '');

            if (empty($nombreNuevo)) {
                return redirect()->back()->withInput()->with('errors', ['id_categoria' => tr('errorSubcategoriaObligatoria') ?? 'Debes escribir un nombre para la nueva categoría.']);
            }

            // Si ya existe una categoría con ese nombre, reutilizamos su ID
            $existente = $this->modeloCategorias->where('nombre', $nombreNuevo)->first();
            if ($existente) {
                $id_categoria_final = $existente->id;
            } else {
                // La creamos nueva y guardamos el ID devuelto
                $this->modeloCategorias->insert(['nombre' => $nombreNuevo]);
                $id_categoria_final = $this->modeloCategorias->insertID();
            }
        }

        // Solo validamos id_categoria si el usuario eligió una existente del select
        $rules = [
            'saldoTotal' => [
                'rules'  => 'required|greater_than_equal_to[0.01]',
                'errors' => [
                    'required'              => tr('errorSaldoInicialObligatorio') ?? 'El saldo inicial es obligatorio.',
                    'greater_than_equal_to' => tr('errorSaldoInicialMinimo') ?? 'El saldo inicial debe ser de al menos 0.01€.',
                ],
            ],
        ];

        // Solo validamos id_categoria si NO acabamos de crearla
        if ($id_categoria_final === null) {
            $rules['id_categoria'] = [
                'rules'  => 'required|is_not_unique[categoria.id]',
                'errors' => [
                    'required'      => tr('errorSeleccionarCategoria') ?? 'Debes seleccionar una categoría.',
                    'is_not_unique' => tr('errorCategoriaInvalida') ?? 'La categoría seleccionada no es válida.',
                ],
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Usamos el ID definitivo: el de la nueva categoría, o el del select
        $id_categoria = $id_categoria_final ?? $this->request->getPost('id_categoria');

        // Doble comprobación de seguridad: Ver si ya existe una cuenta con esa categoría
        $existe = $this->modeloCuentas->where('id_usuario', $dni)
            ->where('id_categoria', $id_categoria)
            ->first();
            
        if ($existe) {
            return redirect()->back()->withInput()->with('errors', ['id_categoria' => tr('errorCuentaCategoriaExistente') ?? 'Ya tienes una cuenta vinculada a esta categoría.']);
        }

        // Encapsulamos los post puros en un array de datos
        $data = [
            'saldoTotal'   => $this->request->getPost('saldoTotal'),
            'id_categoria' => $id_categoria,
            'id_usuario'   => $dni,
        ];

        // Lo inyectamos en la base de datos
        $this->modeloCuentas->insert($data);
        $id_nueva_cuenta = $this->modeloCuentas->insertID();

        // Registramos el saldo inicial como un ingreso, así aparece en el historial de movimientos
        $this->modeloIngreso->insert([
            'dinero'    => $this->request->getPost('saldoTotal'),
            'fecha'     => date('Y-m-d'),
            'id_cuenta' => $id_nueva_cuenta,
        ]);

        // Lo redirigimos amigablemente al inicio con felicitaciones
        return redirect()->to('/tarjetas')->with('success', tr('exitoCuentaCreada') ?? 'Cuenta creada correctamente.');
    }

    // Pantalla superior / Procesamiento para editar opciones clave de una cuenta ya existente (como arreglar saldo inicial)
    public function modificarCuenta($id)
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Buscamos LA cuenta específica por su id en phpMyAdmin / SQLite
        $cuenta = $this->modeloCuentas->find($id);
        
        // Bloqueo total si la cuenta no la encontramos o es de otra tía / tío
        if (!$cuenta || $cuenta->id_usuario != $dni) {
            return redirect()->to('/tarjetas')->with('errors', [tr('errorPermisoModificarCuenta') ?? 'No tienes permiso para modificar esta cuenta.']);
        }

        // ¿Nos está mandando ya las cosas salvadas clickeando en Guardar? (eso es un post)
        if (strtolower($this->request->getMethod()) === 'post') {
            
            // Reglas protectoras
            $rules = [
                'saldoTotal' => [
                    'rules'  => 'required|greater_than_equal_to[0.01]',
                    'errors' => [
                        'required'              => tr('errorSaldoObligatorio') ?? 'El saldo es obligatorio.',
                        'greater_than_equal_to' => tr('errorSaldoMinimo') ?? 'El saldo debe ser de al menos 0.01€.',
                    ],
                ],
                'id_categoria' => [
                    'rules'  => 'required|is_not_unique[categoria.id]',
                    'errors' => [
                        'required'      => tr('errorSeleccionarCategoria') ?? 'Debes seleccionar una categoría.',
                        'is_not_unique' => tr('errorCategoriaInvalida') ?? 'La categoría seleccionada no es válida.',
                    ],
                ],
            ];

            // Comprobación de reglas
            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $id_categoria = $this->request->getPost('id_categoria');

            // Comprobación rarita pero clave: Asegurarnos de que no machaca otra cuenta poniéndole la categoría de la cuenta 2 a la cuenta 1
            $existe = $this->modeloCuentas->where('id_usuario', $dni)
                ->where('id_categoria', $id_categoria)
                ->where('id !=', $id) // Quitamos a esta "id" de la ecuación (ella sí puede tener la suya obvio)
                ->first();
                
            if ($existe) {
                return redirect()->back()->withInput()->with('errors', ['id_categoria' => tr('errorOtraCuentaCategoriaExistente') ?? 'Ya tienes OTRA cuenta diferente vinculada a esta categoría.']);
            }

            // Datos fresquitos a actualizar
            $dataUpdate = [
                'saldoTotal'   => $this->request->getPost('saldoTotal'),
                'id_categoria' => $id_categoria,
            ];

            // Disparamos update para planchar esos datos a la DB
            $this->modeloCuentas->update($id, $dataUpdate);

            // Regresamos a la vista pero enseñando éxito
            return redirect()->to('tarjetas/modificar/' . $id)->with('success', tr('exitoCuentaModificada') ?? 'Cuenta modificada correctamente.');
        }

        // ====== Si entramos aquí, significa que entra a pelo por GET simplemente paseando para ver ========= //
        
        // Hacemos el filtro de categorías quitando las ya usadas... ¡AH PERO SALVAMOS LA DE LA CUENTA ACTUAL o saldría invisible en su propio form!
        $categoriasUsadas = $this->modeloCuentas->where('id_usuario', $cuenta->id_usuario)->where('id !=', $id)->findColumn('id_categoria') ?: [0];
        
        $data['categorias'] = $this->modeloCategorias->whereNotIn('id', $categoriasUsadas)->findAll();
        $data['cuenta'] = $cuenta;
        $data['usuario'] = $this->modeloUsuario->where('dni', $cuenta->id_usuario)->first();
        
        // ¡Al HTML a rellenar casillas!
        return view('tarjetas/v_modificar_tarjetas', $data);
    }
}
