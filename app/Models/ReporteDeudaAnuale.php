<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ReporteDeudaAnuale extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_cierre',
        'fecha_consulta',
        'id_agremiado',
        'numero_cap',
        'apellidos_nombre',
        'monto',
        'id_usuario_inserta',
    ];

    public function agremiado()
    {
        return $this->belongsTo(Agremiado::class, 'id_agremiado');
    }
}
