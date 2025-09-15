<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_expediente',
        'municipalidad_tramite',
        'fecha_entrevista',
        'presidente_comision',
        'delegado1',
        'delegado2',
        'especialista',
        'delegado_ad_hoc'
    ];
}