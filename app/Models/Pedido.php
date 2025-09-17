<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Pedido extends Model
{
    use HasFactory;
    
    protected $fillable = ["purchase_number","amount","email","response","usuario_id","subtotal","descuento_total","impuesto_total","envio_total","total_general","estado"];

    function getPedidoByUsuario($id_usuario){  
        
        $cad = "select p.id,p.purchase_number,p.amount,p.email,p.response,p.subtotal,p.descuento_total,p.total_general,p.estado  
from pedidos p 
order by 1 desc";
		$data = DB::select($cad);
        return $data;

    }


}
