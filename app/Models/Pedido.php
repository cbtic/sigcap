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
        
        $cad = "select p.id,p.purchase_number,p.amount,p.email,p.response,p.subtotal,p.descuento_total,p.total_general,p.estado,p.id_comprobante,
                        p.response::json->'dataMap'->>'YAPE_ID' yape,p.response::json->'dataMap'->>'STATUS' status, (select c2.id from comprobantes c2 where   c2.id_comprobante_ncnd=p.id_comprobante limit 1) id_nc   
                from pedidos p 
                where p.usuario_id=".$id_usuario." 
                order by 1 desc";
		$data = DB::select($cad);
        return $data;

    }


}
