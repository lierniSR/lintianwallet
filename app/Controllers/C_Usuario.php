<?php

namespace App\Controllers;

use App\Models\M_Usuario;

class C_Usuario extends BaseController
{
    public function foto($dni)
    {
        $modelo = new M_Usuario();
        $usuario = $modelo->find($dni);

        if ($usuario && $usuario->foto) {
            return $this->response->setContentType('image/jpeg')->setBody($usuario->foto);
        }

        // Si no hay foto, devolver el logo por defecto
        $path = FCPATH . 'img/logo.png';
        return $this->response->setContentType('image/png')->setBody(file_get_contents($path));
    }
}
