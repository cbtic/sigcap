<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Concurso extends Model
{
    use HasFactory;
	
	function getConcurso(){

        $cad = "select c.id,c.periodo,tm.denominacion tipo_concurso,tms.denominacion sub_tipo_concurso,
to_char(c.fecha,'dd-mm-yyyy')fecha,to_char(c.fecha_inscripcion,'dd-mm-yyyy')fecha_inscripcion,to_char(c.fecha_delegatura_inicio,'dd-mm-yyyy')fecha_delegatura_inicio,to_char(c.fecha_delegatura_fin,'dd-mm-yyyy')fecha_delegatura_fin 
from concursos c
inner join tabla_maestras tm on c.id_tipo_concurso::int=tm.codigo::int and tm.tipo='101'
left join tabla_maestras tms on c.id_sub_tipo_concurso::int=tms.codigo::int and tms.tipo='93'
where c.estado='1'";

		$data = DB::select($cad);
        return $data;
    }
	
	function getConcursoRequisitoByIdConcurso($id){

        $cad = "select c.id,c.denominacion requisito,tm.denominacion tipo_documento,c.requisito_archivo 
from concurso_requisitos c 
inner join tabla_maestras tm on c.id_tipo_documento::int=tm.codigo::int and tm.tipo='97'
Where c.id_concurso = ".$id;
		//echo $cad;
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
