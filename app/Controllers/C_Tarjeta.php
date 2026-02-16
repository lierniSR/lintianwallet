<?php

namespace App\Controllers;

use App\Models\M_Usuario;

class C_Tarjeta extends BaseController
{
    protected $modeloUsuario;

    public function __construct()
    {
        $this->modeloUsuario = new M_Usuario();
    }

    public function index(): string
    {
        return view('tarjetas/v_tarjetas');
    }
}
