<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ConcursoInscripcione extends Model
{
    use HasFactory;
	
	function getConcursoInscripcionById($id){

        $cad = "select t1.id,t5.periodo,t6.denominacion tipo_concurso,
t3.numero_documento,t3.nombres,t3.apellido_paterno,t3.apellido_materno,t2.numero_cap,
t7.denominacion situacion,t8.denominacion region,t10.tipo,t10.serie,t10.numero,t4.id_concurso  
from concurso_inscripciones t1 
inner join agremiados t2 on t1.id_agremiado=t2.id
inner join personas t3 on t2.id_persona=t3.id
inner join concurso_puestos t4 on t1.id_concurso_puesto=t4.id 
inner join concursos t5 on t4.id_concurso=t5.id
inner join tabla_maestras t6 on t5.id_tipo_concurso=t6.codigo::int and t6.tipo='93'
inner join tabla_maestras t7 on t2.id_situacion = t7.codigo::int And t7.tipo ='14' 
inner join regiones t8 on t2.id_regional = t8.id
inner join valorizaciones t9 on t1.id=t9.pk_registro and t9.id_modulo='1'
inner join comprobantes t10 on t9.id_comprobante=t10.id
where t1.id=".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }
	
	function getConcursoInscripcionRequisitoById($id){

        $cad = "select * 
from concurso_requisitos t1
left join tabla_maestras t2 on t1.id_tipo_documento = t2.codigo::int And t2.tipo ='93'
where id_concurso=".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	public function listar_concurso_agremiado($p){

        return $this->readFuntionPostgres('sp_listar_concurso_agremiado_paginado',$p);

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
