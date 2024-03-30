<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class DerechoRevision extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';

    public function listar_derecho_revision_ajax($p){

        return $this->readFuntionPostgres('sp_listar_derecho_revision_paginado',$p);

    }

    public function listar_derecho_revision_HU_ajax($p){

        return $this->readFuntionPostgres('sp_listar_derecho_revision_hu_paginado',$p);

    }
	
	function getCodigoSolicitud($id_tipo_solicitud){
		
		if($id_tipo_solicitud==123){
			$cad = "select '1'||lpad(max(numero+1)::varchar,7,'0') codigo from numeracion_documentos nd where id_tipo_documento='20'";
		}
		
		if($id_tipo_solicitud==124){
			$cad = "select '2'||lpad(max(numero+1)::varchar,7,'0') codigo from numeracion_documentos nd where id_tipo_documento='22'";
		}
		
        
		$data = DB::select($cad);
        return $data[0]->codigo;
    }
	
	function getCountProyectoTipoSolicitud($id_proyecto,$id_tipo_solicitud){
		
		$cad = "select lpad(count(*)::varchar,2,'0') codigo from solicitudes s where id_proyecto=".$id_proyecto." and id_tipo_solicitud=".$id_tipo_solicitud;
        
		$data = DB::select($cad);
        return $data[0]->codigo;
    }
	
	
	function getSolicitudById($id){

        $cad = "select s.id,p2.nombre nombre_proyecto,tp.denominacion tipo_proyecto,tm.denominacion tipo_solicitud, s.numero_revision,s.area_total,s.valor_obra,  
s.direccion,ud.desc_ubigeo departamento,up.desc_ubigeo provincia,udi.desc_ubigeo distrito,
m.denominacion municipalidad, s.fecha_registro, s.estado
from solicitudes s
left join municipalidades m on s.id_municipalidad = m.id
left join proyectos p2 on s.id_proyecto = p2.id
left join tabla_maestras tp on p2.id_tipo_proyecto=tp.codigo::int and tp.tipo='113'
left join tabla_maestras tm on s.id_tipo_solicitud=tm.codigo::int and tm.tipo='24' 
left join ubigeos u on s.id_ubigeo=u.id_ubigeo
left join ubigeos ud on ud.id_departamento=substring(u.id_ubigeo,1,2) and ud.id_provincia='00' and ud.id_distrito='00' and ud.estado='1'
left join ubigeos up on up.id_departamento=substring(u.id_ubigeo,1,2) and up.id_provincia=substring(u.id_ubigeo,3,2) and up.id_distrito='00' and up.estado='1'
left join ubigeos udi on udi.id_ubigeo=u.id_ubigeo and udi.estado='1'
where s.id=".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }
	
	public function getLiquidacionByIdSolicitud($id){

        $cad = "select l.id, to_char(fecha,'dd-mm-yyyy')fecha,credipago,sub_total,igv,total,observacion  
from liquidaciones l 
where id_solicitud=".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	public function getProyectistaByIdSolicitud($id){

        $cad = "select a.numero_cap, a.desc_cliente
from proyectistas pr 
left join agremiados a on pr.id_agremiado = a.id
where pr.id_solicitud=".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	public function getPropietarioByIdSolicitud($id){

        $cad = "select 
CASE 
  WHEN p.id_tipo_propietario = '78' THEN (select p2.numero_documento from personas p2 where p2.id = p.id_persona)
  WHEN p.id_tipo_propietario = '79' THEN (select e.ruc from empresas e where e.id = p.id_empresa) end as numero_documento, 
CASE 
  WHEN p.id_tipo_propietario = '78' THEN (select p2.apellido_paterno||' '||p2.apellido_materno||' '||p2.nombres agremiado from personas p2 where p2.id = p.id_persona)
  WHEN p.id_tipo_propietario = '79' THEN (select e.razon_social from empresas e where e.id = p.id_empresa) end as propietario 
from propietarios p 
left join empresas e on p.id_empresa = e.id 
where p.id_solicitud=".$id;
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

    public function getSolicitudNumeroCap($numero_cap){

        $cad = "select c.id, pr.id_tipo_profesional tipo_proyectista from certificados c 
        inner join solicitudes s on c.id_proyecto = s.id 
        inner join proyectistas pr on s.id_proyectista = pr.id 
        inner join agremiados a on pr.id_agremiado = a.id 
        where a.numero_cap = '".$numero_cap."'";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    public function getSolicitudPdf($id){

        $cad = "select l.credipago, pe.apellido_paterno ||' '|| pe.apellido_materno ||' '|| pe.nombres proyectista, a.numero_cap, e.razon_social, pro.nombre, u.id_departamento departamento, u.id_provincia provincia,
        u.id_distrito distrito, pro.direccion, s.numero_revision, m.denominacion municipalidad, s.area_total total_area_techada, s.valor_obra, l.sub_total, l.igv, l.total, tm.denominacion tipo_proyectista
        from solicitudes s 
        inner join liquidaciones l on l.id_solicitud = s.id
        inner join proyectistas p on s.id_proyectista = p.id
        inner join agremiados a on p.id_agremiado = a.id
        inner join personas pe on a.id_persona = pe.id
        inner join propietarios pr on pr.id_solicitud = s.id
        inner join empresas e on pr.id_empresa = e.id
        inner join proyectos pro on s.id_proyecto = pro.id
        inner join ubigeos u on pro.id_ubigeo = u.id
        inner join municipalidades m on s.id_municipalidad = m.id
        inner join tabla_maestras tm on p.id_tipo_profesional = tm.codigo::int and  tm.tipo ='41' 
        where l.id='".$id."'";

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getTipoSolicitud($id){

        $cad = "select l.id, s.id_tipo_solicitud from liquidaciones l 
        inner join solicitudes s on l.id_solicitud = s.id 
        where l.id='".$id."'";

        $data = DB::select($cad);
        return $data;
    }
    
}
