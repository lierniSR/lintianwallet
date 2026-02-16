<?php

namespace App\Controllers;

use App\Models\M_Usuario;

class C_Login extends BaseController
{
    protected $modeloUsuario;

    public function __construct()
    {
        $this->modeloUsuario = new M_Usuario();
    }

    public function index(): string
    {
        return view('login_registro/v_login');
    }

    public function autenticar()
    {
        $usuario = $this->modeloUsuario->where('dni', $this->request->getPost('dni'))->first();

        if (!$usuario) {
            session()->setFlashdata('error', 'Usuario no encontrado');
            return redirect()->back();
        }

        if (!password_verify($this->request->getPost('contrasenia'), $usuario->contrasenia)) {
            session()->setFlashdata('error', 'Contraseña incorrecta');
            return redirect()->back();
        }

        session()->set('dni', $usuario->dni);
        return redirect()->to('/tarjetas');
    }

    public function registroIndex(): string
    {
        return view('login_registro/v_registro');
    }

    public function autenticarRegistro()
    {
        $rules = [
            'dni' => [
                'rules'  => 'required|regex_match[/^[0-9]{8}[A-Z]$/]',
                'errors' => [
                    'required'    => 'El DNI es obligatorio.',
                    'regex_match' => 'El formato del DNI no es válido (ej. 12345678A).',
                ],
            ],
            'nombre' => [
                'rules'  => 'required|min_length[2]',
                'errors' => [
                    'required'   => 'El nombre es obligatorio.',
                    'min_length' => 'El nombre es demasiado corto.',
                ],
            ],
            'apellido' => [
                'rules'  => 'required|min_length[2]',
                'errors' => [
                    'required'   => 'El apellido es obligatorio.',
                    'min_length' => 'El apellido es demasiado corto.',
                ],
            ],
            'gmail' => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'El correo es obligatorio.',
                    'valid_email' => 'El formato del correo no es válido.',
                ],
            ],
            'contrasenia' => [
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'required'   => 'La contraseña es obligatoria.',
                    'min_length' => 'La contraseña debe tener al menos 4 caracteres.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'dni'        => $this->request->getPost('dni'),
            'nombre'     => $this->request->getPost('nombre'),
            'apellido'   => $this->request->getPost('apellido'),
            'gmail'      => $this->request->getPost('gmail'),
            'contrasenia' => password_hash($this->request->getPost('contrasenia'), PASSWORD_DEFAULT),
        ];

        $this->modeloUsuario->insert($data);
        return redirect()->to('/login');
    }
}
