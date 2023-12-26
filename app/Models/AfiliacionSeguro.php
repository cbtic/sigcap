<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AfiliacionSeguro extends Model
{
    protected $table = 'seguro_afiliados';
    
    public function listar_afiliacion_seguro($p){

        return $this->readFuntionPostgres('sp_listar_afiliado_seguro_paginado',$p);

    }

    public function listar_plan($p){

        return $this->readFuntionPostgres('sp_listar_seguro_plan_paginado',$p);

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
