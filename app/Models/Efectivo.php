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

        $cad="select ed.id, tm2.denominacion caja, e.fecha, tm3.denominacion moneda, tm.denominacion, ed.cantidad, ed.total from efectivos e 
        inner join efectivo_detalles ed on ed.id_efectivo = e.id 
        inner join tabla_maestras tm on ed.id_tipo_efectivo::int = tm.codigo::int and tm.tipo ='133'
        inner join tabla_maestras tm2 on e.id_caja ::int = tm2.codigo::int and tm2.tipo ='91'
        inner join tabla_maestras tm3 on e.id_moneda ::int = tm3.codigo::int and tm3.tipo ='1'
        where id_caja ='".$caja."'
        and fecha ='".$fecha."'";

        $data = DB::select($cad);

        return $data;
        
    }
}
