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

    function getCajaIngresoById($id){
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
                t.denominacion tipo, c.tipo tipo_, sum(c.total) total 
                from comprobantes c 
                inner join tabla_maestras t on t.abreviatura = c.tipo and t.tipo = '126' 
                inner join tabla_maestras m on m.codigo = c.id_caja::varchar and m.tipo = '91' 
                group by c.estado_pago, t.denominacion, c.id_usuario_inserta, c.fecha, c.tipo, c.id_forma_pago 
                having c.id_usuario_inserta = ".$id_usuario."
                and TO_CHAR(c.fecha, 'dd-mm-yyyy') = '".$fecha."' 
                and c.id_forma_pago = 1
                ) 
                group by situacion, tipo_,tipo";

		//echo $cad;
        $data = DB::select($cad);
        return $data;
    }
    
    function getCajaCondicionPago($id_usuario, $fecha){

        $cad = "           
        select condicion, tipo, sum(total_us) total_us,sum(total_tc) total_tc,sum(total_soles) total_soles
         from(
             select t.denominacion condicion, c.tipo, 0 total_us, 0/3.7 total_tc, cp.monto total_soles
             from comprobantes c                                
                 inner join comprobante_pagos cp on cp.id_comprobante = c.id
                 inner join tabla_maestras t on t.codigo  = cp.id_medio::varchar and t.tipo = '19'
             --group by t.denominacion,cp.monto, c.id_usuario_inserta, c.fecha
             where  c.id_usuario_inserta = ".$id_usuario."
             and TO_CHAR(c.fecha, 'dd-mm-yyyy')  = '".$fecha."'
             and c.id_forma_pago = 1
         )
       group by condicion, tipo
        ";

		//echo $cad;
        $data = DB::select($cad);
        return $data;
    }


    function getAllCajaComprobante($id_usuario, $id_caja, $f_inicio, $f_fin){

        $cad = "
        		select situacion, tipo, tipo_, sum(total)total, count(*) cantidad 
                from( 
                    select (case when c.estado_pago='P' then 'PENDIENTE' else 'CANCELADO'end) situacion, 
                    t.denominacion tipo, c.tipo tipo_, sum(c.total) total 
                    from comprobantes c 
                        inner join tabla_maestras t on t.abreviatura = c.tipo and t.tipo = '126' 
                        inner join tabla_maestras m on m.codigo = c.id_caja::varchar and m.tipo = '91' 
                    group by c.estado_pago, t.denominacion, c.id_usuario_inserta, c.fecha, c.tipo, c.id_forma_pago, c.anulado 
                    having c.id_usuario_inserta = ".$id_usuario."
                    and c.id_caja = ".$id_caja."                       
                    and TO_CHAR(c.fecha, 'dd-mm-yyyy') BETWEEN '".$f_inicio."' AND '".$f_fin."' 
                    and c.id_forma_pago = 1
                    and c.anulado = 'N'
                ) 
                group by situacion, tipo_,tipo";

        echo $cad; exit();
        $data = DB::select($cad);
        return $data;
    }
    
    function getAllCajaCondicionPago($id_usuario, $f_inicio, $f_fin){

        $cad = "
            select condicion, sum(total_us) total_us,sum(total_tc) total_tc,sum(total_soles) total_soles
            from(
                select t.denominacion||' '||m.denominacion condicion, 0 total_us, 0/3.7 total_tc, cp.monto total_soles
                from comprobantes c                                
                    inner join comprobante_pagos cp on cp.id_comprobante = c.id
                    inner join tabla_maestras t on t.codigo  = cp.id_medio::varchar and t.tipo = '19'
                    inner join tabla_maestras m on m.codigo  = c.id_moneda::varchar and m.tipo = '1'
                where  c.id_usuario_inserta = ".$id_usuario."
                and TO_CHAR(c.fecha, 'dd-mm-yyyy') BETWEEN '".$f_inicio."' AND '".$f_fin."' 
                and c.id_forma_pago = '1'
                and c.anulado = 'N'
            )
            group by condicion";

		//echo $cad;
        $data = DB::select($cad);
        return $data;
    }

    function getAllCajaComprobanteDet($id_usuario, $f_inicio, $f_fin){

        $cad = "
            select denominacion, sum(importe) importe
            from(
                select co.denominacion, cd.importe
                from comprobantes c                                
                    inner join comprobante_detalles cd on cd.id_comprobante = c.id
                    inner join conceptos co  on co.id  = cd.id_concepto    
            where  c.id_usuario_inserta = ".$id_usuario."
            and to_char(c.fecha, 'YYYY-MM-DD') BETWEEN '".$f_inicio."' AND '".$f_fin."' 
            and c.id_forma_pago = '1'
            and c.anulado = 'N'
            )
            group by denominacion
       
    
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
}
