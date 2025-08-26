<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Carrito extends Model
{
    use HasFactory;

    function getCarritoDetalle($id_carrito)
    {

        $cad = "select ci.id,ci.nombre,ci.fecha_vencimiento,ci.precio_unitario,ci.cantidad,ci.total,c.total_general
from carritos c 
inner join carrito_items ci on c.id=ci.carrito_id 
where c.id=".$id_carrito;

        $data = DB::select($cad);
        return $data;
    }
    

}
