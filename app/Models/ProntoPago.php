<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class ProntoPago extends Model
{
    use HasFactory;

    public function listar_prontoPago_ajax($p){

        return $this->readFuntionPostgres('sp_listar_prontopago_paginado',$p);

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

    function actualizarActivoProntoPago(){
  
        $cad = "update pronto_pagos set estado = '1' where now() between fecha_inicio and fecha_fin and estado = '0'";
        //echo $cad;
        $data = DB::select($cad);
        return $data;
    }

    function actualizarInactivoProntoPago(){
  
        $cad = "update pronto_pagos set estado = '0' where now() not between fecha_inicio and fecha_fin and estado = '1'";
        //echo $cad;
        $data = DB::select($cad);
        return $data;
    }

}
