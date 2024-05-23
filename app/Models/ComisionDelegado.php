<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ComisionDelegado extends Model
{
    function getConcursoInscripcionAll($id_periodo,$id_sub_tipo_concurso){

        $cad = "select 
		t1.id,t1.id_agremiado,t1.puesto_postula,t1.puesto,t5.periodo,t6.denominacion tipo_concurso,
		to_char(t1.created_at,'dd-mm-yyyy')fecha_inscripcion,
		t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
		t7.denominacion situacion,t8.denominacion region,t1.puntaje,t1.resultado,t11.denominacion puesto,t12.denominacion puesto_asignado,
		fecha_acreditacion_inicio,fecha_acreditacion_fin  
		from concurso_inscripciones t1 
		inner join agremiados t2 on t1.id_agremiado=t2.id
		inner join personas t3 on t2.id_persona=t3.id
		inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
		inner join concursos t5 on t4.id_concurso=t5.id
		inner join tabla_maestras t6 on t5.id_sub_tipo_concurso=t6.codigo::int and t6.tipo='93'
		inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo ='14' 
		inner join regiones t8 on t2.id_regional = t8.id
		left join tabla_maestras t11 on t1.puesto_postula::int = t11.codigo::int And t11.tipo ='94' 
		left join tabla_maestras t12 on t1.puesto::int = t12.codigo::int And t12.tipo ='94'
		where t1.estado='1' and t2.estado='1' and t3.estado='1' 
		and t5.estado='1' and t6.estado='1' and t7.estado='1'
		and resultado='Ingreso'
		";
		if($id_periodo>0){
			$cad .= " and t5.id_periodo=".$id_periodo;
		}
		
		if($id_sub_tipo_concurso>0){
			$cad .= " and t5.id_sub_tipo_concurso=".$id_sub_tipo_concurso;
		}

		//echo $cad;

		$data = DB::select($cad);
        return $data;
    }
	
	function getConcursoInscripcionSinPuesto($id_periodo,$id_sub_tipo_concurso){

        $cad = "select 
		t1.id,t1.id_agremiado,t1.puesto_postula,t1.puesto,t5.periodo,t6.denominacion tipo_concurso,
		to_char(t1.created_at,'dd-mm-yyyy')fecha_inscripcion,
		t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
		t7.denominacion situacion,t8.denominacion region,t1.puntaje,t1.resultado,t11.denominacion puesto,t12.denominacion puesto_asignado,
		fecha_acreditacion_inicio,fecha_acreditacion_fin  
		from concurso_inscripciones t1 
		inner join agremiados t2 on t1.id_agremiado=t2.id
		inner join personas t3 on t2.id_persona=t3.id
		inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
		inner join concursos t5 on t4.id_concurso=t5.id
		inner join tabla_maestras t6 on t5.id_sub_tipo_concurso=t6.codigo::int and t6.tipo='93'
		inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo ='14' 
		inner join regiones t8 on t2.id_regional = t8.id
		left join tabla_maestras t11 on t1.puesto_postula::int = t11.codigo::int And t11.tipo ='94' 
		left join tabla_maestras t12 on t1.puesto::int = t12.codigo::int And t12.tipo ='94'
		where t1.estado='1' and t2.estado='1' and t3.estado='1' 
		and t5.estado='1' and t6.estado='1' and t7.estado='1'
		and resultado='Ingreso'
		";
		if($id_periodo>0){
			$cad .= " and t5.id_periodo=".$id_periodo;
		}
		
		if($id_sub_tipo_concurso>0){
			$cad .= " and t5.id_sub_tipo_concurso=".$id_sub_tipo_concurso;
		}
		/*
		$cad .= " and t1.id_agremiado not in (select id_agremiado from comision_delegados cd where id_comision=".$id_comision." 
				and estado='1')
				and t1.puesto is null ";
		*/
		$cad .= " and coalesce(t1.puesto,'12')='12'";
		
		//echo $cad;

		$data = DB::select($cad);
        return $data;
    }
	
	function getConcursoInscripcionAllNuevo($id_periodo,$id_sub_tipo_concurso){

        $cad = "select 
		t1.id,t1.id_agremiado,t1.puesto_postula,t5.periodo,t6.denominacion tipo_concurso,
		to_char(t1.created_at,'dd-mm-yyyy')fecha_inscripcion,
		t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
		t7.denominacion situacion,t8.denominacion region,t1.puntaje,t1.resultado,t11.denominacion puesto,t12.denominacion puesto_asignado,
		fecha_acreditacion_inicio,fecha_acreditacion_fin  
		from concurso_inscripciones t1 
		inner join agremiados t2 on t1.id_agremiado=t2.id
		inner join personas t3 on t2.id_persona=t3.id
		inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
		inner join concursos t5 on t4.id_concurso=t5.id
		inner join tabla_maestras t6 on t5.id_sub_tipo_concurso=t6.codigo::int and t6.tipo='93'
		inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo ='14' 
		inner join regiones t8 on t2.id_regional = t8.id
		left join tabla_maestras t11 on t1.puesto_postula::int = t11.codigo::int And t11.tipo ='94' 
		left join tabla_maestras t12 on t1.puesto::int = t12.codigo::int And t12.tipo ='94'
		where t1.estado='1' and t2.estado='1' and t3.estado='1' 
		and t5.estado='1' and t6.estado='1' and t7.estado='1'
		and resultado='Ingreso'
		and t2.id_situacion!=74 
		";
		if($id_periodo>0){
			$cad .= " and t5.id_periodo=".$id_periodo;
		}
		
		if($id_sub_tipo_concurso>0){
			$cad .= " and t5.id_sub_tipo_concurso=".$id_sub_tipo_concurso;
		}

		//echo $cad;

		$data = DB::select($cad);
        return $data;
    }
	
	function getComisionDelegado(){
 
        $cad = "select t1.id,t1.id_agremiado,t1.id_puesto,t5.periodo,t6.denominacion tipo_concurso,
		to_char(t1.created_at,'dd-mm-yyyy')fecha_inscripcion,
		t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
		t7.denominacion situacion,t8.denominacion region,t11.denominacion puesto 
		from comision_delegados t1 
		inner join agremiados t2 on t1.id_agremiado=t2.id
		inner join personas t3 on t2.id_persona=t3.id
		inner join concurso_puestos t4 on t1.id_puesto=t4.id 
		inner join concursos t5 on t4.id_concurso=t5.id
		inner join tabla_maestras t6 on t5.id_tipo_concurso=t6.codigo::int and t6.tipo='93'
		inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo ='14' 
		inner join regiones t8 on t2.id_regional = t8.id
		left join tabla_maestras t11 on t1.id_puesto::int = t11.codigo::int And t11.tipo ='94' ";

		$data = DB::select($cad);
        return $data;
    }
	
	function getComisionDelegadoByComision($id_comision){

        $cad = " select cd.id,r.denominacion region,tm.denominacion situacion,tm2.denominacion puesto,
		p.numero_documento,p.nombres,p.apellido_paterno,p.apellido_materno,a.numero_cap,cd.coordinador 
		from comision_delegados cd 
		inner join regiones r on cd.id_regional=r.id 
		inner join agremiados a on cd.id_agremiado=a.id
		inner join personas p on a.id_persona=p.id
		inner join tabla_maestras tm on a.id_situacion = tm.codigo::int And tm.tipo ='14'
		inner join tabla_maestras tm2 on cd.id_puesto::int = tm2.codigo::int And tm2.tipo ='94' 
		where id_comision=".$id_comision;

		$data = DB::select($cad);
        return $data;
    }

	function getConcursoInscripcionDelegadoTributo($periodo){

        $cad = "select 
		t1.id,t1.id_agremiado,t1.puesto_postula,pc.descripcion periodo,t6.denominacion tipo_concurso,
		to_char(t1.created_at,'dd-mm-yyyy')fecha_inscripcion,
		t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
		t7.denominacion situacion,t8.denominacion region,t1.puntaje,t1.resultado,t11.denominacion puesto,t12.denominacion puesto_asignado,
		fecha_acreditacion_inicio,fecha_acreditacion_fin  
		from concurso_inscripciones t1 
		inner join agremiados t2 on t1.id_agremiado=t2.id
		inner join personas t3 on t2.id_persona=t3.id
		inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
		inner join concursos t5 on t4.id_concurso=t5.id
		inner join tabla_maestras t6 on t5.id_sub_tipo_concurso=t6.codigo::int and t6.tipo='93'
		inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo ='14' 
		inner join regiones t8 on t2.id_regional = t8.id
		inner join periodo_comisiones pc on t5.id_periodo = pc.id
		left join tabla_maestras t11 on t1.puesto_postula::int = t11.codigo::int And t11.tipo ='94' 
		left join tabla_maestras t12 on t1.puesto::int = t12.codigo::int And t12.tipo ='94'
		where t1.estado='1' and t2.estado='1' and t3.estado='1' 
		and t5.estado='1' and t6.estado='1' and t7.estado='1'
		and resultado='Ingreso'
		";
		if($periodo>0){
			$cad .= " and t5.id_periodo=".$periodo;
		}

		$data = DB::select($cad);
        return $data;
    }
}
