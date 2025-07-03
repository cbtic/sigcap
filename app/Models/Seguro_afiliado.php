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



     

     public function listar_parentesco_agremiado($id_afiliacion,$id_agremiado,$id_seguro){

        $cad = "select sap.id id_seguro_afiliado_parentesco,ap.id,0  id_afiliacion,ap.id_agremiado,ap.id id_familia, 
		extract(year from Age(ap.fecha_nacimiento)) edad,tms.denominacion sexo,ap.estado, 
        tm.denominacion parentesco,
        tmp.denominacion dependencia,
		ap.apellido_nombre nombre,sp.id id_plan,sp.nombre plan, monto, tm2.denominacion moneda, tms.codigo id_sexo 
        from  agremiado_parentecos ap 
        inner join parentesco_seguros ps on ps.id_parentesco_agremiado=ap.id_parentesco
        inner join tabla_maestras tm on cast(tm.codigo as integer)=ps.id_parentesco_agremiado and tm.tipo ='12'
        inner join tabla_maestras tmp on cast(tmp.codigo as integer)=ps.id_parentesco_seguro and tmp.tipo ='23'
        inner join tabla_maestras tms on cast(tms.codigo as integer)=ap.id_sexo  and tms.tipo ='2'
		inner join seguros_planes sp on sp.id=(select id from seguros_planes where id_seguro='".$id_seguro."' 
        and extract(year from Age(ap.fecha_nacimiento)) between edad_minima and edad_maxima 
        and id_parentesco=ps.id_parentesco_seguro 
        order by 1 desc limit 1) 
		left join seguro_afiliado_parentescos sap on ap.id=sap.id_familia and sap.id_afiliacion=".$id_afiliacion." and sap.estado='1' 
        inner join seguros s on sp.id_seguro = s.id
        inner join conceptos c on s.id_concepto::int = c.id 
        inner join tabla_maestras tm2 on c.id_moneda = tm2.codigo::int and  tm2.tipo ='1'
        Where  ap.id_agremiado = " .$id_agremiado. " 
        and (select fecha from seguro_afiliados sa where id=".$id_afiliacion.") between sp.fecha_inicio and sp.fecha_fin 
        Order By id_familia ";
        
    	//echo $cad;exit();
		$data = DB::select($cad);
        return $data;

    }

    public function datos_afiliacion_seguro($id){

        $cad = "select sa.id,a.numero_cap, p.apellido_paterno||' '|| p.apellido_materno || ' ' || p.nombres agremiado, tm.denominacion situacion, sa.id_seguro, 
        (select sp2.id from seguros_planes sp2 where sp2.id_seguro = s.id limit 1) id_plan  from seguro_afiliados sa 
        inner join agremiados a on sa.id_agremiado =a.id
        inner join personas p on p.id = a.id_persona
        inner join seguros s on sa.id_seguro =s.id
        inner join tabla_maestras tm on a.id_situacion = tm.codigo::int And tm.tipo ='14'
        where sa.id= '".$id. "'";
    
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
