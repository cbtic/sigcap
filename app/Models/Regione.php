<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Regione extends Model
{
    use HasFactory;
	
	function getRegionAll(){

        $cad = "select *
                from regiones
                where estado='1' 
                order by denominacion ";
    
		$data = DB::select($cad);
        return $data;
    }
	
}
