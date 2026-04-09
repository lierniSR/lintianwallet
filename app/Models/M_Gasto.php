<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Gasto extends Model
{

    protected $table = "gastos";
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType =  'object';   //'array' u ' object'

    protected $allowedFields = ['id', 'dinero', 'fecha', 'id_cuenta', 'id_subcategoria'];
}
