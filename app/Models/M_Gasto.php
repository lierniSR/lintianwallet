<?php

namespace App\Models;

use CodeIgniter\Model;

// Este modelo nos permite registrar y acceder a los gastos almacenados
class M_Gasto extends Model
{
    // Vinculamos la clase a la tabla 'gastos' de phpMyAdmin/MySQL
    protected $table = 'gastos';
    
    // La fila identificadora única
    protected $primaryKey = 'id';

    // Para que cada nuevo gasto coja el id siguiente al anterior
    protected $useAutoIncrement = true;

    // Así trabajamos con los resultados de forma más limpia (con flechitas ->)
    protected $returnType = 'object';

    // Evita inyecciones de datos, solo pasamos información a estas columnas en específico
    protected $allowedFields = ['id', 'dinero', 'fecha', 'id_cuenta', 'id_subcategoria'];
}
