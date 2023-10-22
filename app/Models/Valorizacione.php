<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;


class Valorizacione extends Model
{
    function getValorizacion($tipo_documento,$persona_id){
        if($tipo_documento=="RUC"){
            $cad = "
            select v.id, v.fecha, c.denominacion concepto, v.monto 
            from valorizaciones v
            inner join conceptos c  on c.id = v.id_concepto 
            where v.id_agremido = ".$persona_id."
            and v.estado = '1'
			";
        }else{
            $cad = "
            select v.id, v.fecha, c.denominacion concepto, v.monto 
            from valorizaciones v
            inner join conceptos c  on c.id = v.id_concepto 
            where v.id_agremido = ".$persona_id."
            and v.estado = '1'
			";
        }

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getPago($tipo_documento,$persona_id){

        $cad = "select distinct c.id id_comprobante,c.tipo, c.fecha, c.serie, c.numero, c.total, u.name usuario_registro,
        (select string_agg(DISTINCT coalesce(d.descripcion), ',')  from comprobante_detalles d  where d.id_comprobante = c.id) descripcion
        from comprobantes c
        inner join comprobante_detalles d on d.id_comprobante = c.id
        inner join valorizaciones v on v.id_comprobante = c.id
        left join users u  on u.id  = c.id_usuario_inserta 
        where v.id_agremido = ".$persona_id."
        order by c.fecha desc";
        
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
}
