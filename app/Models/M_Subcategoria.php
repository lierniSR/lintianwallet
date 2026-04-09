<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Subcategoria extends Model
{

    protected $table = "subcategoria";
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType =  'object';   //'array' u ' object'

    protected $allowedFields = ['id', 'nombre', 'id_categoria'];
}
