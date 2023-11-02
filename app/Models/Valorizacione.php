<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;


class Valorizacione extends Model
{
    function getValorizacion($tipo_documento,$id_persona){
        if($tipo_documento=="RUC"){
            $cad = "
            select v.id, v.fecha, c.denominacion||' '||a.mes||' '||a.periodo  concepto, v.monto,t.denominacion moneda, v.id_moneda
            from valorizaciones v
            inner join conceptos c  on c.id = v.id_concepto
            inner join agremiado_cuotas a  on a.id = v.pk_registro
            inner join tabla_maestras t  on t.codigo::int = v.id_moneda and t.tipo = '1'
            where v.id_agremido = ".$id_persona."
            and v.estado = '1' 
            and id_comprobante is null
			";
        }else{
            $cad = "
            --select v.id, v.fecha, c.denominacion||' '||a.mes||' '||a.periodo  concepto, v.monto,t.denominacion moneda, v.id_moneda
            select v.id, v.fecha, c.denominacion  concepto, v.monto,t.denominacion moneda, v.id_moneda, v.fecha_proceso
            from valorizaciones v
            inner join conceptos c  on c.id = v.id_concepto
            --inner join agremiado_cuotas a  on a.id = v.pk_registro
            inner join tabla_maestras t  on t.codigo::int = v.id_moneda and t.tipo = '1'
            where v.id_persona = ".$id_persona."
            and v.estado = '1'
            and id_comprobante is null
            order by v.fecha desc
			";
        }

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getPago($tipo_documento,$persona_id){

        if($tipo_documento=="RUC"){

        }else{
            $cad = "select distinct c.id id_comprobante,c.tipo, c.fecha, c.serie, c.numero, c.total, u.name usuario_registro,
            (select string_agg(DISTINCT coalesce(d.descripcion), ',')  from comprobante_detalles d  where d.id_comprobante = c.id) descripcion
            from comprobantes c
            inner join comprobante_detalles d on d.id_comprobante = c.id
            inner join valorizaciones v on v.id_comprobante = c.id            
            left join users u  on u.id  = c.id_usuario_inserta 
            where v.id_persona = ".$persona_id."
            order by c.fecha desc";
    
        }

        
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

     function getCajaIngresoByusuario($id_usuario,$tipo){

        $cad = "select t1.id,t1.id_caja,t1.saldo_inicial,
		(select coalesce(Sum(total),0) from comprobantes where id_caja=t1.id_caja And fecha >= fecha_inicio And fecha <= (case when fecha_fin is null then now() else fecha_fin end))total_recaudado,
		((select coalesce(Sum(total),0) from comprobantes where id_caja=t1.id_caja And fecha >= fecha_inicio And fecha <= (case when fecha_fin is null then now() else fecha_fin end)) + t1.saldo_inicial)saldo_total,
		t1.estado,t2.denominacion caja,t3.name usuario
        from caja_ingresos t1
        inner join tabla_maestras t2 on t1.id_caja=t2.codigo::int 
		inner join users t3 on t1.id_usuario = t3.id
        where t1.id_usuario=".$id_usuario."
		And t2.tipo='".$tipo."'
		and t1.estado='1'
		order by 1 desc
        limit 1";

		//echo $cad;
		$data = DB::select($cad);
        if($data)return $data[0];
     }

     public function registrar_caja_ingreso($datos) {

        $cad = "Select sp_crud_caja_ingreso(?,?,?,?,?,?,?,?)";
        //echo "Select sp_crud_caja_ingreso(".$datos[0].",".$datos[1].",".$datos[2].",".$datos[3].",".$datos[4].",".$datos[5].",".$datos[6].",".$datos[7].")";
		$data = DB::select($cad, array($datos[0],$datos[1],$datos[2],$datos[3],$datos[4],$datos[5],$datos[6],$datos[7]));
        return $data[0]->sp_crud_caja_ingreso;
    }
    public function registrar_caja_ingreso_moneda($datos) {

        //$cad = "Select sp_crud_caja_ingreso(?,?,?,?,?,?,?,?)";
		$cad = "Select sp_crud_caja_ingreso_moneda(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        //echo "Select sp_crud_caja_ingreso(".$datos[0].",".$datos[1].",".$datos[2].",".$datos[3].",".$datos[4].",".$datos[5].",".$datos[6].",".$datos[7].",".$datos[8].",".$datos[9].",".$datos[10].",".$datos[11].",".$datos[12].")";
		$data = DB::select($cad, array($datos[0],$datos[1],$datos[2],$datos[3],$datos[4],$datos[5],$datos[6],$datos[7],$datos[8],$datos[9],$datos[10],$datos[11],$datos[12]));
        return $data[0]->sp_crud_caja_ingreso_moneda;
    }
}
