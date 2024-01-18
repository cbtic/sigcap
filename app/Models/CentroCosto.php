<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CentroCosto extends Model
{
    use HasFactory;

    function getCentroCostoAll(){

        $cad = "select *
                from centro_costos
                where estado='1'
                order by denominacion ";
    
		$data = DB::select($cad);
        return $data;
    }
}
