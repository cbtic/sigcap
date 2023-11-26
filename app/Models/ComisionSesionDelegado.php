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
t5.denominacion situacion  
from comision_delegados t1
inner join agremiados t2 on t1.id_agremiado=t2.id
inner join personas t3 on t2.id_persona=t3.id
inner join tabla_maestras t4 on t1.id_puesto::int = t4.codigo::int And t4.tipo ='94'
inner join tabla_maestras t5 on t2.id_situacion = t5.codigo::int And t5.tipo ='14' 
where id_comision=".$id_comision;

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
		$cad = "select t0.id,t1.id_agremiado,to_char(t1.created_at,'dd-mm-yyyy')fecha_inscripcion,
t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,t4.denominacion puesto,
t5.denominacion situacion,p.nombre profesion  
from comision_sesion_delegados t0 
left join comision_delegados t1 on t0.id_delegado=t1.id
left join agremiados t2 on t1.id_agremiado=t2.id
left join profesion_otros po on t0.id_profesion_otro=po.id  
inner join personas t3 on coalesce(t2.id_persona,po.id_persona)=t3.id
left join tabla_maestras t4 on t1.id_puesto::int = t4.codigo::int And t4.tipo ='94'
left join tabla_maestras t5 on t2.id_situacion = t5.codigo::int And t5.tipo ='14' 
left join profesiones p on po.id_profesion=p.id
where t0.id_comision_sesion=".$id_comision_sesion;

		
		$data = DB::select($cad);
        return $data;
    }
	
	
}
