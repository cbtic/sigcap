<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PeriodoComisione extends Model
{
    use HasFactory;

    public function listar_consulta_periodoComision_ajax($p){

        return $this->readFuntionPostgres('sp_listar_periodoComision_paginado',$p);

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

    function getPeriodoComisionAll(){

        $cad = "select *
                from periodo_comisiones
                where estado='1'
                order by descripcion ";
    
		$data = DB::select($cad);
        return $data;
    }
}