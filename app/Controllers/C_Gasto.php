<?php

namespace App\Controllers;

use App\Models\M_Gasto;
use App\Models\M_Cuentas;
use App\Models\M_Subcategoria;

// Controlador destinado a toda la parte dolorosa: ver hacia donde y a qué velocidad huye nuestro dinero
class C_Gasto extends BaseController
{
    protected $modeloGasto;
    protected $modeloCuentas;
    protected $modeloSubcategoria;

    public function __construct()
    {
        $this->modeloGasto = new M_Gasto();
        $this->modeloCuentas = new M_Cuentas();
        $this->modeloSubcategoria = new M_Subcategoria();
    }

    // Función troncal de lista de historial (color rojo general)
    public function index()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Descargamos un array de todas nuestras posibles cuentas con el extra de engancharse e investigar el nombre de categoría
        $cuentas = $this->modeloCuentas->select('cuenta.*, categoria.nombre as categoria_nombre')
            ->join('categoria', 'categoria.id = cuenta.id_categoria', 'left')
            ->where('cuenta.id_usuario', $dni)
            ->findAll();
            
        $data['cuentas'] = $cuentas;

        // Comprobamos en la brújula de URL si estamos siendo forzados a una tarjeta u otra de forma específica
        $cuenta_seleccionada = $this->request->getGet('cuenta_id');

        // Si entramos al general sin ninguna en particular pero poseemos al menos 1, pues vamos tirando mostrándole la [0] (su principal)
        if (!$cuenta_seleccionada && !empty($cuentas)) {
            $cuenta_seleccionada = $cuentas[0]->id;
        }

        $data['cuenta_seleccionada'] = $cuenta_seleccionada;

        // Si después de eso confirmamos cuenta_seleccionada que usar:
        if ($cuenta_seleccionada) {
            
            // Checkeo de anti bugs
            $valida = false;
            foreach ($cuentas as $c) {
                if ($c->id == $cuenta_seleccionada) {
                    $valida = true;
                    break;
                }
            }

            if ($valida) {
                // Aquí en los GASTOS la consulta se complica un poquito porque cruzamos la info (Hacemos JOIN)
                // Cruzamos información para saber en "español" en qué nos lo hemos gastado, por ejemplo que nos devuelva "Gasolinera" y no solo un patético "id_subcategoria_3"
                $data['gastos'] = $this->modeloGasto->select('gastos.*, subcategoria.nombre as subcategoria_nombre')
                    ->join('subcategoria', 'subcategoria.id = gastos.id_subcategoria', 'left')
                    ->where('gastos.id_cuenta', $cuenta_seleccionada)
                    ->orderBy('gastos.fecha', 'DESC') // ¡Cronología de recientes a últimos!
                    ->findAll();
            } else {
                $data['gastos'] = [];
            }
        } else {
            $data['gastos'] = [];
        }

        // Imprimir diseño
        return view('gastos/v_gastos', $data);
    }

    // Para deshacer nuestro despilfarro
    public function eliminarGasto()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        $id = $this->request->getPost('id');

        if ($id) {
            $gasto = $this->modeloGasto->find($id);
            if ($gasto) {
                // Como siempre reenfocarnos e impedir suplantación probando posts
                $cuenta = $this->modeloCuentas->where('id', $gasto->id_cuenta)
                    ->where('id_usuario', $dni)
                    ->first();
                    
                if ($cuenta) {
                    // Matemáticamente de oro: si yo borro mi gasto de "Unas Zapatillas 200€", mi caja personal ahora sube milagrosamente +200€
                    $nuevoSaldo = $cuenta->saldoTotal + $gasto->dinero;
                    $this->modeloCuentas->update($cuenta->id, ['saldoTotal' => $nuevoSaldo]);

                    // Eliminamos el registro de evidencia de nuestro despilfarro (BBDD)
                    $this->modeloGasto->delete($id);
                    
                    return redirect()->to('/gastos?cuenta_id=' . $cuenta->id)->with('success', tr('exitoEliminarGasto') ?? 'Gasto eliminado correctamente.');
                }
            }
        }

        return redirect()->to('/gastos')->with('errors', [tr('errorEliminarGasto') ?? 'No se ha podido eliminar el gasto o no tienes permisos.']);
    }

    // Mostrar el formulario dinámico
    public function nuevoGasto($id_cuenta)
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Solicitamos la propia cuenta base porque el gasto no es como el ingreso ciego, necesita saber a "QUÉ Categoría" atiende nuestra tarjeta para pintarnos opciones viables
        $cuenta = $this->modeloCuentas->where('id', $id_cuenta)
            ->where('id_usuario', $dni)
            ->first();

        // En caso de fallar en la investigación de propiedad abortar
        if (!$cuenta) {
            return redirect()->to('/gastos')->with('errors', [tr('errorCuentaInexistente') ?? 'La cuenta seleccionada no existe o no te pertenece.']);
        }

        // Metemos en caja data
        $data = [
            'dni'           => $dni,
            'id_cuenta'     => $id_cuenta,
            // Magia 2 en lista gastos: Exigir de la BD de subcategorías solo las que compartan una relación con nuestro tipo de familia/banco de origen
            'subcategorias' => $this->modeloSubcategoria->where('id_categoria', $cuenta->id_categoria)->findAll()
        ];

        return view('gastos/v_newgastos', $data);
    }

    // Momento en que tu botón de crear se presiona duro
    public function crearGasto()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Si el usuario eligió "Otro...", creamos o reutilizamos la subcategoría al vuelo
        $id_subcategoria_final = null;

        if ($this->request->getPost('id_subcategoria') === 'otro') {
            $nombreNuevo = trim($this->request->getPost('nueva_subcategoria') ?? '');

            if (empty($nombreNuevo)) {
                return redirect()->back()->withInput()->with('errors', ['id_subcategoria' => tr('errorSubcategoriaObligatoria') ?? 'Debes escribir un nombre para la nueva subcategoría.']);
            }

            // Necesitamos el id_categoria de la cuenta para enlazar correctamente la nueva subcategoría
            $id_cuenta_tmp = $this->request->getPost('id_cuenta');
            $cuenta_tmp    = $this->modeloCuentas->find($id_cuenta_tmp);

            if (!$cuenta_tmp) {
                return redirect()->back()->withInput()->with('errors', ['id_subcategoria' => tr('errorCategoriaCuentaIndeterminada') ?? 'No se pudo determinar la categoría de la cuenta.']);
            }

            // Si ya existe con ese nombre en esta categoría, reutilizamos su ID
            $existente = $this->modeloSubcategoria
                ->where('nombre', $nombreNuevo)
                ->where('id_categoria', $cuenta_tmp->id_categoria)
                ->first();

            if ($existente) {
                $id_subcategoria_final = $existente->id;
            } else {
                $this->modeloSubcategoria->insert([
                    'nombre'       => $nombreNuevo,
                    'id_categoria' => $cuenta_tmp->id_categoria
                ]);
                $id_subcategoria_final = $this->modeloSubcategoria->insertID();
            }
        }

        // Barreras lógicas (CodeIgniter Rules)
        $rules = [
            'dinero' => [
                'rules'  => 'required|greater_than_equal_to[0.01]',
                'errors' => [
                    'required'              => tr('errorCantidadObligatoria') ?? 'La cantidad es obligatoria.',
                    'greater_than_equal_to' => tr('errorCantidadMinima') ?? 'El gasto debe ser de al menos 0.01€.',
                ],
            ],
            'fecha' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required'   => tr('errorFechaObligatoria') ?? 'La fecha es obligatoria.',
                    'valid_date' => tr('errorFechaInvalida') ?? 'La fecha no es válida.',
                ],
            ],
        ];

        // Solo validamos id_subcategoria si NO acabamos de crearla
        if ($id_subcategoria_final === null) {
            $rules['id_subcategoria'] = [
                'rules'  => 'required|is_not_unique[subcategoria.id]',
                'errors' => [
                    'required'      => tr('errorSubcategoriaObligatoriaForm') ?? 'La subcategoría es obligatoria.',
                    'is_not_unique' => tr('errorSubcategoriaInvalida') ?? 'La subcategoría seleccionada no es válida en la base de datos.',
                ],
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_cuenta = $this->request->getPost('id_cuenta');

        // Seguridad a cuchillo
        $cuenta = $this->modeloCuentas->where('id', $id_cuenta)
            ->where('id_usuario', $dni)
            ->first();

        if (!$cuenta) {
            return redirect()->to('/gastos')->with('errors', [tr('errorCuentaInvalida') ?? 'La cuenta seleccionada no es válida.']);
        }

        // Usamos el ID definitivo: el de la nueva subcategoría, o el del select
        $id_subcategoria = $id_subcategoria_final ?? $this->request->getPost('id_subcategoria');

        // Metemos nuestros campos envasados al vacío listos
        $dataInsert = [
            'dinero'          => $this->request->getPost('dinero'),
            'fecha'           => $this->request->getPost('fecha'),
            'id_cuenta'       => $id_cuenta,
            'id_subcategoria' => $id_subcategoria
        ];

        // Impacto a tabla Gastos 
        $this->modeloGasto->insert($dataInsert);

        // Y lo otro importante: Nuestro balance general personal sufre dolor bajando el numero para reflejar nuestra vida (-menos dinero del insertado)
        $nuevoSaldo = $cuenta->saldoTotal - $dataInsert['dinero'];
        $this->modeloCuentas->update($id_cuenta, ['saldoTotal' => $nuevoSaldo]);

        return redirect()->to('/gastos?cuenta_id=' . $id_cuenta)->with('success', tr('exitoGasto') ?? 'Gasto registrado correctamente.');
    }
}
