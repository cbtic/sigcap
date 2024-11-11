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
        where t1.estado='1' 
        order by t1.denominacion asc";
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

    function getMunicipalidadCoordinador($id,$periodo){

        $cad = "select m.*,tm.denominacion tipo_coordinador from coordinador_zonal_detalles czd 
        inner join municipalidades m on czd.id_municipalidad = m.id
        inner join tabla_maestras tm on czd.id_tipo_coordinador = tm.codigo::int and  tm.tipo ='117'
        inner join coordinador_zonales cz on czd.id_tipo_coordinador = cz.id_zonal 
        where cz.id ='".$id."' and czd.estado ='1' and czd.periodo='".$periodo."' order by denominacion asc ";
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

    function getIdUbigeoByMunicipalidad($distrito){

        $cad = "select m.id, m.denominacion from municipalidades m
        inner join ubigeos u on m.id_ubigeo = u.id_ubigeo 
        where u.id_ubigeo ='".$distrito."' and m.estado ='1'";
        //echo($cad);
		$data = DB::select($cad);
        return $data;
    }
    
}
