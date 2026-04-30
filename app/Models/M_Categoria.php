<?php

namespace App\Models;

use CodeIgniter\Model;

// Modelo estándar para conectar con la tabla de categorías
class M_Categoria extends Model
{
    // Nombre de la tabla en nuestra base de datos
    protected $table = 'categoria';
    
    // Identificador principal de la tabla
    protected $primaryKey = 'id';

    // Le decimos que el id o primary key se genera y suma automáticamente
    protected $useAutoIncrement = true;

    // Hacemos que al consultar nos devuelva objetos, así es más fácil acceder (ej: $categoria->nombre)
    protected $returnType = 'object';

    // Solo los campos que ponemos aquí son los que permitimos rellenar o modificar por seguridad
    protected $allowedFields = ['id', 'nombre'];
}
