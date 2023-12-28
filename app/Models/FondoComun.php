<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class FondoComun extends Model
{
    use HasFactory;

    public function listar_fondo_comun_ajax($p){

        return $this->readFuntionPostgres('sp_listar_delegado_fondo_comun_paginado',$p);
    }

    public function calcula_fondo_comun1($p){

        return $this->readFuntionPostgres('sp_calcula_del_fondo_comun',$p);
    }



    public function calcula_fondo_comun($anio, $mes) {

        $cad = "Select sp_calcula_del_fondo_comun(?,?)";
     
		$data = DB::select($cad, array($anio, $mes));
        return $data[0]->sp_calcula_del_fondo_comun;
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
