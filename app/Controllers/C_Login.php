<?php

namespace App\Controllers;

use App\Models\M_Usuario;

// Controlador encargado de gestionar el inicio de sesión y registro de los usuarios
class C_Login extends BaseController
{
    protected $modeloUsuario;

    public function __construct()
    {
        // Cargamos el modelo de usuario para poder buscar o crear cuentas
        $this->modeloUsuario = new M_Usuario();
    }

    // Muestra la vista principal de inicio de sesión
    public function index(): string
    {
        return view('login_registro/v_login');
    }

    // Función que procesa el formulario de login y verifica que seas tú
    public function autenticar()
    {
        // Buscamos a un usuario en la base de datos que tenga el DNI introducido
        $usuario = $this->modeloUsuario->where('dni', $this->request->getPost('dni'))->first();

        // Si no encontramos a nadie con ese DNI, lo devolvemos con un mensaje de error
        if (!$usuario) {
            session()->setFlashdata('error', 'Usuario no encontrado');
            return redirect()->back();
        }

        // Verificamos si la contraseña que escribió coincide con la versión encriptada guardada
        if (!password_verify($this->request->getPost('contrasenia'), $usuario->contrasenia)) {
            session()->setFlashdata('error', 'Contraseña incorrecta');
            return redirect()->back();
        }

        // Si todo está bien, guardamos su DNI en la sesión "como una pulsera VIP" para dejarle pasar
        session()->set('dni', $usuario->dni);

        // ¡Adentro! Lo enviamos a la vista de sus tarjetas
        return redirect()->to('/tarjetas');
    }

    // Muestra el formulario para crear una cuenta nueva
    public function registroIndex(): string
    {
        return view('login_registro/v_registro');
    }

    // Se encarga de procesar todos los datos una vez que dan al botón Registrar
    public function autenticarRegistro()
    {
        // Reglas estrictas: No dejamos que pongan información basura en la base de datos
        $rules = [
            'dni' => [
                'rules'  => 'required|regex_match[/^[0-9]{8}[A-Z]$/]|is_unique[usuario.dni]',
                'errors' => [
                    'required'    => 'El DNI es obligatorio.',
                    'regex_match' => 'El formato del DNI no es válido (ej. 12345678A).',
                    'is_unique'   => 'El DNI ya está registrado.',
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

        // Comprobamos si no cumple con las reglas y le devolvemos los errores
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Metemos los datos limpios en un array listos para enviar a la base de datos
        $data = [
            'dni'         => $this->request->getPost('dni'),
            'nombre'      => $this->request->getPost('nombre'),
            'apellido'    => $this->request->getPost('apellido'),
            'gmail'       => $this->request->getPost('gmail'),
            // ¡MUY IMPORTANTE!: Encriptamos la contraseña para que ni el administrador pueda leerla
            'contrasenia' => password_hash($this->request->getPost('contrasenia'), PASSWORD_DEFAULT),
        ];

        // Insertamos el nuevo usuario
        $this->modeloUsuario->insert($data);

        // Lo mandamos al inicio de sesión para que entre con su cuenta recién hecha
        return redirect()->to('/login');
    }

    // Cierra la sesión del usuario y lo manda de vuelta al login
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
