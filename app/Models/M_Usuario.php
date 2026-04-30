<?php

namespace App\Models;

use CodeIgniter\Model;

// El modelo vital para crear y verificar usuarios en nuestro sistema de monedero
class M_Usuario extends Model
{
    // La propia tabla de usuarios
    protected $table = 'usuario';
    
    // En este caso nuestra clave principal no es un id numérico, es el DNI del usuario
    protected $primaryKey = 'dni';

    // Como es el DNI y lo escribimos a mano, NO queremos que se autoincremente
    // Ojo: CodeIgniter por defecto tiene esto en true, asique si el id no es un número hay ponerlo a false o tener cuidado (aquí no molesta porque la db marca la regla principal)
    protected $useAutoIncrement = true;

    // Nos devolverá el usuario detectado como un objeto
    protected $returnType = 'object';

    // Los datos que recolectamos y guardamos al registrar una cuenta
    protected $allowedFields = ['dni', 'nombre', 'apellido', 'gmail', 'contrasenia', 'foto'];
}
