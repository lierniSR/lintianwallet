<?php

namespace App\Controllers;

use App\Models\M_Gasto;
use App\Models\M_Cuentas;

class C_Gasto extends BaseController
{
    protected $modeloGasto;
    protected $modeloCuentas;

    public function __construct()
    {
        $this->modeloGasto = new M_Gasto();
        $this->modeloCuentas = new M_Cuentas();
    }

    public function index()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Obtener cuentas del usuario con el nombre de su categoría
        $cuentas = $this->modeloCuentas->select('cuenta.*, categoria.nombre as categoria_nombre')
            ->join('categoria', 'categoria.id = cuenta.id_categoria', 'left')
            ->where('cuenta.id_usuario', $dni)
            ->findAll();
        $data['cuentas'] = $cuentas;

        // Intentar obtener cuenta de GET
        $cuenta_seleccionada = $this->request->getGet('cuenta_id');

        // Si no hay cuenta en la URL, seleccionamos la primera
        if (!$cuenta_seleccionada && !empty($cuentas)) {
            $cuenta_seleccionada = $cuentas[0]->id;
        }

        $data['cuenta_seleccionada'] = $cuenta_seleccionada;

        if ($cuenta_seleccionada) {
            // Verificar pertenencia con for loop simple
            $valida = false;
            foreach ($cuentas as $c) {
                if ($c->id == $cuenta_seleccionada) {
                    $valida = true;
                    break;
                }
            }

            if ($valida) {
                $data['gastos'] = $this->modeloGasto->where('id_cuenta', $cuenta_seleccionada)
                    ->orderBy('fecha', 'DESC')
                    ->findAll();
            } else {
                $data['gastos'] = [];
            }
        } else {
            $data['ingresos'] = [];
        }

        return view('gastos/v_gastos', $data);
    }
}
