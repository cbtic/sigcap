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
/*
        $cad = "select t3.desc_ubigeo municipalidad,sum(round(t1.importe_bruto::numeric,2))importe_bruto, sum(round(t1.importe_igv::numeric,2))importe_igv, sum(round(t1.importe_comision_cap::numeric,2))importe_comision_cap, sum(round(t1.importe_fondo_asistencia::numeric,2))importe_fondo_asistencia, sum(round(t1.saldo::numeric,2))saldo, t3.id_ubigeo 
        from delegado_fondo_comuns t1
        --inner join municipalidades t3 on t3.id = t1.id_municipalidad
        inner join ubigeos t3 on t3.id_ubigeo = t1.id_ubigeo
        inner join periodo_comision_detalles t4 on t4.id_periodo_comision = t1.id_periodo_comision and t4.id = t1.id_periodo_comision_detalle
        group by  fecha, desc_ubigeo, t3.id_ubigeo 
        having EXTRACT(YEAR FROM t4.fecha)::varchar = '".$anio."'
        And EXTRACT(MONTH FROM t4.fecha)::varchar = '".$mes."'  
        order by 1 asc         
    ";
*/

 
$cad = "select t3.denominacion municipalidad, sum(t1.importe_bruto::numeric)importe_bruto, sum(t1.importe_igv::numeric)importe_igv, 
            sum(t1.importe_comision_cap::numeric)importe_comision_cap, sum(t1.importe_fondo_asistencia::numeric)importe_fondo_asistencia, 
            sum(t1.saldo::numeric)saldo, t3.id_ubigeo 
        from delegado_fondo_comuns t1
            inner join municipalidades t3 on t1.id_ubigeo::int = t3.id
            inner join periodo_comision_detalles t4 on t4.id_periodo_comision = t1.id_periodo_comision and t4.id = t1.id_periodo_comision_detalle
        where 
            EXTRACT(YEAR FROM t4.fecha)::varchar = '".$anio."'
            And EXTRACT(MONTH FROM t4.fecha)::varchar = '".$mes."'  
        group by  t1.id, t3.id 
        order by 1 asc";
/*
$cad = "select t3.desc_ubigeo municipalidad, sum(t1.importe_bruto::numeric)importe_bruto, sum(t1.importe_igv::numeric)importe_igv, 
sum(t1.importe_comision_cap::numeric)importe_comision_cap, sum(t1.importe_fondo_asistencia::numeric)importe_fondo_asistencia, 
sum(t1.saldo::numeric)saldo, t3.id_ubigeo 
from delegado_fondo_comuns t1
inner join ubigeos t3 on t3.id_ubigeo = t1.id_ubigeo
inner join periodo_comision_detalles t4 on t4.id_periodo_comision = t1.id_periodo_comision and t4.id = t1.id_periodo_comision_detalle
group by  fecha, desc_ubigeo, t3.id_ubigeo 
having EXTRACT(YEAR FROM t4.fecha)::varchar = '".$anio."'
And EXTRACT(MONTH FROM t4.fecha)::varchar = '".$mes."'  
order by 1 asc  
";
*/
    /*
        $cad = "select t3.desc_ubigeo municipalidad,round(t1.importe_bruto::numeric,2)importe_bruto, round(t1.importe_igv::numeric,2)importe_igv, round(t1.importe_comision_cap::numeric,2)importe_comision_cap, round(t1.importe_fondo_asistencia::numeric,2)importe_fondo_asistencia, round(t1.saldo::numeric,2)saldo
                from delegado_fondo_comuns t1
                --inner join municipalidades t3 on t3.id = t1.id_municipalidad
                inner join ubigeos t3 on t3.id_ubigeo = t1.id_ubigeo
                inner join periodo_comision_detalles t4 on t4.id_periodo_comision = t1.id_periodo_comision and t4.id = t1.id_periodo_comision_detalle 
            Where EXTRACT(YEAR FROM t4.fecha)::varchar = '".$anio."'
            And EXTRACT(MONTH FROM t4.fecha)::varchar = '".$mes."'           
            ";
*/
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

    function ListarDetalleFondoComun($id_ubigeo ,$anio, $mes){

        //$mes= intval($mes);

       // $cad = "select m.denominacion municipalidad, c.serie, c.numero, c.fecha_pago, l.total monto, l.credipago, v.descripcion   
        $cad = "select m.denominacion municipalidad, c.serie, c.numero, c.fecha_pago, l.credipago, v.descripcion, c.tipo,
        case 
            when c.tipo='NC' then l.total * -1 else l.total end as monto, 
        CASE 
            WHEN c.destinatario_2 IS NOT NULL AND c.destinatario_2 <> '' THEN c.destinatario_2
            ELSE c.destinatario
        END AS destinatario_final,
        CASE 
            WHEN c.destinatario_2 IS NOT NULL AND c.destinatario_2 <> '' THEN c.cod_tributario_2 
            ELSE c.cod_tributario 
        END AS destinatario_documento_final
        from valorizaciones v
        inner join comprobantes c on v.id_comprobante = c.id
        inner join liquidaciones l on v.pk_registro = l.id
        inner join solicitudes s on l.id_solicitud = s.id
        inner join municipalidades m on s.id_municipalidad = m.id
        where m.id_ubigeo = '".$id_ubigeo."' and s.id_tipo_solicitud ='123'
        and EXTRACT(YEAR FROM c.fecha_pago)::varchar = '".$anio."'
        and EXTRACT(MONTH FROM c.fecha_pago)::varchar = '".$mes."'
        and v.id_modulo ='7'
        and l.id_situacion = 2
        order by c.fecha";
        //echo($cad);        
		$data = DB::select($cad);
        return $data;
    }
}
