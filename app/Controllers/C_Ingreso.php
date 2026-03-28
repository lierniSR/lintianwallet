<?php

namespace App\Controllers;

use CodeIgniter\CLI\Console;

class C_Ingreso extends BaseController
{
    public function index()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        return view('ingresos/v_ingresos');
    }
}
