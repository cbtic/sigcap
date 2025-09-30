<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Carrito extends Model
{
    use HasFactory;

    protected $fillable = ["usuario_id","token_invitado","subtotal","descuento_total","impuesto_total","envio_total","total_general"];
    public function items() { return $this->hasMany(CarritoItem::class); }

    function getCarritoDetalle($id_carrito)
    {

        $cad = "select ci.id,ci.nombre,ci.fecha_vencimiento,ci.precio_unitario,ci.cantidad,ci.total,c.subtotal,c.impuesto_total,c.total_general,ci.impuesto,ci.valor_venta  
from carritos c 
inner join carrito_items ci on c.id=ci.carrito_id 
where c.id=".$id_carrito;

        $data = DB::select($cad);
        return $data;
    }

    function getCarritoDeuda($tipo_documento,$id_persona,$periodo,$mes,$cuota,$concepto, $filas,$exonerado,$numero_documento_b){  
        
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
                left join carrito_items ci on v.id=ci.valorizacion_id 
                /*left join pedido_items pi on v.id=pi.valorizacion_id
                left join pedidos p on pi.pedido_id=p.id AND p.response::json->'dataMap'->>'STATUS' = 'Authorized' */
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
                and ci.id is null
                /*and pi.id is null*/
                and (select count(*) from pedidos p inner join pedido_items pi on p.id=pi.pedido_id where p.response::json->'dataMap'->>'STATUS' = 'Authorized' and pi.valorizacion_id=v.id)=0
            order by v.fecha asc
             ".$filas."
			";
        }


       // echo $cad;

		$data = DB::select($cad);
        return $data;
    }
    
    function getAgremiado($tipo_documento,$id_persona){
		//echo $tipo_documento; exit();
        if($tipo_documento=="79"){  //RUC
            $cad = "select t1.id,razon_social,t1.direccion,t1.representante, t1.ruc, t1.email, 79 id_tipo_documento,  trim(t1.ruc) numero_documento_
                    from empresas t1                    
                    Where trim(t1.ruc)='".$id_persona."' and t1.estado ='1' ";

        }elseif($tipo_documento=="85"){ //NRO_CAP
			
			$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,
			t1.numero_ruc,t2.fecha_colegiado,t3.denominacion situacion, t1.apellido_paterno|| ' ' ||t1.apellido_materno || ', ' || t1.nombres as nombre_completo,85 id_tipo_documento,email1 email, 
			t4.denominacion actividad, t2.numero_regional, r.denominacion regional, t5.denominacion autoriza_tramite, t6.denominacion ubicacion, t7.denominacion categoria, t2.celular1, trim(t2.numero_cap) numero_documento_, t2.celular1 celular, t2.firma 
			from personas t1 
			inner join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
			left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'
			left join tabla_maestras t4 on t2.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'
			inner join regiones r on t2.id_regional = r.id
			left join tabla_maestras t5 on t2.id_autoriza_tramite = t5.codigo::int And t5.tipo ='45'	
			left join tabla_maestras t6 on t2.id_ubicacion = t6.codigo::int And t6.tipo ='63'
			left join tabla_maestras t7 on t2.id_categoria = t7.codigo::int And t7.tipo ='18'
			where t1.id=".$id_persona."
			and t1.estado='1' 
			limit 1";
								
        }else{
			$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,
					t1.numero_ruc,t1.id_tipo_documento,t3.denominacion situacion, t4.denominacion actividad,t1.correo email, trim(t1.numero_documento)  numero_documento_ 			
					from personas t1 
					left join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
					left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'
					left join tabla_maestras t4 on t2.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'                    
					Where  t1.id_tipo_documento='".$tipo_documento."' 
                    and t1.id=".$id_persona."
					and t1.estado='1' 
					limit 1";
		}
		//echo $cad; exit();
		$data = DB::select($cad);
		
        return $data[0];
    }

    function getCarritoDeudaById($id){  
        
        $cad = "select v.id, v.fecha, c.denominacion  concepto, v.monto,t.denominacion moneda, v.id_moneda, v.fecha_proceso, 
            (case when descripcion is null then c.denominacion else v.descripcion end) descripcion, t.abreviatura,
            (case when v.fecha < now() then '1' else '0' end) vencio, v.id_concepto, c.id_tipo_afectacion,
            coalesce(v.cantidad, '1') cantidad, coalesce(v.valor_unitario, v.monto) valor_unitario, otro_concepto,
            codigo_fraccionamiento, v.exonerado,v.exonerado_motivo, c.codigo cod_concepto, coalesce(v.descuento_porcentaje, '0') descuento_porcentaje, c.obligatorio_ultimo_pago
        from valorizaciones v
            inner join conceptos c  on c.id = v.id_concepto            
            inner join tabla_maestras t  on t.codigo::int = v.id_moneda and t.tipo = '1'
            where v.id = ".$id;
       // echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    public function genera_prontopago($p){
		return $this->readFunctionPostgres('sp_genera_prontopago',$p);
    }

    public function readFunctionPostgresTransaction($function, $parameters = null){
	
      $_parameters = '';
      if (count($parameters) > 0) {
	  		
			foreach($parameters as $par){
				if(is_string($par))$_parameters .= "'" . $par . "',";
				else $_parameters .= "" . $par . ",";
		  	}
			if(strlen($_parameters)>1)$_parameters= substr($_parameters,0,-1);
			
      }

	  $cad = "select " . $function . "(" . $_parameters . ");";
	  $data = DB::select($cad);
	  return $data[0]->$function;
   }

   public function readFunctionPostgres($function, $parameters = null){

      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  $data = DB::select("BEGIN;");
	  $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
	  //echo $cad;
	  $data = DB::select($cad);
	  $cad = "FETCH ALL IN ref_cursor;";
	  $data = DB::select($cad);
      return $data;
   }

}
