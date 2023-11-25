<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Profesione extends Model
{
    use HasFactory;

    public function listar_profesion_ajax($p){

        return $this->readFuntionPostgres('sp_listar_profesion_paginado',$p);
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

    public function getProfesionAll(){

        $cad = "select *
                from profesiones p
                where p.estado='1'
                order by p.nombre ";
    
		$data = DB::select($cad);
        return $data;

    }

}
