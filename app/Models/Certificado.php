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

        $cad = "select c.id , a.numero_cap ,p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres agremiado ,tm.denominacion Tipo_certificado,c.codigo,c.estado,  a.desc_cliente ,a.id_situacion , tms.denominacion situacion,a.fecha_colegiado,a.numero_regional,fecha_emision,p.id_sexo,c.dias_validez 
            from certificados c 
            inner join agremiados a on c.id_agremiado =a.id 
            inner join tabla_maestras tm on c.id_tipo =tm.codigo::int and tm.tipo ='100' 
            inner join tabla_maestras tms on a.id_situacion= tms.codigo::int and  tms.tipo ='14' 
            inner join personas p on p.id =a.id_persona 
            where c.id=". $id .";  ";
    
		$data = DB::select($cad);
        return $data;

    }

    function valida_pago($idagremiado,$serie,$numero,$concepto){

            $cad = "
            select distinct c.id id_comprobante,c.tipo, c.fecha, c.serie, c.numero, c.total, u.name usuario_registro,
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


}

