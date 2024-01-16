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
	
	public function generar_planilla_delegado($anio,$mes) {
		
        $cad = "Select sp_planilla_delegado(?,?)";
        $data = DB::select($cad, array($anio,$mes));
        return $data[0]->sp_planilla_delegado;
    }
	
	function getSaldoDelegadoFondoComun($anio,$mes){

        $cad = "select sum(d.saldo)::decimal saldo
	from delegado_fondo_comuns d
	inner join periodo_delegado_detalles p on p.id = d.id_periodo_delegado_detalle and p.id_periodo_delegado = d.id_periodo_delegado   
	where extract(year from p.fecha)::varchar = '".$anio."'
	and extract(month from  p.fecha)::varchar = '".$mes."'::int::varchar; ";
		//echo $cad;
		$data = DB::select($cad);
        return $data[0];
    }
	
	    
}
