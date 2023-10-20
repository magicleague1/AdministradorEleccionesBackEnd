<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;

    protected $table = 'administrador'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'CODADMINISTRADOR'; // Clave primaria
    public $incrementing = false; // Si la clave primaria es autoincrementable
    protected $keyType = 'string'; // Tipo de dato de la clave primaria

    protected $fillable = [
        'CODCOMITE',
        'nombreadministrador',
        'contrasenaadministrador',
        'correo',
        'telefono',
    ];

    // Resto de tu modelo y relaciones si las tienes
}
