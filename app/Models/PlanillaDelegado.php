<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class PlanillaDelegado extends Model
{
    use HasFactory;

	function getPlanillaDelegadoDetalleByIdPlanilla($id){

        $cad = "select p.apellido_paterno||' '||p.apellido_materno||' '||p.nombres delegado,c.denominacion municipalidad,pdd.*
from planilla_delegados pd
inner join planilla_delegado_detalles pdd on pd.id=pdd.id_planilla  
inner join agremiados a on pdd.id_agremiado=a.id
inner join personas p on a.id_persona=p.id 
inner join comisiones c on pdd.id_comision=c.id
where pd.id=".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	
	function getMonto($id_tipo_reintegro,$id_comision,$id_periodo,$mes){

		if($id_tipo_reintegro==1){
        	$cad = "select monto 
from comision_movilidades cm 
where id_municipalidad_integrada=(select id_municipalidad_integrada from comisiones c where id=".$id_comision.") 
and id_periodo_comisiones=".$id_periodo."
and estado='1'";
		}
		
		if($id_tipo_reintegro==2){
        	$cad = "select importe_sesion monto
from planilla_delegados 
where periodo=(select to_char(fecha_fin,'yyyy') from periodo_comisiones pc where id=".$id_periodo.")::int
and mes=".$mes."::int 
and id_periodo_comision=".$id_periodo."
and estado='1'";
		}
		
		if($id_tipo_reintegro==3){
			$cad = "select ((0.10)*valor_uit::decimal)monto 
from parametros p where anio=(select to_char(fecha_fin,'yyyy') from periodo_comisiones pc where id=".$id_periodo.") and estado='1';";
			//echo $cad;
		}
		//echo $cad;
		$data = DB::select($cad);
        if(isset($data[0]))return $data[0]->monto;
    }
	
	public function generar_planilla_delegado($id_periodo,$anio,$mes) {
		
        $cad = "Select sp_planilla_delegado(?,?,?)";
        $data = DB::select($cad, array($id_periodo,$anio,$mes));
        return $data[0]->sp_planilla_delegado;
    }
	
	function getSaldoDelegadoFondoComun($id_periodo,$anio,$mes){

        $cad = "select sum(t1.saldo)::decimal saldo
	from delegado_fondo_comuns t1               
	inner join ubigeos t3 on t3.id_ubigeo = t1.id_ubigeo
	inner join periodo_comision_detalles t4 on t4.id_periodo_comision = t1.id_periodo_comision and t4.id = t1.id_periodo_comision_detalle 
	Where EXTRACT(YEAR FROM t4.fecha)::varchar = '".$anio."'
	And EXTRACT(MONTH FROM t4.fecha)::varchar = '".$mes."'::int::varchar
	/*And t1.id_periodo_comision = '".$id_periodo."'::int*/";
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }
	
	public function getGenerarAsientoPlanilla($asiento,$id_periodo,$anio,$mes) {
		
        $cad = "Select sp_generar_asiento_planilla(?,?,?,?)";
        $data = DB::select($cad, array($asiento, $id_periodo,$anio,$mes));
        return $data[0]->sp_generar_asiento_planilla;
    }
    
	    
}
