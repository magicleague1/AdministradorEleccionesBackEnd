<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Elecciones extends Model
{
    protected $table = 'eleccioness'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'COD_ELECCION'; // Clave primaria
    public $timestamps = true; // Habilitar los campos created_at y updated_at
   
    protected $fillable = [
        'COD_ADMIN',
        'COD_FRENTE',
        'COD_TEU',
        'COD_COMITE',
        'MOTIVO_ELECCION',
        'FECHA_ELECCION',
        'FECHA_INI_CONVOCATORIA',
        'FECHA_FIN_CONVOCATORIA',
        'ELECCION_ACTIVA',
    ];
}
