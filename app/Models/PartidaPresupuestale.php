<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PartidaPresupuestale extends Model
{
    use HasFactory;

    function getPartidaPresupuestalAll(){

        $cad = "select *
                from partida_presupuestales
                where estado='1'
                order by denominacion ";
    
		$data = DB::select($cad);
        return $data;
    }
}
