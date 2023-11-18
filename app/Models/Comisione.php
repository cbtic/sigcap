<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Comisione extends Model
{
    //use HasFactory;

    public function listar_comision_ajax($p){

        return $this->readFuntionPostgres('sp_listar_municipalidad_comision_paginado',$p);

    }

    public function listar_municipalidad_integrada_ajax($p){

        return $this->readFuntionPostgres('sp_listar_municipalidad_integrada_paginado',$p);

    }

    public function listar_comision_integrada_ajax($p){

        return $this->readFuntionPostgres('sp_listar_comision_paginado',$p);

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

    function getComisionAll($cad_id){

        $cad = " select c.*,tm.denominacion tipo_agrupacion, cm.monto from comisiones c
        inner join municipalidad_integradas mi on c.id_municipalidad_integrada = mi.id
        inner join tabla_maestras tm on mi.id_tipo_agrupacion ::int =tm.codigo::int and tm.tipo='99'
        left join comision_movilidades cm on cm.id_municipalidad_integrada =mi.id 
        where mi.estado='1' ";

        if($cad_id!="" && $cad_id!="0"){
            $cad .= "and c.id_municipalidad_integrada in (".$cad_id.")";
        }

		$data = DB::select($cad);
        return $data;
    }

    function getCodigoComision($id_municipalidad_integrada){

        $cad = "select lpad((count(*)+1)::varchar,2,'0') codigo from comisiones c where id_municipalidad_integrada=".$id_municipalidad_integrada." and estado ='1'";
        //echo $cad;exit();
		$data = DB::select($cad);
        return $data[0]->codigo;
    }


}
