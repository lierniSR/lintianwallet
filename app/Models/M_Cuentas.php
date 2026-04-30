<?php

namespace App\Models;

use CodeIgniter\Model;

// Modelo que utilizamos para manejar la tabla de cuentas del usuario en la billetera
class M_Cuentas extends Model
{
    // Tabla a la que nos conectamos en la base de datos
    protected $table = 'cuenta';
    
    // Clave principal
    protected $primaryKey = 'id';

    // Indica que los números de la clave principal suben automáticamente
    protected $useAutoIncrement = true;

    // Al pedir datos, queremos objetos en vez de un array común
    protected $returnType = 'object';

    // Las columnas que nuestra aplicación puede escribir y actualizar libremente
    protected $allowedFields = ['id', 'saldoTotal', 'id_usuario', 'id_categoria'];
}
