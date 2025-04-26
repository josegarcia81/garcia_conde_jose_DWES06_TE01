<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    // Definir el nombre de la tabla
    protected $table = 'incidencias';

    // Si tus columnas no tienen los nombres convencionales 'created_at' y 'updated_at'
    public $timestamps = false; // Si no usas los timestamps

    // Datos que vamos a recoger
    protected $fillable = [
        'idTrabajador',
        'idInstalacion',
        'hora',
        'descripcion',
    ];
}
