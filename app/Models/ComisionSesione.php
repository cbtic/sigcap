<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComisionSesione extends Model
{
	
	public static function getDistritoSesion($anio,$mes,$id_municipalidad_integrada){

        $cad = "select distinct u.id_ubigeo,u.desc_ubigeo distrito
from comision_sesiones t1 
inner join comision_sesion_dictamenes csd on t1.id=csd.id_comision_sesion 
inner join solicitudes s2 on s2.id=csd.id_solicitud
inner join ubigeos u on s2.id_ubigeo=u.id_ubigeo
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
where t0.id_aprobar_pago=2
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."' 
and t4.id_municipalidad_integrada=".$id_municipalidad_integrada;
		$data = DB::select($cad);
        return $data;
    }
	
	public static function getComisionDistritoSesion($anio,$mes,$id_ubigeo){

        $cad = "select distinct t4.id,t4.comision comision
from comision_sesiones t1 
inner join comision_sesion_dictamenes csd on t1.id=csd.id_comision_sesion 
inner join solicitudes s2 on s2.id=csd.id_solicitud
inner join ubigeos u on s2.id_ubigeo=u.id_ubigeo
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
where t0.id_aprobar_pago=2
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and u.id_ubigeo = '".$id_ubigeo."'";

		$data = DB::select($cad);
        return $data;
    }
	
	public static function getDelegadoComisionDistritoSesion($anio,$mes,$id_ubigeo,$id_comision){

        $cad = "select distinct case when t0.id_agremiado>0 then 'AE' else 'T' end tipo,a.id,p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres delegado,a.numero_cap
from comision_sesiones t1 
inner join comision_sesion_dictamenes csd on t1.id=csd.id_comision_sesion 
inner join solicitudes s2 on s2.id=csd.id_solicitud
inner join ubigeos u on s2.id_ubigeo=u.id_ubigeo
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
left join comision_delegados cd on t0.id_delegado=cd.id  
left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id
inner join personas p on a.id_persona=p.id 
where t0.id_aprobar_pago=2
and t0.estado='1'
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and u.id_ubigeo = '".$id_ubigeo."' 
and t1.id_comision=".$id_comision;

		$data = DB::select($cad);
        return $data;
    }
	
	public static function getDelegadoComisionSesionCoordinadorZonal($anio,$mes,$id_municipalidad_integrada){

        $cad = "select distinct 'CZ' tipo,a.id,p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres delegado,a.numero_cap
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
left join comision_delegados cd on t0.id_delegado=cd.id  
left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id
inner join coordinador_zonales cz on a.id=cz.id_agremiado and t4.id=cz.id_comision and t1.id_periodo_comisione=cz.id_periodo 
inner join personas p on a.id_persona=p.id 
where t0.id_aprobar_pago=2
and t0.estado='1'
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and t4.id_municipalidad_integrada = ".$id_municipalidad_integrada;

		$data = DB::select($cad);
        return $data;
    }
	
	public static function getFechaDelegadoComisionDistritoSesion($anio,$mes,$id_ubigeo,$id_comision,$id_agremiado,$fecha){
		
		//select case when id_tipo_sesion='401' and t0.id_delegado>0 then 'O' when id_tipo_sesion='402' and t0.id_delegado>0 then 'E'  else 'AE' end tipo_sesion
        $cad = "select case when id_tipo_sesion='401' then 'O' when id_tipo_sesion='402' then 'E' end tipo_sesion 
from comision_sesiones t1 
inner join comision_sesion_dictamenes csd on t1.id=csd.id_comision_sesion 
inner join solicitudes s2 on s2.id=csd.id_solicitud
inner join ubigeos u on s2.id_ubigeo=u.id_ubigeo
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
left join comision_delegados cd on t0.id_delegado=cd.id  
left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id
inner join personas p on a.id_persona=p.id 
where t0.id_aprobar_pago=2
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and u.id_ubigeo = '".$id_ubigeo."' 
and t1.id_comision=".$id_comision."
and a.id=".$id_agremiado."
and to_char(t1.fecha_ejecucion,'dd-mm-yyyy')='".$fecha."'";

		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
	
	public static function getFechaDelegadoComisionSesionCoordinadorZonal($anio,$mes,$id_municipalidad_integrada,$id_agremiado,$fecha){
		
		//select case when id_tipo_sesion='401' and t0.id_delegado>0 then 'O' when id_tipo_sesion='402' and t0.id_delegado>0 then 'E'  else 'AE' end tipo_sesion
        $cad = "select 'E' tipo_sesion 
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
left join comision_delegados cd on t0.id_delegado=cd.id  
left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id
inner join personas p on a.id_persona=p.id 
where t0.id_aprobar_pago=2
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and t4.id_municipalidad_integrada = ".$id_municipalidad_integrada." 
and a.id=".$id_agremiado."
and to_char(t1.fecha_ejecucion,'dd-mm-yyyy')='".$fecha."'";

		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
			
	public static function getMunicipalidadSesion($id_periodo,$anio,$mes){

        $cad = "select distinct mi.id,mi.denominacion municipalidad
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
where t0.id_aprobar_pago=2
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."' 
And t1.id_periodo_comisione = ".$id_periodo." 
and t4.denominacion not ilike '%coordinador%'";
		$data = DB::select($cad);
        return $data;
    }
	
	public static function getMunicipalidadSesionCoordinadorZonal($id_periodo,$anio,$mes){

        $cad = "select distinct mi.id,mi.denominacion municipalidad
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
where t0.id_aprobar_pago=2
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."' 
And t1.id_periodo_comisione = ".$id_periodo." 
and t4.denominacion ilike '%coordinador%'";
		$data = DB::select($cad);
        return $data;
    }
	
	public function getComisionMunicipalidadSesion($anio,$mes,$id_municipalidad_integrada){

        $cad = "select distinct t4.id,t4.comision comision
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
where t0.id_aprobar_pago=2
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and t4.id_municipalidad_integrada = ".$id_municipalidad_integrada;

		$data = DB::select($cad);
        return $data;
    }
	
	public function getDelegadoComisionMunicipalidadSesion($anio,$mes,$id_municipalidad_integrada,$id_comision){

        $cad = "select distinct a.id,p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres delegado,a.numero_cap
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
inner join comision_delegados cd on t0.id_delegado=cd.id  
inner join agremiados a on cd.id_agremiado=a.id 
inner join personas p on a.id_persona=p.id 
where t0.id_aprobar_pago=2
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and t4.id_municipalidad_integrada = ".$id_municipalidad_integrada."
and t1.id_comision=".$id_comision;

		$data = DB::select($cad);
        return $data;
    }
	
	public function getFechaDelegadoComisionMunicipalidadSesion($anio,$mes,$id_municipalidad_integrada,$id_comision,$id_agremiado,$fecha){

        $cad = "select count(*) cantidad 
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id
inner join comision_delegados cd on t0.id_delegado=cd.id  
inner join agremiados a on cd.id_agremiado=a.id 
inner join personas p on a.id_persona=p.id 
where t0.id_aprobar_pago=2
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and t4.id_municipalidad_integrada = ".$id_municipalidad_integrada."
and t1.id_comision=".$id_comision."
and a.id=".$id_agremiado."
and to_char(t1.fecha_ejecucion,'dd-mm-yyyy')='".$fecha."'";

		$data = DB::select($cad);
        return $data[0];
    }
	
    public function lista_programacion_sesion_ajax($p){

        return $this->readFunctionPostgres('sp_listar_programacion_sesion_paginado',$p);

    }
	
	public function lista_computo_sesion_ajax($p){

        return $this->readFunctionPostgres('sp_listar_computo_sesion_paginado',$p);

    }
	
	public function lista_computo_cerrado_ajax($p){

        return $this->readFunctionPostgres('sp_listar_computo_cerrado_paginado',$p);

    }
	
	public function readFunctionPostgres($function, $parameters = null){

      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  $data = DB::select("BEGIN;");
	  $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
	  //echo $cad;
	  $data = DB::select($cad);
	  $cad = "FETCH ALL IN ref_cursor;";
	  $data = DB::select($cad);
      return $data;
   }
   
}
