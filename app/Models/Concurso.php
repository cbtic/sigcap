<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Concurso extends Model
{
    use HasFactory;
	
	function getConcurso(){

        $cad = "select c.id,c.periodo,tm.denominacion tipo_concurso
from concursos c
inner join tabla_maestras tm on c.id_tipo_concurso=tm.codigo::int and tm.tipo='93' 
where c.estado='1'";

		$data = DB::select($cad);
        return $data;
    }
	
	public function listar_concurso($p){

        return $this->readFuntionPostgres('sp_listar_concurso_paginado',$p);

    }
	
	public function listar_puesto($p){

        return $this->readFuntionPostgres('sp_listar_concurso_puesto_paginado',$p);

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
