<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Adelanto_detalle extends Model
{
    use HasFactory;

    public function listar_adelanto_ajax($p){

        return $this->readFuntionPostgres('sp_listar_detalle_adelanto_paginado',$p);
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

    function getAdelantoDetalleId($id){ 

        $cad = "select ad.id, ad.numero_cuota, ad.adelanto_pagar, to_char(ad.fecha_pago,'dd-mm-yyyy') fecha_pago, ad.estado, a.total_adelanto
        from adelanto_detalles ad
        inner join adelantos a on ad.id_adelento = a.id
        where a.id='".$id."'
        and ad.estado='1'
        order by ad.id asc";

        $data = DB::select($cad);
        return $data;

    }

    function getAdelantoFechaPagoId($id){ 

        $cad = "select a.id, ad.fecha_pago from adelanto_detalles ad
        inner join adelantos a on ad.id_adelento = a.id
        where a.id='".$id."'
        and ad.estado='1'
        limit 1";

        $data = DB::select($cad);
        return $data;

    }
}
