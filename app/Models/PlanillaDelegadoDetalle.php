<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PlanillaDelegadoDetalle extends Model
{
    use HasFactory;

    public function listar_recibo_honorario_ajax($p){

        return $this->readFuntionPostgres('sp_listar_recibo_honorario_paginado',$p);

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

    function getDatosRecibo($id){     
        
        $cad = "select pdd.id, a.numero_cap, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres agremiado, p.numero_ruc ruc, 
        pdd.numero_comprobante, pdd.fecha_comprobante, pdd.fecha_vencimiento, pdd.numero_operacion, pdd.cancelado,pdd.id_grupo, pdd.fecha_operacion, pdd.tipo_comprobante,
        pd.periodo, pd.mes, pd.id_periodo_comision, pdd.id_grupo
        from planilla_delegado_detalles pdd 
        inner join planilla_delegados pd on pdd.id_planilla = pd.id
        inner join agremiados a on pdd.id_agremiado = a.id
        inner join personas p on a.id_persona = p.id
        where pdd.id ='".$id."' ";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function actualizarReciboHonorario($id_periodo,$anio,$mes,$grupo,$cancelado,$numero_operacion,$fecha_operacion,$id_usuario){
  
        $cad = "
            update planilla_delegado_detalles set numero_operacion= '".$numero_operacion."', cancelado= '".$cancelado."', fecha_operacion= '".$fecha_operacion."', id_usuario_actualiza= '".$id_usuario."'
                
            where id in (
                select pdd.id
                from planilla_delegados pd 
                    inner join planilla_delegado_detalles pdd on pdd.id_planilla = pd.id
                where pd.id_periodo_comision = '".$id_periodo."' 
                    and pd.periodo = '".$anio."' 
                    and pd.mes = '".$mes."' 
                    and pdd.estado = '1'
                    and pdd.id_grupo = '".$grupo."'            
                )
                   
        ";

      //  echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }

    Function secuencua_vou($id_periodo,$anio,$mes){
        $cad = "
        select  coalesce(max(secuencua_vou),'0')+1 secuencia
        from planilla_delegados pd 
            inner join planilla_delegado_detalles pdd on pdd.id_planilla = pd.id
        where pd.id_periodo_comision = '".$id_periodo."' 
                and pd.periodo = '".$anio."' 
                and pd.mes = '".$mes."' ";

  //  echo $cad; exit();
    $data = DB::select($cad);
    return $data;

    }

}
