<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TipoCambio extends Model
{
    use HasFactory;

    public function listar_tipo_cambio_ajax($p){

        return $this->readFuntionPostgres('sp_listar_tipo_cambio_paginado',$p);
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

    function getTipoCambio(){

        $cad = "select tc.id, to_char(tc.fecha,'dd-mm-yyyy')fecha, tc.valor_venta,tc.estado, to_char(now(),'dd-mm-yyyy') fecha_act 
                from tipo_cambios tc 
                order by tc.fecha desc
                limit 1";

		//echo $cad;
        $data = DB::select($cad);
        if($data)return $data[0];
    }

    function validarFecha($fecha){

        $cad = "select count(*) cantidad from tipo_cambios tc 
        where fecha ='".$fecha."'";

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

}
