<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Reporte extends Model
{
    use HasFactory;

    function getReporteAll(){

        $cad = "select *
                from reportes
                where estado='1' 
                order by descripcion ";
    
		$data = DB::select($cad);
        return $data;
    }
}
