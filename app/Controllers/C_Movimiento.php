<?php

namespace App\Controllers;

use App\Models\M_Ingreso;
use App\Models\M_Gasto;
use App\Models\M_Cuentas;

class C_Movimiento extends BaseController
{
    protected $modeloIngreso;
    protected $modeloGasto;
    protected $modeloCuentas;

    public function __construct()
    {
        $this->modeloIngreso = new M_Ingreso();
        $this->modeloGasto = new M_Gasto();
        $this->modeloCuentas = new M_Cuentas();
    }

    public function index()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Obtener cuentas
        $cuentas = $this->modeloCuentas->select('cuenta.*, categoria.nombre as categoria_nombre')
            ->join('categoria', 'categoria.id = cuenta.id_categoria', 'left')
            ->where('cuenta.id_usuario', $dni)
            ->findAll();
        $data['cuentas'] = $cuentas;

        $cuenta_seleccionada = $this->request->getGet('cuenta_id');
        if (!$cuenta_seleccionada && !empty($cuentas)) {
            $cuenta_seleccionada = $cuentas[0]->id;
        }
        $data['cuenta_seleccionada'] = $cuenta_seleccionada;

        $movimientos = [];
        $saldoCuenta = 0;

        if ($cuenta_seleccionada) {
            $valida = false;
            foreach ($cuentas as $c) {
                if ($c->id == $cuenta_seleccionada) {
                    $saldoCuenta = $c->saldoTotal;
                    $valida = true;
                    break;
                }
            }

            if ($valida) {
                $ingresos = $this->modeloIngreso->where('id_cuenta', $cuenta_seleccionada)->findAll();
                
                // Extraer gastos con el nombre de su subcategoría para pintarlo en el título
                $gastos = $this->modeloGasto->select('gastos.*, subcategoria.nombre as subcategoria_nombre')
                    ->join('subcategoria', 'subcategoria.id = gastos.id_subcategoria', 'left')
                    ->where('gastos.id_cuenta', $cuenta_seleccionada)
                    ->findAll();

                foreach($ingresos as $i) {
                    $i->tipo = 'ingreso';
                    $movimientos[] = $i;
                }

                foreach($gastos as $g) {
                    $g->tipo = 'gasto';
                    $movimientos[] = $g;
                }

                // Sorting by date descending
                usort($movimientos, function($a, $b) {
                    return strtotime($b->fecha) - strtotime($a->fecha);
                });
            }
        }
        
        $data['movimientos'] = $movimientos;
        $data['saldoCuenta'] = $saldoCuenta;

        return view('movimientos/v_movimientos', $data);
    }
}
