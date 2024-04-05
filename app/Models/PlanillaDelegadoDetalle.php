<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PlanillaDelegadoDetalle extends Model
{
    use HasFactory;

    public function listar_recibo_honorario_ajax($p){

        return $this->readFuntionPostgres('sp_listar_recibo_honorario_paginado',$p);

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

    function getDatosRecibo($id){     
        
        $cad = "select pdd.id, a.numero_cap, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres agremiado, pdd.numero_comprobante, pdd.fecha_comprobante, pdd.fecha_vencimiento, pdd.numero_operacion from planilla_delegado_detalles pdd 
        inner join agremiados a on pdd.id_agremiado = a.id
        inner join personas p on a.id_persona = p.id
        where pdd.id = '".$id."'";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }


}
