<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AsientoPlanilla extends Model
{
    public function listar_asiento_ajax($p){
		return $this->readFunctionPostgres('sp_listar_asiento_cuenta_paginado',$p);
    }

    function getConcursoRequisitoByIdConcurso($id){

        $cad = "select c.id,c.denominacion requisito,tm.denominacion tipo_documento,c.requisito_archivo 
from concurso_requisitos c 
inner join tabla_maestras tm on c.id_tipo_documento::int=tm.codigo::int and tm.tipo='97'
Where c.id_concurso = ".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
    
    function ListarAsientoPlanilla($anio, $mes, $periodo){

        $mes= intval($mes);

        $cad = "select id, id_persona, cuenta, debe, haber, glosa, centro_costo, presupuesto, codigo_financiero, medio_pago, id_tipo_documento, serie, numero, fecha_documento, fecha_vencimiento, id_moneda, tipo_cambio, id_estado_doc, estado, id_usuario_inserta, id_asiento_planilla, id_periodo_comision, id_periodo_comision_detalle
        from asiento_planillas
        where EXTRACT(YEAR FROM fecha_documento)::varchar = ".$anio."'
        And EXTRACT(MONTH FROM fecha_documento)::varchar = '".$mes."'
        And id_periodo_comision = ".$periodo."'  ";

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    public function readFunctionPostgres($function, $parameters = null){
	
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

