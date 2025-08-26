<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CarritoItem extends Model
{
    use HasFactory;
    protected $fillable = ["carrito_id","valorizacion_id","nombre","fecha_vencimiento","precio_unitario","cantidad","total"];

}
