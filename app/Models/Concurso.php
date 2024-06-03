<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Concurso extends Model
{
    use HasFactory;
	
	function getConcurso(){

        $cad = "select c.id,pc.descripcion periodo,tm.denominacion tipo_concurso,tms.denominacion sub_tipo_concurso,
to_char(c.fecha,'dd-mm-yyyy')fecha,to_char(c.fecha_inscripcion_inicio,'dd-mm-yyyy')fecha_inscripcion_inicio,to_char(c.fecha_inscripcion_fin,'dd-mm-yyyy')fecha_inscripcion_fin,to_char(c.fecha_acreditacion_inicio,'dd-mm-yyyy')fecha_acreditacion_inicio,to_char(c.fecha_acreditacion_fin,'dd-mm-yyyy')fecha_acreditacion_fin 
from concursos c
inner join periodo_comisiones pc on c.id_periodo=pc.id 
inner join tabla_maestras tm on c.id_tipo_concurso::int=tm.codigo::int and tm.tipo='101'
left join tabla_maestras tms on c.id_sub_tipo_concurso::int=tms.codigo::int and tms.tipo='93'
where c.estado='1'";

		$data = DB::select($cad);
        return $data;
    }
	
	function getConcursoVigente(){

        $cad = "select c.id,c.periodo,tm.denominacion tipo_concurso,tms.denominacion sub_tipo_concurso,
to_char(c.fecha,'dd-mm-yyyy')fecha,to_char(c.fecha_inscripcion_inicio,'dd-mm-yyyy')fecha_inscripcion_inicio,to_char(c.fecha_inscripcion_fin,'dd-mm-yyyy')fecha_inscripcion_fin,to_char(c.fecha_acreditacion_inicio,'dd-mm-yyyy')fecha_acreditacion_inicio,to_char(c.fecha_acreditacion_fin,'dd-mm-yyyy')fecha_acreditacion_fin 
from concursos c
inner join tabla_maestras tm on c.id_tipo_concurso::int=tm.codigo::int and tm.tipo='101'
left join tabla_maestras tms on c.id_sub_tipo_concurso::int=tms.codigo::int and tms.tipo='93'
where c.estado='1'
and now() between (to_char(c.fecha_inscripcion_inicio,'dd-mm-yyyy')||' 00:00')::timestamp  and (to_char(c.fecha_inscripcion_fin,'dd-mm-yyyy')||' 23:59')::timestamp";

		$data = DB::select($cad);
        return $data;
    }
	
	function getConcursoRequisitoByIdConcurso($id){

        $cad = "select c.id,c.denominacion requisito,tm.denominacion tipo_documento,c.requisito_archivo 
from concurso_requisitos c 
inner join tabla_maestras tm on c.id_tipo_documento::int=tm.codigo::int and tm.tipo='97'
Where c.id_concurso = ".$id." 
order by c.denominacion asc";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	function getPuestoByIdConcurso($id){

        $cad = "select cp.id,tm.denominacion puesto,cp.id_tipo_plaza 
from concurso_puestos cp 
inner join tabla_maestras tm on cp.id_tipo_plaza::int=tm.codigo::int and tm.tipo='94'
where cp.estado='1'
And cp.id_concurso = ".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	function getPuestoResultado(){

        $cad = "select distinct cp.id_tipo_plaza codigo,tm.denominacion 
from concurso_puestos cp 
inner join tabla_maestras tm on cp.id_tipo_plaza::int=tm.codigo::int and tm.tipo='94'
where cp.estado='1'";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	function getConcursoVigentePendienteByAgremiado($id_agremiado){

        $cad = "select c.id,pc.descripcion periodo,tm.denominacion tipo_concurso,tms.denominacion sub_tipo_concurso,
to_char(c.fecha,'dd-mm-yyyy')fecha,to_char(c.fecha_inscripcion_inicio,'dd-mm-yyyy')fecha_inscripcion_inicio,to_char(c.fecha_inscripcion_fin,'dd-mm-yyyy')fecha_inscripcion_fin,to_char(c.fecha_acreditacion_inicio,'dd-mm-yyyy')fecha_acreditacion_inicio,to_char(c.fecha_acreditacion_fin,'dd-mm-yyyy')fecha_acreditacion_fin 
from concursos c
inner join periodo_comisiones pc on c.id_periodo=pc.id 
inner join tabla_maestras tm on c.id_tipo_concurso::int=tm.codigo::int and tm.tipo='101'
left join tabla_maestras tms on c.id_sub_tipo_concurso::int=tms.codigo::int and tms.tipo='93'
where c.estado='1'
and now() between (to_char(c.fecha_inscripcion_inicio,'dd-mm-yyyy')||' 00:00')::timestamp  and (to_char(c.fecha_inscripcion_fin,'dd-mm-yyyy')||' 23:59')::timestamp
and c.id not in (
select cp.id_concurso  
from concurso_inscripciones ci 
inner join concurso_puestos cp on ci.id_concurso_puesto=cp.id
where id_agremiado=".$id_agremiado." and ci.estado='1'
)";

		$data = DB::select($cad);
        return $data;
    }
		
	function getInscripcionDocumentoPendienteByAgremiado($id_agremiado){

        $cad = "select cp.id_concurso,pc.descripcion periodo,tm.denominacion tipo_concurso,tms.denominacion sub_tipo_concurso  
from concurso_inscripciones ci 
inner join concurso_puestos cp on ci.id_concurso_puesto=cp.id
inner join concursos c on cp.id_concurso=c.id
inner join periodo_comisiones pc on c.id_periodo=pc.id 
inner join tabla_maestras tm on c.id_tipo_concurso::int=tm.codigo::int and tm.tipo='101'
left join tabla_maestras tms on c.id_sub_tipo_concurso::int=tms.codigo::int and tms.tipo='93'
where id_agremiado=".$id_agremiado." and ci.estado='1'
and (select count(*) from inscripcion_documentos id where id_concurso_inscripcion=ci.id and estado='1')='0'";

		$data = DB::select($cad);
        return $data;
    }
		
	public function listar_concurso($p){

        return $this->readFuntionPostgres('sp_listar_concurso_paginado',$p);

    }
	
	public function listar_puesto($p){

        return $this->readFuntionPostgres('sp_listar_concurso_puesto_paginado',$p);

    }
	
	public function listar_requisito($p){

        return $this->readFuntionPostgres('sp_listar_concurso_requisito_paginado',$p);

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
