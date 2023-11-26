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

	public function registrar_factura_moneda($serie, $numero, $tipo, $ubicacion, $persona, $total, $descripcion, $cod_contable, $id_v, $id_caja, $descuento, $accion,    $id_user,   $id_moneda) {
                                          //( serie,  numero,  tipo,  ubicacion,  persona,  total,  descripcion,  cod_contable,  id_v,  id_caja,  descuento,  accion, p_id_usuario, p_id_moneda)

        $cad = "Select sp_crud_factura_moneda(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        //echo "Select sp_crud_factura(".$serie.",".$numero.", ".$tipo.", ".$ubicacion.",".$persona.",".$total.",".$descripcion.",".$cod_contable.",".$codigo_v.",".$estab_v.",".$modulo.",".$smodulo.",".$descuento.",".$accion.",".$id_user.")";

		$data = DB::select($cad, array($serie, $numero, $tipo, $ubicacion, $persona, $total, $descripcion, $cod_contable, $id_v, $id_caja, $descuento, $accion,     $id_user,  $id_moneda));
                                    //( serie,  numero,  tipo,  ubicacion,  persona,  total,  descripcion,  cod_contable,  id_v,  id_caja,  descuento,  accion, p_id_usuario, p_id_moneda)
        return $data[0]->sp_crud_factura_moneda;
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
	
    
    

	
}
