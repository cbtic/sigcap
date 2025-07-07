<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreguntaEncuesta extends Model
{
    use HasFactory;

    protected $fillable = ['seccion_id', 'pregunta', 'tipo_respuesta', 'requerida', 'orden', 'opciones'];

    protected $casts = [
        'opciones' => 'array',
        'requerida' => 'boolean'
    ];

    public function seccion()
    {
        return $this->belongsTo(SeccionEncuesta::class);
    }
}