<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Efectivo extends Model
{
    use HasFactory;

    public function listar_consulta_efectivo_ajax($p){

        return $this->readFuntionPostgres('sp_listar_efectivo_paginado',$p);

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

    public function datos_efectivo_caja($fecha, $caja){

        $cad="select  
            min(ed.id) as id, 
            tm2.denominacion as caja, 
            e.fecha, 
            max(case when tm3.denominacion = 'SOLES' then tm3.denominacion end) as moneda_soles,
            max(case when tm3.denominacion = 'SOLES' then tm.denominacion end) as descripcion_soles,
            coalesce(sum(case when tm3.denominacion = 'SOLES' then ed.cantidad::float end), 0) as cantidad_soles,
            coalesce(sum(case when tm3.denominacion = 'SOLES' then ed.total::float end), 0) as total_soles,
            max(case when tm3.denominacion = 'DOLARES AMERICANOS' then tm3.denominacion end) as moneda_dolares,
            max(case when tm3.denominacion = 'DOLARES AMERICANOS' then tm.denominacion end) as descripcion_dolares,
            coalesce(sum(case when tm3.denominacion = 'DOLARES AMERICANOS' then ed.cantidad::float end), 0) as cantidad_dolares,
            coalesce(sum(case when tm3.denominacion = 'DOLARES AMERICANOS' then ed.total::float end), 0) as total_dolares,
            u.name as cajero
        from efectivos e 
        inner join efectivo_detalles ed on ed.id_efectivo = e.id 
        inner join tabla_maestras tm on ed.id_tipo_efectivo::int = tm.codigo::int and tm.tipo = '133'
        inner join tabla_maestras tm2 on e.id_caja::int = tm2.codigo::int and tm2.tipo = '91'
        inner join tabla_maestras tm3 on ed.id_moneda::int = tm3.codigo::int and tm3.tipo = '1'
        inner join users u on e.id_usuario_inserta = u.id
        where e.id_caja = '".$caja."' 
        and e.fecha = '".$fecha."'
        group by tm2.denominacion, e.fecha, tm.denominacion, u.name
        order by min(ed.id)";

        $data = DB::select($cad);

        return $data;
        
    }

    public function datos_efectivo_consolidado($fecha){

        $cad="select 
            e.fecha,
            ed.id_tipo_efectivo,
            tm.denominacion as tipo_efectivo,
            coalesce(sum(case when tm3.denominacion = 'SOLES' then ed.cantidad::float end), 0) as cantidad_soles,
            coalesce(sum(case when tm3.denominacion = 'SOLES' then ed.total::float end), 0) as total_soles,
            coalesce(sum(case when tm3.denominacion = 'DOLARES AMERICANOS' then ed.cantidad::FLOAT end), 0) as cantidad_dolares,
            coalesce(sum(case when tm3.denominacion = 'DOLARES AMERICANOS' then ed.total::FLOAT end), 0) as total_dolares
        from efectivos e
        inner join efectivo_detalles ed on ed.id_efectivo = e.id
        inner join tabla_maestras tm on ed.id_tipo_efectivo::int = tm.codigo::int and tm.tipo = '133'
        inner join tabla_maestras tm3 on ed.id_moneda::int = tm3.codigo::int and tm3.tipo = '1'
        where e.fecha = '".$fecha."' and e.estado ='1'
        group by e.fecha, ed.id_tipo_efectivo, tm.denominacion
        order by e.fecha, ed.id_tipo_efectivo";

        $data = DB::select($cad);

        return $data;
        
    }

    public function valida_caja($caja, $fecha, $moneda, $id_efectivo){

        $cad="select count(*) cantidad from efectivos e 
        inner join efectivo_detalles ed on e.id = ed.id_efectivo 
        where e.id_caja = '".$caja."'
        and e.fecha ='".$fecha."'
        and ed.id_moneda ='".$moneda."'
        and e.estado='1' 
        and e.id!=".$id_efectivo;

        $data = DB::select($cad);

        return $data;
        
    }

}
