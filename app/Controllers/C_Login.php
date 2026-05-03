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
            session()->setFlashdata('error', tr('Usuario no encontrado') ?? 'Usuario no encontrado');
            return redirect()->back();
        }

        // Verificamos si la contraseña que escribió coincide con la versión encriptada guardada
        if (!password_verify($this->request->getPost('contrasenia'), $usuario->contrasenia)) {
            session()->setFlashdata('error', tr('Contraseña incorrecta') ?? 'Contraseña incorrecta');
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
                'rules'  => [
                    'required',
                    'regex_match[/^[0-9]{8}[A-Z]$/]',
                    'is_unique[usuario.dni]',
                    static function ($value, array $data, ?string &$error = null): bool {
                        $dni = strtoupper($value);
                        $letra = substr($dni, -1);
                        $numeros = substr($dni, 0, 8);
                        if (!is_numeric($numeros)) return false;
                        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) !== $letra) {
                            $error = tr('La letra del DNI no es correcta.') ?? 'La letra del DNI no es correcta.';
                            return false;
                        }
                        return true;
                    },
                ],
                'errors' => [
                    'required'    => tr('El DNI es obligatorio.') ?? 'El DNI es obligatorio.',
                    'regex_match' => tr('El formato del DNI no es válido (ej. 12345678A).') ?? 'El formato del DNI no es válido (ej. 12345678A).',
                    'is_unique'   => tr('El DNI ya está registrado.') ?? 'El DNI ya está registrado.',
                ],
            ],
            'nombre' => [
                'rules'  => 'required|min_length[2]',
                'errors' => [
                    'required'   => tr('El nombre es obligatorio.') ?? 'El nombre es obligatorio.',
                    'min_length' => tr('El nombre es demasiado corto.') ?? 'El nombre es demasiado corto.',
                ],
            ],
            'apellido' => [
                'rules'  => 'required|min_length[2]',
                'errors' => [
                    'required'   => tr('El apellido es obligatorio.') ?? 'El apellido es obligatorio.',
                    'min_length' => tr('El apellido es demasiado corto.') ?? 'El apellido es demasiado corto.',
                ],
            ],
            'gmail' => [
                'rules'  => 'required|valid_email|is_unique[usuario.gmail]',
                'errors' => [
                    'required'    => tr('El correo es obligatorio.') ?? 'El correo es obligatorio.',
                    'valid_email' => tr('El formato del correo no es válido.') ?? 'El formato del correo no es válido.',
                    'is_unique'   => tr('El correo ya está registrado.') ?? 'El correo ya está registrado.',
                ],
            ],
            'contrasenia' => [
                'rules'  => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>]).*$/]',
                'errors' => [
                    'required'    => tr('La contraseña es obligatoria.') ?? 'La contraseña es obligatoria.',
                    'min_length'  => tr('La contraseña debe tener al menos 8 caracteres.') ?? 'La contraseña debe tener al menos 8 caracteres.',
                    'regex_match' => tr('La contraseña debe incluir mayúsculas, minúsculas, números y caracteres especiales.') ?? 'La contraseña debe incluir mayúsculas, minúsculas, números y caracteres especiales.',
                ],
            ],
            'fotoPerfil' => [
                'rules'  => 'max_size[fotoPerfil,2048]|ext_in[fotoPerfil,png,jpg,jpeg]|is_image[fotoPerfil]',
                'errors' => [
                    'max_size' => tr('La foto es demasiado grande (máx 2MB).') ?? 'La foto es demasiado grande (máx 2MB).',
                    'ext_in'   => tr('Solo se permiten imágenes PNG o JPG.') ?? 'Solo se permiten imágenes PNG o JPG.',
                    'is_image' => tr('El archivo seleccionado no es una imagen válida.') ?? 'El archivo seleccionado no es una imagen válida.',
                ],
            ],
        ];

        // Comprobamos si no cumple con las reglas y le devolvemos los errores
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // --- Manejo de la Foto de Perfil (BLOB) ---
        $img = $this->request->getFile('fotoPerfil');
        $contenidoFoto = null;

        if ($img && $img->isValid() && !$img->hasMoved()) {
            // Leemos el archivo como binario (BLOB)
            $contenidoFoto = file_get_contents($img->getTempName());
        } else {
            // Si no suben nada, podemos cargar una imagen por defecto desde el disco y guardarla también como BLOB
            $rutaDefault = FCPATH . 'img/logo.png'; // Usamos el logo como imagen por defecto si no hay otra
            if (file_exists($rutaDefault)) {
                $contenidoFoto = file_get_contents($rutaDefault);
            }
        }

        // Metemos los datos limpios en un array listos para enviar a la base de datos
        $data = [
            'dni'         => $this->request->getPost('dni'),
            'nombre'      => $this->request->getPost('nombre'),
            'apellido'    => $this->request->getPost('apellido'),
            'gmail'       => $this->request->getPost('gmail'),
            // ¡MUY IMPORTANTE!: Encriptamos la contraseña para que ni el administrador pueda leerla
            'contrasenia' => password_hash($this->request->getPost('contrasenia'), PASSWORD_DEFAULT),
            'foto'        => $contenidoFoto
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
