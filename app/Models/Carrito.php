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

        $cad = "select ci.id,ci.nombre,ci.fecha_vencimiento,ci.precio_unitario,ci.cantidad,ci.total,c.total_general
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
