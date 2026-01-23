<?php

namespace App\Controllers;

use CodeIgniter\CLI\Console;

class C_Json extends BaseController
{
    public function traducciones()
    {
        $ruta = WRITEPATH . 'data\strings.json';

        if (!file_exists($ruta)) {
            return $this->response->setContentType('application/json')
                ->setBody(json_encode(['error' => 'Archivo no encontrado']));
        }

        $json = file_get_contents($ruta);

        if ($json === false) {
            return $this->response->setContentType('application/json')
                ->setBody(json_encode(['error' => 'No se pudo leer el archivo']));
        }

        $data = json_decode($json, true);

        if ($data === null) {
            return $this->response->setContentType('application/json')
                ->setBody(json_encode(['error' => 'JSON inválido']));
        }

        return $this->response->setContentType('application/json')
            ->setBody(json_encode($data, JSON_PRETTY_PRINT));
    }
}
