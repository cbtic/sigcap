<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class CoordinadorZonal extends Model
{
    use HasFactory;

    protected $table = 'coordinador_zonales';

    public function listar_coordinadorZonal_ajax($p){
 
        return $this->readFuntionPostgres('sp_listar_coordinador_zonal_paginado',$p);
        
    }

    public function listar_coordinadorZonalSesion_ajax($p){
 
        return $this->readFuntionPostgres('sp_listar_coordinador_zonal_sesion_paginado',$p);

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

    function getCoordinadorZonalById($id){

        $cad = "select cz.id, cz.id_regional, cz.id_periodo , a.numero_cap, p.numero_documento, p.apellido_paterno, p.apellido_materno, p.nombres, cz.id_zonal , cz.estado_coordinador from coordinador_zonales cz 
        inner join regiones r on cz.id_regional = r.id 
        inner join periodo_comisiones pc on cz.id_periodo =pc.id 
        inner join agremiados a on cz.id_agremiado = a.id 
        inner join personas p on a.id_persona = p.id 
        --inner join tabla_maestras tm on cz.id_zonal = tm.codigo::int And tm.tipo ='117'
        --inner join tabla_maestras tm2 on cz.estado_coordinador = tm2.codigo::int And tm2.tipo ='119'
        where cz.id ='".$id."'";
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }

    function getInformeById($id){

        $cad = "select 'Informe' ruta ,cs.ruta_informe from comision_sesion_delegados csd
        inner join comision_sesiones cs on csd.id_comision_sesion = cs.id
        where csd.id='".$id."'";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getUltimoMesUsado($id_comision){

        $cad = "select cs.id, extract ('MONTH' from cs.fecha_ejecucion) mes
        from comision_sesiones cs 
        where id_comision ='".$id_comision."' 
        order by 1 desc
        limit 1";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

}
