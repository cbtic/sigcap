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

    function getMunicipalidadIntegradaAll($periodo,$tipo_agrupacion,$tipo_comision){

        $cad = "select mi.*,tm.denominacion tipo_agrupacion, cm.monto from municipalidad_integradas mi
        inner join tabla_maestras tm on mi.id_tipo_agrupacion ::int =tm.codigo::int and tm.tipo='99'
        left join comision_movilidades cm on cm.id_municipalidad_integrada =mi.id 
        where mi.estado='1' and mi.id_tipo_agrupacion::varchar ilike '%".$tipo_agrupacion."'
		and mi.id_periodo_comision='".$periodo."'";
		
		if($tipo_comision>0){
			$cad .= " and mi.id_tipo_comision='".$tipo_comision."'";
		}
			//$cad .= " and mi.estado='1' order by 1 desc ";
		$cad .= " and mi.estado='1' order by mi.denominacion asc "; 
		

		$data = DB::select($cad);
        return $data;
    }
	
	function getMunicipalidadDetalle($id_periodo_comision,$id_tipo_comision,$municipalidad){

        $cad = "select distinct m.denominacion from mucipalidad_detalles md
inner join municipalidad_integradas mi on md.id_municipalidad_integrada=mi.id  
inner join municipalidades m on md.id_municipalidad=m.id
where mi.id_periodo_comision='".$id_periodo_comision."' 
and mi.id_tipo_comision = ".$id_tipo_comision."
and m.denominacion='".$municipalidad."' 
and mi.estado='1'";

		$data = DB::select($cad);
        return $data;
    }
	
	function getMunicipalidadDetalleById($id){

        $cad = "select md.id,m.denominacion 
from mucipalidad_detalles md
inner join municipalidad_integradas mi on md.id_municipalidad_integrada=mi.id  
inner join municipalidades m on md.id_municipalidad=m.id
where mi.id='".$id."'  
and md.estado='1'
and mi.estado='1'";

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

    function getMuniIntegradaByPeriodoAndTipComisionMovilidad($id_periodo,$id_tipo_comision){

        $cad = "select mi.*
        from municipalidad_integradas mi
        where mi.estado='1'
        and mi.id_periodo_comision='".$id_periodo."'
        and mi.id_tipo_comision='".$id_tipo_comision."'";

		$data = DB::select($cad);
        return $data;
    }

    function getMuniIntegradaByPeriodoAndTipComision($id_periodo,$id_tipo_comision){

        $cad = "select mi.*
        from municipalidad_integradas mi
        where mi.estado='1'
        and mi.id_periodo_comision='".$id_periodo."'
        and mi.id_tipo_comision='".$id_tipo_comision."'
        and mi.id not in(select distinct id_comision from comision_delegados cd where estado='1')";

		$data = DB::select($cad);
        return $data;
    }
}
