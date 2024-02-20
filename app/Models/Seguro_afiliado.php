<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Seguro_afiliado extends Model
{
   
    public function listar_afiliacion_seguro($p){

        return $this->readFuntionPostgres('sp_listar_afiliado_seguro_paginado',$p);

    }

    public function listar_parentesco($p){

        return $this->readFuntionPostgres('sp_listar_parentesco_seguro_paginado',$p);

    }



     

     public function listar_parentesco_agremiado($id_agremiado){

        $cad = "select ap.id,0  id_afiliacion,id_agremiado,ap.id id_familia, extract(year from Age(ap.fecha_nacimiento)) edad,tms.denominacion  		sexo,ap.estado, tm.denominacion  parentesco,ap.apellido_nombre nombre,sp.id id_plan,nombre plan,monto,tms.codigo id_sexo  
        from  agremiado_parentecos ap inner join tabla_maestras tm on cast(tm.codigo as integer)=ap.id_parentesco and tm.tipo ='12' 
        inner join tabla_maestras tms on cast(tms.codigo as integer)=ap.id_sexo  and tms.tipo ='2'
		inner join seguros_planes sp on sp.id=(select id from seguros_planes where id_seguro=1 and extract(year from Age(ap.fecha_nacimiento)) between edad_minima and edad_maxima) 
        Where  id_agremiado = " .$id_agremiado. "
        Order By id_familia;  ";
    
		$data = DB::select($cad);
        return $data;

    }

    public function datos_afiliacion_seguro($id){

        $cad = "select * ,s.id id_seguro 
                from seguro_afiliados sa inner join agremiados a on sa.id_agremiado =a.id 
                inner join seguros_planes sp on sa.id_plan =sp.id 
                inner join seguros s on sp.id_seguro  =s.id inner join tabla_maestras tm on a.id_situacion  =cast( tm.codigo as integer) inner join personas p on p.id=a.id_persona 
                where sa.id=".$id. " and tm.tipo='14';  ";
    
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
