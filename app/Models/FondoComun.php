<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class FondoComun extends Model
{
    use HasFactory;

    public function listar_fondo_comun_ajax($p){

        return $this->readFuntionPostgres('sp_listar_delegado_fondo_comun_all_paginado',$p);
    }

    public function calcula_fondo_comun1($p){

        return $this->readFuntionPostgres('sp_calcula_del_fondo_comun',$p);
    }



    public function calcula_fondo_comun($periodo, $anio, $mes) {

        $cad = "Select  sp_calcula_del_fondo_comun_all(?, ?, ?)";
     
		$data = DB::select($cad, array($periodo, $anio, $mes ));
        return $data[0]->sp_calcula_del_fondo_comun_all;
    }

    function ListarFondoComun($anio, $mes, $periodo){

        $mes= intval($mes);

        $cad = "select t3.desc_ubigeo municipalidad,round(t1.importe_bruto::numeric,2)importe_bruto, round(t1.importe_igv::numeric,2)importe_igv, round(t1.importe_comision_cap::numeric,2)importe_comision_cap, round(t1.importe_fondo_asistencia::numeric,2)importe_fondo_asistencia, round(t1.saldo::numeric,2)saldo
                from delegado_fondo_comuns t1
                --inner join municipalidades t3 on t3.id = t1.id_municipalidad
                inner join ubigeos t3 on t3.id_ubigeo = t1.id_ubigeo
                inner join periodo_comision_detalles t4 on t4.id_periodo_comision = t1.id_periodo_comision and t4.id = t1.id_periodo_comision_detalle 
            Where EXTRACT(YEAR FROM t4.fecha)::varchar = '".$anio."'
            And EXTRACT(MONTH FROM t4.fecha)::varchar = '".$mes."'
            And t1.id_periodo_comision = '".$periodo."' ";

		//echo $cad;
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
