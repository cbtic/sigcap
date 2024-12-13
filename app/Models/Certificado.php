<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Certificado extends Model
{
    

  

    public function listar_certificado($p){

        return $this->readFuntionPostgres('sp_listar_certificado2_paginado',$p);

    }

	public function getCodigoCertificado($id_tipo){
		
		$cad = "select lpad((count(*)+1)::varchar,5,'0') codigo 
from certificados c where id_tipo=".$id_tipo;
        
		$data = DB::select($cad);
        return $data[0]->codigo;
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

    public function datos_agremiado_certificado($id){

        $cad = "select c.id , a.numero_cap ,p.nombres ||' '||p.apellido_paterno||' '||p.apellido_materno agremiado ,tm.denominacion Tipo_certificado,c.codigo,c.estado,  a.desc_cliente ,a.id_situacion , tms.denominacion situacion,a.fecha_colegiado,a.numero_regional,fecha_emision,p.id_sexo,c.dias_validez,a.email1, tm2.denominacion tipo_tramite, tm3.denominacion categoria, a.id_categoria   
        from certificados c 
        inner join agremiados a on c.id_agremiado =a.id 
        inner join tabla_maestras tm on c.id_tipo =tm.codigo::int and tm.tipo ='100' 
        inner join tabla_maestras tms on a.id_situacion= tms.codigo::int and  tms.tipo ='14' 
        inner join personas p on p.id =a.id_persona
        left join tabla_maestras tm2 on c.id_tipo_tramite= tm2.codigo::int and  tm2.tipo ='44' 
        inner join tabla_maestras tm3 on a.id_categoria = tm3.codigo::int and  tm3.tipo ='18' 
        where c.id=". $id .";  ";
    
		$data = DB::select($cad);
        return $data;

    }

    public function datos_agremiado_certificado1($id){

        $cad = "select c.id, a.numero_cap, p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres agremiado, tm.denominacion Tipo_certificado, c.codigo, c.estado, a.desc_cliente, 
        a.id_situacion, tms.denominacion situacion, a.fecha_colegiado, a.numero_regional, fecha_emision, p.id_sexo, c.dias_validez, t3.denominacion situacion, a.email1, t4.denominacion tipo_proyectista, 
        u.id_departamento, u.id_provincia, u.id_distrito, pro.direccion direccion, pro.lugar lugar, 
        CASE 
            WHEN prop.id_tipo_propietario = '78' THEN (select p2.apellido_paterno||' '||p2.apellido_materno||' '||p2.nombres agremiado from personas p2 where p2.id = prop.id_persona)
            WHEN prop.id_tipo_propietario = '79' THEN (select e.razon_social from empresas e where e.id = prop.id_empresa)
        end as propietario,
        pre.valor_unitario, pre.area_techada, t5.denominacion tipo_obra, 
        (select t6.denominacion tipo_uso from uso_edificaciones ue 
        left join tabla_maestras t6 on ue.id_tipo_uso = t6.codigo::int And t6.tipo ='111' and t6.sub_codigo is null
        where ue.id_solicitud = c.id_solicitud 
        limit 1), 
        --(select t7.denominacion sub_tipo_uso from uso_edificaciones ue left join tabla_maestras t7 on ue.id_sub_tipo_uso = t7.codigo::int And t7.tipo ='111' where ue.id_solicitud = s.id limit 1), 
        --t7.denominacion sub_tipo_uso, 
        c.id_solicitud id_solicitud, pro.nombre nombre_proyecto, s.valor_obra, pre.area_techada, s.id_ubigeo, c.expediente, 
        t8.denominacion tipo_tramite_tipo3, s.numero_piso ,s.sotanos_m2, s.semisotano_m2, s.piso_nivel_m2, s.otro_piso_nivel_m2, s.total_area_techada_m2, pro.zonificacion 
        from certificados c 
        inner join agremiados a on c.id_agremiado =a.id 
        inner join tabla_maestras tm on c.id_tipo =tm.codigo::int and tm.tipo ='100' 
        inner join tabla_maestras tms on a.id_situacion= tms.codigo::int and  tms.tipo ='14'
        left join personas p on p.id =a.id_persona
        left join solicitudes s on c.id_solicitud =s.id
        left join proyectistas pr on s.id_proyectista = pr.id
        left join proyectos pro on s.id_proyecto = pro.id 
        left join ubigeos u on pro.id_ubigeo = u.id_ubigeo
        left join propietarios prop on prop.id_solicitud = s.id 
        left join personas p2 on prop.id_persona = p2.id
        left join presupuestos pre on pre.id_solicitud = s.id 
        --left join uso_edificaciones ue on ue.id_solicitud = s.id
        left join tabla_maestras t3 on a.id_situacion = t3.codigo::int And t3.tipo ='14'
        left join tabla_maestras t4 on pr.id_tipo_profesional = t4.codigo::int And t4.tipo ='41'
        left join tabla_maestras t5 on pre.id_tipo_obra = t5.codigo::int And t5.tipo ='29'
        --left join tabla_maestras t6 on ue.id_tipo_uso = t6.codigo::int And t6.tipo ='30'
        --left join tabla_maestras t7 on ue.id_sub_tipo_uso = t7.codigo::int And t7.tipo ='111' and t7.sub_codigo ='1'
        left join tabla_maestras t8 on c.id_tipo_tramite_tipo3 = t8.codigo::int And t8.tipo ='38' 
        where c.id='". $id ."'";
    
		$data = DB::select($cad);
        return $data;

    }

    public function datos_agremiado_certificado2($id){

        $cad = "select c.id , a.numero_cap ,p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres agremiado ,tm.denominacion Tipo_certificado,c.codigo,c.estado,  a.desc_cliente ,a.id_situacion , tms.denominacion situacion,a.fecha_colegiado,a.numero_regional,fecha_emision,p.id_sexo,c.dias_validez,t3.denominacion situacion,a.email1, t4.denominacion tipo_proyectista, u.id_departamento, u.id_provincia, u.id_distrito, pro.direccion direccion, pro.lugar lugar, 
        CASE 
            WHEN prop.id_tipo_propietario = '78' THEN (select p2.apellido_paterno||' '||p2.apellido_materno||' '||p2.nombres agremiado from personas p2 where p2.id = prop.id_persona)
            WHEN prop.id_tipo_propietario = '79' THEN (select e.razon_social from empresas e where e.id = prop.id_empresa)
        end as propietario,
        pre.valor_unitario, pre.area_techada,t5.denominacion tipo_tramite, t6.denominacion tipo_uso, pro.zonificacion, s.area_total, pro.nombre nombre_proyecto
        from certificados c 
        inner join agremiados a on c.id_agremiado =a.id 
        inner join tabla_maestras tm on c.id_tipo =tm.codigo::int and tm.tipo ='100' 
        inner join tabla_maestras tms on a.id_situacion= tms.codigo::int and  tms.tipo ='14' 
        left join personas p on p.id =a.id_persona
        left join solicitudes s on c.id_solicitud =s.id
        left join proyectistas pr on s.id_proyectista = pr.id
        left join proyectos pro on s.id_proyecto = pro.id 
        left join ubigeos u on pro.id_ubigeo = u.id_ubigeo
        left join propietarios prop on prop.id_solicitud = s.id 
        left join personas p2 on prop.id_persona = p2.id
        left join presupuestos pre on pre.id_solicitud = s.id 
        left join uso_edificaciones ue on ue.id_solicitud = s.id
        left join tabla_maestras t3 on a.id_situacion = t3.codigo::int And t3.tipo ='14'
        left join tabla_maestras t4 on pr.id_tipo_profesional = t4.codigo::int And t4.tipo ='41'
        left join tabla_maestras t5 on pre.id_tipo_obra = t5.codigo::int And t5.tipo ='123'
        left join tabla_maestras t6 on ue.id_tipo_uso = t6.codigo::int And t6.tipo ='124' 
        where c.id='". $id ."'";
    
		$data = DB::select($cad);
        return $data;

    }

    function valida_pago($idagremiado,$serie,$numero,$concepto){

        $cad = "select distinct c.id id_comprobante,c.tipo, c.fecha, c.serie, c.numero, c.total, u.name usuario_registro,
        (select string_agg(DISTINCT coalesce(d.descripcion), ',')  from comprobante_detalles d  where d.id_comprobante = c.id) descripcion
        from comprobantes c
        inner join comprobante_detalles d on d.id_comprobante = c.id
        inner join valorizaciones v on v.id_comprobante = c.id            
        left join users u  on u.id  = c.id_usuario_inserta 
        where v.id_agremido  = " . $idagremiado  . " and c.serie ='" . $serie  . "' and c.numero ='" . $numero  . "' and v.id_concepto =" . $concepto  . "
        order by c.fecha desc";
    
        
        //echo $cad;
		$data = DB::select($cad);
        return $data;
    }

    function getTipoCertificado($id){

        $cad = "select c.id_tipo tipo_certificado 
        from certificados c 
        where c.id= '".$id."'";

        $data = DB::select($cad);
        return $data;
    }

    function getMinMes($id_agremiado,$año){

        $cad = "select min(mes) from agremiado_cuotas ac
        inner join valorizaciones v on ac.id = v.pk_registro and v.id_concepto ='26411'
        where ac.id_agremiado ='".$id_agremiado."' and ac.periodo ='".$año."' and v.pagado ='1'";

        $data = DB::select($cad);
        return $data;
    }

    function getMaxMes($id_agremiado,$año){

        $cad = "select max(mes) from agremiado_cuotas ac
        inner join valorizaciones v on ac.id = v.pk_registro and v.id_concepto ='26411'
        where ac.id_agremiado ='".$id_agremiado."' and ac.periodo ='".$año."' and v.pagado = '1'";

        $data = DB::select($cad);
        return $data;
    }

    function getRecordProyecto($numero_cap){

        $cad = "select s.id, s.fecha_registro fecha, l.credipago, pe.apellido_paterno ||' '|| pe.apellido_materno ||' '|| pe.nombres propietario, pr.nombre nombreProyecto, 
        m.denominacion distrito, a.numero_cap, p2.apellido_paterno ||' '|| p2.apellido_materno ||' '|| p2.nombres agremiado, p2.id_sexo, a.fecha_colegiado, null total_area_techada_m2, null area_total, tm.denominacion tipo_profesional, 'Derecho Revision' tipo
        --case when exists (select 1 from solicitudes s2 where id=s.id) then 'Derecho Revision' else null end tipo
        from solicitudes s --where id_proyectista ='6725'
        left join liquidaciones l on l.id_solicitud = s.id 
        left join propietarios p on p.id_solicitud = s.id 
        left join personas pe on p.id_persona = pe.id
        left join proyectos pr on s.id_proyecto = pr.id 
        left join municipalidades m on s.id_municipalidad = m.id 
        left join proyectistas pro on pro.id_solicitud = s.id
        left join agremiados a on pro.id_agremiado = a.id
        left join personas p2 on a.id_persona = p2.id
        left join tabla_maestras tm on pro.id_tipo_profesional = tm.codigo::int And tm.tipo ='41'
        where a.numero_cap ='".$numero_cap."'
        union all
        select s.id, s.fecha_registro fecha, l.credipago, pe.apellido_paterno ||' '|| pe.apellido_materno ||' '|| pe.nombres propietario, pr.nombre nombreProyecto, 
        m.denominacion distrito, a.numero_cap, p2.apellido_paterno ||' '|| p2.apellido_materno ||' '|| p2.nombres agremiado, p2.id_sexo, a.fecha_colegiado, s.total_area_techada_m2::float, s.area_total, tm.denominacion tipo_profesional, 'Certificado' tipo
        from certificados c 
        inner join solicitudes s on c.id_solicitud = s.id
        left join liquidaciones l on l.id_solicitud = s.id 
        left join propietarios p on p.id_solicitud = s.id 
        left join personas pe on p.id_persona = pe.id
        left join proyectos pr on s.id_proyecto = pr.id 
        left join municipalidades m on s.id_municipalidad = m.id 
        left join proyectistas pro on pro.id_solicitud = s.id
        left join agremiados a on pro.id_agremiado = a.id
        left join personas p2 on a.id_persona = p2.id
        left join tabla_maestras tm on pro.id_tipo_profesional = tm.codigo::int And tm.tipo ='41'
        where a.numero_cap ='".$numero_cap."'
        union all
        select ch.id, ch.fecha, ch.numero_certificado credipago, ch.propietario, ch.nombre_proyecto, ch.distrito, ch.numero_cap, p.apellido_paterno ||' '|| p.apellido_materno ||' '|| p.nombres agremiado, p.id_sexo, a.fecha_colegiado, ch.area_construida, ch.area_lote, ch.tip_proyectista, ch.tipo from certificado_historicos ch 
        inner join agremiados a on ch.numero_cap = a.numero_cap 
        inner join personas p on a.id_persona = p.id 
        where a.numero_cap ='".$numero_cap."'
        order by fecha asc";

        $data = DB::select($cad);
        return $data;
    }

    public function datos_agremiado_certificado_unico($id){

        $cad = "select c.id , a.numero_cap ,p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres agremiado ,tm.denominacion Tipo_certificado,c.codigo,c.estado,  a.desc_cliente ,a.id_situacion , tms.denominacion situacion,a.fecha_colegiado,a.numero_regional,fecha_emision,p.id_sexo,c.dias_validez,a.email1, tm2.denominacion tipo_tramite  
        from certificados c 
        inner join agremiados a on c.id_agremiado =a.id 
        inner join tabla_maestras tm on c.id_tipo =tm.codigo::int and tm.tipo ='100' 
        inner join tabla_maestras tms on a.id_situacion= tms.codigo::int and  tms.tipo ='14' 
        inner join personas p on p.id =a.id_persona
        left join tabla_maestras tm2 on c.id_tipo_tramite= tm2.codigo::int and  tm2.tipo ='44' 
        where c.id='". $id ."'";
    
		$data = DB::select($cad);
        return $data;

    }

}

