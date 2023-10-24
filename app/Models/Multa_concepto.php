<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Multa_concepto extends Model
{
    use HasFactory;
	
	function getMulta_conceptoAll(){

        $cad = "select m.*,tm.denominacion moneda
from multas m
inner join tabla_maestras tm on m.id_moneda::int=tm.codigo::int and tm.tipo='1'
where m.estado='1' 
order by m.denominacion ";
    
		$data = DB::select($cad);
        return $data;
    }
}
