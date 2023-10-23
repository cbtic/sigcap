<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Moneda extends Model
{
    use HasFactory;
	
	function getMonedaAll(){

        $cad = "select *
                from tabla_maestras tm
                where tipo_nombre ='MONEDA' and estado='1'
                order by denominacion ";
                 
		$data = DB::select($cad);
        return $data;
    }
}
