<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Reporte extends Model
{
    use HasFactory;

    function getReporteAll($tipo_reporte){

        $cad = "select *
                from reportes
                where estado='1'
                and id_tipo = ".$tipo_reporte." 
                order by descripcion ";
        //echo($cad);
    
		$data = DB::select($cad);
        return $data;
    }

    public function lista_reporte_ajax($p){

        return $this->readFunctionPostgres('sp_listar_reporte_paginado',$p);

    }



    public function readFunctionPostgres($function, $parameters = null){

        $_parameters = '';
        if (count($parameters) > 0) {
            $_parameters = implode("','", $parameters);
            $_parameters = "'" . $_parameters . "',";
        }
        $data = DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
        //echo $cad;
        $data = DB::select($cad);
        $cad = "FETCH ALL IN ref_cursor;";
        $data = DB::select($cad);
        return $data;
     }
}
