<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CajaIngreso extends Model
{
    function getCajaIngresoByusuario($id_usuario,$tipo){

        $cad = "select t1.id,t1.id_caja,t1.saldo_inicial,
		(select coalesce(Sum(total),0) from comprobantes where id_caja = t1.id_caja And fecha >= fecha_inicio And fecha <= (case when fecha_fin is null then now() else fecha_fin end))total_recaudado,
	    ((select coalesce(Sum(total),0) from comprobantes where id_caja=t1.id_caja And fecha >= fecha_inicio And fecha <= (case when fecha_fin is null then now() else fecha_fin end)) + t1.saldo_inicial)saldo_total,
		t1.estado,t2.denominacion caja,t3.name usuario		
		from caja_ingresos t1
        inner join tabla_maestras t2 on t1.id_caja=t2.codigo::int
		inner join users t3 on t1.id_usuario = t3.id
        where t1.id_usuario= ".$id_usuario."
		And t2.tipo= '".$tipo."'
		and t1.estado='1'
		order by 1 desc
        limit 1";

		//echo $cad;
		$data = DB::select($cad);
        if($data)return $data[0];
    }

    function getCajaUsuario(){

        $cad = "select distinct t3.id id,t3.name ||'-'||t2.denominacion denominacion
                from caja_ingresos t1
                    inner join tabla_maestras t2 on t2.codigo = t1.id_caja::varchar and t2.tipo = '91'
                    inner join users t3 on t1.id_usuario=t3.id			
                where t1.saldo_liquidado is null
                order by 1
        ";

		//echo $cad;
        $data = DB::select($cad);
        return $data;
    }

    function getCajaUsuario_u(){

        $cad = "select u.id, u.name  denominacion
                from users u 
                where u.id in(select distinct  ci.id_usuario from caja_ingresos ci where ci.estado = '0')
        ";

		//echo $cad;
        $data = DB::select($cad);
        return $data;
    }
    function getCajaUsuario_all(){

        $cad = "select u.id, u.name  denominacion
                from users u 
                where u.id in(select distinct  ci.id_usuario from caja_ingresos ci)
        ";

		//echo $cad;
        $data = DB::select($cad);
        return $data;
    }
    function getCajaUsuario_c($id){

        $cad = "select distinct t2.codigo id, t2.denominacion 
                from caja_ingresos t1
                inner join tabla_maestras t2 on t2.codigo = t1.id_caja::varchar and t2.tipo = '91'
                where t1.id_usuario = ".$id."
                order by 2
        ";

		//echo $cad;
        $data = DB::select($cad);
        return $data;
    }

    function getAllCajaUsuario(){

        $cad = "select distinct t1.id id,t3.name ||'-'||t2.denominacion denominacion
                from caja_ingresos t1
                    inner join tabla_maestras t2 on t2.codigo = t1.id_caja::varchar and t2.tipo = '91'
                    inner join users t3 on t1.id_usuario=t3.id			
                where t1.saldo_liquidado is not null
                order by 1
        ";

		//echo $cad;
        $data = DB::select($cad);
        return $data;
    }

    function getCajaIngresoById($id,$f_inicio){
        $cad = "select distinct t1.id id,t3.name ||'-'||t2.denominacion denominacion
            from caja_ingresos t1
                inner join tabla_maestras t2 on t2.codigo = t1.id_caja::varchar and t2.tipo = '91'
                inner join users t3 on t1.id_usuario=t3.id			
            where t1.id = ".$id."
        ";

        //echo $cad;
        $data = DB::select($cad);
        return $data;

    }

    function getCajaById($id){
        $cad = "select t2.denominacion denominacion
            from tabla_maestras t2 
            where t2.codigo = '".$id."' and t2.tipo = '91'
        ";

        //echo $cad;
        $data = DB::select($cad);
        return $data;

    }

    function getUsuarioById($id){
        $cad = "select t2.name usuario
            from users t2 
            where t2.id = ".$id."
        ";

        //echo $cad;
        $data = DB::select($cad);
        return $data;

    }


    function getCajaComprobante($id_usuario, $fecha){
/*
        $cad = "select situacion, tipo, sum(total)total, count(*) cantidad
            from(
                select (case when c.estado_pago='P' then 'PENDIENTE' else 'CANCELADO'end) situacion, t.denominacion tipo, sum(c.total) total
                from comprobantes c 
                    inner join tabla_maestras t on t.abreviatura = c.tipo  and t.tipo = '126'
                    inner join tabla_maestras m on m.codigo = c.id_caja::varchar and m.tipo = '91'
                group by c.estado_pago, t.denominacion, c.id_usuario_inserta, c.fecha
                having  c.id_usuario_inserta = ".$id_usuario."
                and TO_CHAR(c.fecha, 'dd-mm-yyyy')  = '".$fecha."'
            )
            group by situacion, tipo
        ";
*/
        $cad = "select situacion, tipo, tipo_, sum(total)total, count(*) cantidad 
                from( select (case when c.estado_pago='P' then 'PENDIENTE' else 'CANCELADO'end) situacion, 
                t.denominacion tipo, c.tipo tipo_, case when  c.tipo ='NC' and c.afecta_caja='C' then -1* sum(c.total)  when  c.tipo ='NC' and c.afecta_caja='D' then 0 else sum(c.total) end  total  
                from comprobantes c 
                inner join tabla_maestras t on t.abreviatura = c.tipo and t.tipo = '126' 
                inner join tabla_maestras m on m.codigo = c.id_caja::varchar and m.tipo = '91' 
                group by c.estado_pago, t.denominacion, c.id_usuario_inserta, c.fecha, c.tipo, c.id_forma_pago ,c.afecta_caja
                having c.id_usuario_inserta = ".$id_usuario."
                and TO_CHAR(c.fecha, 'dd-mm-yyyy') = '".$fecha."' 
                and c.id_forma_pago = 1
                )  as reporte
                group by situacion, tipo_,tipo";

	    //echo($cad);

        $data = DB::select($cad);
        return $data;
    }
    
    function getCajaCondicionPago($id_usuario, $fecha){

        $cad = "           
        select condicion,  sum(total_us) total_us,sum(total_tc) total_tc,sum(total_soles) total_soles
         from(
             select t.denominacion condicion,  0 total_us, 0/3.7 total_tc,  case when  c.tipo ='NC' and c.afecta_caja='C' then  cp.monto  when  c.tipo ='NC' and c.afecta_caja='D' then 0 else  cp.monto end  total_soles
             from comprobantes c                                
                 inner join comprobante_pagos cp on cp.id_comprobante = c.id
                 inner join tabla_maestras t on t.codigo  = cp.id_medio::varchar and t.tipo = '19'
            
             where  c.id_usuario_inserta = ".$id_usuario."
             and TO_CHAR(c.fecha, 'dd-mm-yyyy')  = '".$fecha."'
             and c.id_forma_pago = 1
         ) as consulta
       group by condicion
        ";

		//echo $cad;
        $data = DB::select($cad);
        return $data;
    }


    function getAllCajaComprobante($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

         //echo $tipo; exit(); 

        $usuario_sel = "";
        if ($tipo=='S') {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }
        
        $cad = "
        		select situacion, tipo, tipo_, sum(total)total, count(*) cantidad 
                from( 
                    select (case when c.estado_pago='P' then 'PENDIENTE' else 'CANCELADO'end) situacion, 
                    t.denominacion tipo, c.tipo tipo_, case when  c.tipo ='NC' and c.afecta_caja='C' then -1* sum(c.total)  when  c.tipo ='NC' and c.afecta_caja='D' then 0 else sum(c.total) end total 
                    from comprobantes c 
                        inner join tabla_maestras t on t.abreviatura = c.tipo and t.tipo = '126' 
                        inner join tabla_maestras m on m.codigo = c.id_caja::varchar and m.tipo = '91' 
                    group by c.estado_pago, t.denominacion, c.id_usuario_inserta, c.fecha, c.tipo, c.id_forma_pago, c.anulado,c.id_caja,afecta_caja 
                    having  1=1
                    ".$usuario_sel."
                    and TO_CHAR(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."' 
                    and c.id_forma_pago = 1
                    and c.anulado = 'N'

                ) as reporte
                group by situacion, tipo_,tipo";

        //echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }

    function getAllCajaComprobante_por_cobrar($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }
        $cad = "
        		select tm.denominacion tipo_documento, c.serie ||'-'|| c.numero::varchar(20) numero, c.destinatario,  0 us , case when afecta_caja ='C' then -1* c.total 
              																											    when afecta_caja ='D' then - c.total
              																											    else c.total end  
                    from comprobantes c inner join tabla_maestras tm on c.tipo =tm.abreviatura  and tm.tipo='126'
                    where 1=1 
                    ".$usuario_sel."
                    and to_char(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."'
                    and c.id_forma_pago = 2 
                    order by tm.denominacion,c.id  ;  ";

        //echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }
    
    function getAllCajaCondicionPago($id_usuario,  $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }

        $cad = "
            select condicion, sum(total_us) total_us,sum(total_tc) total_tc,sum(total_soles) total_soles
            from(
                select t.denominacion||' '||m.denominacion condicion, 0 total_us, 0/3.7 total_tc, round( CAST(case when  c.tipo ='NC' and c.afecta_caja='C' then  cp.monto  when  c.tipo ='NC' and c.afecta_caja='D' then 0 else  cp.monto end as numeric), 2) total_soles
                from comprobantes c                                
                    inner join comprobante_pagos cp on cp.id_comprobante = c.id
                    inner join tabla_maestras t on t.codigo  = cp.id_medio::varchar and t.tipo = '19'
                    inner join tabla_maestras m on m.codigo  = c.id_moneda::varchar and m.tipo = '1'
                where  1=1
                ".$usuario_sel."
                and TO_CHAR(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."' 
                and c.id_forma_pago = '1'
                and c.anulado = 'N'
            ) as reporte
            group by condicion";

        //echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }

    function getAllReporteVentas( $f_inicio, $f_fin, $id_concepto, $forma_pago,$estado_pago){

        $concepto_sel = "";
        $forma_pago_sel="";
        $estado_pago_sel = "";


        if ($id_concepto!="-1") $concepto_sel = " and cd.id_concepto  = ".$id_concepto; 
        if ($forma_pago!="-1") $forma_pago_sel = " and c.id_forma_pago  = '". $forma_pago . "' "; 
        if ($estado_pago!="-1") $estado_pago_sel = " and c.estado_pago  = '". $estado_pago . "' "; 

        $cad = "
               select concepto, fecha,tipo, serie,numero, cod_tributario, destinatario, cantidad, descripcion, importe ,id_concepto  
                from (
                        select fecha,c.tipo, c.serie,c.numero, cod_tributario, destinatario, cd.cantidad, cd.descripcion, cd.importe ,cd.id_concepto , c2.denominacion concepto
                        from comprobantes c inner join comprobante_detalles cd on c.id=cd.id_comprobante 
                        inner join conceptos c2 on cd.id_concepto=c2.id 
                       where 1=1 "
                      .  $concepto_sel . $estado_pago_sel.  $forma_pago_sel. " and  TO_CHAR(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."' ) 
                      as reporte group by fecha,tipo, serie,numero, cod_tributario, destinatario, cantidad, descripcion, importe ,id_concepto, concepto
                      order by id_concepto, fecha";

        
       $data = DB::select($cad);
        
        return $data;
    }

    function getAllReporteVentasMensual( $f_inicio, $f_fin, $id_concepto, $forma_pago,$estado_pago){

        $concepto_sel = "";
        $forma_pago_sel="";
        $estado_pago_sel = "";

        if ($id_concepto!="-1") $concepto_sel = " and cd.id_concepto  = ".$id_concepto; 
        if ($forma_pago!="-1") $forma_pago_sel = " and c.id_forma_pago  = '". $forma_pago . "' "; 
        if ($estado_pago!="-1") $estado_pago_sel = " and c.estado_pago  = '". $estado_pago . "' "; 
      
        $cad = "select fecha,c.tipo, c.serie,c.numero, cod_tributario, destinatario,subtotal ,impuesto ,total , case when id_forma_pago=1 then 'CONTADO' else 'CREDITO' end as forma_pago, case when estado_pago='P' then 'PENDIENTE' else 'CANCELADO' end as estado_pago,
                case when c.impuesto >0 then subtotal * case when c.tipo='NC' then -1 else 1 end else 0 end imp_afecto,
                case when c.impuesto =0 then subtotal * case when c.tipo='NC' then -1 else 1 end else 0 end imp_inafecto
                from comprobantes c
                where 1=1 "
                .  $forma_pago_sel . $estado_pago_sel. " and  TO_CHAR(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin." '
                and c.anulado='N' and c.estado_sunat<>'TERCERO'
                and tipo in ('FT','BV','ND')
            
                union
                select fecha,c.tipo, c.serie,c.numero, cod_tributario, destinatario,subtotal ,impuesto ,total , case when id_forma_pago=1 then 'CONTADO' else 'CREDITO' end as forma_pago, case when estado_pago='P' then 'PENDIENTE' else 'CANCELADO' end as estado_pago,
                case when c.impuesto >0 then subtotal * case when c.tipo='NC' then -1 else 1 end else 0 end imp_afecto,
                case when c.impuesto =0 then subtotal * case when c.tipo='NC' then -1 else 1 end else 0 end imp_inafecto
                from comprobantes c
                where 1=1 "
                .  $forma_pago_sel . $estado_pago_sel. " and  TO_CHAR(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin." ' 
                and c.anulado='N' --and c.estado_sunat<>'TERCERO'
                and tipo in ('NC') --and c.afecta_caja='C'
                
                order by  fecha";
        
        $data = DB::select($cad);
        
        return $data;
    }

    function getAllCajaComprobanteDet($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }

        $cad = "
            select denominacion, sum(importe) importe
            from(
                select co.denominacion, case when  c.tipo ='NC' and c.afecta_caja='C' then -1* (cd.importe)  when  c.tipo ='NC' and c.afecta_caja='D' then 0 else cd.importe  end importe
                from comprobantes c                                
                    inner join comprobante_detalles cd on cd.id_comprobante = c.id
                    inner join conceptos co  on co.id  = cd.id_concepto    
            where 1=1 
            ".$usuario_sel."
            and to_char(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."' 
            and c.id_forma_pago = '1'
            and c.anulado = 'N'
            ) as reporte
            group by denominacion
       
    
        ";

		//echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }

    function getAllComprobanteConteo($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }

        $cad = "
            select denominacion tipo_documento, count(*) cantidad 
            from (
                    select tm.denominacion, c.serie ||'-'|| c.numero::varchar(20) 
                    from comprobantes c inner join tabla_maestras tm on c.tipo =tm.abreviatura  and tm.tipo='126'
                    where 1=1 
                    ".$usuario_sel."
                    and to_char(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."'   
                    and anulado='N'                  
            ) as reporte_cantidad group by denominacion;    
       
    
        ";

		//echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }

    function getAllComprobanteLista($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }


        $cad = "
                    select tm.denominacion tipo_documento, c.serie ||'-'|| c.numero::varchar(20) numero 
                    from comprobantes c inner join tabla_maestras tm on c.tipo =tm.abreviatura  and tm.tipo='126'
                    where 1=1 
                    ".$usuario_sel."
                    and to_char(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."'
                    and anulado='N'
                    order by tm.denominacion,c.id                     
                    ;    
       
    
        ";

		//echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }

    function getAllComprobantePorSerie($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }


        $cad = "
                    
                select case when tipo='FT' then 'FACTURA'
                            when tipo='BV' then 'BOLETA DE VENTA'
                            when tipo='NC' then 'NOTA DE CREDITO'
                            when tipo='ND' then 'NOTA DE DEBITO' end  tipo,serie, min(numero) inicio ,max(numero) fin 
                from comprobantes c
                where 1=1 
                      ".$usuario_sel."
                      and to_char(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."' and anulado='N'
                 group by tipo,serie
                 ;    
       
    
        ";

		//echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }
    

    function getAllComprobantencnd($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }


        $cad = "
                    select tm.denominacion tipo_documento, c.serie ||'-'|| c.numero::varchar(20) numero, c.destinatario,  0 us , case when afecta_caja ='C' then -1* c.total 
              																											    when afecta_caja ='D' then - c.total
              																											    else c.total end  
                    from comprobantes c inner join tabla_maestras tm on c.tipo =tm.abreviatura  and tm.tipo='126'
                    where 1=1 
                    ".$usuario_sel."
                    and to_char(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."'
                    and (c.tipo ='NC' or c.tipo ='ND') and afecta_caja='C' 
                    and anulado='N'
                    order by tm.denominacion,c.id  ;

        ";

		//echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }

    function getAllComprobantencnd_noafecta($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }


        $cad = "
                  select tm.denominacion tipo_documento, c.serie ||'-'|| c.numero::varchar(20) numero, c.destinatario,  0 us , case when afecta_caja ='C' then -1* c.total 
              																											    when afecta_caja ='D' then - c.total
              																											    else c.total end  
                    from comprobantes c inner join tabla_maestras tm on c.tipo =tm.abreviatura  and tm.tipo='126'
                    where 1=1 
                    ".$usuario_sel."
                    and to_char(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."'
                    and (c.tipo ='NC' or c.tipo ='ND') and afecta_caja='D' 
                    and anulado='N'
                    order by tm.denominacion,c.id  ;  ;

        ";

		//echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }

    function getAllIngressComp($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja= " . $id_caja; 
        }


        $cad = "
                    select cp.fecha, c.tipo || '-' || c.serie || '-' || c.numero || '-' || c.destinatario || '-' || m.denominacion || '- S/ ' || cp.monto  || case when cp.nro_operacion<>'' then   '-Nro Oper. ' ||  cp.nro_operacion else '' end     comprobante ,0 usd, cp.monto importe
                    from comprobantes c 
                        inner join comprobante_cuota_pagos cp on c.id =cp.id_comprobante
                        
                        inner join tabla_maestras m on m.codigo = cp.id_medio::varchar and m.tipo = '19'
                    where 1=1 
                            ".$usuario_sel."
                            and to_char(cp.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."' 
                            and c.id_forma_pago = '2'
                            and cp.monto >0
                            and to_char(c.fecha, 'yyyy-mm-dd')<'".$f_fin."'
                            and c.anulado = 'N'
                    
        ";
        
		//echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }

    
    function getAllMovimientoComprobantes($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }

        $cad = "
                    select  concepto, fecha,	 tipo_documento,  serie,  numero,fecha_ncd,tipo_documento_ncd,  serie_ncd,  numero_ncd, cod_tributario,  destinatario , imp_afecto, imp_inafecto,igv , total
                    from (
                            select  co.denominacion concepto,c.fecha fecha,	 c.tipo tipo_documento, c.serie serie, c.numero::varchar(20)  numero, c2.fecha fecha_ncd,c2.tipo tipo_documento_ncd, c2.serie serie_ncd, c2.numero::varchar(20)  numero_ncd, c.cod_tributario cod_tributario, c.destinatario destinatario ,case when co.id_tipo_afectacion=30 then 0 else sum((cd.pu * cd.cantidad)-cd.descuento) end * case when c.tipo='NC' then -1 else 1 end  imp_afecto,case when co.id_tipo_afectacion=30 then sum((cd.pu_con_igv*cd.cantidad)-cd.descuento) else 0  end * case when c.tipo='NC' then -1 else 1 end imp_inafecto,sum(cd.igv_total) * case when c.tipo='NC' then -1 else 1 end igv  ,sum(cd.importe) * case when c.tipo='NC' then -1 else 1 end total,c.id 
                            																																																																																		 															
                            from comprobantes c 
                               inner join comprobante_detalles cd on cd.id_comprobante =c.id
                                inner join tabla_maestras tm on c.tipo =tm.abreviatura  and tm.tipo='126'
                                inner join conceptos co on co.id=cd.id_concepto
                                left join comprobantes c2 on c.id=c2.id_comprobante_ncnd
                                
                        
                            where 1=1 
                                ".$usuario_sel."
                                and to_char(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."' 
                                and c.anulado='N' and c.estado_sunat<>'TERCERO'
                                and (c.afecta_caja='C' or  c.afecta_caja is null)

                            group by co.denominacion ,c.fecha ,	 c.tipo , c.serie , c.numero,c2.fecha ,c2.tipo , c2.serie ,c2.fecha, c2.numero, c.cod_tributario, c.destinatario  , co.id_tipo_afectacion, c.subtotal,c.id  
                            order by concepto, tipo_documento,c.id  
                    ) as reporte_movimiento group by concepto, fecha,	 tipo_documento,  serie,  numero,fecha_ncd,tipo_documento_ncd,  serie_ncd,  numero_ncd, cod_tributario,  destinatario , imp_afecto, imp_inafecto,igv , total 
    
                    
                ";

		//echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }

    function getAllMovimientoComprobantes_noafecta($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }

        $cad = "
                    select  concepto, fecha,	 tipo_documento,  serie,  numero,fecha_ncd,tipo_documento_ncd,  serie_ncd,  numero_ncd, cod_tributario,  destinatario , imp_afecto, imp_inafecto,igv , total
                    from (
                            select  co.denominacion concepto,c.fecha fecha,	 c.tipo tipo_documento, c.serie serie, c.numero::varchar(20)  numero, c2.fecha fecha_ncd,c2.tipo tipo_documento_ncd, c2.serie serie_ncd, c2.numero::varchar(20)  numero_ncd, c.cod_tributario cod_tributario, c.destinatario destinatario ,case when co.id_tipo_afectacion=30 then 0 else sum((cd.pu * cd.cantidad)-cd.descuento) end * case when c.tipo='NC' then -1 else 1 end  imp_afecto,case when co.id_tipo_afectacion=30 then sum((cd.pu_con_igv*cd.cantidad)-cd.descuento) else 0  end * case when c.tipo='NC' then -1 else 1 end imp_inafecto,sum(cd.igv_total) * case when c.tipo='NC' then -1 else 1 end igv  ,sum(cd.importe) * case when c.tipo='NC' then -1 else 1 end total,c.id 
                            																																																																																		 															
                            from comprobantes c 
                               inner join comprobante_detalles cd on cd.id_comprobante =c.id
                                inner join tabla_maestras tm on c.tipo =tm.abreviatura  and tm.tipo='126'
                                inner join conceptos co on co.id=cd.id_concepto
                                left join comprobantes c2 on c.id=c2.id_comprobante_ncnd
                        
                            where 1=1 
                                ".$usuario_sel."
                                and to_char(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."' 
                                and c.anulado='N' 
                                and c.afecta_caja='D'
                            group by co.denominacion ,c.fecha ,	 c.tipo , c.serie , c.numero,c2.fecha ,c2.tipo , c2.serie ,c2.fecha, c2.numero, c.cod_tributario, c.destinatario  , co.id_tipo_afectacion, c.subtotal,c.id  
                            order by concepto, tipo_documento,c.id  
                    ) as reporte_movimiento group by concepto, fecha,	 tipo_documento,  serie,  numero,fecha_ncd,tipo_documento_ncd,  serie_ncd,  numero_ncd, cod_tributario,  destinatario , imp_afecto, imp_inafecto,igv , total 
    
                    
                ";

		//echo $cad; exit();
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

    function datos_reporte_deudas($id,$id_concepto){

        $concepto="";

        if ($id_concepto!="") $concepto = " and c.id = ".$id_concepto; 

        $cad = "/*select c.id,c.denominacion , ROW_NUMBER() OVER (PARTITION BY c.id order by ac.fecha_venc_pago asc ) AS row_num, descripcion, ac.importe, to_char(ac.fecha_venc_pago, 'dd-mm-yyyy' )  fecha_vencimiento
        from agremiado_cuotas ac
        inner join valorizaciones v on ac.id =v.pk_registro and v.pagado ='0'
        inner join conceptos c on ac.id_concepto =c.id
        where id_agremiado =".$id."
        and id_situacion in (59) 
        and (v.codigo_fraccionamiento is null or v.codigo_fraccionamiento =0)
        and v.fecha < now()
        and v.estado ='1'
        ".$concepto."
        union all */
        select v2.id, c.denominacion, ROW_NUMBER() OVER (PARTITION BY v2.id_concepto order by v2.fecha asc ) AS row_num, v2.descripcion, v2.monto importe,to_char(v2.fecha, 'dd-mm-yyyy' ) fecha_vencimiento
        from valorizaciones v2 
        inner join conceptos c on v2.id_concepto =c.id
        where v2.id_agremido = ".$id."
        and v2.pagado = '0'
        /*and v2.id_modulo = 6*/
        and v2.fecha < now()
        and v2.estado ='1'
        and v2.exonerado !='1' 
        ".$concepto." 
        order by v2.fecha asc";

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getDenominacionDeuda($id,$id_concepto){

        $concepto="";

        if ($id_concepto!="") $concepto = " and c.id = ".$id_concepto; 

        $cad = "/*select distinct c.denominacion 
        from agremiado_cuotas ac
        inner join valorizaciones v ON ac.id = v.pk_registro
        inner join conceptos c ON ac.id_concepto = c.id
        where id_agremiado = ".$id."
        and id_situacion in (59)
        and v.codigo_fraccionamiento is null 
        and v.fecha < now()
        ".$concepto." 
        union all */
        select distinct c.denominacion
        from valorizaciones v2 
        inner join conceptos c on v2.id_concepto =c.id
        where v2.id_agremido = ".$id."
        and v2.pagado = '0'
        /*and v2.id_modulo = 6*/
        and v2.fecha < now()
        and v2.estado ='1'
        ".$concepto." 
        order by denominacion asc";

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getReporteDeudasTotal($id, $id_concepto){

        $concepto="";

        if ($id_concepto!="") $concepto = " and c.id = ".$id_concepto; 

        $cad = "select  c.id,c.denominacion , ROW_NUMBER() OVER (PARTITION BY c.id order by ac.fecha_venc_pago asc ) AS row_num, v.descripcion, ac.importe , to_char(ac.fecha_venc_pago, 'dd-mm-yyyy' ) fecha_vencimiento, cp.fecha fecha_pago, C2.tipo|| C2.serie || C2.numero comprobante , 
        tm2.denominacion forma_pago, tm3.denominacion condicion,cp.nro_operacion nro_operacion ,  case when  v.pagado='1' then 'PAGADO' else 'PENDIENTE' end  estado_pago
        from agremiado_cuotas ac 
        inner join valorizaciones v on ac.id =v.pk_registro
        inner join conceptos c on ac.id_concepto =c.id
        inner join tabla_maestras tm on tm.codigo =id_situacion::varchar(10) and tm.tipo='11' 
        left join comprobantes c2 on c2.id=v.id_comprobante
        left join tabla_maestras tm2 on tm2.codigo = c2.id_forma_pago::varchar(10) and tm2.tipo='104' 
        left join comprobante_pagos cp on c2.id =cp.id_comprobante 
        left join  tabla_maestras tm3 on tm3.codigo = cp.id_medio ::varchar(10) and tm3.tipo='19' 
        where  id_agremiado = ".$id." 
        and v.pagado ='1'
        ".$concepto."
        union all
        select v2.id, c.denominacion, ROW_NUMBER() OVER (PARTITION BY v2.id order by v2.fecha asc ) AS row_num, v2.descripcion, v2.monto, to_char(v2.fecha, 'dd-mm-yyyy' ) fecha_vencimiento, cp.fecha fecha_pago, C2.tipo|| C2.serie || C2.numero comprobante ,
        tm2.denominacion forma_pago, tm3.denominacion condicion,cp.nro_operacion nro_operacion ,  case when  v2.pagado='1' then 'PAGADO' else 'PENDIENTE' end  estado_pago
        from valorizaciones v2 
        inner join conceptos c on v2.id_concepto =c.id
        left join comprobantes c2 on c2.id=v2.id_comprobante
        left join comprobante_pagos cp on c2.id =cp.id_comprobante 
        left join tabla_maestras tm2 on tm2.codigo = c2.id_forma_pago::varchar(10) and tm2.tipo='104' 
        left join  tabla_maestras tm3 on tm3.codigo = cp.id_medio ::varchar(10) and tm3.tipo='19' 
        where v2.id_agremido = ".$id." 
        ".$concepto."
        and v2.id_modulo = 6
        and v2.pagado ='1'";

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getDenominacionDeudaTotal($id, $id_concepto){

        $concepto="";

        if ($id_concepto!="") $concepto = " and c.id = ".$id_concepto; 

        $cad = "select  distinct(c.denominacion)
        from agremiado_cuotas ac 
        inner join valorizaciones v on ac.id =v.pk_registro
        inner join conceptos c on ac.id_concepto =c.id
        inner join tabla_maestras tm on tm.codigo =id_situacion::varchar(10) and tipo='11' 
        where  id_agremiado = ".$id."
        and v.pagado = '1'
        ".$concepto." 
        union all
        select c.denominacion
        from valorizaciones v2 
        inner join conceptos c on v2.id_concepto =c.id
        where v2.id_agremido = ".$id." 
        and v2.pagado = '1'
        and v2.id_modulo = 6
        and v2.fecha < now()
        ".$concepto." 
        order by denominacion asc";

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getDeudaCuotaFraccionamiento($id){

        $cad = "select c.codigo, c.denominacion, v.descripcion, v.monto, v.fecha, v.codigo_fraccionamiento 
        from valorizaciones v 
        inner join fraccionamientos f on f.id= v.codigo_fraccionamiento 
        inner join conceptos c on c.id = v.id_concepto
        where 1=1
        and v.id_modulo in ('2','6')
        and v.id_persona = '".$id."'
        and v.estado <> '1'
        and v.codigo_fraccionamiento is not null
        order by c.codigo, v.fecha";

		//echo $cad; exit();
		$data = DB::select($cad);
        return $data;
    }

    function getCronogramaFraccionamiento($id){

        $cad = "select c.codigo, c.denominacion, v.descripcion, v.monto, v.fecha, v.codigo_fraccionamiento 
                from valorizaciones v 
                inner join fraccionamientos f on f.id= v.codigo_fraccionamiento 
                inner join conceptos c on c.id = v.id_concepto
                where 1=1
                and v.id_modulo = 6
                and v.id_persona = ".$id." 
                and v.codigo_fraccionamiento is not null
                and v.estado ='1'
                order by c.codigo, v.fecha ";

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getAllCajaComprobanteDet2($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja; 
        }

        $cad = "
             select   upper( denominacion) denominacion, sum(importe) importe, sum(pu) pu, sum(igv_total) igv_total
            from(
           select  cc.denominacion   || case when (cc.id=19 or cc.id=23 or cc.id=6   or cc.id=46 or cc.id=43 or cc.id=440 or cc.id=430) then ' ' else  ' - '|| trim(REGEXP_REPLACE(co.denominacion,'- DELEGADOS|- ARQUITECTOS HABILITADOS|- ESTUDIANTES Y BACHILLERES|- PUBLICO EN GENERAL','','g')) end  denominacion, 
            case when  c.tipo ='NC' and c.afecta_caja='C' then -1* (cd.importe)  when  c.tipo ='NC' and c.afecta_caja='D' then 0 else cd.importe  end importe,
            case when  c.tipo ='NC' and c.afecta_caja='C' then -1* (cd.valor_venta_bruto-cd.descuento)  when  c.tipo ='NC' and c.afecta_caja='D' then 0 else case when cd.id_concepto=26464 then cd.pu else  cd.valor_venta_bruto-cd.descuento end  end pu,
            case when  c.tipo ='NC' and c.afecta_caja='C' then -1* (cd.igv_total)  when  c.tipo ='NC' and c.afecta_caja='D' then 0 else cd.igv_total  end igv_total
            from comprobantes c                                
	            inner join comprobante_detalles cd on cd.id_comprobante = c.id
	            inner join conceptos co  on co.id  = cd.id_concepto
	            inner join tipo_conceptos tc on co.id_tipo_concepto=tc.id
	            inner join centro_costos cc on cc.id=co.centro_costo
	            inner join partida_presupuestales pp on pp.id=co.partida_presupuestal  
            where 1=1 
            ".$usuario_sel."
            and to_char(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."' 
            and c.tipo in ('FT', 'BV')
            and c.anulado = 'N'
            ) as reporte
            group by denominacion ";
            

		//echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }

    function getAllComprobantencnd2($id_usuario, $id_caja, $f_inicio, $f_fin, $tipo){

        $usuario_sel = "";
        if ($tipo=="S") {
            
            $usuario_sel = " and c.id_usuario_inserta = ".$id_usuario . " and c.id_caja=" . $id_caja;
        }

        $cad = "select tm.denominacion tipo_documento, c.serie ||'-'|| c.numero::varchar(20) numero, c.destinatario,  0 us , 
                case when afecta_caja ='C' then -1* c.total when afecta_caja ='D' then - c.total else c.total end total,
                case when afecta_caja ='C' then -1* c.subtotal when afecta_caja ='D' then - c.subtotal else c.subtotal end subtotal,
                case when afecta_caja ='C' then -1* c.impuesto when afecta_caja ='D' then - c.impuesto else c.impuesto end impuesto
                from comprobantes c inner join tabla_maestras tm on c.tipo =tm.abreviatura  and tm.tipo='126'
                where 1=1 
                ".$usuario_sel."
                and to_char(c.fecha, 'yyyy-mm-dd') BETWEEN '".$f_inicio."' AND '".$f_fin."'
                and (c.tipo ='NC' or c.tipo ='ND') and afecta_caja='C' 
                and anulado='N'
                order by tm.denominacion,c.id; ";

		//echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }
}
