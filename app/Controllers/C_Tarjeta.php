<?php

namespace App\Controllers;

use App\Models\M_Cuentas;
use App\Models\M_Usuario;
use App\Models\M_Categoria;

class C_Tarjeta extends BaseController
{
    protected $modeloCuentas;
    protected $modeloUsuario;
    protected $modeloCategorias;

    public function __construct()
    {
        $this->modeloCuentas = new M_Cuentas();
        $this->modeloUsuario = new M_Usuario();
        $this->modeloCategorias = new M_Categoria();
    }

    public function index()
    {
        if (session()->get('dni') == null) {
            return redirect()->to('/login');
        }
        $cuentas = $this->modeloCuentas->where('id_usuario', session()->get('dni'))->findAll();
        $data['cuentas'] = $cuentas;
        $data['usuario'] = $this->modeloUsuario->where('dni', session()->get('dni'))->first();
        $data['categorias'] = $this->modeloCategorias->findAll();
        return view('tarjetas/v_tarjetas', $data);
    }

    public function nuevaCuenta()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        // Obtener IDs de categorías ya usadas por este usuario
        $categoriasUsadas = $this->modeloCuentas->where('id_usuario', $dni)->findColumn('id_categoria') ?: [0];

        // Filtrar categorías que NO estén en la lista de usadas
        $data['categorias'] = $this->modeloCategorias->whereNotIn('id', $categoriasUsadas)->findAll();
        $data['usuario'] = $this->modeloUsuario->where('dni', $dni)->first();

        return view('tarjetas/v_new_tarjetas', $data);
    }

    public function crearCuenta()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        $rules = [
            'saldoTotal' => [
                'rules'  => 'required|greater_than_equal_to[0.01]',
                'errors' => [
                    'required'            => 'El saldo inicial es obligatorio.',
                    'greater_than_equal_to' => 'El saldo inicial debe ser de al menos 0.01€.',
                ],
            ],
            'id_categoria' => [
                'rules'  => 'required|is_not_unique[categoria.id]',
                'errors' => [
                    'required'      => 'Debes seleccionar una categoría.',
                    'is_not_unique' => 'La categoría seleccionada no es válida.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_categoria = $this->request->getPost('id_categoria');

        // Doble comprobación de seguridad: Ver si ya existe una cuenta con esa categoría para este usuario
        $existe = $this->modeloCuentas->where('id_usuario', $dni)
            ->where('id_categoria', $id_categoria)
            ->first();
        if ($existe) {
            return redirect()->back()->withInput()->with('errors', ['id_categoria' => 'Ya tienes una cuenta vinculada a esta categoría.']);
        }

        $data = [
            'saldoTotal'   => $this->request->getPost('saldoTotal'),
            'id_categoria' => $id_categoria,
            'id_usuario'   => $dni,
        ];

        $this->modeloCuentas->insert($data);
        return redirect()->to('/tarjetas')->with('success', 'Cuenta creada correctamente.');
    }

    public function modificarCuenta($id)
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        $cuenta = $this->modeloCuentas->find($id);
        
        if (!$cuenta || $cuenta->id_usuario != $dni) {
            return redirect()->to('/tarjetas')->with('errors', ['No tienes permiso para modificar esta cuenta.']);
        }

        if (strtolower($this->request->getMethod()) === 'post' || strtoupper($this->request->getMethod()) === 'POST') {
            $rules = [
                'saldoTotal' => [
                    'rules'  => 'required|greater_than_equal_to[0.01]',
                    'errors' => [
                        'required'            => 'El saldo es obligatorio.',
                        'greater_than_equal_to' => 'El saldo debe ser de al menos 0.01€.',
                    ],
                ],
                'id_categoria' => [
                    'rules'  => 'required|is_not_unique[categoria.id]',
                    'errors' => [
                        'required'      => 'Debes seleccionar una categoría.',
                        'is_not_unique' => 'La categoría seleccionada no es válida.',
                    ],
                ],
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $id_categoria = $this->request->getPost('id_categoria');

            // Doble comprobación: Ver si ya existe otra cuenta con esa categoría para este usuario
            $existe = $this->modeloCuentas->where('id_usuario', $dni)
                ->where('id_categoria', $id_categoria)
                ->where('id !=', $id)
                ->first();
                
            if ($existe) {
                return redirect()->back()->withInput()->with('errors', ['id_categoria' => 'Ya tienes otra cuenta vinculada a esta categoría.']);
            }

            $dataUpdate = [
                'saldoTotal'   => $this->request->getPost('saldoTotal'),
                'id_categoria' => $id_categoria,
            ];

            $this->modeloCuentas->update($id, $dataUpdate);

            // "se va a dirigir a la misma vista pero con los cambios claramente"
            return redirect()->to('tarjetas/modificar/' . $id)->with('success', 'Cuenta modificada correctamente.');
        }

        // Excluimos la cuenta actual para que su categoría sí salga como disponible
        $categoriasUsadas = $this->modeloCuentas->where('id_usuario', $cuenta->id_usuario)->where('id !=', $id)->findColumn('id_categoria') ?: [0];
        $data['categorias'] = $this->modeloCategorias->whereNotIn('id', $categoriasUsadas)->findAll();
        $data['cuenta'] = $cuenta;
        $data['usuario'] = $this->modeloUsuario->where('dni', $cuenta->id_usuario)->first();
        return view('tarjetas/v_modificar_tarjetas', $data);
    }
}
