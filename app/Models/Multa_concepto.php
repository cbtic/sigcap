<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Multa_concepto extends Model
{
    use HasFactory;
	
	function getMulta_conceptoAll(){

        $cad = "select *
                from multas
                where estado='1' 
                order by denominacion ";
    
		$data = DB::select($cad);
        return $data;
    }
}
