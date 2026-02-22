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
}
