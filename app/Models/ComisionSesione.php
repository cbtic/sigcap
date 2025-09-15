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
inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1' 
inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
where --t0.id_aprobar_pago=2 And 
to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."' 
and t4.id_municipalidad_integrada=".$id_municipalidad_integrada;
		$data = DB::select($cad);
        return $data;
    }
	
	public static function getComisionDistritoSesion($anio,$mes,$id_ubigeo,$id_municipalidad_integrada){

        $cad = "select distinct t4.id,t4.comision comision
from comision_sesiones t1 
inner join comision_sesion_dictamenes csd on t1.id=csd.id_comision_sesion 
inner join solicitudes s2 on s2.id=csd.id_solicitud
inner join ubigeos u on s2.id_ubigeo=u.id_ubigeo
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1' 
inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
where t1.id_estado_sesion=290 
/*t0.id_aprobar_pago=2*/
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and u.id_ubigeo = '".$id_ubigeo."'
and t4.id_municipalidad_integrada=".$id_municipalidad_integrada;

		$data = DB::select($cad);
        return $data;
    }
	
	public static function getDelegadoComisionDistritoSesion($anio,$mes,$id_ubigeo,$id_comision){ 

        $cad = "select distinct case when cd.id_puesto=12 or cd.id_puesto=30 then 'S' when t0.id_agremiado>0 then 'AE' else 'T' end tipo,a.id,p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres delegado,a.numero_cap,tmp.denominacion,tmp.orden 
from comision_sesiones t1 
inner join comision_sesion_dictamenes csd on t1.id=csd.id_comision_sesion 
inner join solicitudes s2 on s2.id=csd.id_solicitud
inner join ubigeos u on s2.id_ubigeo=u.id_ubigeo
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1' 
left join comision_delegados cd on t0.id_delegado=cd.id  
left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id
inner join personas p on a.id_persona=p.id 
left join tabla_maestras tmp on cd.id_puesto::int=tmp.codigo::int And tmp.tipo ='94'
where 1=1
--And t0.id_aprobar_pago=2
--And t1.id_estado_aprobacion=2
And t1.id_estado_sesion=290 
and t0.estado='1'
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and u.id_ubigeo = '".$id_ubigeo."' 
and t1.id_comision=".$id_comision." 
order by tmp.orden /*tmp.denominacion*/
";

		$data = DB::select($cad);
        return $data;
    }
	
	public static function getDelegadoComisionSesionCoordinadorZonal($id_periodo,$anio,$mes,$id_municipalidad_integrada){

        $cad = "select distinct 'CZ' tipo,a.id,p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres delegado,a.numero_cap
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1' 
left join comision_delegados cd on t0.id_delegado=cd.id  
left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id
inner join coordinador_zonales cz on a.id=cz.id_agremiado and t4.id=cz.id_comision and t1.id_periodo_comisione=cz.id_periodo 
inner join personas p on a.id_persona=p.id 
where 1=1
--And t0.id_aprobar_pago=2
And t1.id_estado_sesion=290   
and t1.estado='1'
and t0.estado='1'
and t4.denominacion in(select denominacion from tabla_maestras tm where tipo='117' and estado='1')
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and t4.id_municipalidad_integrada = ".$id_municipalidad_integrada."
and t1.id_periodo_comisione=".$id_periodo;

		$data = DB::select($cad);
        return $data;
    }
	
	public static function getFechaDelegadoComisionDistritoSesion($anio,$mes,$id_ubigeo,$id_comision,$id_agremiado,$fecha){
		
		//select case when id_tipo_sesion='401' and t0.id_delegado>0 then 'O' when id_tipo_sesion='402' and t0.id_delegado>0 then 'E'  else 'AE' end tipo_sesion
        $cad = "select case 
						when id_tipo_sesion='401' then
							case 
								when t1.id_estado_aprobacion=2 and t1.id_estado_sesion=290 then 'O' 
								else 'X'
							end
						when id_tipo_sesion='402' then 
							case 
								when t1.id_estado_aprobacion=2 and t1.id_estado_sesion=290 then 'E' 
								else 'X'
							end 
						end tipo_sesion 
						from comision_sesiones t1 				
						inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion
						inner join comision_sesion_dictamenes csd on t1.id=csd.id_comision_sesion 
						inner join solicitudes s2 on s2.id=csd.id_solicitud
						inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1'
--						inner join municipalidad_integradas mi on mi.id=t4.id_municipalidad_integrada														   	
	--					inner join mucipalidad_detalles md on md.id_municipalidad_integrada=mi.id
						--inner join municipalidades m on md.id_municipalidad =m.id
						inner join ubigeos u on  s2.id_ubigeo=u.id_ubigeo
						left join comision_delegados cd on t0.id_delegado=cd.id  
						left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id
						inner join personas p on a.id_persona=p.id
						
						where 1=1
						--And t0.id_aprobar_pago=2
						--And t1.id_estado_aprobacion=2 
						--And t1.id_estado_sesion=290  
						And t0.estado='1' 
						And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
						And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
						and u.id_ubigeo = '".$id_ubigeo."' 
						and t1.id_comision=".$id_comision."
						and a.id=".$id_agremiado."
						and to_char(t1.fecha_ejecucion,'dd-mm-yyyy')='".$fecha."'";

		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
	
	public static function getFechaDelegadoComisionDistritoSesionTemp($anio,$mes,$id_municipalidad_integrada,$id_agremiado){
		
		//select case when id_tipo_sesion='401' and t0.id_delegado>0 then 'O' when id_tipo_sesion='402' and t0.id_delegado>0 then 'E'  else 'AE' end tipo_sesion
        $cad = "select distinct t1.fecha_ejecucion,
						case 
				when id_tipo_sesion='401' then
					case 
						when t1.id_estado_aprobacion=2 and t1.id_estado_sesion=290 then 'O' 
						else 'X'
					end
				when id_tipo_sesion='402' then 
					case 
						when t1.id_estado_aprobacion=2 and t1.id_estado_sesion=290 then 'E' 
						else 'X'
					end 
				end tipo_sesion 
		from comision_sesiones t1 
		inner join comision_sesion_dictamenes csd on t1.id=csd.id_comision_sesion 
		inner join solicitudes s2 on s2.id=csd.id_solicitud
		inner join ubigeos u on s2.id_ubigeo=u.id_ubigeo
		inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
		inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1' 
		left join comision_delegados cd on t0.id_delegado=cd.id  
		left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id
		inner join personas p on a.id_persona=p.id 
		where 1=1
		--And t0.id_aprobar_pago=2
		--And t1.id_estado_aprobacion=2 
		And t1.id_estado_sesion=290  
		And t0.estado='1' 
		And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
		And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
		and t4.id_municipalidad_integrada=".$id_municipalidad_integrada." 
		and a.id=".$id_agremiado."
		--and t0.id_aprobar_pago =2
		and case 
				when id_tipo_sesion='401' then
					case 
				when t1.id_estado_aprobacion=2 and t1.id_estado_sesion=290 then 'O' 
				else 'X'
			end
				when id_tipo_sesion='402' then 
					case 
						when t1.id_estado_aprobacion=2 and t1.id_estado_sesion=290 then 'E' 
						else 'X'
					end
			end!='X'";

		$data = DB::select($cad);
        //if(isset($data[0]))return $data[0];
		return $data;
    }
	
	public static function getFechaDelegadoComisionSesionCoordinadorZonal($anio,$mes,$id_municipalidad_integrada,$id_agremiado,$fecha){
		
		//select case when id_tipo_sesion='401' and t0.id_delegado>0 then 'O' when id_tipo_sesion='402' and t0.id_delegado>0 then 'E'  else 'AE' end tipo_sesion
        $cad = "select 
--'E' tipo_sesion 
case 
	when t0.id_aprobar_pago=2 then 'E' 
	else 'X'
end tipo_sesion 
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1' 
left join comision_delegados cd on t0.id_delegado=cd.id  
left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id
inner join personas p on a.id_persona=p.id 
where 1=1
--And t0.id_aprobar_pago=2
And t1.id_estado_sesion=290 
and t1.estado='1'
and t0.estado='1'
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
inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1' 
inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
where --t0.id_aprobar_pago=2 And 
to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."' 
And t1.id_periodo_comisione = ".$id_periodo." 
and t4.denominacion not in(select denominacion from tabla_maestras tm where tipo='117' and estado='1')
order by mi.denominacion";
		$data = DB::select($cad);
        return $data;
    }
	
	public static function getMunicipalidadSesionCoordinadorZonal($id_periodo,$anio,$mes){

        $cad = "select distinct mi.id,mi.denominacion municipalidad
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1' 
inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
where t0.id_aprobar_pago=2
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."' 
And t1.id_periodo_comisione = ".$id_periodo." 
and t1.estado='1'
and t0.estado='1'
and t4.denominacion in(select denominacion from tabla_maestras tm where tipo='117' and estado='1')";
		$data = DB::select($cad);
        return $data;
    }
	
	public function getComisionMunicipalidadSesion($anio,$mes,$id_municipalidad_integrada){

        $cad = "select distinct t4.id,t4.comision comision
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion 
inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1' 
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
inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1' 
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
inner join comisiones t4 on t1.id_comision=t4.id and t4.estado='1' 
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
	
	public function anularComisionSesion($id,$id_regional,$id_periodo_comisione,$id_tipo_sesion,$id_comision){

        $cad = "update comision_sesiones set
				estado='0'
				where id>=".$id."
				and id_regional=".$id_regional."
				and id_periodo_comisione=".$id_periodo_comisione."
				and id_tipo_sesion=".$id_tipo_sesion."
				and id_comision=".$id_comision."
				and id_estado_sesion=288
				and estado='1'";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	public function anularComisionSesionDelegado($id,$id_regional,$id_periodo_comisione,$id_tipo_sesion,$id_comision){

        $cad = "update comision_sesion_delegados set
				estado='0'
				where id_comision_sesion in (
					select id 
					from comision_sesiones cs
					where id>=".$id."
					and id_regional=".$id_regional."
					and id_periodo_comisione=".$id_periodo_comisione."
					and id_tipo_sesion=".$id_tipo_sesion."
					and id_comision=".$id_comision."
					and id_estado_sesion=288
				)";
				
		$data = DB::select($cad);
        return $data;
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

   /*public function importar_dictamenes_dataLicencia($fecha_ejecucion_formateada,$id_comision,$id_sesion){

	return $this->readFuntionPostgres_('copiar_datalicencia_sesiones("'.$fecha_ejecucion_formateada.'",'.$id_comision.','.$id_sesion.')');

	}

	public function readFuntionPostgres_($function = null){

		$cad = "select " . $function;
		$data = DB::select($cad);
		return $data;
	}*/

	public function importar_dictamenes_dataLicencia($fecha_ejecucion_formateada, $equivaComision, $id_sesion) {
		
		$function = 'copiar_datalicencia_sesiones(:fecha_ejecucion, :id_comision, :id_sesion)';
	
		
		return $this->readFuntionPostgres_($function, [
			'fecha_ejecucion' => $fecha_ejecucion_formateada,
			'id_comision' => $equivaComision,
			'id_sesion' => $id_sesion
		]);
	}
	
	public function readFuntionPostgres_($function = null, $params = []) {
		
		$cad = "SELECT " . $function;
	
		$data = DB::select($cad, $params);
	
		return $data;
	}

	public static function getComisionData($id_comision){

		$cad = "select id_comision_dl FROM equiva_comisiones_dl WHERE id_comision = '".$id_comision."' LIMIT 1";
		//$data = DB::select($cad, ['id_comision' => $id_comision]);
		$data = DB::select($cad);
		return $data;
	}
	
	public function getCalendarioSesion($id_periodo,$anio,$mes){

        $cad = "select count(*) cantidad
				from comision_sesiones t1 
				inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion and t0.estado='1' 
				inner join comisiones t4 on t1.id_comision=t4.id
				inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
				left join comision_delegados cd on t0.id_delegado=cd.id  
				left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id
				inner join personas p on a.id_persona=p.id 
				where 1=1
				and t1.id_periodo_comisione=".$id_periodo."
				And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
				And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
				And t1.id_estado_sesion=290 
				and t1.id_estado_aprobacion=2
				--and t0.id_aprobar_pago=2
				and t1.id in (select id_comision_sesion from comision_sesion_dictamenes)";

		$data = DB::select($cad);
        if(isset($data[0]))return $data[0]->cantidad;
    }
	
	public function getCalendarioCoordinadorZonalSesion($id_periodo,$anio,$mes){

        $cad = "select count(*) cantidad
from comision_sesiones t1 
inner join comision_sesion_delegados t0 on t1.id=t0.id_comision_sesion and t0.estado='1' 
inner join comisiones t4 on t1.id_comision=t4.id
inner join municipalidad_integradas mi on t4.id_municipalidad_integrada = mi.id
left join comision_delegados cd on t0.id_delegado=cd.id  
left join agremiados a on coalesce(cd.id_agremiado,t0.id_agremiado)=a.id
inner join personas p on a.id_persona=p.id 
where 1=1
and t1.id_periodo_comisione=".$id_periodo."
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
And t1.id_estado_sesion=290 
and t1.id_estado_aprobacion=2
and t4.denominacion in(select denominacion from tabla_maestras tm where tipo='117' and estado='1')";

		$data = DB::select($cad);
        if(isset($data[0]))return $data[0]->cantidad;
    }
	
	
}
