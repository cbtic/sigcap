<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Movilidade extends Model
{
    use HasFactory;

    public function listar_movilidad2_ajax($p){

        return $this->readFuntionPostgres('sp_listar_movilidad_paginado',$p);

    }
	
	function getMesByPeriodo($id_periodo){

        $cad = "select to_char(mes::date,'yyyymm')mes,to_char(mes::date,'mm')mes_ ,to_char(mes::date,'yyyy')anio
from generate_series(
(select fecha_inicio from periodo_comisiones pc where id=".$id_periodo." and estado='1'), 
(select fecha_fin from periodo_comisiones pc where id=".$id_periodo." and estado='1'), 
'1 month'::interval) mes";

		$data = DB::select($cad);
        return $data;
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
