<?php

namespace App\Controllers;

use App\Models\M_Ingreso;
use App\Models\M_Gasto;
use App\Models\M_Cuentas;

// Controlador especial de SOLO-LECTURA que junta en un mismo historial tanto el dinero que entra como el que sale
class C_Movimiento extends BaseController
{
    // Reservamos espacio en memoria para nuestros tres modelos
    protected $modeloIngreso;
    protected $modeloGasto;
    protected $modeloCuentas;

    public function __construct()
    {
        // Instanciamos los modelos para usarlos más abajo
        $this->modeloIngreso = new M_Ingreso();
        $this->modeloGasto = new M_Gasto();
        $this->modeloCuentas = new M_Cuentas();
    }

    // Es la página principal del historial
    public function index()
    {
        // Lo de siempre, comprobamos que nadie intente colarse escribiendo la URL a mano
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Le pedimos todas las cuentas que tenga (con sus nombres) para ponerlas en el menú desplegable
        $cuentas = $this->modeloCuentas->select('cuenta.*, categoria.nombre as categoria_nombre')
            ->join('categoria', 'categoria.id = cuenta.id_categoria', 'left')
            ->where('cuenta.id_usuario', $dni)
            ->findAll();
        
        $data['cuentas'] = $cuentas;

        // Comprobamos si el usuario ha pinchado directamente en la tarjeta (nos pasará un id_cuenta en el enlace)
        $cuenta_seleccionada = $this->request->getGet('cuenta_id');
        
        // Si no pillamos ninguna cuenta, pero al menos tiene una, seleccionamos la número 1 por defecto
        if (!$cuenta_seleccionada && !empty($cuentas)) {
            $cuenta_seleccionada = $cuentas[0]->id;
        }
        
        $data['cuenta_seleccionada'] = $cuenta_seleccionada;

        // Aquí guardaremos todo el historial revuelto
        $movimientos = [];
        $saldoCuenta = 0;

        // Si realmente tenemos una cuenta seleccionada que analizar
        if ($cuenta_seleccionada) {
            
            // Un pequeño seguro para comprobar de forma lógica que esta cuenta sí que te pertenece
            $valida = false;
            foreach ($cuentas as $c) {
                if ($c->id == $cuenta_seleccionada) {
                    $saldoCuenta = $c->saldoTotal; // Fichamos cuánta pasta queda para mostrarla al lado
                    $valida = true;
                    break;
                }
            }

            // Si es tu cuenta de verdad verificada por el bucle:
            if ($valida) {
                
                // 1. Nos traemos todos los ingresos ingresados
                $ingresos = $this->modeloIngreso->where('id_cuenta', $cuenta_seleccionada)->findAll();
                
                // 2. Nos traemos los gastos e interceptamos la subcategoría pegándole un JOIN para saber en qué lo ha gastado (ej: Gasolina)
                $gastos = $this->modeloGasto->select('gastos.*, subcategoria.nombre as subcategoria_nombre')
                    ->join('subcategoria', 'subcategoria.id = gastos.id_subcategoria', 'left')
                    ->where('gastos.id_cuenta', $cuenta_seleccionada)
                    ->findAll();

                // Etiquetamos manualmente a todos los ingresos diciendo: ¡eh que sois ingresos! y los metemos a la cazuela final
                foreach ($ingresos as $i) {
                    $i->tipo = 'ingreso';
                    $movimientos[] = $i;
                }

                // Hacemos lo mismito con los gastos (para que el HTML luego sepa de qué color pintar, si en rojo o verde)
                foreach ($gastos as $g) {
                    $g->tipo = 'gasto';
                    $movimientos[] = $g;
                }

                // Esto es clave: Ordenamos este cajón desastre mágico pidiendo a PHP que los mida por fecha, del más nuevo al más viejo
                usort($movimientos, function($a, $b) {
                    return strtotime($b->fecha) - strtotime($a->fecha);
                });
            }
        }
        
        // Pasamos todo el trabajo sucio al cofre de los datos para la plantilla
        $data['movimientos'] = $movimientos;
        $data['saldoCuenta'] = $saldoCuenta;

        // Pintamos la ventana
        return view('movimientos/v_movimientos', $data);
    }
}
