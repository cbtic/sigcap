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
		/*
		if($id_tipo_solicitud==123){
			$cad = "select '1'||lpad(max(numero+1)::varchar,7,'0')codigo,max(numero+1)numero from numeracion_documentos nd where id_tipo_documento='20'";
		}
		
		if($id_tipo_solicitud==124){
			$cad = "select '2'||lpad(max(numero+1)::varchar,7,'0') codigo,max(numero+1)numero from numeracion_documentos nd where id_tipo_documento='22'";
		}
		*/
        
        if($id_tipo_solicitud==123){
			$cad = "select '222'||lpad(max(numero+1)::varchar,5,'0')codigo,max(numero+1)numero from numeracion_documentos nd where id_tipo_documento='20'";
		}
		
		if($id_tipo_solicitud==124){
			$cad = "select '444'||lpad(max(numero+1)::varchar,5,'0') codigo,max(numero+1)numero from numeracion_documentos nd where id_tipo_documento='22'";
		}

		$data = DB::select($cad);
        return $data[0];
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
        left join tabla_maestras tm on s.id_tipo_tramite=tm.codigo::int and tm.tipo='25' 
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

        $cad = "select l.id, to_char(fecha,'dd-mm-yyyy')fecha,credipago,sub_total,igv,total,observacion, l.estado,
        (select v.pagado from valorizaciones v where pk_registro = l.id and v.id_modulo ='7' limit 1) pagado,
        --(select case when v.pagado = '1' then 'PAGADO' else 'PENDIENTE' end from valorizaciones v where pk_registro = l.id and v.id_modulo ='7' limit 1) situacion,
        (select c.fecha_pago from valorizaciones v inner join comprobantes c on v.id_comprobante = c.id where pk_registro = l.id and v.id_modulo ='7' limit 1) fecha_pago,
        (select concat(c.serie,'-', c.numero) numero_comprobante from valorizaciones v inner join comprobantes c on v.id_comprobante = c.id where pk_registro = l.id and v.id_modulo ='7' limit 1) numero_comprobante, l.id_situacion, tm.denominacion situacion
        from liquidaciones l 
        left join tabla_maestras tm on l.id_situacion =tm.codigo::int and tm.tipo='125'
        where id_solicitud='".$id."'
        and l.estado = '1'";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    public function actSituacionLiquidacion($id){

        $updateQuery = "update liquidaciones l 
        set id_situacion = 
        (case 
        when l.id_situacion <> 3 or l.id_situacion is null then
        (select case when v.pagado = '1' then 2 else 1 end 
        from valorizaciones v 
        where pk_registro = l.id and v.id_modulo ='7' 
        limit 1)
        else l.id_situacion end)
        where l.id_solicitud ='".$id."' and l.estado='1'";

        DB::update($updateQuery);
    }
	
	public function getProyectistaByIdSolicitud($id){

        $cad = "select a.numero_cap, a.desc_cliente, pr.id_tipo_proyectista 
        from proyectistas pr 
        left join agremiados a on pr.id_agremiado = a.id
        where pr.id_solicitud= '".$id."'
        union all 
        select po.colegiatura numero_cap, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres nombres, po.id_tipo_proyectista 
        from profesion_otros po 
        inner join personas p on po.id_persona =p.id
        where po.id_solicitud= '".$id."'
        order by id_tipo_proyectista ";
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

        $cad = "select l.credipago, pe.apellido_paterno ||' '|| pe.apellido_materno ||' '|| pe.nombres proyectista, a.numero_cap,CASE 
        WHEN pr.id_empresa is not null THEN (select e2.razon_social from empresas e2 where e2.id = pr.id_empresa)
        WHEN pr.id_persona is not null THEN (select p2.apellido_paterno ||' '|| p2.apellido_materno ||' '|| p2.nombres from personas p2 where p2.id = pr.id_persona)
        end as razon_social, pro.nombre, u.id_departamento departamento, u.id_provincia provincia,
        u.id_distrito distrito, pro.direccion, s.numero_revision, m.denominacion municipalidad, s.area_total total_area_techada, s.valor_obra, l.sub_total, l.igv, l.total, 
        (SELECT tm6.denominacion AS tipo_proyectista
        FROM proyectistas p5
        INNER JOIN agremiados a3 ON p5.id_agremiado = a3.id 
        INNER JOIN personas p4 ON a3.id_persona = p4.id 
        left join tabla_maestras tm6 on p5.id_tipo_profesional = tm6.codigo::int and  tm6.tipo ='41'
        WHERE p5.id_solicitud = s.id and p5.id_tipo_proyectista='1'
        UNION
        select tm7.denominacion AS tipo_proyectista 
        FROM profesion_otros po 
        INNER JOIN solicitudes s2 ON po.id_solicitud = s2.id
        INNER JOIN personas p6 ON po.id_persona = p6.id 
        left join tabla_maestras tm7 on po.id_tipo_profesional = tm7.codigo::int and  tm7.tipo ='41'
        WHERE po.id_solicitud = s.id and po.id_tipo_proyectista='1'
        LIMIT 1 )tipo_proyectista, 
        tm2.denominacion tipo_liquidacion, tm3.denominacion instancia,
        (select tm4.denominacion from uso_edificaciones ue left join tabla_maestras tm4 on ue.id_tipo_uso = tm4.codigo::int and  tm4.tipo ='30' where ue.id_solicitud = s.id and ue.estado ='1' limit 1) tipo_uso,
        (select tm5.denominacion from presupuestos p3 left join tabla_maestras tm5 on p3.id_tipo_obra = tm5.codigo::int and  tm5.tipo ='112' where p3.id_solicitud = s.id and p3.estado ='1' limit 1) tipo_obra, 
        pro.codigo, tm5.denominacion tipo_tramite, s.valor_reintegro, to_char(l.fecha, 'dd-mm-yyyy') fecha_liquidacion
        from solicitudes s 
        inner join liquidaciones l on l.id_solicitud = s.id
        left join proyectistas p on p.id_solicitud = s.id
        left join agremiados a on p.id_agremiado = a.id
        left join personas pe on a.id_persona = pe.id
        left join propietarios pr on pr.id_solicitud = s.id
        left join empresas e on pr.id_empresa = e.id
        left join personas pe2 on pr.id_persona = pe2.id
        left join proyectos pro on s.id_proyecto = pro.id
        left join ubigeos u on pro.id_ubigeo::varchar = u.id_ubigeo
        left join municipalidades m on s.id_municipalidad = m.id and m.estado='1'
        left join tabla_maestras tm on p.id_tipo_profesional = tm.codigo::int and  tm.tipo ='41'
        left join tabla_maestras tm2 on s.id_tipo_liquidacion1 = tm2.codigo::int and  tm2.tipo ='27'
        left join tabla_maestras tm3 on s.id_instancia = tm3.codigo::int and  tm3.tipo ='47'
        left join tabla_maestras tm5 on s.id_tipo_tramite = tm5.codigo::int and  tm5.tipo ='25'
        where l.id='".$id."'";

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    public function getSolicitudPdfHU($id){

        $cad = "select l.credipago, pe.apellido_paterno ||' '|| pe.apellido_materno ||' '|| pe.nombres proyectista, a.numero_cap,CASE 
        WHEN pr.id_empresa is not null THEN (select e2.razon_social from empresas e2 where e2.id = pr.id_empresa)
        WHEN pr.id_persona is not null THEN (select p2.apellido_paterno ||' '|| p2.apellido_materno ||' '|| p2.nombres from personas p2 where p2.id = pr.id_persona)
        end as razon_social, pro.nombre, u.id_departamento departamento, u.id_provincia provincia,
        u.id_distrito distrito, pro.direccion, s.numero_revision, m.denominacion municipalidad, s.area_total total_area_techada, s.valor_obra, l.sub_total, l.igv, l.total, tm.denominacion tipo_proyectista, 
        tm2.denominacion tipo_liquidacion, tm3.denominacion instancia,
        (select tm4.denominacion from uso_edificaciones ue inner join tabla_maestras tm4 on ue.id_tipo_uso = tm4.codigo::int and  tm4.tipo ='123' where ue.id_solicitud = s.id) tipo_uso, pro.codigo 
        from solicitudes s 
        inner join liquidaciones l on l.id_solicitud = s.id
        left join proyectistas p on p.id_solicitud = s.id
        left join agremiados a on p.id_agremiado = a.id
        left join personas pe on a.id_persona = pe.id
        left join propietarios pr on pr.id_solicitud = s.id
        left join empresas e on pr.id_empresa = e.id
        left join personas pe2 on pr.id_persona = pe2.id
        left join proyectos pro on s.id_proyecto = pro.id
        left join ubigeos u on pro.id_ubigeo::varchar = u.id_ubigeo
        left join municipalidades m on s.id_municipalidad = m.id and m.estado='1'
        left join tabla_maestras tm on p.id_tipo_profesional = tm.codigo::int and  tm.tipo ='41'
        left join tabla_maestras tm2 on s.id_tipo_liquidacion1 = tm2.codigo::int and  tm2.tipo ='27'
        left join tabla_maestras tm3 on s.id_instancia = tm3.codigo::int and  tm3.tipo ='47'
        where l.id='".$id."'";

		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    public function getSolicitudPdfHU2($id){

        $cad = "select l.credipago, pe.apellido_paterno ||' '|| pe.apellido_materno ||' '|| pe.nombres proyectista, a.numero_cap,CASE 
        WHEN pr.id_empresa is not null THEN (select e2.razon_social from empresas e2 where e2.id = pr.id_empresa)
        WHEN pr.id_persona is not null THEN (select p2.apellido_paterno ||' '|| p2.apellido_materno ||' '|| p2.nombres from personas p2 where p2.id = pr.id_persona)
        end as razon_social, pro.nombre, u.id_departamento departamento, u.id_provincia provincia,
        u.id_distrito distrito, pro.direccion, s.numero_revision, m.denominacion municipalidad, s.area_total total_area_techada, s.valor_obra, l.sub_total, l.igv, l.total, tm.denominacion tipo_proyectista, 
        tm2.denominacion tipo_liquidacion, tm3.denominacion instancia, pro.codigo, tm5.denominacion tipo_tramite,
        tm6.denominacion id_sitio, pro.sitio_descripcion, tm7.denominacion id_zona, pro.zona_descripcion, pro.parcela, pro.super_manzana, tm8.denominacion id_tipo, pro.direccion, pro.lote, pro.sub_lote, pro.fila, pro.zonificacion 
        from solicitudes s 
        inner join liquidaciones l on l.id_solicitud = s.id
        left join proyectistas p on p.id_solicitud = s.id
        left join agremiados a on p.id_agremiado = a.id
        left join personas pe on a.id_persona = pe.id
        left join propietarios pr on pr.id_solicitud = s.id and pr.estado ='1'
        left join empresas e on pr.id_empresa = e.id
        left join personas pe2 on pr.id_persona = pe2.id
        left join proyectos pro on s.id_proyecto = pro.id
        left join ubigeos u on pro.id_ubigeo::varchar = u.id_ubigeo
        left join municipalidades m on s.id_municipalidad = m.id and m.estado='1'
        left join tabla_maestras tm on p.id_tipo_profesional = tm.codigo::int and  tm.tipo ='41'
        left join tabla_maestras tm2 on s.id_tipo_liquidacion1 = tm2.codigo::int and  tm2.tipo ='27'
        left join tabla_maestras tm3 on s.id_instancia = tm3.codigo::int and  tm3.tipo ='47'
        left join tabla_maestras tm5 on s.id_tipo_tramite = tm5.codigo::int and  tm5.tipo ='123'
        left join tabla_maestras tm6 on pro.id_tipo_sitio = tm6.codigo::int and  tm6.tipo ='33'
        left join tabla_maestras tm7 on pro.id_zona = tm7.codigo::int and  tm7.tipo ='34'
        left join tabla_maestras tm8 on pro.id_tipo_direccion = tm8.codigo::int and  tm8.tipo ='35'
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

    public function getReintegroByIdSolicitud($id){

        $cad = "select p.nombre, 
        CASE 
            WHEN pr.id_tipo_propietario = '78' THEN (select p2.apellido_paterno||' '||p2.apellido_materno||' '||p2.nombres agremiado from personas p2 where p2.id = pr.id_persona and p2.estado ='1')
            WHEN pr.id_tipo_propietario = '79' THEN (select e.razon_social from empresas e where e.id = pr.id_empresa and e.estado ='1')
            WHEN pr.id_tipo_propietario = '84' THEN (select p3.apellido_paterno||' '||p3.apellido_materno||' '||p3.nombres agremiado from personas p3 where p3.id = pr.id_persona and p3.estado ='1')
        end as propietario,
        s.valor_obra, s.area_total, pre.area_techada, p.id_ubigeo, tm.denominacion tipo, p.direccion direccion_proyecto, 
        (SELECT numero_cap
        FROM (
            SELECT 1 as tipo, a2.numero_cap AS numero_cap
            FROM proyectistas p4
            INNER JOIN agremiados a2 ON p4.id_agremiado = a2.id 
            WHERE p4.id_solicitud = s.id  and p4.id_tipo_proyectista=1
            UNION
            SELECT 2 AS tipo, po.colegiatura AS numero_cap
            FROM profesion_otros po 
            INNER JOIN solicitudes s2 ON po.id_solicitud = s2.id
            WHERE po.id_solicitud = s.id  and po.id_tipo_proyectista=1
            ORDER BY tipo
            LIMIT 1
        )  subquery_proyectista_cap
        ) numero_cap,
        (SELECT nombre_completo
        FROM (
            SELECT 1 AS tipo, p.apellido_paterno || ' ' || p.apellido_materno || ' ' || p.nombres AS nombre_completo
        FROM proyectistas p4
        INNER JOIN agremiados a2 ON p4.id_agremiado = a2.id 
        INNER JOIN personas p ON a2.id_persona = p.id 
        WHERE p4.id_solicitud = s.id and p4.id_tipo_proyectista=1
        UNION
        SELECT 2 AS tipo, p.apellido_paterno || ' ' || p.apellido_materno || ' ' || p.nombres AS nombre_completo
        FROM profesion_otros po 
        INNER JOIN solicitudes s2 ON po.id_solicitud = s2.id
        INNER JOIN personas p ON po.id_persona = p.id 
        WHERE po.id_solicitud = s.id and po.id_tipo_proyectista=1
        ORDER BY tipo
        LIMIT 1
        )  subquery_proyectista
        )  agremiado,
        tm2.denominacion ubicacion, a.numero_regional, a.direccion, l.denominacion as local, r.denominacion regional, tm3.denominacion autoriza, tm4.denominacion actividad_gremial, tm5.denominacion situacion, m.denominacion municipalidad, s.valor_obra, s.numero_revision, s.etapa, s.numero_etapa,
        (select 'CAP' tipo_colegiatura
        FROM proyectistas p4
        WHERE p4.id_solicitud = s.id and p4.id_tipo_proyectista=1
        UNION
        SELECT 'CIP' tipo_colegiatura
        FROM profesion_otros po 
        WHERE po.id_solicitud = s.id and po.id_tipo_proyectista=1
        order by tipo_colegiatura limit 1) as tipo_colegiatura
        from solicitudes s 
        left join proyectos p on s.id_proyecto = p.id and p.estado ='1'
        left join propietarios pr on pr.id_solicitud = s.id and pr.estado ='1'
        left join empresas e on pr.id_empresa = e.id and e.estado ='1'
        left join presupuestos pre on pre.id_solicitud = s.id and pre.estado ='1'
        left join tabla_maestras tm on p.id_tipo_direccion = tm.codigo::int And tm.tipo ='35'
        left join proyectistas pro on pro.id_solicitud = s.id and pro.estado ='1'
        left join agremiados a on pro.id_agremiado = a.id 
        left join personas pe on a.id_persona = pe.id and pe.estado ='1'
        left join tabla_maestras tm2 on a.id_ubicacion = tm2.codigo::int And tm2.tipo ='63'
        left join locales l on a.id_local = l.id
        left join regiones r on a.id_regional = r.id 
        left join tabla_maestras tm3 on a.id_autoriza_tramite = tm3.codigo::int And tm3.tipo ='45'
        left join tabla_maestras tm4 on a.id_actividad_gremial = tm4.codigo::int And tm4.tipo ='46'
        left join tabla_maestras tm5 on a.id_situacion = tm5.codigo::int And tm5.tipo ='14'
        left join municipalidades m on s.id_municipalidad = m.id and m.estado = '1'
        where s.id='".$id."'";
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getPeridoSolicitud(){

        $cad = "select distinct DATE_PART('YEAR', s.fecha_registro)::varchar anio from solicitudes s 
        where s.estado ='1' and s.id_tipo_solicitud='123'
        order by  DATE_PART('YEAR', s.fecha_registro)::varchar";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getPeridoSolicitudHu(){

        $cad = "select distinct DATE_PART('YEAR', s.fecha_registro)::varchar anio from solicitudes s 
        where s.estado ='1' and s.id_tipo_solicitud='124'
        order by  DATE_PART('YEAR', s.fecha_registro)::varchar";

        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    public function importar_proyectos_dataLicencia(){

        return $this->readFuntionPostgres_('copia_datalicencia_proyecto()');

    }

    public function importar_solicitudes_dataLicencia(){

        return $this->readFuntionPostgres_('copia_datalicencia_solicitud()');

    }

    public function importar_solicitudes_dataLicenciaIndividual($codigo_solicitud){

        return $this->readFuntionPostgres_("copia_datalicencia_solicitud_codgo(?)", [$codigo_solicitud]);

    }

    public function importar_empresas_dataLicencia(){

        return $this->readFuntionPostgres_('copia_datalicencia_empresa()');

    }

    public function importar_personas_dataLicencia(){

        return $this->readFuntionPostgres_('copia_datalicencia_persona()');

    }

    public function importar_uso_edificacion_dataLicencia(){

        return $this->readFuntionPostgres_('copia_datalicencia_eduso()');

    }

    public function importar_presupuesto_dataLicencia(){

        return $this->readFuntionPostgres_('copia_datalicencia_presupuesto()');

    }

    public function importar_proyectista_dataLicencia(){

        return $this->readFuntionPostgres_('copia_datalicencia_proyectista()');

    }

    public function readFuntionPostgres_($function = null){

        $cad = "select " . $function;
        $data = DB::select($cad);
        return $data;
    }

    public function getProvinciaDistritoByIdSolicitud($id){

        $cad = "select u.id_provincia provincia, u.id_ubigeo distrito from solicitudes s
        inner join proyectos p on s.id_proyecto = p.id
        inner join ubigeos u on p.id_ubigeo = u.id_ubigeo 
        where s.id=".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    public function getCodigoSolicitudHU(){
		
		$cad = "select lpad((count(*)+1)::varchar,5,'0') codigo 
        from solicitudes s where id_tipo_solicitud ='124'";
        
		$data = DB::select($cad);
        return $data[0]->codigo;
    }

    public function getSolicitudCorreo($id){
		
		$cad = "select s.id, p.nombre nombre_proyecto, p.codigo, pe.nombres ||' '|| pe.apellido_paterno ||' '|| pe.apellido_materno nombres, a.numero_cap, s.codigo_solicitud, tm2.denominacion tipo_tramite,
        u.desc_ubigeo distrito, tm.denominacion situacion 
        from solicitudes s 
        inner join proyectos p on s.id_proyecto = p.id 
        inner join proyectistas pr on pr.id_solicitud = s.id 
        inner join agremiados a on pr.id_agremiado = a.id 
        inner join personas pe on a.id_persona = pe.id 
        left join tabla_maestras tm on a.id_situacion = tm.codigo::int and  tm.tipo ='14'
        left join tabla_maestras tm2 on s.id_tipo_tramite = tm2.codigo::int and  tm2.tipo ='25'
        inner join ubigeos u on s.id_ubigeo = u.id_ubigeo 
        where s.id='".$id."'
        and s.id_tipo_solicitud ='123'
        and s.estado = '1'
        order by pr.id_tipo_proyectista asc";
        
		$data = DB::select($cad);
        return $data;
    }

    public function getSolicitudCorreoAprobadoHu($id){
		
		$cad = "select s.id, p.nombre nombre_proyecto, p.codigo, pe.nombres ||' '|| pe.apellido_paterno ||' '|| pe.apellido_materno nombres, a.numero_cap, tm2.denominacion tipo_tramite,
        u.desc_ubigeo distrito, tm.denominacion situacion, s.area_total, p.direccion,
        (select case WHEN pro2.id_empresa IS NOT NULL THEN e.razon_social ELSE pe.apellido_paterno ||' '|| pe.apellido_materno ||' '|| pe.nombres END
        from propietarios pro2
        left join personas pe on pro2.id_persona = pe.id 
        left join empresas e on pro2.id_empresa = e.id where pro2.id_solicitud = s.id limit 1) propietario,
        l.credipago, l.total 
        from solicitudes s 
        inner join proyectos p on s.id_proyecto = p.id 
        inner join proyectistas pr on pr.id_solicitud = s.id 
        inner join agremiados a on pr.id_agremiado = a.id 
        inner join personas pe on a.id_persona = pe.id 
        left join tabla_maestras tm on a.id_situacion = tm.codigo::int and  tm.tipo ='14'
        left join tabla_maestras tm2 on s.id_tipo_tramite = tm2.codigo::int and  tm2.tipo ='123'
        inner join ubigeos u on s.id_ubigeo = u.id_ubigeo 
        left join liquidaciones l on l.id_solicitud = s.id
        where s.id='".$id."'
        and s.id_tipo_solicitud ='124'
        and s.estado = '1'";
        
		$data = DB::select($cad);
        return $data;
    }

    public function getSolicitudCorreoAprobadoReintegro($id){
		
		$cad = "select s.id, p.nombre nombre_proyecto, p.codigo, pe.nombres ||' '|| pe.apellido_paterno ||' '|| pe.apellido_materno nombres, a.numero_cap, tm2.denominacion tipo_tramite,
        u.desc_ubigeo distrito, tm.denominacion situacion, s.area_total, p.direccion,
        (select case WHEN pro2.id_empresa IS NOT NULL THEN e.razon_social ELSE pe.apellido_paterno ||' '|| pe.apellido_materno ||' '|| pe.nombres END
        from propietarios pro2
        left join personas pe on pro2.id_persona = pe.id 
        left join empresas e on pro2.id_empresa = e.id where pro2.id_solicitud = s.id limit 1) propietario,
        l.credipago, l.total,s.codigo_solicitud, s.valor_obra 
        from solicitudes s 
        inner join proyectos p on s.id_proyecto = p.id 
        inner join proyectistas pr on pr.id_solicitud = s.id 
        inner join agremiados a on pr.id_agremiado = a.id 
        inner join personas pe on a.id_persona = pe.id 
        left join tabla_maestras tm on a.id_situacion = tm.codigo::int and  tm.tipo ='14'
        left join tabla_maestras tm2 on s.id_tipo_tramite = tm2.codigo::int and  tm2.tipo ='25'
        inner join ubigeos u on s.id_ubigeo = u.id_ubigeo 
        left join liquidaciones l on l.id_solicitud = s.id
        where s.id='".$id."'
        and s.id_tipo_solicitud ='123'
        and s.estado = '1'
        order by pr.id_tipo_proyectista asc";
        
		$data = DB::select($cad);
        return $data;
    }

    function getCredipagoUnico($id_solicitud){

        $cad = "select count(*) cantidad from liquidaciones l 
        inner join solicitudes s on l.id_solicitud = s.id
        where s.id='".$id_solicitud."'
        and l.id_situacion not in (2,3)";

        $data = DB::select($cad);
        return $data;
    }

    function getNumeroRevisionBySolicitud($id_solicitud){

        $cad = "select s.id, s.numero_revision, p.codigo from solicitudes s 
        inner join proyectos p on s.id_proyecto = p.id
        where s.id='".$id_solicitud."'";

        $data = DB::select($cad);
        return $data;
    }

    function getLiquidacionByRevision($id, $numero_revision, $codigo){

        $cad = "select s.numero_revision, v.pagado , l.* from liquidaciones l 
        inner join solicitudes s on l.id_solicitud = s.id 
        inner join proyectos p on s.id_proyecto = p.id
        inner join valorizaciones v on l.id = v.pk_registro and v.id_modulo = '7'
        where p.codigo ilike '%".$codigo."%'
        and l.id_situacion is distinct from 3
        and l.id_solicitud is distinct from '".$id."'
        and s.numero_revision < ".$numero_revision."
        and s.estado ='1'
        and l.estado ='1'
        order by s.numero_revision asc";

        $data = DB::select($cad);
        return $data;
    }

    function getSolicitudEdificaciones($id){

        $cad = "select s.id, tm.denominacion estado_solicitud, s.codigo_solicitud, p.codigo,
        (select case when exists (select 1 from liquidaciones l where l.id_solicitud = s.id) then 'Aprobado' else 'Pendiente' end) estado_liquidacion,
        tm2.denominacion tipo_solicitud, tm3.denominacion instancia, p.nombre nombre_proyecto,
        tm6.denominacion id_sitio, p.sitio_descripcion, tm7.denominacion id_zona, p.zona_descripcion, p.parcela, p.super_manzana, tm8.denominacion id_tipo, p.direccion, p.lote, p.sub_lote, p.fila, p.id_ubigeo ubigeo,
        m.denominacion municipalidad, to_char(s.fecha_registro,'dd-mm-yyyy') fecha_registro, to_char(s.created_at,'HH24:MI:SS') hora_registro, tm4.denominacion numero_revision, s.numero_piso, s.numero_sotano, s.azotea, s.semisotano, s.planta_tipica, s.id_resultado 
        from solicitudes s 
        left join proyectos p on s.id_proyecto = p.id
        left join tabla_maestras tm on s.id_resultado = tm.codigo::int and tm.tipo ='118'
        left join tabla_maestras tm2 on s.id_tipo_tramite = tm2.codigo::int and tm2.tipo ='25'
        left join tabla_maestras tm3 on s.id_instancia  = tm3.codigo::int and tm3.tipo ='47'
        inner join tabla_maestras tm4 on s.numero_revision   = tm4.codigo::int and tm4.tipo ='134'
        left join tabla_maestras tm6 on p.id_tipo_sitio = tm6.codigo::int and  tm6.tipo ='33'
        left join tabla_maestras tm7 on p.id_zona = tm7.codigo::int and  tm7.tipo ='34'
        left join tabla_maestras tm8 on p.id_tipo_direccion = tm8.codigo::int and  tm8.tipo ='35'
        inner join municipalidades m on s.id_municipalidad = m.id 
        where s.id='".$id."'";

        $data = DB::select($cad);
        return $data;
    }

    function getSolicitudEdificacionesbyCodigoProyecto($codigo_proyecto){

        $cad = "select s.id, tm.denominacion estado_solicitud,
        (select case when exists (select 1 from liquidaciones l where l.id_solicitud = s.id) then 'Aprobado' else 'Pendiente' end) estado_liquidacion,
        tm2.denominacion tipo_solicitud, tm3.denominacion instancia, p.nombre nombre_proyecto,
        tm6.denominacion id_sitio, p.sitio_descripcion, tm7.denominacion id_zona, p.zona_descripcion, p.parcela, p.super_manzana, tm8.denominacion id_tipo, p.direccion, p.lote, p.sub_lote, p.fila, p.id_ubigeo ubigeo,
        m.denominacion municipalidad, s.id_municipalidad, to_char(s.fecha_registro,'dd-mm-yyyy') fecha_registro, to_char(s.created_at,'HH24:MI:SS') hora_registro, tm4.denominacion numero_revision, s.numero_piso, s.numero_sotano, s.azotea, s.semisotano, s.planta_tipica
        from solicitudes s 
        left join proyectos p on s.id_proyecto = p.id
        left join tabla_maestras tm on s.id_resultado = tm.codigo::int and tm.tipo ='118'
        left join tabla_maestras tm2 on s.id_tipo_tramite = tm2.codigo::int and tm2.tipo ='113'
        left join tabla_maestras tm3 on s.id_instancia  = tm3.codigo::int and tm3.tipo ='47'
        inner join tabla_maestras tm4 on s.numero_revision   = tm4.codigo::int and tm4.tipo ='134'
        left join tabla_maestras tm6 on p.id_tipo_sitio = tm6.codigo::int and  tm6.tipo ='33'
        left join tabla_maestras tm7 on p.id_zona = tm7.codigo::int and  tm7.tipo ='34'
        left join tabla_maestras tm8 on p.id_tipo_direccion = tm8.codigo::int and  tm8.tipo ='35'
        inner join municipalidades m on s.id_municipalidad = m.id 
        where p.codigo = '".$codigo_proyecto."'";

        $data = DB::select($cad);
        return $data;
    }

    function getSolicitudEdificacionesbyNumeroLiquidacion($credipago){

        $cad = "select s.id, tm.denominacion estado_solicitud,
        (select case when exists (select 1 from liquidaciones l where l.id_solicitud = s.id) then 'Aprobado' else 'Pendiente' end) estado_liquidacion,
        tm2.denominacion tipo_solicitud, tm3.denominacion instancia, p.nombre nombre_proyecto,
        tm6.denominacion id_sitio, p.sitio_descripcion, tm7.denominacion id_zona, p.zona_descripcion, p.parcela, p.super_manzana, tm8.denominacion id_tipo, p.direccion, p.lote, p.sub_lote, p.fila, p.id_ubigeo ubigeo,
        m.denominacion municipalidad, s.id_municipalidad, to_char(s.fecha_registro,'dd-mm-yyyy') fecha_registro, to_char(s.created_at,'HH24:MI:SS') hora_registro, tm4.denominacion numero_revision, s.numero_piso, s.numero_sotano, s.azotea, s.semisotano, s.planta_tipica 
        from solicitudes s 
        left join proyectos p on s.id_proyecto = p.id
        left join tabla_maestras tm on s.id_resultado = tm.codigo::int and tm.tipo ='118'
        left join tabla_maestras tm2 on s.id_tipo_tramite = tm2.codigo::int and tm2.tipo ='113'
        left join tabla_maestras tm3 on s.id_instancia  = tm3.codigo::int and tm3.tipo ='47'
        inner join tabla_maestras tm4 on s.numero_revision   = tm4.codigo::int and tm4.tipo ='134'
        left join tabla_maestras tm6 on p.id_tipo_sitio = tm6.codigo::int and  tm6.tipo ='33'
        left join tabla_maestras tm7 on p.id_zona = tm7.codigo::int and  tm7.tipo ='34'
        left join tabla_maestras tm8 on p.id_tipo_direccion = tm8.codigo::int and  tm8.tipo ='35'
        inner join municipalidades m on s.id_municipalidad = m.id 
        where exists (select 1 from liquidaciones l where l.id_solicitud = s.id and l.credipago ='".$credipago."') ";

        $data = DB::select($cad);
        return $data;
    }

    public function listar_aprobaciones_solicitud($id){

        $cad = "select s.id, u.name usuario, to_char(s.fecha_aprobado,'dd-mm-yyyy') fecha_aprobacion, s.observacion nota from solicitudes s 
        inner join users u on s.id_usuario_aprueba = u.id
        where s.id = '".$id."'
        and s.estado = '1' 
        order by s.id desc";
    	//echo $cad;
		$data = DB::select($cad);
        return $data;

    }
    
}
