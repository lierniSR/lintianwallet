<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Cuentas extends Model
{

    protected $table = "cuenta";
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType =  'object';   //'array' u ' object'

    protected $allowedFields = ['id', 'saldoTotal', 'id_usuario', 'id_categoria'];
}
