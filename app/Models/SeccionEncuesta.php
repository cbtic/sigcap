<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeccionEncuesta extends Model
{
    use HasFactory;

    protected $fillable = ['encuesta_id', 'titulo', 'descripcion', 'orden'];

    public function preguntas()
    {
        return $this->hasMany(PreguntaEncuesta::class)->orderBy('orden');
    }

    public function encuesta()
    {
        return $this->belongsTo(Encuesta::class);
    }
}