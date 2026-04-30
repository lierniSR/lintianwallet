<?php

namespace App\Models;

use CodeIgniter\Model;

// Modelo que hace de puente entre la aplicación y la tabla de ingresos
class M_Ingreso extends Model
{
    // Nombre exacto de la tabla en la base de datos
    protected $table = 'ingresos';
    
    // Identificador principal (id)
    protected $primaryKey = 'id';

    // El sistema numera los ingresos nuevos de uno en uno automáticamente
    protected $useAutoIncrement = true;

    // Las respuestas de nuestra base de datos vendrán como objetos en vez de arrays
    protected $returnType = 'object';

    // Lista de propiedades que están autorizadas para ser modificadas o insertadas
    protected $allowedFields = ['id', 'dinero', 'fecha', 'id_cuenta'];
}
