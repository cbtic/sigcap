<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Pedido extends Model
{
    use HasFactory;
    
    protected $fillable = ["purchase_number","amount","email","response","usuario_id","subtotal","descuento_total","impuesto_total","envio_total","total_general","estado"];

}
