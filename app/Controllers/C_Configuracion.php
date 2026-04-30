<?php

namespace App\Controllers;

use App\Models\M_Usuario;

class C_Configuracion extends BaseController
{
    protected $modeloUsuario;

    public function __construct()
    {
        $this->modeloUsuario = new M_Usuario();
    }

    public function index()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        $data['usuario'] = $this->modeloUsuario->where('dni', $dni)->first();
        
        return view('configuracion/v_configuracion', $data);
    }

    public function cambiarContrasenia()
    {
        $dni = session()->get('dni');
        if ($dni == null) {
            return redirect()->to('/login');
        }

        $rules = [
            'old_password' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'La contraseña actual es obligatoria.',
                ],
            ],
            'new_password' => [
                'rules'  => 'required|min_length[4]',
                'errors' => [
                    'required'   => 'La nueva contraseña es obligatoria.',
                    'min_length' => 'La nueva contraseña debe tener al menos 4 caracteres.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $usuario = $this->modeloUsuario->where('dni', $dni)->first();
        $old_password = $this->request->getPost('old_password');
        $new_password = $this->request->getPost('new_password');

        // Verificamos si la contraseña actual es correcta
        if (!password_verify($old_password, $usuario->contrasenia)) {
            return redirect()->back()->with('error', 'La contraseña actual no es correcta.');
        }

        // Actualizamos con la nueva contraseña hasheada
        $this->modeloUsuario->update($dni, [
            'contrasenia' => password_hash($new_password, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/configuracion')->with('success', 'Contraseña actualizada correctamente.');
    }
}
