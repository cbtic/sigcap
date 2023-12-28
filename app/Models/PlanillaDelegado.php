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
inner join comision_delegados cd on pdd.id_comision_delegado=cd.id 
inner join agremiados a on cd.id_agremiado=a.id
inner join personas p on a.id_persona=p.id 
inner join comisiones c on cd.id_comision=c.id
where pd.id=".$id;
		//echo $cad;
		$data = DB::select($cad);
        return $data;
    }
	    
}
