<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Comprobante extends Model
{
    public function listar_comprobante($p){
		return $this->readFuntionPostgres('sp_listar_comprobante_paginado',$p);
    }
 

    function fecha_hora_actual(){
		
		$cad = "select now() as fecha_actual";

		$data = DB::select($cad);
        return $data[0]->fecha_actual;
		
	}

	public function registrar_factura_moneda($serie, $numero, $tipo, $ubicacion, $persona, $total, $descripcion, $cod_contable, $id_v, $id_caja, $descuento, $accion,    $id_user,   $id_moneda) {
                                          //( serie,  numero,  tipo,  ubicacion,  persona,  total,  descripcion,  cod_contable,  id_v,  id_caja,  descuento,  accion, p_id_usuario, p_id_moneda)
             //print_r($serie .",". $numero.",".$tipo.",".$ubicacion.",".$persona.",".$total.",".$descripcion.",".$cod_contable.",".$id_v.",". $id_caja.",".$descuento.",".$accion.",".$id_user.",".$id_moneda);exit();
        $cad = "Select sp_crud_factura_moneda(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        //echo "Select sp_crud_factura(".$serie.",".$numero.", ".$tipo.", ".$ubicacion.",".$persona.",".$total.",".$descripcion.",".$cod_contable.",".$codigo_v.",".$estab_v.",".$modulo.",".$smodulo.",".$descuento.",".$accion.",".$id_user.")";

		$data = DB::select($cad, array($serie, $numero, $tipo, $ubicacion, $persona, $total, $descripcion, $cod_contable, $id_v, $id_caja, $descuento, $accion,     $id_user,  $id_moneda));
                                    //( serie,  numero,  tipo,  ubicacion,  persona,  total,  descripcion,  cod_contable,  id_v,  id_caja,  descuento,  accion, p_id_usuario, p_id_moneda)
       // print_r($data); exit();
        return $data[0]->sp_crud_factura_moneda;
    }                   

    public function registrar_comprobante($serie, $numero, $tipo, $cod_tributario, $total, $descripcion, $cod_contable, $id_v, $id_caja, $descuento, $accion,    $id_user,   $id_moneda) {
        //( serie,  numero,  tipo,  ubicacion,  persona,  total,  descripcion,  cod_contable,  id_v,  id_caja,  descuento,  accion, p_id_usuario, p_id_moneda)
       // print_r($serie ." numero". $numero." tipo". $tipo." ubicacion". $cod_tributario."persona ". $cod_tributario." total". $total."descripcion ". $descripcion." ". $cod_contable." ". $id_v." ". $id_caja." ". $descuento." ". $accion." ".    $id_user." ".   $id_moneda);exit();
        $cad = "Select sp_crud_comprobante(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        //echo "Select sp_crud_factura(".$serie.",".$numero.", ".$tipo.", ".$ubicacion.",".$persona.",".$total.",".$descripcion.",".$cod_contable.",".$codigo_v.",".$estab_v.",".$modulo.",".$smodulo.",".$descuento.",".$accion.",".$id_user.")";
        
        $data = DB::select($cad, array($serie, $numero, $tipo, $cod_tributario, $total, $descripcion, $cod_contable, $id_v, $id_caja, $descuento, $accion,     $id_user,  $id_moneda));
        //( serie,  numero,  tipo,  ubicacion,  persona,  total,  descripcion,  cod_contable,  id_v,  id_caja,  descuento,  accion, p_id_usuario, p_id_moneda)
        //print_r($data );exit();
       
        return $data[0]->sp_crud_comprobante;
       
    }

    public function registrar_comprobante_ncnd($serie, $numero, $tipo, $cod_tributario, $total, $descripcion, $cod_contable, $id_v, $id_caja, $descuento, $accion,    $id_user,   $id_moneda,$razon_social,$direccion,$id_comprobante_origen,$correo,$id_afecta,$tiponota,  $motivo,$afecta_ingreso) {
        //( serie,  numero,  tipo,  ubicacion,  persona,  total,  descripcion,  cod_contable,  id_v,  id_caja,  descuento,  accion, p_id_usuario, p_id_moneda)
       //print_r($serie ." numero". $numero." tipo". $tipo." ubicacion". $cod_tributario."persona ". $cod_tributario.
         //           " total". $total."descripcion ". $descripcion." ". $cod_contable." ". $id_v." ". $id_caja." ". $descuento.
          //      " ". $accion." ".    $id_user." ".   $id_moneda . " ". $razon_social. " ". $direccion." ". $id_comprobante_origen ." ". $id_afecta ." ". $afecta_ingreso );exit();
        
       $cad = "Select sp_crud_comprobante_ncnd(?,?,?,?,?,
                                                ?,?,?,?,?,
                                                ?,?,?,?,?,
                                                ?,?,?,?,?,?)";
        //echo "Select sp_crud_factura(".$serie.",".$numero.", ".$tipo.", ".$ubicacion.",".$persona.",".$total.",".$descripcion.",".$cod_contable.",".$codigo_v.",".$estab_v.",".$modulo.",".$smodulo.",".$descuento.",".$accion.",".$id_user.")";
       
        $data = DB::select($cad, array($serie, $numero, $tipo, $cod_tributario, $total, 
                                       $descripcion, $cod_contable, $id_comprobante_origen, $id_caja, $descuento, 
                                       $accion,     $id_user,  $id_moneda, $razon_social, $direccion,
                                       $id_comprobante_origen,$correo,$id_afecta,$tiponota,  $motivo,$afecta_ingreso));
        //( serie,  numero,  tipo,  ubicacion,  persona,  total,  descripcion,  cod_contable,  id_v,  id_caja,  descuento,  accion, p_id_usuario, p_id_moneda)
        //print_r($data );exit();
       
        return $data[0]->sp_crud_comprobante_ncnd;
       
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
    use HasFactory;
	
     
    function getCronogramaPagos($id){

        $cad = "select item ,monto,fecha_vencimiento  
                from comprobante_cuotas cc 
                where cc.id_comprobante='". $id . "'
                order by cc.item" ;

                //print_r($cad); exit();
		$data = DB::select($cad);
        //print_r($data); exit();
        return $data;
    }

    function listar_credito_pago($id){

        $cad = "select  c.id, c.id_comprobante, c.item, c.fecha, c.id_medio, c.nro_operacion, c.descripcion, c.monto, c.fecha_vencimiento fecha, c.estado, cp.denominacion
                from comprobante_cuota_pagos c
                inner join tabla_maestras cp on cp.tipo = '19' and cp.codigo::int = c.id_medio 
                where c.id_comprobante='". $id . "'
                order by c.id" ;

                //print_r($cad); exit();
		$data = DB::select($cad);
        //print_r($data); exit();
        return $data;
    }

    public function listar_credito_pago_paginado($p){

        return $this->readFuntionPostgres('sp_listar_comprobante_cuota_pago_paginado',$p);

    }
  
    function getCuotaPagoById($id){

        $cad = "select *
                from comprobante_cuota_pagos
                where id=".$id." 
				";
    
		$data = DB::select($cad);
        return $data[0];
    }

   

    function getDatosByComprobante($id){

        $cad = "select distinct u.name as usuario,a.numero_cap,v.id_persona  
        from comprobantes c
        inner join valorizaciones v on v.id_comprobante = c.id
        left join agremiados a on a.id = v.id_agremido
        inner join users u on c.id_usuario_inserta =u.id 
                where c.id='". $id . "'" ;

		$data = DB::select($cad);

        if ( empty($data)){
            $cad = "select distinct u.name as usuario,a.numero_cap,a.id_persona  
                    from comprobantes c
                    inner join personas p on c.cod_tributario =p.numero_documento 
                    inner join agremiados a on a.id_persona = p.id  
                    inner join users u on c.id_usuario_inserta =u.id 
                    where c.id='". $id . "'" ;

            $data = DB::select($cad);
            
        }

        if ( empty($data)){
            $cad = "select distinct u.name as usuario,a.numero_cap,a.id_persona  
                    from comprobantes c
                    left join personas p on c.cod_tributario =p.numero_ruc 
                    left join agremiados a on a.id_persona = p.id  
                    inner join users u on c.id_usuario_inserta =u.id 
                    where c.id='". $id . "'" ;

            $data = DB::select($cad);
            
        }
       

        if(isset($data[0]))return $data[0];
    }

	function getComprobanteByTipoSerieNumero($numero_comprobante){

        $cad = "select * 
				from comprobantes c 
				where tipo||serie||'-'||numero='".$numero_comprobante."'";
    
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }

    function getComprobanteById($numero_comprobante){

        $cad = "select * 
				from comprobantes c 
				where c.id='".$numero_comprobante."'";
    
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }

    function getPersonaDni($numero_documento){

        $cad = "select p.id, p.numero_documento, p.apellido_paterno, p.apellido_materno, p.nombres,direccion ,correo
		        from personas p
		        Where p.numero_documento='".$numero_documento."'";
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }

    function getPersonaRuc($numero_documento){

        $cad = "select p.id, p.numero_documento, p.apellido_paterno, p.apellido_materno, p.nombres, direccion,correo email
		from personas p
		Where p.numero_ruc='".$numero_documento."' or  p.numero_documento='".$numero_documento."'";
		//echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
    

    function getEmpresaRuc($numero_documento){

        $cad = "select id, direccion,email
		        from empresas
		        Where ruc='".$numero_documento."'";
		//echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }

    function getExisteNotaById($numero_comprobante){

        $cad = "select id,serie,numero,tipo 
				from comprobantes c 
				where c.id='".$numero_comprobante."' limit 1";
    
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0];
    }
	
    function get_envio_pendiente_factura_sunat($fecha){
		
        $cad = "select id, anulado 
                from comprobantes
                where to_char(fecha,'yyyy-mm-dd')='".$fecha."'
                and coalesce(estado_sunat,'')=''
                and tipo<>'TK' 
                order by id";
		
		$data = DB::select($cad);
        return $data;
    }
    
    function getFacturaByCaja($id_caja,$fecha_inicio,$fecha_fin){
/*
        $cad = "select f.id, f.fac_serie, f.fac_numero, f.fac_tipo, f.fac_fecha, f.fac_cod_tributario, f.fac_destinatario, f.fac_subtotal, f.fac_impuesto, f.fac_total, f.fac_estado_pago, f.fac_anulado, m.denominacion caja,
        (select string_agg(DISTINCT t2_.plan_denominacion, ',') from afiliaciones t1_ inner join plan_atenciones t2_ on t1_.plan_id=t2_.id left join personas t3_ on t3_.id=t1_.persona_id
        where t3_.numero_documento=f.fac_cod_tributario And t1_.estado='1' And t2_.plan_estado='A')plan_denominacion, 
        replace(replace(u.email, '@felmo.pe', ''), '@felmo.com', '') usuario
        ,val.val_pac_nombre,per.tipo_documento,per.numero_documento,emp.ruc,emp.nombre_comercial,val.val_aten_estab,val.val_aten_codigo,alb.placa
        FROM facturas f
        Inner Join tabla_maestras m On m.id = f.fac_caja_id
        Inner Join users u On u.id = f.id_usuario 
        left join(
        select vsm_fac_tipo,vsm_fac_serie,vsm_fac_numero,max(vsm_vestab)vsm_vestab,max(vsm_vnumero)vsm_vnumero
        from val_atencion_smodulos
        group by vsm_fac_tipo,vsm_fac_serie,vsm_fac_numero
        ) vas on vas.vsm_fac_tipo=f.fac_tipo and vas.vsm_fac_serie=f.fac_serie And vas.vsm_fac_numero=f.fac_numero
        left join valorizaciones val on val.val_estab = vas.vsm_vestab And val.val_codigo = vas.vsm_vnumero
        left join personas per on val.val_persona=per.id
        left join ubicacion_trabajos ut on val.val_ubicacion=ut.id
        left join empresas emp on emp.id=ut.ubicacion_empresa_id
        left join alquiler_balanzas alb on val.val_estab = alb.aten_establecimiento And val.val_aten_codigo = alb.aten_numero
        where f.fac_caja_id=".$id_caja." 
        And f.fac_fecha >= '".$fecha_inicio."' 
        And f.fac_fecha <= '".$fecha_fin."'
        Order By f.fac_fecha Desc";
*/
        $cad ="select distinct f.id, f.serie, f.numero, f.tipo, f.fecha, f.cod_tributario, f.destinatario, f.subtotal, f.impuesto, f.total, f.estado_pago, f.anulado, m.denominacion caja,
        'plan A'plan_denominacion, 
        replace(replace(u.email, '@felmo.pe', ''), '@felmo.com', '') usuario
        ,f.destinatario pac_nombre, per.id_tipo_documento tipo_documento,per.numero_documento,emp.ruc,emp.nombre_comercial, 1 val_aten_estab, 1 val_aten_codigo, '' placa,
        f.id_forma_pago,  fp.denominacion forma_pago, (case when f.estado_pago='P' then 'PENDIENTE' else 'CANCELADO'end) estado_pago, 
        (select string_agg(DISTINCT coalesce(tm.denominacion||'->'||cp.monto), ', ')  
		from comprobante_pagos cp 
		inner join tabla_maestras tm on tm.codigo = cp.id_medio::varchar and tm.tipo = '19'
		--group by cp.id
		--having cp.id_comprobante = f.id
        where cp.id_comprobante = f.id
        --order by cp.id
) medio_pago
 FROM comprobantes f
        inner join tabla_maestras m on m.codigo = f.id_caja::varchar and m.tipo = '91'
        inner join tabla_maestras fp on fp.codigo = f.id_forma_pago::varchar and fp.tipo = '104'
        Inner Join users u On u.id = f.id_usuario_inserta        
        left join valorizaciones val on val.id_comprobante = f.id 
        left join personas per on val.id_persona = per.id
        left join empresas emp on emp.id=val.id_empresa 
        where f.id_caja=".$id_caja."  
        And f.fecha >= '".$fecha_inicio."' 
        And f.fecha <= '".$fecha_fin."' 
        Order By f.fecha Desc";


        //echo( $cad); exit;

		$data = DB::select($cad);
        return $data;
    }

    function getFacturaByCajaFiltro($id_caja,$fecha_inicio,$fecha_fin, $forma_pago, $estado_pago, $medio_pago, $total){
        
        $forma_pago_="";

        $estado_pago_="";

        $medio_pago_="";

        $total_="";

        if ($forma_pago!="") $forma_pago_ = " and f.id_forma_pago = ".$forma_pago." "; 

        if ($estado_pago!="") $estado_pago_ = " and f.estado_pago = '".$estado_pago."' ";
        
        if ($total!="") $total_ = " and f.total = '".$total."' ";

        if ($medio_pago!="") $medio_pago_ = " and EXISTS (
        SELECT 1
        FROM comprobante_pagos cp
        WHERE cp.id_comprobante = f.id
        AND cp.id_medio = ".$medio_pago."
        ) "; 

        $cad ="select distinct f.id, f.serie, f.numero, f.tipo, f.fecha, f.cod_tributario, f.destinatario, f.subtotal, f.impuesto, f.total, f.estado_pago, f.anulado, m.denominacion caja,
        'plan A'plan_denominacion, 
        replace(replace(u.email, '@felmo.pe', ''), '@felmo.com', '') usuario
        ,f.destinatario pac_nombre, per.id_tipo_documento tipo_documento,per.numero_documento,emp.ruc,emp.nombre_comercial, 1 val_aten_estab, 1 val_aten_codigo, '' placa,
        f.id_forma_pago,  fp.denominacion forma_pago, (case when f.estado_pago='P' then 'PENDIENTE' else 'CANCELADO'end) estado_pago, 
        (select string_agg(DISTINCT coalesce(tm.denominacion||'->'||cp.monto), ', ')  
        from comprobante_pagos cp 
        inner join tabla_maestras tm on tm.codigo = cp.id_medio::varchar and tm.tipo = '19'
        where cp.id_comprobante = f.id
        ) medio_pago
        FROM comprobantes f
        inner join tabla_maestras m on m.codigo = f.id_caja::varchar and m.tipo = '91'
        inner join tabla_maestras fp on fp.codigo = f.id_forma_pago::varchar and fp.tipo = '104'
        Inner Join users u On u.id = f.id_usuario_inserta        
        left join valorizaciones val on val.id_comprobante = f.id 
        left join personas per on val.id_persona = per.id
        left join empresas emp on emp.id=val.id_empresa 
        where f.id_caja= ".$id_caja."
        And f.fecha >= '".$fecha_inicio."'
        And f.fecha <= '".$fecha_fin."'
        --and f.id_forma_pago = ".$forma_pago."
        --and f.estado_pago = '".$estado_pago."'
        --AND EXISTS (
        --SELECT 1
        --FROM comprobante_pagos cp
        --WHERE cp.id_comprobante = f.id
        --AND cp.id_medio = ".$medio_pago."
        --)
        ".$forma_pago_."
        ".$estado_pago_."
        ".$medio_pago_."
        ".$total_."
        Order By f.fecha Desc";

        //echo $cad; exit();
        
        $data = DB::select($cad);
        return $data;        
    }

	public function lista_deuda_pendiente($p){
		return $this->readFunctionPostgres('sp_lista_deuda_pendiente',$p);
    }
	
	public function actualiza_pago_pos($p){
		return $this->readFunctionPostgres('sp_actualiza_pago_pos',$p);
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
