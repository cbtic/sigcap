<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AgremiadoRole extends Model
{
    use HasFactory;

    public function listar_agremiado_rol_ajax($p){

        return $this->readFuntionPostgres('sp_listar_agremiado_roles_paginado',$p);

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

    function getAgremiadoRol($id_agremiado){

        $cad = "select ar.id, ar.rol, ar.rol_especifico, ar.fecha_inicio, ar.fecha_fin, ar.observacion, ar.estado from agremiado_roles ar 
        where ar.id_agremiado=".$id_agremiado."
        and ar.estado='1'";
    
		$data = DB::select($cad);
        return $data;
    }
	
	function updatePuestoConcursoInscripcion($id_agremiado,$id_concurso,$puesto){

        $cad = "update concurso_inscripciones ci 
		set puesto=".$puesto."
		where id_agremiado=".$id_agremiado." 
		and id_concurso_puesto in(select id from concurso_puestos cp where id_concurso=".$id_concurso." and estado='1') ";
    
		$data = DB::select($cad);
        return $data;
    }
	
	
}
