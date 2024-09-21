<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProfesionalesOtro extends Model
{
    use HasFactory;

    protected $table = 'profesion_otros';

    public function listar_profesionalesOtro_ajax($p){

        return $this->readFuntionPostgres('sp_listar_profesionotro_paginado',$p);
    }

    function getProfesionSesion(){ 
		
		$cad = "select po.id,p2.numero_documento,p2.apellido_paterno,p2.apellido_materno,p2.nombres,
		p.nombre profesion 
        from profesion_otros po 
        inner join profesiones p on po.id_profesion=p.id 
        inner join personas p2 on po.id_persona=p2.id";

		
		$data = DB::select($cad);
        return $data;
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
