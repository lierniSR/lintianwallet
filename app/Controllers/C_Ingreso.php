<?php

namespace App\Controllers;

use CodeIgniter\CLI\Console;
use App\Models\M_Ingreso;
use App\Models\M_Cuentas;

class C_Ingreso extends BaseController
{
    protected $modeloIngreso;
    protected $modeloCuentas;

    public function __construct()
    {
        $this->modeloIngreso = new M_Ingreso();
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
                $data['ingresos'] = $this->modeloIngreso->where('id_cuenta', $cuenta_seleccionada)->findAll();
            } else {
                $data['ingresos'] = [];
            }
        } else {
            $data['ingresos'] = [];
        }

        return view('ingresos/v_ingresos', $data);
    }

    public function eliminarIngreso()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        $id = $this->request->getPost('id');

        if ($id) {
            $ingreso = $this->modeloIngreso->find($id);
            if ($ingreso) {
                // Verificar que la cuenta a la que pertenece el ingreso sea de este usuario
                $cuenta = $this->modeloCuentas->where('id', $ingreso->id_cuenta)
                                              ->where('id_usuario', $dni)
                                              ->first();
                if ($cuenta) {
                    $this->modeloIngreso->delete($id);
                    return redirect()->to('/ingresos?cuenta_id=' . $cuenta->id)->with('success', 'Ingreso eliminado correctamente.');
                }
            }
        }

        return redirect()->to('/ingresos')->with('errors', ['No se ha podido eliminar el ingreso o no tienes permisos.']);
    }
}
