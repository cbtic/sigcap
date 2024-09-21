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

    public function listar_partida_presupuestal_ajax($p){

        return $this->readFuntionPostgres('sp_listar_partida_presupuestal_paginado',$p);

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
