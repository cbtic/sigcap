<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Adelanto extends Model
{
    use HasFactory;

    public function listar_adelanto_ajax($p){

        return $this->readFuntionPostgres('sp_listar_adelanto_paginado',$p);
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

    function getAdelantoId($id){ 

        $cad = "select a.id_agremiado, a.total_adelanto, a.fecha from adelantos a 
        where a.id=".$id;

        $data = DB::select($cad);
        return $data;

    }
}
