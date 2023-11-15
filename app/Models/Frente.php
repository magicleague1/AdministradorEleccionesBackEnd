<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frente extends Model
{
    use HasFactory;
    protected $table = 'frentes'; 
    protected $keyType = 'integer';
    protected $primaryKey = 'COD_FRENTE';
    protected $guarded = [];
    public $timestamps = false;
    protected $fillable = ['NOMBRE_FRENTE', 'SIGLA_FRENTE', 'LOGO', 'COD_MOTIVO'];

    
    public function eleccion(){
        return $this->hasMany(Eleccion::class, 'COD_ELECCION');
    }

    public function candidato(){
        return $this->hasMany(Candidato::class, 'COD_FRENTE');
    }

    public function motivoEliminacion()
    {
        return $this->belongsTo(MotivoEliminacion::class, 'COD_MOTIVO');
    }
}
