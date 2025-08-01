<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;


class Valorizacione extends Model
{

    protected $fillable = [
    'id_comprobante',
    'pagado',
    // Añade aquí todos los campos que necesites asignar en masa
    'valor_unitario',
    'monto',
    'cantidad',
    'id_pronto_pago',
    // ... otros campos
    ];

    function getValorizacion($tipo_documento,$id_persona,$periodo,$mes,$cuota,$concepto, $filas,$exonerado,$numero_documento_b){  
        
        if($filas!="")$filas="limit ".$filas;
        $credipago = "";
        $tlb_liquidacion = "";
        if($numero_documento_b!=""){
            //$credipago=" and v.descripcion ilike '%".$numero_documento_b."' ";
            $credipago=" and l.credipago = '".$numero_documento_b."' and l.estado = '1' ";
            $tlb_liquidacion = "left join liquidaciones l  on l.id = v.pk_registro and v.id_modulo = 7";

        }
        $exonerado_="";
        if($exonerado!=""){
            $exonerado_ = "and v.exonerado = '".$exonerado."'";
        }

        //if($exonerado=="0")$exonerado="";
        
    //echo($tipo_documento);

        if($tipo_documento=="79"){  //RUC

            $cad = "
            select v.id, v.fecha, c.denominacion  concepto, v.monto,t.denominacion moneda, v.id_moneda, v.fecha_proceso, 
                (case when descripcion is null then c.denominacion else v.descripcion end) descripcion, t.abreviatura,
                (case when v.fecha < now() then '1' else '0' end) vencio, v.id_concepto, c.id_tipo_afectacion,
                coalesce(v.cantidad, '1') cantidad, coalesce(v.valor_unitario, v.monto) valor_unitario, otro_concepto, 
                codigo_fraccionamiento, v.exonerado,v.exonerado_motivo, c.codigo cod_concepto, coalesce(v.descuento_porcentaje, '0') descuento_porcentaje, c.obligatorio_ultimo_pago
                --, v.id_tipo_concepto
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto
                --inner join agremiado_cuotas a  on a.id = v.pk_registro
                inner join tabla_maestras t  on t.codigo::int = v.id_moneda and t.tipo = '1'
                ".$tlb_liquidacion."
                where v.id_empresa = ".$id_persona."            
                and DATE_PART('YEAR', v.fecha)::varchar ilike '%".$periodo."'
                and to_char(DATE_PART('MONTH', v.fecha),'00') ilike '%".$mes."'                
                and (case when v.fecha < now() then '1' else '0' end) ilike '%".$cuota."'
                and c.id::varchar ilike '%".$concepto."'
                and v.estado = '1'            
                and v.pagado = '0'
                --and v.exonerado = '".$exonerado."' 
                ".$exonerado_."
                ".$credipago."
                --and v.descripcion ilike '%".$numero_documento_b."' 
            order by v.fecha desc
             ".$filas."
			";
            //print_r($cad);exit();
        }else{
            $cad = "
            
            select v.id, v.fecha, c.denominacion  concepto, v.monto,t.denominacion moneda, v.id_moneda, v.fecha_proceso, 
                (case when descripcion is null then c.denominacion else v.descripcion end) descripcion, t.abreviatura,
                (case when v.fecha < now() then '1' else '0' end) vencio, v.id_concepto, c.id_tipo_afectacion,
                coalesce(v.cantidad, '1') cantidad, coalesce(v.valor_unitario, v.monto) valor_unitario, otro_concepto,
                codigo_fraccionamiento, v.exonerado,v.exonerado_motivo, c.codigo cod_concepto, coalesce(v.descuento_porcentaje, '0') descuento_porcentaje, c.obligatorio_ultimo_pago
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto            
                inner join tabla_maestras t  on t.codigo::int = v.id_moneda and t.tipo = '1'
                ".$tlb_liquidacion."
                where v.id_persona = ".$id_persona."            
                and DATE_PART('YEAR', v.fecha)::varchar ilike '%".$periodo."'
                and to_char(DATE_PART('MONTH', v.fecha),'00') ilike '%".$mes."'
                and (case when v.fecha < now() then '1' else '0' end) ilike '%".$cuota."'
                and c.id::varchar ilike '%".$concepto."'
                and v.estado = '1'            
                and v.pagado = '0'
                --and v.exonerado = '".$exonerado."' 
                ".$exonerado_."
                ".$credipago."
                --and v.descripcion ilike '%".$numero_documento_b."' 
            order by v.fecha desc
             ".$filas."
			";
        }


       // echo $cad;

		$data = DB::select($cad);
        return $data;
    }

    function getValidaValorizacion($tipo_documento,$id_persona,$concepto){  

        $id_concepto_="";
        if($concepto!=""){
            $id_concepto_ = "and v.id_concepto = ".$concepto." ";
        }

        
        if($tipo_documento=="79"){  //RUC
            $cad = "
            select v.id, v.fecha, to_char(DATE_PART('MONTH', v.fecha),'00') mes, DATE_PART('year', v.fecha) anio
            from valorizaciones v
            where v.id_empresa = ".$id_persona."            
                and v.estado = '1'            
                and v.pagado = '0'
                and v.exonerado = '0'
                ".$id_concepto_."             
            order by v.fecha 
            limit 1            
			";
        }else{
            $cad = "            
            select v.id, v.fecha, to_char(DATE_PART('MONTH', v.fecha),'00') mes, DATE_PART('year', v.fecha) anio            
            from valorizaciones v
            where v.id_persona = ".$id_persona."
                and v.estado = '1'            
                and v.pagado = '0'
                and v.exonerado = '0' 
                  ".$id_concepto_."               
            order by v.fecha 
            limit 1             
			";
        }


        //echo $cad;

		$data = DB::select($cad);
        return $data;
    }

    function getValorizacionFrac($tipo_documento,$id_persona,$periodo,$cuota,$concepto, $filas){  
        
        if($filas!="")$filas="limit ".$filas;
  /*      
        $exonerado_="";
        if($exonerado!=""){
            $exonerado_ = "and v.exonerado = '".$exonerado."'";
        }
*/

        if($tipo_documento=="79"){  //RUC
            $cad = "
            select v.id, v.fecha, c.denominacion  concepto, v.monto,t.denominacion moneda, v.id_moneda, v.fecha_proceso, 
                (case when descripcion is null then c.denominacion else v.descripcion end) descripcion, t.abreviatura,
                (case when v.fecha < now() then '1' else '0' end) vencio, v.id_concepto, c.id_tipo_afectacion,
                coalesce(v.cantidad, '1') cantidad, coalesce(v.valor_unitario, v.monto) valor_unitario, otro_concepto, 
                codigo_fraccionamiento, v.exonerado, v.exonerado_motivo, c.codigo cod_concepto,  coalesce(v.descuento_porcentaje, '0') descuento_porcentaje, c.obligatorio_ultimo_pago
                --, v.id_tipo_concepto
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto
                --inner join agremiado_cuotas a  on a.id = v.pk_registro
                inner join tabla_maestras t  on t.codigo::int = v.id_moneda and t.tipo = '1'
                where v.id_empresa = ".$id_persona."            
                --and DATE_PART('YEAR', v.fecha)::varchar ilike '%".$periodo."'
                --and (case when v.fecha < now() then '1' else '0' end) ilike '%".$cuota."'
                --and c.id in (26411, 26412)
                --and ((c.id = 26411 and  (case when v.fecha < now() then '1' else '0' end) = '0') or (c.id = 26412))
                and ((c.codigo = '00006' and  (case when v.fecha < now() then '1' else '0' end) = '0') or (c.codigo = '00001'))
                and v.estado = '1'            
                and v.pagado = '0'
                and v.exonerado = '0'
            order by v.fecha asc
             ".$filas."
			";
        }else{
            $cad = "            
            select v.id, v.fecha, c.denominacion  concepto, v.monto,t.denominacion moneda, v.id_moneda, v.fecha_proceso, 
                (case when descripcion is null then c.denominacion else v.descripcion end) descripcion, t.abreviatura,
                (case when v.fecha < now() then '1' else '0' end) vencio, v.id_concepto, c.id_tipo_afectacion,
                coalesce(v.cantidad, '1') cantidad, coalesce(v.valor_unitario, v.monto) valor_unitario, otro_concepto,
                codigo_fraccionamiento, v.exonerado, v.exonerado_motivo, c.codigo cod_concepto, coalesce(v.descuento_porcentaje, '0') descuento_porcentaje, c.obligatorio_ultimo_pago
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto                
                inner join tabla_maestras t  on t.codigo::int = v.id_moneda and t.tipo = '1'
                where v.id_persona = ".$id_persona."            
                --and DATE_PART('YEAR', v.fecha)::varchar ilike '%".$periodo."'
                --and (case when v.fecha < now() then '1' else '0' end) ilike '%".$cuota."'
                --and c.id in (26411, 26412)
                --and ((c.id = 26411 and  (case when v.fecha < now() then '1' else '0' end) = '1') or (c.id = 26412))
                and ((c.codigo = '00006' and  (case when v.fecha < now() then '1' else '0' end) = '1') or (c.codigo = '00001'))
                and v.estado = '1'            
                and v.pagado = '0' 
                and v.exonerado = '0'               
            order by v.fecha asc
             ".$filas."
			";
            /*            
            $cad = "
            --select v.id, v.fecha, c.denominacion||' '||a.mes||' '||a.periodo  concepto, v.monto,t.denominacion moneda, v.id_moneda
            select v.id, v.fecha, c.denominacion  concepto, v.monto,t.denominacion moneda, v.id_moneda, v.fecha_proceso, 
                (case when descripcion is null then c.denominacion else v.descripcion end) descripcion, t.abreviatura,
                (case when v.fecha < now() then '1' else '0' end) vencio, v.id_concepto, c.id_tipo_afectacion,
                coalesce(v.cantidad, '1') cantidad, coalesce(v.valor_unitario, v.monto) valor_unitario, otro_concepto,
                codigo_fraccionamiento, v.exonerado
                --, v.id_tipo_concepto
            from valorizaciones v
                inner join conceptos c  on c.id = v.id_concepto
                --inner join agremiado_cuotas a  on a.id = v.pk_registro
                inner join tabla_maestras t  on t.codigo::int = v.id_moneda and t.tipo = '1'
                where v.id_persona = ".$id_persona."            
                and DATE_PART('YEAR', v.fecha)::varchar ilike '%".$periodo."'
                and (case when v.fecha < now() then '1' else '0' end) ilike '%".$cuota."'
                and c.id in (26411, 26412)
                and v.estado = '1'            
                and v.pagado = '0'
                --and v.exonerado = '0'
            order by v.fecha desc
             ".$filas."
			";
*/
        }


        //echo $cad;

		$data = DB::select($cad);
        return $data;
    }
    function getValorizacion_total($tipo_documento,$id_persona, $id_concepto){        
        if($tipo_documento=="79"){  //RUC
            $cad = "
            select  sum(v.monto) as monto
            from valorizaciones v
            inner join conceptos c  on c.id = v.id_concepto                       
            where v.id_empresa = ".$id_persona."                              
                and (case when v.fecha < now() then '1' else '0' end) ilike '1'
                --and id_concepto in (26412, 26411)
                and c.codigo in ('00006', '00001')
                and v.estado = '1'            
                and v.pagado = '0'
			";
        }else{
            $cad = "
            select  sum(v.monto) as monto
            from valorizaciones v
             inner join conceptos c  on c.id = v.id_concepto                       
            where v.id_persona = ".$id_persona."                              
                and (case when v.fecha < now() then '1' else '0' end) ilike '1'
                --and id_concepto in (26412, 26411)
                and c.codigo in ('00006', '00001')
                and v.estado = '1'            
                and v.pagado = '0'
			";
        }


        //echo $cad;

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

        if($tipo_documento=="79"){
            $cad = "select distinct c.id id_comprobante,c.tipo, c.fecha, c.serie, c.numero, c.total, u.name usuario_registro, c.estado_pago,
            (select string_agg(coalesce(d.descripcion), ',' order by d.item desc)  from comprobante_detalles d  where d.id_comprobante = c.id ) descripcion,id_comprobante_ncnd, 
            (select id
             from comprobantes cc 
             where c.id=cc.id_comprobante_ncnd and cc.tipo='NC' limit 1) as tiene_nc,
             (select id
             from comprobantes cn 
             where c.id=cn.id_comprobante_ncnd and cn.tipo='ND' limit 1) as tiene_nd

            from comprobantes c
            inner join comprobante_detalles d on d.id_comprobante = c.id
            --inner join valorizaciones v on v.id_comprobante = c.id            
            left join users u  on u.id  = c.id_usuario_inserta 
            where c.id_empresa = ".$persona_id."
            and c.tipo in ('FT', 'BV')
            order by c.fecha desc";

        }else{
            $cad = "select distinct c.id id_comprobante,c.tipo, c.fecha, c.serie, c.numero, c.total, u.name usuario_registro, c.estado_pago,
            (select string_agg( coalesce(d.descripcion), ',' order by d.item desc)  from comprobante_detalles d  where d.id_comprobante = c.id ) descripcion,id_comprobante_ncnd ,
            (select id
             from comprobantes cc 
             where cc.id_comprobante_ncnd = c.id and cc.tipo='NC' limit 1) as tiene_nc,
             (select id
             from comprobantes cn 
             where cn.id_comprobante_ncnd = c.id and cn.tipo='ND' limit 1) as tiene_nd
            from comprobantes c
            inner join comprobante_detalles d on d.id_comprobante = c.id            
            left join users u  on u.id  = c.id_usuario_inserta 
            --inner join personas p on c.cod_tributario=p.numero_documento
            where c.id_persona = ".$persona_id."            
            and c.tipo in ('FT', 'BV')
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



     function getPeridoValorizacion($tipo_documento,$id_persona){        
        if($tipo_documento=="79"){  //RUC
            $cad = "
            select distinct  DATE_PART('YEAR', v.fecha)::varchar periodo
            from valorizaciones v
            group by v.fecha,v.id_empresa,v.estado,v.pagado
            having v.id_empresa = ".$id_persona."
            and v.estado = '1'            
            and v.pagado = '0'
            order by  DATE_PART('YEAR', v.fecha)::varchar
			";
        }else{
            $cad = "
            select distinct  DATE_PART('YEAR', v.fecha)::varchar periodo
            from valorizaciones v
            group by v.fecha,v.id_persona,v.estado,v.pagado
            having v.id_persona = ".$id_persona."
            and v.estado = '1'            
            and v.pagado = '0'
            order by  DATE_PART('YEAR', v.fecha)::varchar
			";
        }

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getMesValorizacion($tipo_documento,$id_persona){        
        if($tipo_documento=="79"){  //RUC
            $cad = "
            select distinct  to_char(DATE_PART('MONTH', v.fecha),'00') id, to_char(v.fecha, 'TMMonth') mes
            from valorizaciones v
            group by v.fecha,v.id_empresa,v.estado,v.pagado
            having v.id_empresa = ".$id_persona."
            and v.estado = '1'            
            and v.pagado = '0'
            order by to_char(DATE_PART('MONTH', v.fecha),'00')
			";
        }else{
            $cad = "
            select distinct to_char(DATE_PART('MONTH', v.fecha),'00') id, to_char(v.fecha, 'TMMonth') mes
            from valorizaciones v
            group by v.fecha,v.id_persona,v.estado,v.pagado
            having v.id_persona = ".$id_persona."
            and v.estado = '1'            
            and v.pagado = '0'
            order by  to_char(DATE_PART('MONTH', v.fecha),'00')
			";
        }

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }


    function getAnulaFraccionamiento($tipo_documento,$id_persona, $codigo_fraccionamiento){        
        if($tipo_documento=="79"){  //RUC
            $cad = "
            update valorizaciones v set estado = (
            	select (case when v2.estado = '1' then '0' else '1' end)
            	from valorizaciones v2 where v2.id = v.id 
            ) 
            where v.id_empresa = ".$id_persona."            
                and v.pagado = '0'
                and v.codigo_fraccionamiento = ".$codigo_fraccionamiento."

			";
        }else{
            $cad = "
            update valorizaciones v set estado = (
            	select (case when v2.estado = '1' then '0' else '1' end)
            	from valorizaciones v2 where v2.id = v.id 
            ) 
            where v.id_persona = ".$id_persona."            
                and v.pagado = '0'
                and v.codigo_fraccionamiento = ".$codigo_fraccionamiento."
			";
        }

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function ActualizaValorizacion_pp($tipo_documento,$id_fraccionamiento,$id_persona){        
        if($tipo_documento=="79"){  //RUC
            $cad = "
            update valorizaciones set codigo_fraccionamiento = ".$id_fraccionamiento.", estado = 0                      
            where id_empresa = ".$id_persona."                              
                and (case when fecha < now() then '1' else '0' end) ilike '1'
                and id_concepto = 26411
                and estado = '1'            
                and pagado = '0'
			";
        }else{
            $cad = "
            update valorizaciones set codigo_fraccionamiento = ".$id_fraccionamiento.", estado = 0                      
            where id_persona = ".$id_persona."                              
                and (case when fecha < now() then '1' else '0' end) ilike '1'
                and id_concepto = 26411
                and estado = '1'            
                and pagado = '0'
			";
        }
        
      //  echo $cad;

		$data = DB::select($cad);
        return $data;
    }

    function getBuscaDeudaAgremido($id_persona){
        $cad = "    
            select  count(*) total from (
                select  count(*)  total          
                from valorizaciones v
                group by v.fecha,v.id_persona,v.estado,v.pagado,v.id_concepto,v.exonerado
                having v.id_persona =  ".$id_persona."
                and v.estado = '1'
                and v.exonerado = '0'            
                and v.pagado = '0'
                and v.fecha < now() 
                and v.id_concepto in(26411, 26461)
            ) AS total;

			";
    
		$data = DB::select($cad);
        if($data)return $data[0];
    }
    
    function getBuscaMultaAgremido($id_persona){
        $cad = "    
            select  count(*) total from (
                select  count(*)  total          
                from valorizaciones v
                group by v.fecha,v.id_persona,v.estado,v.pagado,v.id_concepto,v.exonerado
                having v.id_persona =  ".$id_persona."
                and v.estado = '1'            
                and v.pagado = '0'  
                and v.exonerado = '0'              
                and v.id_concepto in (26461)
            ) AS total;

			";
    
		$data = DB::select($cad);
        if($data)return $data[0];
    }

    function ActualizaValorizacionCredipago($id_val){        
       
        $cad = "
        update solicitudes s set id_resultado = '4' 
        from liquidaciones l 
            inner join valorizaciones v on v.pk_registro = l.id 
        where v.id =  ".$id_val."
            and l.id_solicitud = s.id 
        ";
       
        
      //  echo $cad;

		$data = DB::select($cad);
        return $data;
    }
    
	public function listar_liquidacion_caja_ajax($p){
		return $this->readFunctionPostgres('sp_listar_liquidacion_caja_paginado',$p);
    }

    public function listar_reporte_deudas_ajax($p){
		return $this->readFunctionPostgres('sp_listar_deudas_seguro_paginado',$p);
    }

    public function listar_deuda_detallado_caja_ajax($p){
		return $this->readFunctionPostgres('sp_listar_deuda_detallado_caja_paginado',$p);
    }

    public function listar_deuda_caja_ajax($p){
		return $this->readFunctionPostgres('sp_listar_deuda_caja_paginado',$p);
    }
    
    public function listar_deuda_caja_anual_ajax($p){
		return $this->readFunctionPostgres('sp_listar_deuda_caja_anual_paginado',$p);
    }

    function getExonerado($id_agremido){        
       
        $cad = "select *
        from valorizaciones
        where id_concepto = 26461
        and id_agremido = '".$id_agremido."'
        and pagado = '0' and exonerado = '0'";
       
        
      //  echo $cad;

		$data = DB::select($cad);
        return $data;
    }

    function getGeneraAnioDeuda(){        
       
        $cad = "select distinct  DATE_PART('YEAR', v.fecha)::varchar anio
        from valorizaciones v
        where v.estado ='1'
        and v.id_modulo ='4'";
        
      //  echo $cad;

		$data = DB::select($cad);
        return $data;
    }

    function getDeudaDetalladoReporte($f_fin){        
       
        $cad = "select v.id, a.numero_cap, p.apellido_paterno ||' '|| p.apellido_materno ||' ' || p.nombres apellidos_nombre, v.monto, c.denominacion concepto, v.descripcion , EXTRACT(YEAR FROM v.fecha) periodo , v.fecha fecha_vencimiento 
        from valorizaciones v 
        inner join conceptos c on v.id_concepto = c.id 
        inner join agremiados a on v.id_agremido = a.id 
        inner join personas p on a.id_persona = p.id
        where v.estado ='1'
        and v.pagado ='0'
        and v.fecha <= '".$f_fin."'
        and v.id_modulo in (2,3,4,6)
        order by apellidos_nombre, concepto
        limit 1000";
        
      //  echo $cad;

		$data = DB::select($cad);
        return $data;
    }

    function getDeudaReporte($f_fin){        
       
        $cad = "select a.numero_cap, p.apellido_paterno || ' ' || p.apellido_materno || ' ' || p.nombres AS apellidos_nombre, SUM(v.monto) AS monto_total
        from valorizaciones v 
        inner JOIN conceptos c ON v.id_concepto = c.id 
        inner JOIN agremiados a ON v.id_agremido = a.id 
        inner JOIN personas p ON a.id_persona = p.id
        where v.estado = '1'
        and v.pagado = '0'
        and v.fecha <= '".$f_fin."'
        and v.id_modulo IN (2, 3, 4, 6)
        and a.id_regional = 5
        group by a.numero_cap, apellidos_nombre
        order by apellidos_nombre
        limit 1000";
        
      //  echo $cad;

		$data = DB::select($cad);
        return $data;
    }

    function getProntoPago($cap, $año_actual){

        $cad = "select v.id, v.id_pronto_pago from valorizaciones v 
        inner join agremiados a on v.id_agremido = a.id 
        inner join pronto_pagos pp on v.id_pronto_pago = pp.id
        where a.numero_cap ='".$cap."' and pp.periodo ='".$año_actual."' 
        limit 1 ";

		//echo $cad;
		$data = DB::select($cad);
        if($data)return $data[0];
    }

    function getPagosCuotaConstancia($cap, $año_actual){

        $cad = "select v.id, to_char(v.fecha,'yyyy-mm-dd') fecha_vencimiento, to_char(c.fecha_pago,'yyyy-mm-dd') fecha_pago from valorizaciones v 
        inner join agremiados a on v.id_agremido = a.id 
        left join comprobantes c on v.id_comprobante = c.id
        where a.numero_cap ='".$cap."' and DATE_PART('YEAR', v.fecha)::varchar ilike '%".$año_actual."' 
        --and v.pagado ='1'
        and id_modulo ='2'
        order by id desc";

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getFechaVencimientoPagos($cap, $anio){

        $cad = "select v.id, to_char(v.fecha,'yyyy-mm-dd') fecha_vencimiento, to_char(c.fecha_pago,'yyyy-mm-dd') fecha_pago from valorizaciones v 
        inner join agremiados a on v.id_agremido = a.id 
        left join comprobantes c on v.id_comprobante = c.id
        where a.numero_cap ='".$cap."' and DATE_PART('YEAR', v.fecha)::varchar ilike '%".$anio."' 
        and id_modulo ='2'
        order by id desc";

		//echo $cad;
		$data = DB::select($cad);
        //if($data)return $data[0];
        return $data;
    }

    function getUltimoPago($cap){

        $cad = "select v.id, v.fecha, v.pagado from valorizaciones v 
        inner join agremiados a on v.id_agremido = a.id 
        where a.numero_cap ='".$cap."' and id_modulo ='2' and pagado ='1'
        order by v.fecha desc
        limit 1";

        //echo $cad;
        $data = DB::select($cad);
        if($data)return $data[0];
    }

    function getUltimaCuota($cap){

        $cad = "select v.id, v.fecha, v.pagado from valorizaciones v 
        inner join agremiados a on v.id_agremido = a.id 
        where a.numero_cap ='".$cap."' and id_modulo ='2'
        order by v.fecha desc
        limit 1";

        //echo $cad;
        $data = DB::select($cad);
        if($data)return $data[0];
    }

    function getAgremiadoMulta($id_agremiado){

        $cad = "select count(*) cantidad from valorizaciones v 
        where id_modulo ='3'
        and id_agremido ='".$id_agremiado."'
        and pagado ='0'
        and estado ='1'
        and exonerado ='0'";

        //echo $cad;
        $data = DB::select($cad);
        return $data;
    }
}
