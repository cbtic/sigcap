<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Parametro extends Model
{
    use HasFactory;

    public function listar_parametro_ajax($p){

        return $this->readFuntionPostgres('sp_listar_parametro_paginado',$p);
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

    public function getParametroAll(){

        $cad = "select *
                from parametros p
                where p.estado='1'
                order by p.id ";
    
		$data = DB::select($cad);
        return $data;

    }

    public function getParametroAnio($anio){

        $cad = "select *
                from parametros p
                where p.estado='1' and anio = '".$anio."'
                order by p.id desc";
    
		$data = DB::select($cad);
        return $data;

    }
}
