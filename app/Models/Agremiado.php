<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Agremiado extends Model
{
    use HasFactory;

	protected $fillable = [
        'direccion',
        'email1',
        // Añade aquí todos los campos que necesites asignar en masa
        'nombre',
        'apellido',
        'telefono',
		'id_situacion',
        // ... otros campos
    ];
	
	public function listar_agremiado_ajax($p){
		return $this->readFunctionPostgres('sp_listar_agremiado_paginado',$p);
    }
	
	public function crud_automatico_agremiado_inhabilita_tresm(){
		return $this->readFunctionPostgresTransaction('sp_crud_automatico_agremiado_inhabilita_tresm',[]);
    }

	public function crud_automatico_agremiado_cuota($p){
		return $this->readFunctionPostgresTransaction('sp_crud_automatico_agremiado_cuota',$p);
    }
	
	public function crud_automatico_agremiado_cuota_fecha($p){
		return $this->readFunctionPostgresTransaction('sp_crud_automatico_agremiado_cuota_fecha',$p);
    }

	public function crud_automatico_agremiado_cuota_fecha_individual($p){
		return $this->readFunctionPostgresTransaction('sp_crud_automatico_agremiado_cuota_fecha_individual',$p);
    }

	public function crud_automatico_agremiado_cuota_fecha_rango_individual($p){
		return $this->readFunctionPostgresTransaction('sp_crud_automatico_agremiado_cuota_fecha_rango_individual',$p);
    }

	public function crud_automatico_agremiado_cuota_fecha_inicio_individual($p){
		return $this->readFunctionPostgresTransaction('sp_crud_automatico_agremiado_cuota_fecha_inicio_individual',$p);
    }
	
	public function crud_automatico_agremiado_cuota_vitalicio(){
		return $this->readFunctionPostgresTransaction('sp_crud_automatico_agremiado_cuota_vitalicio',[]);
    }
	
	public function crud_automatico_agremiado_inhabilita_fraccionamiento(){
		return $this->readFunctionPostgresTransaction('sp_crud_automatico_agremiado_inhabilita_fraccionamiento',[]);
    }
	
	public function agremiado_cuota_traslado($op,$id_agremiado,$fecha_ini,$fecha_fin) {
		
        $cad = "Select sp_crud_agremiado_cuota_traslado(?,?,?,?)";
        $data = DB::select($cad, array($op,$id_agremiado,$fecha_ini,$fecha_fin));
        return $data[0]->sp_crud_agremiado_cuota_traslado;
    }
	
	public function agremiado_cuota_extranjero($op,$id_agremiado,$fecha_ini,$fecha_fin) {
		
        $cad = "Select sp_crud_agremiado_cuota_extranjero(?,?,?,?)";
        $data = DB::select($cad, array($op,$id_agremiado,$fecha_ini,$fecha_fin));
        return $data[0]->sp_crud_agremiado_cuota_extranjero;
    }
	
	public function agremiado_cuota_fallecido($op,$id_agremiado,$fecha_fallecido) {
		
        $cad = "Select sp_crud_agremiado_cuota_fallecido(?,?,?)";
        $data = DB::select($cad, array($op,$id_agremiado,$fecha_fallecido));
        return $data[0]->sp_crud_agremiado_cuota_fallecido;
    }
	
	public function agremiado_cuota_suspension($op,$id_agremiado,$fecha_ini,$fecha_fin) {
		
        $cad = "Select sp_crud_agremiado_cuota_suspension(?,?,?,?)";
        $data = DB::select($cad, array($op,$id_agremiado,$fecha_ini,$fecha_fin));
        return $data[0]->sp_crud_agremiado_cuota_suspension;
    }
	
	function getAgremiadoAll(){
		$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,t1.numero_ruc,t2.fecha_colegiado,t3.denominacion situacion, desc_cliente nombre_completo,t1.id_tipo_documento 								
		from personas t1 
		inner join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
		left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'                    
		Where  t1.estado='1' ";
		$data = DB::select($cad);
		
        return $data;
	}
	
	function getEdadAgremiadoById($id){
		$cad = "select date_part('year',age(now(), p.fecha_nacimiento::timestamp))edad 
from agremiados a
inner join personas p on a.id_persona=p.id
where p.estado='1'
and a.estado='1'
and a.id=".$id;

		$data = DB::select($cad);
		
        if(isset($data[0]))return $data[0]->edad;
	}

	function getAgremiadoRLAll(){
		$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,t1.numero_ruc,t2.fecha_colegiado,t3.denominacion situacion, desc_cliente nombre_completo,t1.id_tipo_documento 								
		from personas t1 
		inner join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
		left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'                    
		Where  t1.estado='1' and t2.id_regional ='5' order by t1.apellido_paterno asc";
		$data = DB::select($cad);
		
        return $data;
	}
	
	function getAgremiadoHabilitadoAll(){
		$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,t1.numero_ruc,t2.fecha_colegiado,t3.denominacion situacion, desc_cliente nombre_completo,t1.id_tipo_documento 								
		from personas t1 
		inner join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
		left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'                    
		Where  t1.estado='1' 
		and t2.id_situacion not in(74,83)
		and t2.id_regional ='5'
		order by (t1.apellido_paterno||' '||t1.apellido_materno||' '||t1.nombres) asc";
		$data = DB::select($cad);
		
        return $data;
	}

	function getAgremiado($tipo_documento,$numero_documento){
		//echo $tipo_documento; exit();
        if($tipo_documento=="79"){  //RUC
            $cad = "select t1.id,razon_social,t1.direccion,t1.representante, t1.ruc, t1.email, 79 id_tipo_documento,  trim(t1.ruc) numero_documento_
                    from empresas t1                    
                    Where trim(t1.ruc)='".$numero_documento."' and t1.estado ='1' ";

        }elseif($tipo_documento=="85"){ //NRO_CAP
			
			$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,
			t1.numero_ruc,t2.fecha_colegiado,t3.denominacion situacion, t1.apellido_paterno|| ' ' ||t1.apellido_materno || ', ' || t1.nombres as nombre_completo,85 id_tipo_documento,email1 email, 
			t4.denominacion actividad, t2.numero_regional, r.denominacion regional, t5.denominacion autoriza_tramite, t6.denominacion ubicacion, t7.denominacion categoria, t2.celular1, trim(t2.numero_cap) numero_documento_, t2.celular1 celular, t2.firma 
			from personas t1 
			inner join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
			left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'
			left join tabla_maestras t4 on t2.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'
			inner join regiones r on t2.id_regional = r.id
			left join tabla_maestras t5 on t2.id_autoriza_tramite = t5.codigo::int And t5.tipo ='45'	
			left join tabla_maestras t6 on t2.id_ubicacion = t6.codigo::int And t6.tipo ='63'
			left join tabla_maestras t7 on t2.id_categoria = t7.codigo::int And t7.tipo ='18'
			Where  trim(t2.numero_cap) = trim('".$numero_documento."')
			and t1.estado='1' 
			limit 1";
								
        }else{
			$cad = "select t2.id,t1.id id_p,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,
					t1.numero_ruc,t1.id_tipo_documento,t3.denominacion situacion, t4.denominacion actividad,t1.correo email, trim(t1.numero_documento)  numero_documento_ 			
					from personas t1 
					left join agremiados  t2 on t1.id = t2.id_persona And t2.estado='1'
					left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14'
					left join tabla_maestras t4 on t2.id_actividad_gremial = t4.codigo::int And t4.tipo ='46'                    
					Where  t1.id_tipo_documento='".$tipo_documento."' and trim(t1.numero_documento) = trim('".$numero_documento."') 
					and t1.estado='1' 
					limit 1";
		}
		//echo $cad; exit();
		$data = DB::select($cad);
		
        return $data[0];
    }
	
	function getAgremiadoLiquidacion($numero_documento){
		$cad = "select pr.id_persona, pr.id_empresa, p.id_tipo_documento, p.numero_documento, e.ruc, e.razon_social 
		from liquidaciones l 
		inner join propietarios pr on pr.id_solicitud = l.id_solicitud
		left join personas p on p.id = pr.id_persona 
		left join empresas e  on e.id = pr.id_empresa 
		where 1=1 
		and pr.estado ='1'
		and trim(l.credipago) = '".$numero_documento."'
		limit 1 ";

		/*
		$cad = "select s.id_persona, s.id_empresa, p.id_tipo_documento, p.numero_documento, e.ruc, e.razon_social 
		from liquidaciones l 
		inner join solicitudes s on s.id = l.id_solicitud		
		left join personas p on p.id = s.id_persona 
		left join empresas e  on e.id = s.id_empresa 
		where 1=1 and 
		trim(l.credipago) = '".$numero_documento."'
		limit 1
		";
		*/

		//echo $cad;
		$data = DB::select($cad);
	
        //return $data;
		if(isset($data[0]))return $data[0];
	}

	function getRepresentante($tipo_documento,$numero_documento){

        if($tipo_documento=="79"){  //RUC
            $cad = "select id, ruc numero_documento, razon_social representante, direccion, email 
                    from empresas                     
                    Where ruc='".$numero_documento."'";

        }elseif($tipo_documento=="78"){ //NRO_CAP
			
			$cad = "select id, numero_documento, apellido_paterno ||' '|| apellido_materno ||' '|| nombres representante, direccion, correo email  			
			from personas  
			where id_tipo_documento='".$tipo_documento."' 
			and numero_documento = '".$numero_documento."' and estado='1' ";
		}
		//echo $cad;
		$data = DB::select($cad);
		
        //return $data[0];
		if(isset($data[0]))return $data[0];
    }


	function getAgremiadoDatos($numero_cap){

		$cad = "select a.numero_cap, pe.apellido_paterno || ' ' || pe.apellido_materno ||' '|| pe.nombres agremiado, tm.denominacion situacion, pe.direccion, a.numero_regional, tm2.denominacion actividad_gremial, a.celular1 celular, a.email1 email, a.firma 
		from agremiados a
		inner join personas pe on a.id_persona = pe.id
		inner join tabla_maestras tm on a.id_situacion ::int=tm.codigo::int and tm.tipo='14'
		inner join tabla_maestras tm2 on a.id_actividad_gremial ::int=tm2.codigo::int and tm2.tipo='46'
		where a.numero_cap ='".$numero_cap."'";
						
		//echo $cad;
		$data = DB::select($cad);
		
        return $data[0];
    }

	function getAgremiadoDatosCoordinadorZonal($numero_cap){


		$cad = "select a.numero_cap, pe.numero_documento, pe.apellido_paterno, pe.apellido_materno, pe.nombres from agremiados a
		inner join personas pe on a.id_persona = pe.id
		where a.numero_cap =  '".$numero_cap."'";
		
	//echo $cad;
	$data = DB::select($cad);
	
	return $data[0];
}

	function getAgremiadoDatosRevisorUrbano($numero_cap){

		$cad = "select a.numero_cap, pe.id_tipo_documento tipo_documento, pe.numero_documento, pe.apellido_paterno, pe.apellido_materno, pe.nombres , a.numero_regional, a.id_regional regional, a.fecha_colegiado,a.id_ubicacion ubicacion, a.id_situacion situacion from agremiados a
		inner join personas pe on a.id_persona = pe.id
		where a.numero_cap = '".$numero_cap."'";
		
	//echo $cad;
	$data = DB::select($cad);
	
	return $data[0];
}
	
	function getAgremiadoByIdPersona($id_persona){

        $cad = "select t2.id,t1.numero_documento,t1.nombres,t1.apellido_paterno,t1.apellido_materno,t2.numero_cap,t1.foto,t1.numero_ruc,t2.fecha_colegiado,t3.denominacion situacion,t4.denominacion region 
from personas t1 
left join agremiados t2 on t1.id = t2.id_persona And t2.estado='1'
left join tabla_maestras t3 on t2.id_situacion = t3.codigo::int And t3.tipo ='14' 
inner join regiones t4 on t2.id_regional = t4.id
Where t2.id_persona=".$id_persona;
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }
	
	function getTipoPlaza($id_agremiado){
		
		$cad = "select 
case 
	when date_part('year', CURRENT_DATE)-date_part('year', fecha_colegiado)>=20 then 1
	when date_part('year', CURRENT_DATE)-date_part('year', fecha_colegiado)>5 and 
		 date_part('year', CURRENT_DATE)-date_part('year', fecha_colegiado)<20 then 2
	else 0 
end id_tipo_plaza
from agremiados a 
where id=".$id_agremiado;
		//echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0]->id_tipo_plaza;
		
	}

	function getAgremiadoDatosById($id){
		$cad = "
		select p.id, p.apellido_paterno, p.apellido_materno, p.nombres, a.numero_cap from agremiados a 
		inner join personas p on a.id_persona = p.id
		where a.id='".$id."'";
		$data = DB::select($cad);
		
        return $data;
	}
	
	public function readFunctionPostgres($function, $parameters = null){

      $_parameters = '';
      if (count($parameters) > 0) {
          $_parameters = implode("','", $parameters);
          $_parameters = "'" . $_parameters . "',";
      }
	  $data = DB::select("BEGIN;");
	  $cad = "select " . $function . "(" . $_parameters . "'ref_cursor');";
	  //echo $cad;
	  $data = DB::select($cad);
	  $cad = "FETCH ALL IN ref_cursor;";
	  $data = DB::select($cad);
      return $data;
   }
   
   public function readFunctionPostgresTransaction($function, $parameters = null){
	
      $_parameters = '';
      if (count($parameters) > 0) {
	  		
			foreach($parameters as $par){
				if(is_string($par))$_parameters .= "'" . $par . "',";
				else $_parameters .= "" . $par . ",";
		  	}
			if(strlen($_parameters)>1)$_parameters= substr($_parameters,0,-1);
			
      }

	  $cad = "select " . $function . "(" . $_parameters . ");";
	  $data = DB::select($cad);
	  return $data[0]->$function;
   }

   function getAgremiadoDatosProyectista($numero_cap){

		$cad = "select a.numero_cap, pe.apellido_paterno || ' ' || pe.apellido_materno ||' '|| pe.nombres agremiado, tm.denominacion situacion, pe.direccion, a.numero_regional, tm2.denominacion actividad_gremial, a.celular1 celular, a.email1 email, a.firma 
		from agremiados a
		inner join personas pe on a.id_persona = pe.id
		inner join tabla_maestras tm on a.id_situacion ::int=tm.codigo::int and tm.tipo='14'
		inner join tabla_maestras tm2 on a.id_actividad_gremial ::int=tm2.codigo::int and tm2.tipo='46'
		where a.numero_cap ='".$numero_cap."'";
						
		//echo $cad;
		$data = DB::select($cad);

		if (!empty($data) && isset($data[0])) {
			return $data[0];
		}
	
		return null;
	}

	public function persona()
    {
        return $this->belongsTo(Persona::class, 'id_persona');
    }
   	
}
