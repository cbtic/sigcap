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

    public function listar_centro_costo_ajax($p){

        return $this->readFuntionPostgres('sp_listar_centro_costo_paginado',$p);

    }

    public function readFuntionPostgres($function, $parameters = null){

        $_parameters = '';
        if (count($parameters) > 0) {
            $_parameters = implode("','", $parameters);
            $_parameters = "'" . $_parameters . "',";
        }
        $data = DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
        $data = DB::select($cad);
        $cad = "FETCH ALL IN ref_cursor;";
        $data = DB::select($cad);
        return $data;

    }
}
