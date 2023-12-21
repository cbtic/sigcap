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

        $cad = "select to_char(fecha,'dd-mm-yyyy')fecha,credipago,sub_total,igv,total,observacion  
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
    
}
