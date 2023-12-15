<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Municipalidade extends Model
{
   
    public function listar_municipalidad($p){

        return $this->readFuntionPostgres('sp_listar_municipalidad_paginado',$p);

    }

    function getMunicipalidadAll(){

        $cad = "select t1.*,tm.denominacion tipo_municipalidad
        from municipalidades t1
        inner join tabla_maestras tm on t1.id_tipo_municipalidad::int =tm.codigo::int and tm.tipo='43'
        where t1.estado='1' ";
		$data = DB::select($cad);
        return $data;
    }

    function getMunicipalidadOrden(){

        $cad = "select t1.*,tm.denominacion tipo_municipalidad
        from municipalidades t1
        inner join tabla_maestras tm on t1.id_tipo_municipalidad::int =tm.codigo::int and tm.tipo='43'
        where t1.estado='1' order by denominacion asc ";
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
