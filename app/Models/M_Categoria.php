<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Categoria extends Model
{

    protected $table = "categoria";
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType =  'object';   //'array' u ' object'

    protected $allowedFields = ['id', 'nombre'];
}
