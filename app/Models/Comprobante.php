<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Comprobante extends Model
{
    use HasFactory;
	
	function getComprobanteByTipoSerieNumero($numero_comprobante){

        $cad = "select * 
				from comprobantes c 
				where tipo||serie||'-'||numero='".$numero_comprobante."'";
    
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
	
}
