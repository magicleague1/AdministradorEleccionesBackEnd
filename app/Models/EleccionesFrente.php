<?php


namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class EleccionesFrente extends Model
{
    protected $table = 'Elecciones_Frente';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'COD_ELECCION',
        'COD_FRENTE',
    ];

   
    // Si deseas agregar relaciones, puedes definirlas aquí
    // Ejemplo: relación con la tabla 'elecciones'
    public function eleccion()
    {
        return $this->belongsTo(Elecciones::class, 'COD_ELECCION', 'cod_eleccion');
    }

    // Ejemplo: relación con la tabla 'frente'
    public function frente()
    {
        return $this->belongsTo(Frente::class, 'COD_FRENTE', 'COD_FRENTE');
    }
}
