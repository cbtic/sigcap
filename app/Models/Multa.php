<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Multa extends Model
{
    use HasFactory;

    public function listar_datosAgremiado_ajax($p){

        return $this->readFuntionPostgres('sp_listar_datos_agremiado_paginado',$p);

    }

    public function listar_historialMulta_ajax($p){

        return $this->readFuntionPostgres('sp_listar_historialmulta_paginado',$p);

    }

    public function listar_multa_ajax($p){

        return $this->readFuntionPostgres('sp_listar_multa_paginado',$p);

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
