<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;


class Valorizacione extends Model
{
    function getValorizacion($tipo_documento,$id_persona,$periodo,$cuota,$concepto){        
        if($tipo_documento=="79"){  //RUC
            $cad = "
            select v.id, v.fecha, c.denominacion  concepto, v.monto,t.denominacion moneda, v.id_moneda, v.fecha_proceso, 
                (case when descripcion is null then c.denominacion else v.descripcion end) descripcion, t.abreviatura,
                (case when v.fecha < now() then '1' else '0' end) vencio, v.id_concepto
                --, v.id_tipo_concepto
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto
                --inner join agremiado_cuotas a  on a.id = v.pk_registro
                inner join tabla_maestras t  on t.codigo::int = v.id_moneda and t.tipo = '1'
                where v.id_empresa = ".$id_persona."            
                and DATE_PART('YEAR', v.fecha)::varchar ilike '%".$periodo."'
                and (case when v.fecha < now() then '1' else '0' end) ilike '%".$cuota."'
                and c.id::varchar ilike '%".$concepto."'
                and v.estado = '1'            
                and v.pagado = '0'
            order by v.fecha desc
			";
        }else{
            $cad = "
            --select v.id, v.fecha, c.denominacion||' '||a.mes||' '||a.periodo  concepto, v.monto,t.denominacion moneda, v.id_moneda
            select v.id, v.fecha, c.denominacion  concepto, v.monto,t.denominacion moneda, v.id_moneda, v.fecha_proceso, 
                (case when descripcion is null then c.denominacion else v.descripcion end) descripcion, t.abreviatura,
                (case when v.fecha < now() then '1' else '0' end) vencio, v.id_concepto
                --, v.id_tipo_concepto
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto
                --inner join agremiado_cuotas a  on a.id = v.pk_registro
                inner join tabla_maestras t  on t.codigo::int = v.id_moneda and t.tipo = '1'
                where v.id_persona = ".$id_persona."            
                and DATE_PART('YEAR', v.fecha)::varchar ilike '%".$periodo."'
                and (case when v.fecha < now() then '1' else '0' end) ilike '%".$cuota."'
                and c.id::varchar ilike '%".$concepto."'
                and v.estado = '1'            
                and v.pagado = '0'
            order by v.fecha desc
			";
        }

       // echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getValorizacionConcepto($tipo_documento,$id_persona){        
        if($tipo_documento=="79"){  //RUC
            $cad = "
            select distinct  c.id, c.denominacion 
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto
            where v.id_empresa  = ".$id_persona."            
                and v.estado = '1'            
                and v.pagado = '0'            
            order by c.denominacion  asc
			";
        }else{
            $cad = "
            select distinct  c.id, c.denominacion 
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto
            where v.id_persona = ".$id_persona."            
                and v.estado = '1'            
                and v.pagado = '0'            
            order by c.denominacion  asc
			";
        }

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getPago($tipo_documento,$persona_id){

        if($tipo_documento=="RUC"){

        }else{
            $cad = "select distinct c.id id_comprobante,c.tipo, c.fecha, c.serie, c.numero, c.total, u.name usuario_registro,
            (select string_agg(DISTINCT coalesce(d.descripcion), ',')  from comprobante_detalles d  where d.id_comprobante = c.id) descripcion
            from comprobantes c
            inner join comprobante_detalles d on d.id_comprobante = c.id
            inner join valorizaciones v on v.id_comprobante = c.id            
            left join users u  on u.id  = c.id_usuario_inserta 
            where v.id_persona = ".$persona_id."
            order by c.fecha desc";
    
        }

        
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
        DB::select("BEGIN;");
        $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
        DB::select($cad);
        $cad = "FETCH ALL IN ref_cursor;";
        $data = DB::select($cad);
        DB::select("END;");
        return $data;
     }

     function getCajaIngresoByusuario($id_usuario,$tipo){

        $cad = "select t1.id,t1.id_caja,t1.saldo_inicial,
		(select coalesce(Sum(total),0) from comprobantes where id_caja=t1.id_caja And fecha >= fecha_inicio And fecha <= (case when fecha_fin is null then now() else fecha_fin end))total_recaudado,
		((select coalesce(Sum(total),0) from comprobantes where id_caja=t1.id_caja And fecha >= fecha_inicio And fecha <= (case when fecha_fin is null then now() else fecha_fin end)) + t1.saldo_inicial)saldo_total,
		t1.estado,t2.denominacion caja,t3.name usuario
        from caja_ingresos t1
        inner join tabla_maestras t2 on t1.id_caja=t2.codigo::int 
		inner join users t3 on t1.id_usuario = t3.id
        where t1.id_usuario=".$id_usuario."
		And t2.tipo='".$tipo."'
		and t1.estado='1'
		order by 1 desc
        limit 1";

		//echo $cad;
		$data = DB::select($cad);
        if($data)return $data[0];
     }

     public function registrar_caja_ingreso($datos) {

        $cad = "Select sp_crud_caja_ingreso(?,?,?,?,?,?,?,?)";
        //echo "Select sp_crud_caja_ingreso(".$datos[0].",".$datos[1].",".$datos[2].",".$datos[3].",".$datos[4].",".$datos[5].",".$datos[6].",".$datos[7].")";
		$data = DB::select($cad, array($datos[0],$datos[1],$datos[2],$datos[3],$datos[4],$datos[5],$datos[6],$datos[7]));
        return $data[0]->sp_crud_caja_ingreso;
    }
    public function registrar_caja_ingreso_moneda($datos) {

        //$cad = "Select sp_crud_caja_ingreso(?,?,?,?,?,?,?,?)";
		$cad = "Select sp_crud_caja_ingreso_moneda(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        //echo "Select sp_crud_caja_ingreso(".$datos[0].",".$datos[1].",".$datos[2].",".$datos[3].",".$datos[4].",".$datos[5].",".$datos[6].",".$datos[7].",".$datos[8].",".$datos[9].",".$datos[10].",".$datos[11].",".$datos[12].")";
		$data = DB::select($cad, array($datos[0],$datos[1],$datos[2],$datos[3],$datos[4],$datos[5],$datos[6],$datos[7],$datos[8],$datos[9],$datos[10],$datos[11],$datos[12]));
        return $data[0]->sp_crud_caja_ingreso_moneda;
    }

    function getValorizacionFactura($id_factura)
    {

        $cad = "select R.*,
            round(cast(vsm_precio/1.18 as numeric),2) valor_unitario,
            round(cast(vsm_precio*1/1.18 as numeric),2) valor_venta_bruto,
            round(cast((vsm_precio*1/1.18)-(((COALESCE(descuento,0)*vsm_precio)/100)/1.18) as numeric),2) valor_venta,
            round(cast(((vsm_precio*1/1.18)-(((COALESCE(descuento,0)*vsm_precio)/100)/1.18))*0.18 as numeric),2) igv,
            round(cast((((vsm_precio*1/1.18)-(((COALESCE(descuento,0)*vsm_precio)/100)/1.18))*0.18)+(vsm_precio*1/1.18)-(((COALESCE(descuento,0)*vsm_precio)/100)/1.18) as numeric),2) total,
            round(cast((((COALESCE(descuento,0)*vsm_precio)/100)/1.18) as numeric),2) descuento_item
            from(
            select
            t1.val_estab, t1.val_codigo,t3.vsm_modulo,
            t3.vsm_smodulo,t1.val_fecha,t1.val_pac_nombre,t1.val_subtotal,t1.val_subtotal_plan,t1.val_total,
            t1.val_moneda,t2.vm_modulod,t2.vm_descripcion,t2.vm_precio,t3.vsm_smodulo,t3.vsm_smodulod,t3.vsm_precio,
            t3.vsm_costo_plan, t4.smod_plancontable plancontable,
            t1.val_impuesto,
            t3.vsm_precio precio_venta,
            case when (select count(*) from valorizaciones t11
                inner join val_atencion_modulos t22 on t1.val_estab = t22.vm_vestab And t11.val_codigo = t22.vm_vnumero
                inner join val_atencion_smodulos t33 on t22.vm_vestab = t33.vsm_vestab And t22.vm_vnumero = t33.vsm_vnumero And t22.vm_modulo = t33.vsm_modulo
            where t11.val_estab_i = t1.val_estab_i and t11.val_codigo_i = t1.val_codigo_i and t33.vsm_modulo = t3.vsm_modulo and t33.vsm_smodulo = t3.vsm_smodulo) > 1 then null else t4.smod_descuento end descuento,
            COALESCE(plan_tipo_factura,smod_tipo_factura) smod_tipo_factura,
            smod_control,
            (case when t3.vsm_modulo=2 And t3.vsm_smodulo in (1,2,6,11,19,20) Then 0 else 1 end)flag_estado_cuenta
            from valorizaciones t1
            inner join val_atencion_modulos t2 on t1.val_estab = t2.vm_vestab And t1.val_codigo = t2.vm_vnumero
            inner join val_atencion_smodulos t3 on t2.vm_vestab = t3.vsm_vestab And t2.vm_vnumero = t3.vsm_vnumero And t2.vm_modulo = t3.vsm_modulo
            inner join sub_modulos t4 on t3.vsm_modulo = t4.smod_modulo And t3.vsm_smodulo = t4.smod_codigo
            inner join facturas t5 on t3.vsm_fac_tipo=t5.fac_tipo And t3.vsm_fac_serie=t5.fac_serie And t3.vsm_fac_numero=t5.fac_numero
            left join plan_atenciones t6 on t1.val_plan = t6.id
            Where t1.val_estab=1
            And t5.id=" . $id_factura . "
            And val_tipo='P'
            And t1.val_anulado='N'
            And t3.vsm_facturado='S'
            And t2.vm_estado='A' And t2.vm_eliminado='N'
            And t3.vsm_estado='A' And t3.vsm_eliminado='N'
            And t3.vsm_precio > 0
            order by t1.val_fecha desc
            )R";

        $data = DB::select($cad);
        return $data;
    }
}
