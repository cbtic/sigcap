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

        $cad = "select a.id, a.id_persona, c.denominacion  cuenta_den, p.numero_ruc, 
                    case when p.desc_cliente_sunat is null then p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres else p.desc_cliente_sunat end desc_cliente_sunat, a.cuenta, 
                    case when a.debe = 0 then '' else a.debe::varchar end debe, 
                    case when a.haber = 0 then '' else a.haber::varchar end haber,
                    case when a.debe = 0 then round(a.haber/a.tipo_cambio) else round(a.debe/a.tipo_cambio) end equivalente, 
                    a.glosa, a.centro_costo, a.presupuesto, a.codigo_financiero, a.medio_pago, a.id_tipo_documento, a.serie, a.numero, a.fecha_documento, 
                    a.fecha_vencimiento, a.id_moneda, a.tipo_cambio, a.id_estado_doc, a.estado, a.id_asiento_planilla, a.id_periodo_comision, a.id_periodo_comision_detalle
                from asiento_planillas a
                    inner join personas p on p.id = a.id_persona
                    inner join plan_contables c on c.cuenta = a.cuenta
                where EXTRACT(YEAR FROM fecha_documento)::varchar = '".$anio."'
                    And EXTRACT(MONTH FROM fecha_documento)::varchar = '".$mes."'
                    And id_periodo_comision = '".$periodo."'  ";

		//echo $cad; exit();
		$data = DB::select($cad);
        return $data;
    }

    public function generar_asiento_planilla($periodo, $anio, $mes) {

        $cad = "Select  sp_generar_asiento_planilla(?, ?, ?)";
     
		$data = DB::select($cad, array($periodo, $anio, $mes ));
        return $data[0]->sp_generar_asiento_planilla;
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

