<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComisionSesionDelegado extends Model
{
    
	function getComisionDelegadosByIdComision($id_comision){

        $cad = "select t1.id,t1.id_agremiado,to_char(t1.created_at,'dd-mm-yyyy')fecha_inscripcion,
t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,t4.denominacion puesto,
t5.denominacion situacion,t1.coordinador   
from comision_delegados t1
inner join agremiados t2 on t1.id_agremiado=t2.id
inner join personas t3 on t2.id_persona=t3.id
inner join tabla_maestras t4 on t1.id_puesto::int = t4.codigo::int And t4.tipo ='94'
inner join tabla_maestras t5 on t2.id_situacion = t5.codigo::int And t5.tipo ='14' 
where id_comision=".$id_comision;

		$data = DB::select($cad);
        return $data;
    }
	
	function getComisionDelegadosByIdPeriodo($id_periodo){

        $cad = "select distinct t1.id_agremiado,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap   
from comision_delegados t1
inner join comisiones t0 on t1.id_comision = t0.id 
inner join agremiados t2 on t1.id_agremiado=t2.id
inner join personas t3 on t2.id_persona=t3.id 
where t0.id_periodo_comisiones=".$id_periodo;

		$data = DB::select($cad);
        return $data;
    }
	
	function getComisionDelegadosByIdPeriodoAgremiado($id_periodo,$id_agremiado){

        $cad = "select t1.id id_delegado,t1.id_comision,t0.denominacion comision  
from comision_delegados t1
inner join comisiones t0 on t1.id_comision = t0.id 
inner join agremiados t2 on t1.id_agremiado=t2.id
inner join personas t3 on t2.id_persona=t3.id 
where t0.id_periodo_comisiones=".$id_periodo."
and t1.id_agremiado=".$id_agremiado;

		$data = DB::select($cad);
        return $data;
    }
	
	function getComisionSesionDelegadosByIdComisionSesion($id_comision_sesion){ 
		/*
        $cad = " select 
t1.id,t1.id_agremiado,t1.puesto_postula,t5.periodo,t6.denominacion tipo_concurso,
to_char(t1.created_at,'dd-mm-yyyy')fecha_inscripcion,
t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
t7.denominacion situacion,t8.denominacion region,t1.puntaje,t1.resultado,t11.denominacion puesto 
from concurso_inscripciones t1 
inner join agremiados t2 on t1.id_agremiado=t2.id
inner join personas t3 on t2.id_persona=t3.id
inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
inner join concursos t5 on t4.id_concurso=t5.id
inner join tabla_maestras t6 on t5.id_tipo_concurso=t6.codigo::int and t6.tipo='93'
inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo ='14' 
inner join regiones t8 on t2.id_regional = t8.id
left join tabla_maestras t11 on t1.puesto_postula::int = t11.codigo::int And t11.tipo ='94' ";
		*/
		$cad = "select t0.id,coalesce(t1.id_agremiado,t0.id_agremiado)id_agremiado,to_char(t1.created_at,'dd-mm-yyyy')fecha_inscripcion,
t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,t4.denominacion puesto,
t5.denominacion situacion,t0.coordinador,t0.id_delegado,t0.id_aprobar_pago     
from comision_sesion_delegados t0 
left join comision_delegados t1 on t0.id_delegado=t1.id
left join agremiados t2 on coalesce(t1.id_agremiado,t0.id_agremiado)=t2.id
inner join personas t3 on t2.id_persona=t3.id
left join tabla_maestras t4 on t1.id_puesto::int = t4.codigo::int And t4.tipo ='94'
left join tabla_maestras t5 on t2.id_situacion = t5.codigo::int And t5.tipo ='14'
where t0.id_comision_sesion=".$id_comision_sesion."
and t0.estado='1'";

		
		$data = DB::select($cad);
        return $data;
    }
	
	function getComisionSesionDelegadoCoordinadorByIdPeriodo($id_periodo,$anio,$mes){ 
		
		$cad = "select distinct t4.denominacion comision,t3.apellido_paterno||' '||t3.apellido_materno||' '||t3.nombres agremiado,t2.numero_cap
from comision_sesiones t1 
inner join comision_sesion_delegados csd on t1.id=csd.id_comision_sesion 
left join comision_delegados cd on csd.id_delegado=cd.id left join agremiados a on coalesce(cd.id_agremiado,csd.id_agremiado)=a.id
left join agremiados t2 on coalesce(cd.id_agremiado,csd.id_agremiado)=t2.id
inner join personas t3 on t2.id_persona=t3.id
inner join comisiones t4 on t1.id_comision=t4.id
where csd.estado='1' 
and csd.coordinador='1'
And to_char(t1.fecha_ejecucion,'yyyy') = '".$anio."'
And to_char(t1.fecha_ejecucion,'mm') = '".$mes."'
and t1.id_periodo_comisione=".$id_periodo ;
		
		$data = DB::select($cad);
        return $data;
    }
	
	
}
