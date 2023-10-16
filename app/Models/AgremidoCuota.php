<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class AgremidoCuota extends Model
{
    function getCajaIngresoByusuario($id_usuario,$tipo){

        $cad = "select t1.id,t1.id_caja,t1.saldo_inicial,
		--(select coalesce(Sum(fac_total),0) from facturas where fac_caja_id=t1.id_caja And fac_fecha >= fecha_inicio And fac_fecha <= (case when fecha_fin is null then now() else fecha_fin end))total_recaudado,
		1000 total_recaudado,
        --((select coalesce(Sum(fac_total),0) from facturas where fac_caja_id=t1.id_caja And fac_fecha >= fecha_inicio And fac_fecha <= (case when fecha_fin is null then now() else fecha_fin end)) + t1.saldo_inicial)saldo_total,
		10 saldo_total,
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
    function getCaja($tipo){

        $cad = "select t1.id,t1.denominacion 
		from tabla_maestras t1
		where t1.tipo='".$tipo."' and t1.estado='A' 
		And t1.id not in (select distinct id_caja from caja_ingresos where estado='1')
		order by t1.id ";
    
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
