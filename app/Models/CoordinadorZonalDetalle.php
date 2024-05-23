<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CoordinadorZonalDetalle extends Model
{
    use HasFactory;

    public function listar_coordinadorZonal_detalle_ajax($p){
 
        return $this->readFuntionPostgres('sp_listar_coordinador_zonal_detalle_paginado',$p);

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

    function getZonalDetalle($zonal,$id_periodo){

        $cad = "select czd.id, tm.denominacion tipo_coordinador, m.denominacion municipalidad, pc.descripcion periodo, czd.estado from coordinador_zonal_detalles czd
        inner join tabla_maestras tm on czd.id_tipo_coordinador = tm.codigo::int and  tm.tipo ='117'
        inner join municipalidades m on czd.id_municipalidad = m.id
        inner join periodo_comisiones pc on czd.periodo::int = pc.id
        where czd.id_tipo_coordinador='".$zonal."' and pc.id='".$id_periodo."' and czd.estado='1'";
    
		$data = DB::select($cad);
        return $data;
    }
}
