<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PeriodoComisione extends Model
{
    use HasFactory;

    public function listar_consulta_periodoComision_ajax($p){

        return $this->readFuntionPostgres('sp_listar_periodoComision_paginado',$p);

    }
	
	public function getPeriodoAll(){
		
		$cad = "select pc.id,pc.descripcion,pc.activo  
		from periodo_comisiones pc where pc.estado='1'";

		$data = DB::select($cad);
        return $data;
		
	}

    public function getPeriodoAllByFecha(){
		
		$cad = "select pc.id,pc.descripcion,pc.activo  
        from periodo_comisiones pc 
        where pc.estado='1'
        order by 
        case when pc.created_at is null then 1 else 0 end,
        pc.created_at desc";

		$data = DB::select($cad);
        return $data;
		
	}

    public function getPeriodoDetAll(){
		
		$cad = "select id, denominacion, activo  
		from periodo_comision_detalles pc where estado='1'";

		$data = DB::select($cad);
        return $data;
		
	}
	
	public function getAnioByFecha($fecha_inicio,$fecha_fin){
		
		$cad = "select to_char(anio::date,'yyyy')anio 
        from generate_series(('01-01-'||to_char('".$fecha_inicio."'::date,'yyyy'))::date,('01-01-'||to_char('".$fecha_fin."'::date,'yyyy'))::date, '1 years'::interval) anio";

		$data = DB::select($cad);
        return $data;
		
	}
	
	public function getPeriodoVigenteAll(){
		
		$cad = "select pc.id,pc.descripcion 
		from periodo_comisiones pc where pc.estado='1'
		and now() between (to_char(pc.fecha_inicio,'dd-mm-yyyy')||' 00:00')::timestamp  and (to_char(pc.fecha_fin,'dd-mm-yyyy')||' 23:59')::timestamp";

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

    function getPeriodoComisionAll(){

        $cad = "select *
                from periodo_comisiones
                where estado='1'
                order by descripcion ";
    
		$data = DB::select($cad);
        return $data;
    }

    function actualizarActivoPeriodoComision(){
  
        $cad = "update periodo_comisiones set estado = '1' where now() between fecha_inicio and fecha_fin and estado = '2'";
        //echo $cad;
        $data = DB::select($cad);
        return $data;
    }

    function actualizarInactivoPeriodoComision(){
  
        $cad = "update periodo_comisiones set estado = '0' where now() not between fecha_inicio and fecha_fin and estado = '1'";
        //echo $cad;
        $data = DB::select($cad);
        return $data;
    }

    function actualizarInactivoPeriodoComisionDertalle($id_periodo_comision){
  
        $cad = "update periodo_comision_detalles set estado = '0' where id_periodo_comision=".$id_periodo_comision;
        //echo $cad;
        $data = DB::select($cad);
        return $data;
    }
}
