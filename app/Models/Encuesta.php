<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'descripcion', 'activa'];

    public function secciones()
    {
        //print_r("1"); exit();
        return $this->hasMany(SeccionEncuesta::class)->orderBy('orden');
    }
}