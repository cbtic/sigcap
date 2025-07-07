<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestaEncuesta extends Model
{
    use HasFactory;

    protected $fillable = [
        'pregunta_id',
        'expediente_id',
        'respuesta',
        'evaluador_id' // Opcional: para identificar al evaluador si es necesario
    ];

    protected $casts = [
        'respuesta' => 'array' // Para respuestas que pueden ser arrays (como checkbox)
    ];

    /**
     * Relación con la pregunta respondida
     */
    public function pregunta()
    {
        return $this->belongsTo(PreguntaEncuesta::class);
    }

    /**
     * Relación con el expediente asociado
     */
    public function expediente()
    {
        return $this->belongsTo(Expediente::class);
    }

    /**
     * Relación con el evaluador (si aplica)
     */
    public function evaluador()
    {
        return $this->belongsTo(Evaluadore::class);
    }

    /**
     * Accesor para formatear la respuesta según el tipo de pregunta
     */
    public function getRespuestaFormateadaAttribute()
    {
        switch ($this->pregunta->tipo_respuesta) {
            case 'checkbox':
                return implode(', ', json_decode($this->respuesta, true));
            case 'radio':
            case 'select':
                return $this->pregunta->opciones[$this->respuesta] ?? $this->respuesta;
            case 'rango':
                return "{$this->respuesta}/{$this->pregunta->opciones['max']}";
            default:
                return $this->respuesta;
        }
    }
}