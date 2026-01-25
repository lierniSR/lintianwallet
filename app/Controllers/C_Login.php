<?php

namespace App\Controllers;

class C_Login extends BaseController
{
    public function index(): string
    {
        return view('login_registro/v_login');
    }

    public function registroIndex(): string
    {
        return view('login_registro/v_registro');
    }
}
