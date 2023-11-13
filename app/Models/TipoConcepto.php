<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class TipoConcepto extends Model
{
    use HasFactory;

    public function listar_tipoConcepto_ajax($p){

        return $this->readFuntionPostgres('sp_listar_tipoconcepto_paginado',$p);

    }

    function getCodigoTipoConcepto(){

        $cad = "select lpad((max(codigo::int)+1)::varchar,5,'0') codigo from tipo_conceptos tc ";
    
		$data = DB::select($cad);
        return $data[0]->codigo;
    }

    function getCodigoTipoConceptoEdit(){

        $cad = "select lpad((max(codigo::int))::varchar,5,'0') codigo from tipo_conceptos tc ";
    
		$data = DB::select($cad);
        return $data[0]->codigo;
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

    function getTipoConceptoAll(){

        $cad = "select *
                from tipo_conceptos
                where estado='1' 
                order by denominacion ";
    
		$data = DB::select($cad);
        return $data;
    }
}
