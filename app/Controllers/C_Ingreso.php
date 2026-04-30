<?php

namespace App\Controllers;

use CodeIgniter\CLI\Console;
use App\Models\M_Ingreso;
use App\Models\M_Cuentas;

// Controlador que gestiona toda el área donde el usuario registra que le ha caído dinero (para bien)
class C_Ingreso extends BaseController
{
    protected $modeloIngreso;
    protected $modeloCuentas;

    public function __construct()
    {
        // Instanciamos para tenerlos disponibles rápido en toda la web
        $this->modeloIngreso = new M_Ingreso();
        $this->modeloCuentas = new M_Cuentas();
    }

    // Pantalla base donde se despliega tu lista en verde de ingresos
    public function index()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login'); // Sin logueo no entras
        }

        // Obtener cuentas del usuario junto con el nombre de cada categoría para lucirlo en el selector gigante del menú de arriba
        $cuentas = $this->modeloCuentas->select('cuenta.*, categoria.nombre as categoria_nombre')
            ->join('categoria', 'categoria.id = cuenta.id_categoria', 'left')
            ->where('cuenta.id_usuario', $dni)
            ->findAll();
            
        $data['cuentas'] = $cuentas;

        // ¿Nos pasó alguna pista de en qué tarjeta quiere buscar los ingresos por la URL? (ej: ?id_cuenta=5)
        $cuenta_seleccionada = $this->request->getGet('cuenta_id');

        // Si no pillamos cuenta en la URL pero el usuario de hecho tiene una cuenta real inventada, seleccionamos su primera tarjeta del índice 0
        if (!$cuenta_seleccionada && !empty($cuentas)) {
            $cuenta_seleccionada = $cuentas[0]->id;
        }

        $data['cuenta_seleccionada'] = $cuenta_seleccionada;

        if ($cuenta_seleccionada) {
            
            // Un chequeo de lógica pura para evitar que mire el ID de otra persona probando números
            $valida = false;
            foreach ($cuentas as $c) {
                if ($c->id == $cuenta_seleccionada) {
                    $valida = true;
                    break;
                }
            }

            if ($valida) {
                // Sácanos todos esos ingresos y, MODO IMPORTANTE, los colocamos pidiendo orden descendente por fecha para que veas tus caprichos más recientes arriba
                $data['ingresos'] = $this->modeloIngreso->where('id_cuenta', $cuenta_seleccionada)
                                                        ->orderBy('fecha', 'DESC')
                                                        ->findAll();
            } else {
                // Si la cuenta la inventó en URL intentando ser el listo hackeando el sistema, o está vacía, no saca un error fatal, simplemente le dejamos la listita vacía
                $data['ingresos'] = [];
            }
        } else {
            $data['ingresos'] = [];
        }

        // A dibujar HTML (la Vista)
        return view('ingresos/v_ingresos', $data);
    }

    // ¡Ups! Borra ese ingreso erróneo y devuélveme a la realidad monetaria
    public function eliminarIngreso()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Nos envía el identificador secreto del ingreso pulsando en el icono rojo / trash
        $id = $this->request->getPost('id');

        if ($id) {
            // Buscamos cuál es exactamente ese ingreso perdido
            $ingreso = $this->modeloIngreso->find($id);
            if ($ingreso) {
                
                // Comprobamos la propiedad al milímetro
                $cuenta = $this->modeloCuentas->where('id', $ingreso->id_cuenta)
                    ->where('id_usuario', $dni)
                    ->first();
                    
                if ($cuenta) {
                    // Magia en el código: Si retrocedemos el tiempo quitando un ingreso... significa que tenemos menos total en general
                    $nuevoSaldo = $cuenta->saldoTotal - $ingreso->dinero;
                    $this->modeloCuentas->update($cuenta->id, ['saldoTotal' => $nuevoSaldo]); // Actualizamos la "bolsa" desinflando esa suma

                    // Por fin aplastamos digitalmente el historial de ese ingreso
                    $this->modeloIngreso->delete($id);
                    
                    return redirect()->to('/ingresos?cuenta_id=' . $cuenta->id)->with('success', tr('exitoEliminarIngreso') ?? 'Ingreso eliminado correctamente.');
                }
            }
        }

        // Cae en esto si es modificado el dom con id falso
        return redirect()->to('/ingresos')->with('errors', [tr('errorEliminarIngreso') ?? 'No se ha podido eliminar el ingreso o no tienes permisos.']);
    }

    // Su función es la sencilla proeza de llamar al view (al formulario para meter dineritos frescos)
    public function nuevoIngreso($id_cuenta)
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Llevamos su mochila con datos atados a esa tarjeta a la inyección
        $data = [
            'dni'       => $dni,
            'id_cuenta' => $id_cuenta,
        ];

        return view('ingresos/v_newingresos', $data);
    }

    // Encestando la bola; Recibe todo el formulario pulsado y decide
    public function crearIngreso()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Reglas de sintaxis estricta, no admitimos campos de 0 euros ni vacíos chistosos
        $rules = [
            'dinero' => [
                'rules'  => 'required|greater_than_equal_to[0.01]',
                'errors' => [
                    'required'              => tr('errorCantidadObligatoria') ?? 'La cantidad es obligatoria.',
                    'greater_than_equal_to' => tr('errorCantidadMinima') ?? 'El ingreso debe ser de al menos 0.01€ y no puede ser 0.',
                ],
            ],
            'fecha' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required'   => tr('errorFechaObligatoria') ?? 'La fecha es obligatoria.',
                    'valid_date' => tr('errorFechaInvalida') ?? 'La fecha no es válida.',
                ],
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_cuenta = $this->request->getPost('id_cuenta');

        // Seguridad estricta por si intentó hacer F12 e inspeccionar elementos cambiando variables clave de nuestra base de datos
        $cuenta = $this->modeloCuentas->where('id', $id_cuenta)
                                      ->where('id_usuario', $dni)
                                      ->first();

        // Expulsión si descubrimos una mentira
        if (!$cuenta) {
            return redirect()->to('/ingresos')->with('errors', [tr('errorCuentaInvalida') ?? 'La cuenta seleccionada no es válida o no te pertenece.']);
        }

        // Preparamos nuestro arsenal con todo ya pulido
        $dataInsert = [
            'dinero'    => $this->request->getPost('dinero'),
            'fecha'     => $this->request->getPost('fecha'),
            'id_cuenta' => $id_cuenta
        ];

        // Lo escribimos oficialmente ✍
        $this->modeloIngreso->insert($dataInsert);

        // Actualizamos nuestra cartera, pero esta vez afortunadamente, sumando la variable rica "dinero"
        $nuevoSaldo = $cuenta->saldoTotal + $dataInsert['dinero'];
        $this->modeloCuentas->update($id_cuenta, ['saldoTotal' => $nuevoSaldo]);

        return redirect()->to('/ingresos?cuenta_id=' . $id_cuenta)->with('success', tr('exitoIngreso') ?? 'Ingreso registrado correctamente.');
    }
}
