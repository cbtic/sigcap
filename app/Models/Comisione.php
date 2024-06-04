<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Comisione extends Model
{
    //use HasFactory;

    public function listar_comision_ajax($p){

        return $this->readFuntionPostgres('sp_listar_municipalidad_comision_paginado',$p);

    }
	
	public function lista_comision_ajax($p){

        return $this->readFuntionPostgres('sp_listar_comision_new_paginado',$p);

    }

    public function listar_municipalidad_integrada_ajax($p){

        return $this->readFuntionPostgres('sp_listar_municipalidad_integrada_paginado',$p);

    }

    public function listar_comision_integrada_ajax($p){

        return $this->readFuntionPostgres('sp_listar_comision_paginado',$p);

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

    public function getComisionAll($periodo,$tipo_comision,$cad_id,$estado){

        $cad = "select c.*,tm.denominacion tipo_agrupacion, cm.monto,pc.descripcion periodo
		from comisiones c
        inner join municipalidad_integradas mi on c.id_municipalidad_integrada = mi.id
        inner join tabla_maestras tm on mi.id_tipo_agrupacion ::int =tm.codigo::int and tm.tipo='99'
        left join comision_movilidades cm on cm.id_municipalidad_integrada =mi.id 
		inner join periodo_comisiones pc on c.id_periodo_comisiones=pc.id
        where c.estado ilike '%".$estado."'";
		
		if($periodo!="" && $periodo!="0"){
			$cad .= " and mi.id_periodo_comision='".$periodo."'";
		}
		
		if($tipo_comision!="" && $tipo_comision!="0"){
			$cad .= " and c.id_tipo_comision='".$tipo_comision."'";
		}
        if($cad_id!="" && $cad_id!="0"){
            $cad .= " and c.id_municipalidad_integrada in (".$cad_id.")";
        }
		
		$cad .= " order by c.denominacion asc";

		$data = DB::select($cad);
        return $data;
    }
	
	function getComisionByPeriodoAndTipComision($id_periodo,$id_tipo_comision){

        $cad = "select c.*
		from comisiones c
		where c.estado='1'
		and c.id_periodo_comisiones='".$id_periodo."'
		and c.id_tipo_comision='".$id_tipo_comision."'
		and c.id not in(select distinct id_comision from comision_delegados cd where estado='1')";

		$data = DB::select($cad);
        return $data;
    }
	
	function getComisionSinDelegadoAll($tipo_comision,$cad_id,$estado){

        $cad = " select c.*,tm.denominacion tipo_agrupacion, cm.monto,pc.descripcion periodo
		from comisiones c
        inner join municipalidad_integradas mi on c.id_municipalidad_integrada = mi.id
        inner join tabla_maestras tm on mi.id_tipo_agrupacion ::int =tm.codigo::int and tm.tipo='99'
        left join comision_movilidades cm on cm.id_municipalidad_integrada =mi.id 
		inner join periodo_comisiones pc on c.id_periodo_comisiones=pc.id
        where c.estado ilike '%".$estado."'
		and c.id not in(select distinct id_comision from comision_delegados cd where estado='1')";
		
		if($tipo_comision!="" && $tipo_comision!="0"){
			$cad .= " and c.id_tipo_comision='".$tipo_comision."'";
		}
        if($cad_id!="" && $cad_id!="0"){
            $cad .= " and c.id_municipalidad_integrada in (".$cad_id.")";
        }

		$data = DB::select($cad);
        return $data;
    }
	
	function getComisionByPeriodo($id_periodo,$tipo_comision){

        $cad = " select c.*,tm.denominacion tipo_agrupacion, cm.monto,pc.descripcion periodo 
		from comisiones c
        inner join municipalidad_integradas mi on c.id_municipalidad_integrada = mi.id
        inner join tabla_maestras tm on mi.id_tipo_agrupacion ::int =tm.codigo::int and tm.tipo='99'
        left join comision_movilidades cm on cm.id_municipalidad_integrada =mi.id 
		inner join periodo_comisiones pc on c.id_periodo_comisiones=pc.id
        where c.id_periodo_comisiones=".$id_periodo;
		
		if($tipo_comision!="" && $tipo_comision!="0"){
			$cad .= " and c.id_tipo_comision='".$tipo_comision."'";
		}

		$cad .= " order by c.denominacion asc,c.comision asc ";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getDiaComisionAll(){

        $cad = " select c.id_dia_semana from comisiones c 
        inner join tabla_maestras tm on c.id_dia_semana ::int =tm.codigo:: int and tm.tipo = '70'";

		$data = DB::select($cad);
        return $data;  
    }

    function getCodigoComision($id_municipalidad_integrada){

        $cad = "select lpad((count(*)+1)::varchar,2,'0') codigo from comisiones c where id_municipalidad_integrada=".$id_municipalidad_integrada." and estado ='1'";
        //echo $cad;exit();
		$data = DB::select($cad);
        return $data[0]->codigo;
    }

    function getCodigoComision2($id_municipalidad_integrada,$id_tipo_comision){

        //$cad = "select lpad((count(*)+1)::varchar,2,'0') codigo from comisiones c where id_municipalidad_integrada=".$id_municipalidad_integrada." and estado ='1'";
        $cad = "select lpad((count(*)+1)::varchar,2,'0') codigo from comisiones c where id_municipalidad_integrada=".$id_municipalidad_integrada." and id_tipo_comision = '2' and estado ='1'";

        //echo $cad;exit();
		$data = DB::select($cad);
        return $data[0]->codigo;
    }
    
    function getAllComision($id){
        $cad = "select *, c.denominacion comision from comision_sesiones cs 
        inner join comisiones c on cs.id_comision = c.id
        where cs.id='".$id."'";

        //echo $cad;exit();
		$data = DB::select($cad);
        return $data[0];
    }
    
}
