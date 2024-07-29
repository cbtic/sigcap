<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComisionMovilidade extends Model
{
    use HasFactory;

    public function listar_movilidad_ajax($p){

        return $this->readFuntionPostgres('sp_listar_movilidad_paginado',$p);

    }

	public static function getMovilidadByPeriodo($id_periodo,$anio,$mes){

        $cad = "select cm.id,mi.id id_municipalidad_integrada, mi.denominacion comision, pc.descripcion periodo, r.denominacion regional, cm.monto, tm.denominacion, cm.estado 
,(select count(distinct t4.id_municipalidad_integrada)
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
where t0.id_aprobar_pago=2 
And t1.id_periodo_comisione = ".$id_periodo."
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and t4.id_municipalidad_integrada=mi.id)cantidad
from comision_movilidades cm 
inner join municipalidad_integradas mi  on cm.id_municipalidad_integrada = mi.id
inner join periodo_comisiones pc on cm.id_periodo_comisiones = pc.id
inner join regiones r on cm.id_regional = r.id
inner join tabla_maestras tm on cm.id_tipo_comision::int =tm.codigo::int and tm.tipo='102'
where 1=1 ";

		if($id_periodo>0){
			$cad .= " And cm.id_periodo_comisiones=".$id_periodo;
		}
		
		$cad .= " Order By cm.id Desc";
		
		$data = DB::select($cad);
        return $data;
    }
	
	public static function getMovilidadMesByPeriodoAndMunicipalidad($id_periodo,$anio,$mes,$id_municipalidad_integrada){

        $cad = "select count(distinct t4.id_municipalidad_integrada)cantidad,cm.monto
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
inner join comision_movilidades cm on cm.id_periodo_comisiones=t1.id_periodo_comisione and cm.id_municipalidad_integrada=t4.id_municipalidad_integrada
where t0.id_aprobar_pago=2 
And t1.id_periodo_comisione = ".$id_periodo."
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and t4.id_municipalidad_integrada=".$id_municipalidad_integrada."
group by cm.id";
		
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
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
