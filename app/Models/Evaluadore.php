<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluadore extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'numero_cap',
        'tipo',
        'especialidad'
    ];
}