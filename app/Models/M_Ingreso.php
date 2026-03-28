<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Ingreso extends Model
{

    protected $table = "ingresos";
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType =  'object';   //'array' u ' object'

    protected $allowedFields = ['id', 'dinero', 'fecha', 'id_cuenta'];
}
