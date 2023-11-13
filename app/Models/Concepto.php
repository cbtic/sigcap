<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Concepto extends Model
{
    use HasFactory;

    public function listar_concepto_ajax($p){

        return $this->readFuntionPostgres('sp_listar_concepto_paginado',$p);

    }

    function getConceptoPeriodo($periodo){      
        $cad = "
        select id, id_regional, codigo, denominacion, estado, id_tipo_concepto, importe, id_moneda, moneda, periodo, cuenta_contable, cuenta_contable_debe, 
        cuenta_contable_al_haber1, cuenta_contable_al_haber2, partida_presupuestal, id_tipo_afectacion, centro_costo, genera_pago
        from conceptos
        where periodo = '".$periodo."'
        and estado = '1'
        and genera_pago = '1'
        order by denominacion
        ";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
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

    function getConceptoAll(){

        $cad = "select *
                from conceptos
                where estado='1'and codigo = '00006'
                order by denominacion ";
    
		$data = DB::select($cad);
        return $data;
    }

    function getCodigoConcepto(){

        $cad = "select lpad((max(codigo::int)+1)::varchar,5,'0') codigo from conceptos c ";
    
		$data = DB::select($cad);
        return $data[0]->codigo;
    }

    function getCodigoConceptoEdit(){

        $cad = "select lpad((max(codigo::int))::varchar,5,'0') codigo from conceptos c ";
    
		$data = DB::select($cad);
        return $data[0]->codigo;
    }
}
