<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConcursoInscripcione extends Model
{
    use HasFactory;
	
	function getConcursoInscripcionById($id){

        $cad = "select t1.id,pc.descripcion periodo,tm.denominacion tipo_concurso,tms.denominacion sub_tipo_concurso,
t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
t7.denominacion situacion,t8.denominacion region,t10.tipo,t10.serie,t10.numero,t4.id_concurso,
to_char(t5.fecha_acreditacion_inicio,'dd-mm-yyyy')fecha_acreditacion_inicio,to_char(t5.fecha_acreditacion_fin,'dd-mm-yyyy')fecha_acreditacion_fin,t11.denominacion nombre_puesto,puesto,t1.puntaje,t1.resultado   
from concurso_inscripciones t1 
inner join agremiados t2 on t1.id_agremiado=t2.id
inner join personas t3 on t2.id_persona=t3.id
inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
inner join concursos t5 on t4.id_concurso=t5.id 
inner join periodo_comisiones pc on t5.id_periodo=pc.id 
/*inner join tabla_maestras t6 on t5.id_tipo_concurso=t6.codigo::int and t6.tipo='93'*/
inner join tabla_maestras tm on t5.id_tipo_concurso::int=tm.codigo::int and tm.tipo='101'
left join tabla_maestras tms on t5.id_sub_tipo_concurso::int=tms.codigo::int and tms.tipo='93'
inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo ='14' 
inner join regiones t8 on t2.id_regional = t8.id
left join valorizaciones t9 on t1.id=t9.pk_registro and t9.id_modulo='1'
left join comprobantes t10 on t9.id_comprobante=t10.id
left join tabla_maestras t11 on t1.puesto_postula::int = t11.codigo::int And t11.tipo ='94'
where t1.id=".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }
	
	function getConcursoUltimoByIdAgremiado($id_concurso_inscripcion,$id_agremiado){

        $cad = "select id 
from concurso_inscripciones ci
where id_agremiado=".$id_agremiado."
and id<".$id_concurso_inscripcion."
limit 1";
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }
	
	function getConcursoInscripcionByIdAgremiadoIdPeriodoIdSubTipoConcurso($id_agremiado,$id_periodo,$id_sub_tipo_concurso){

        $cad = "select id 
from concurso_inscripciones ci 
where id_agremiado=".$id_agremiado." 
and id_concurso_puesto in(select id from concurso_puestos cp 
						   where id_concurso in(select id from concursos c where id_periodo=".$id_periodo." and id_sub_tipo_concurso=".$id_sub_tipo_concurso." and estado='1') 
					and estado='1')
and ci.estado='1'";
		//if($id_agremiado==3364)echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
	
	function updateConcursoInscripcionByIdPeriodoIdSubTipoConcurso($id_periodo,$id_sub_tipo_concurso){

        $cad = "update concurso_inscripciones set puesto=null  
where id_concurso_puesto in(select id from concurso_puestos cp 
						   where id_concurso in(select id from concursos c where id_periodo=".$id_periodo." and id_sub_tipo_concurso=".$id_sub_tipo_concurso." and estado='1') 
					and estado='1')
and estado='1'";
		//if($id_agremiado==3364)echo $cad;
		$data = DB::select($cad);
        //if(isset($data[0]))return $data[0];
    }
	
	function getConcursoUltimoNuevoByIdAgremiado($id_concurso_inscripcion,$id_agremiado,$id_tipo_concurso,$id_sub_tipo_concurso){

        $cad = "select t1.id   
from concurso_inscripciones t1 
inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
inner join concursos t5 on t4.id_concurso=t5.id
where t5.id_tipo_concurso=".$id_tipo_concurso."
and t5.id_sub_tipo_concurso=".$id_sub_tipo_concurso."
and t1.id_agremiado=".$id_agremiado."
and t1.estado='1'
and t1.id<".$id_concurso_inscripcion."
limit 1";
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }
	
	function getConcursoDelegadoValidaByIdAgremiado($id_periodo,$id_agremiado,$id_tipo_concurso){

        $cad = "select t1.id   
from concurso_inscripciones t1 
inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
inner join concursos t5 on t4.id_concurso=t5.id
where t5.id_periodo=".$id_periodo." 
and t5.id_tipo_concurso=".$id_tipo_concurso." 
and t1.id_agremiado=".$id_agremiado."
and t1.estado='1'
limit 1";
		//echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
	
	function getConcursoInscripcionRequisitoById($id){

        $cad = "select t1.id,t1.denominacion,t2.denominacion tipo_documento 
from concurso_requisitos t1
left join tabla_maestras t2 on t1.id_tipo_documento = t2.codigo::int And t2.tipo ='97'
where id_concurso_inscripcion=".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	function getAgremiadoConcursoInscripcionZip($numero_cap){

        $cad = "select distinct id_agremiado,a.numero_cap,p.apellido_paterno,p.apellido_materno,p.nombres 
from concurso_inscripciones ci 
inner join agremiados a on ci.id_agremiado=a.id 
inner join personas p on a.id_persona=p.id
where ci.estado='1' ";

		if($numero_cap!=""){
			$cad .= "and a.numero_cap='".$numero_cap."'";
		}
		
		
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	function getConcursoInscripcionZip($id_agremiado,$id_concurso){

        $cad = "select ci.id,replace(pc.descripcion,'/','-') periodo,tm.denominacion tipo_concurso,tms.denominacion sub_tipo_concurso 
from concurso_inscripciones ci
inner join concurso_puestos cp on ci.id_concurso_puesto=cp.id
inner join concursos c on cp.id_concurso=c.id
inner join periodo_comisiones pc on c.id_periodo=pc.id 
inner join tabla_maestras tm on c.id_tipo_concurso::int=tm.codigo::int and tm.tipo='101'
left join tabla_maestras tms on c.id_sub_tipo_concurso::int=tms.codigo::int and tms.tipo='93'
where id_agremiado=".$id_agremiado." and ci.estado='1'";
		
		if($id_concurso!=""){
			$cad .= "and cp.id_concurso='".$id_concurso."'";
		}

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	function getConcursoInscripcionZipNuevo($id_agremiado,$id_periodo,$id_tipo_concurso,$id_sub_tipo_concurso,$id_puesto){

        $cad = "select ci.id,replace(pc.descripcion,'/','-') periodo,tm.denominacion tipo_concurso,tms.denominacion sub_tipo_concurso 
from concurso_inscripciones ci
inner join concurso_puestos cp on ci.id_concurso_puesto=cp.id
inner join concursos c on cp.id_concurso=c.id
inner join periodo_comisiones pc on c.id_periodo=pc.id 
inner join tabla_maestras tm on c.id_tipo_concurso::int=tm.codigo::int and tm.tipo='101'
left join tabla_maestras tms on c.id_sub_tipo_concurso::int=tms.codigo::int and tms.tipo='93'
where id_agremiado=".$id_agremiado." and ci.estado='1'";
		/*
		if($id_concurso!=""){
			$cad .= "and cp.id_concurso='".$id_concurso."' ";
		}
		*/
		
		if($id_puesto!="" && $id_puesto!="0"){
	 		$cad .= "And ci.puesto_postula = '".$id_puesto."' ";
		}
	
		if($id_tipo_concurso!="" && $id_tipo_concurso!="0"){
	 		$cad .= "And c.id_tipo_concurso = '".$id_tipo_concurso."' ";
		}

		if($id_sub_tipo_concurso!="" && $id_sub_tipo_concurso!="0"){
	 		$cad .= "And c.id_sub_tipo_concurso = '".$id_sub_tipo_concurso."' ";
		}
	
		if($id_periodo!="" && $id_periodo!="0"){
	 		$cad .= "And c.id_periodo = '".$id_periodo."' ";
		}
		
		//echo $cad;exit();
		$data = DB::select($cad);
        return $data;
    }
	
	function getConcursoInscripcionDocumentoZip($id_concurso_inscripcion){

        $cad = "select ruta_archivo from inscripcion_documentos id where id_concurso_inscripcion=".$id_concurso_inscripcion;
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	public function listar_concurso_agremiado($p){

        return $this->readFuntionPostgres('sp_listar_concurso_agremiado_paginado',$p);

    }
	
	public function listar_concurso_resultado_agremiado($p){

        return $this->readFuntionPostgres('sp_listar_concurso_resultado_agremiado_paginado',$p);

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
