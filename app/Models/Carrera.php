<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carrera'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'COD_CARRERA'; // Nombre de la clave primaria

    protected $fillable = [
        'COD_FACULTAD',
        'NOMBRE_CARRERA',
        'DESCRIPCION'
    ];

    public function facultad()
    {
        return $this->belongsTo(Facultad::class, 'COD_FACULTAD');
    }
}
