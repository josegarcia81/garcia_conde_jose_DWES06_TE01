<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'trabajadores';
    protected $primaryKey = 'idTrabajador'; // Si la clave primaria no es 'id'

    public $timestamps = false;

    // Datos que vamos a recoger
    protected $fillable = [
        'idTrabajador',
        'nombreTrabajador',
        'apellido1',
        'apellido2',
        'dni',
        'telefono',
        'direccion',
        'email',
    ];
}
