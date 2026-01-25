<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Usuario extends Model
{

    protected $table = "usuario";
    protected $primaryKey = 'dni';

    protected $useAutoIncrement = true;

    protected $returnType =  'object';   //'array' u ' object'

    protected $allowedFields = ['dni', 'nombre', 'apellido', 'gmail', 'contrasenia', 'foto'];
}
