<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class MunicipalidadIntegrada extends Model
{
    use HasFactory;

    public function listar_municipalidadIntegrada($p){

        return $this->readFuntionPostgres('sp_listar_municipalidad_integrada_paginado',$p);

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

    function getMunicipalidadIntegradaAll($tipo_agrupacion){

        $cad = "select mi.*,tm.denominacion tipo_agrupacion, cm.monto from municipalidad_integradas mi
        inner join tabla_maestras tm on mi.id_tipo_agrupacion ::int =tm.codigo::int and tm.tipo='99'
        left join comision_movilidades cm on cm.id_municipalidad_integrada =mi.id 
        where mi.estado='1' and mi.id_tipo_agrupacion::varchar ilike '%".$tipo_agrupacion."'";
		$data = DB::select($cad);
        return $data;
    }

    function getMuniIntegradaAll(){

        $cad = "select mi.*,tm.denominacion tipo_agrupacion, cm.monto from municipalidad_integradas mi
        inner join tabla_maestras tm on mi.id_tipo_agrupacion ::int =tm.codigo::int and tm.tipo='99'
        left join comision_movilidades cm on cm.id_municipalidad_integrada =mi.id 
        where mi.estado='1'";
		$data = DB::select($cad);
        return $data;
    }
}
