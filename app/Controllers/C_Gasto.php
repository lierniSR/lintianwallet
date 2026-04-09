<?php

namespace App\Controllers;

use App\Models\M_Gasto;
use App\Models\M_Cuentas;
use App\Models\M_Subcategoria;

class C_Gasto extends BaseController
{
    protected $modeloGasto;
    protected $modeloCuentas;
    protected $modeloSubcategoria;

    public function __construct()
    {
        $this->modeloGasto = new M_Gasto();
        $this->modeloCuentas = new M_Cuentas();
        // Usamos el modelo M_Subcategoria que acabo de crear
        $this->modeloSubcategoria = new M_Subcategoria();
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
                // Hacemos JOIN con subcategoria para obtener el nombre real de lo que se ha gastado
                $data['gastos'] = $this->modeloGasto->select('gastos.*, subcategoria.nombre as subcategoria_nombre')
                    ->join('subcategoria', 'subcategoria.id = gastos.id_subcategoria', 'left')
                    ->where('gastos.id_cuenta', $cuenta_seleccionada)
                    ->orderBy('gastos.fecha', 'DESC')
                    ->findAll();
            } else {
                $data['gastos'] = [];
            }
        } else {
            $data['gastos'] = [];
        }

        return view('gastos/v_gastos', $data);
    }

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
                // Verificar pertenencia
                $cuenta = $this->modeloCuentas->where('id', $gasto->id_cuenta)
                    ->where('id_usuario', $dni)
                    ->first();
                if ($cuenta) {
                    // Si eliminamos un gasto, significa que sumamos de nuevo ese dinero a la cuenta
                    $nuevoSaldo = $cuenta->saldoTotal + $gasto->dinero;
                    $this->modeloCuentas->update($cuenta->id, ['saldoTotal' => $nuevoSaldo]);

                    $this->modeloGasto->delete($id);
                    return redirect()->to('/gastos?cuenta_id=' . $cuenta->id)->with('success', 'Gasto eliminado correctamente.');
                }
            }
        }

        return redirect()->to('/gastos')->with('errors', ['No se ha podido eliminar el gasto o no tienes permisos.']);
    }

    public function nuevoGasto($id_cuenta)
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Obtener la cuenta seleccionada para poder buscar sus subcategorías (basado en la categoría de la cuenta)
        $cuenta = $this->modeloCuentas->where('id', $id_cuenta)
            ->where('id_usuario', $dni)
            ->first();

        if (!$cuenta) {
            return redirect()->to('/gastos')->with('errors', ['La cuenta seleccionada no existe o no te pertenece.']);
        }

        $data = [
            'dni' => $dni,
            'id_cuenta' => $id_cuenta,
            // Buscamos todas las subcategorias cuyo id_categoria coincida con la categoría de la cuenta.
            'subcategorias' => $this->modeloSubcategoria->where('id_categoria', $cuenta->id_categoria)->findAll()
        ];

        return view('gastos/v_newgastos', $data);
    }

    public function crearGasto()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        $rules = [
            'dinero' => [
                'rules'  => 'required|greater_than_equal_to[0.01]',
                'errors' => [
                    'required' => 'La cantidad es obligatoria.',
                    'greater_than_equal_to' => 'El gasto debe ser de al menos 0.01€.',
                ],
            ],
            'fecha' => [
                'rules'  => 'required|valid_date',
                'errors' => [
                    'required' => 'La fecha es obligatoria.',
                    'valid_date' => 'La fecha no es válida.',
                ],
            ],
            'id_subcategoria' => [
                'rules'  => 'required|is_not_unique[subcategoria.id]',
                'errors' => [
                    'required' => 'La subcategoría es obligatoria.',
                    'is_not_unique' => 'La subcategoría seleccionada no es válida en la base de datos.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_cuenta = $this->request->getPost('id_cuenta');

        // Seguridad extra
        $cuenta = $this->modeloCuentas->where('id', $id_cuenta)
            ->where('id_usuario', $dni)
            ->first();

        if (!$cuenta) {
            return redirect()->to('/gastos')->with('errors', ['La cuenta seleccionada no es válida.']);
        }

        $dataInsert = [
            'dinero'          => $this->request->getPost('dinero'),
            'fecha'           => $this->request->getPost('fecha'),
            'id_cuenta'       => $id_cuenta,
            'id_subcategoria' => $this->request->getPost('id_subcategoria')
        ];

        $this->modeloGasto->insert($dataInsert);

        // Actualizamos la cuenta quitándole ese dinero gastado
        $nuevoSaldo = $cuenta->saldoTotal - $dataInsert['dinero'];
        $this->modeloCuentas->update($id_cuenta, ['saldoTotal' => $nuevoSaldo]);

        return redirect()->to('/gastos?cuenta_id=' . $id_cuenta)->with('success', 'Gasto registrado correctamente.');
    }
}
