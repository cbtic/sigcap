<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TablaMaestra extends Model
{
    use HasFactory;
	
	function getMaestroByTipo($tipo){

        $cad = "select id,codigo,denominacion 
                from tabla_maestras 
                where tipo='".$tipo."' 
				and estado='1' 
                order by orden ";
    
		$data = DB::select($cad);
        return $data;
    }
	
	
}
