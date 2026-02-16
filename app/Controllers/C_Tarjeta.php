<?php

namespace App\Controllers;

use App\Models\M_Cuentas;
use App\Models\M_Usuario;

class C_Tarjeta extends BaseController
{
    protected $modeloCuentas;
    protected $modeloUsuario;

    public function __construct()
    {
        $this->modeloCuentas = new M_Cuentas();
        $this->modeloUsuario = new M_Usuario();
    }

    public function index()
    {
        if (session()->get('dni') == null) {
            return redirect()->to('/login');
        }
        $cuentas = $this->modeloCuentas->findAll();
        $data['cuentas'] = $cuentas;
        $data['usuario'] = $this->modeloUsuario->where('dni', session()->get('dni'))->first();
        return view('tarjetas/v_tarjetas', $data);
    }
}
