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
        //print_r($data); exit();
        return $data[0]->sp_crud_factura_moneda;
    }                   

    public function registrar_comprobante($serie, $numero, $tipo, $cod_tributario, $total, $descripcion, $cod_contable, $id_v, $id_caja, $descuento, $accion,    $id_user,   $id_moneda) {
        //( serie,  numero,  tipo,  ubicacion,  persona,  total,  descripcion,  cod_contable,  id_v,  id_caja,  descuento,  accion, p_id_usuario, p_id_moneda)
        //print_r($serie ." numero". $numero." tipo". $tipo." ubicacion". $cod_tributario."persona ". $cod_tributario." total". $total."descripcion ". $descripcion." ". $cod_contable." ". $id_v." ". $id_caja." ". $descuento." ". $accion." ".    $id_user." ".   $id_moneda);exit();
        $cad = "Select sp_crud_comprobante(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        //echo "Select sp_crud_factura(".$serie.",".$numero.", ".$tipo.", ".$ubicacion.",".$persona.",".$total.",".$descripcion.",".$cod_contable.",".$codigo_v.",".$estab_v.",".$modulo.",".$smodulo.",".$descuento.",".$accion.",".$id_user.")";
        
        $data = DB::select($cad, array($serie, $numero, $tipo, $cod_tributario, $total, $descripcion, $cod_contable, $id_v, $id_caja, $descuento, $accion,     $id_user,  $id_moneda));
        //( serie,  numero,  tipo,  ubicacion,  persona,  total,  descripcion,  cod_contable,  id_v,  id_caja,  descuento,  accion, p_id_usuario, p_id_moneda)
        //print_r($data );exit();
       
        return $data[0]->sp_crud_comprobante;
       
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

		$data = DB::select($cad);
        return $data;
    }

	
}
