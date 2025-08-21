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

    function getVouporID($periodo, $origen, $voucher,$ruc){

        $cad = "select id 
                from planilla_siscont ps
                Where ps.periodo='" . $periodo. "' and ps.origen='" . $origen . "' and ps.voucher='" . $voucher . "' and ruc='" . $ruc. "'";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function ListarAsientoPlanilla($anio, $mes, $periodo, $tipo){

        $mes= intval($mes);

        $cad = "select a.id, a.id_persona, c.denominacion  cuenta_den, p.numero_ruc, 
                    case when p.desc_cliente_sunat is null then p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres else p.desc_cliente_sunat end desc_cliente_sunat, a.cuenta, 
                    case when a.debe = 0 then 0 else a.debe end debe, 
                    case when a.haber = 0 then 0 else a.haber end haber,
                    a.equivalente, 
                    a.glosa, a.centro_costo, a.presupuesto, a.codigo_financiero, a.medio_pago, a.id_tipo_documento, a.serie, a.numero, a.fecha_documento, 
                    a.fecha_vencimiento, a.id_moneda, a.tipo_cambio, a.id_estado_doc, a.estado, a.id_asiento_planilla, a.id_periodo_comision, a.id_periodo_comision_detalle,
                    case when a.id_tipo = 1 then 'PROVISION ' else 'CANCELACION' end tipo, a.orden, a.numero_comprobante, a.id_grupo
                from asiento_planillas a
                    inner join personas p on p.id = a.id_persona
                    inner join plan_contables c on c.cuenta = a.cuenta
                where EXTRACT(YEAR FROM fecha_documento)::varchar = '".$anio."'
                    And EXTRACT(MONTH FROM fecha_documento)::varchar = '".$mes."'
                    And a.id_periodo_comision = '".$periodo."'
                    And a.id_tipo = '".$tipo."'

                order by numero_comprobante, orden
                    
                    ";

		//echo $cad; exit();
		$data = DB::select($cad);
        return $data;
    }

    public function generar_asiento_planilla($tipo, $id_periodo, $anio, $mes) {

        $cad = "Select  sp_generar_asiento_planilla(?, ?, ?, ?)";
     
		$data = DB::select($cad, array($tipo, $id_periodo, $anio, $mes ));
        return $data[0]->sp_generar_asiento_planilla;
    }

    function InsertaVou($periodo,$origen,$voucher,$comprobante,$ruc ){

        $cad = "insert into planilla_siscont (periodo,origen,voucher,comprobante,ruc )
                values ('".$periodo."','".$origen."','".$voucher."','".$comprobante."','" .$ruc . "') ";
		
    
		$data = DB::select($cad);
        return $data;
    }
    
    function ListarAsientoExportar($fecha_inicio,$fecha_fin,$tipo){



        $cad = "select pdd.secuencua_vou as vou, a.id, a.id_persona,  p.numero_ruc, 
                case when p.desc_cliente_sunat is null then p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres else p.desc_cliente_sunat end desc_cliente_sunat, a.cuenta, 
                case when a.debe = 0 then 0 else a.debe end debe, 
                case when a.haber = 0 then 0 else a.haber end haber,
                a.equivalente, 
                a.glosa, case when  a.centro_costo is null then '' else a.centro_costo end ,case when   a.presupuesto is null then '' else   a.presupuesto end, a.codigo_financiero, a.medio_pago, a.id_tipo_documento, a.serie, a.numero, a.fecha_documento, 
                a.fecha_vencimiento, a.id_moneda, a.tipo_cambio, a.id_estado_doc, a.estado, a.id_asiento_planilla, a.id_periodo_comision, a.id_periodo_comision_detalle,
                case when a.id_tipo = 1 then 'PROVISION' else 'CANCELACION' end tipo, a.orden, a.numero_comprobante, a.id_grupo
                from asiento_planillas a
                inner join personas p on p.id = a.id_persona
                --inner join plan_contables c on c.cuenta = a.cuenta
                inner join planilla_delegado_detalles pdd on a.id_planilla_delegado_detalle  =pdd.id 
                where
                    fecha_documento  between '". $fecha_inicio ."' and '". $fecha_fin ."'
                    and pdd.migra_conta='N'
                --And a.id_periodo_comision = 1050
                and a.id_tipo="  .$tipo. " 
                order by vou, numero_comprobante, orden                  ";

		//echo $cad; exit();
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

