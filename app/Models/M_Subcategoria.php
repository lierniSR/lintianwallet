<?php

namespace App\Models;

use CodeIgniter\Model;

// Modelo encargado de obtener o guardar todas las posibles subcategorías (ej: Restaurantes, Gasolina)
class M_Subcategoria extends Model
{
    // Referencia a nuestra tabla
    protected $table = 'subcategoria';
    
    // ID único de nuestra subcategoría
    protected $primaryKey = 'id';

    // Permite que MySQL ponga los IDs por nosotros
    protected $useAutoIncrement = true;

    // Establecemos el modo objeto porque es más útil manejándolo después en la vista
    protected $returnType = 'object';

    // Información permitida (la subcategoria está atada a una categoria gigante a través de id_categoria)
    protected $allowedFields = ['id', 'nombre', 'id_categoria'];
}
