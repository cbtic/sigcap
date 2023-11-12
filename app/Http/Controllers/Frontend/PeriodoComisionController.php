<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodoComisione;
use Carbon\Carbon;
use Auth;

class PeriodoComisionController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_periodoComision(){

		//$tablaMaestra_model = new TablaMaestra;
		$periodoComision = new PeriodoComisione;
        //$tipo_afectacion = $tablaMaestra_model->getMaestroByTipo(53);
        return view('frontend.periodoComision.all',compact('periodoComision'));

    }

    public function listar_consulta_periodoComision_ajax(Request $request){
	
		$periodoComision_model = new PeriodoComisione;
		$p[]=$request->descripcion;
		$p[]=$request->fecha_inicio;//$request->nombre;
		$p[]=$request->fecha_fin;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $periodoComision_model->listar_consulta_periodoComision_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;

		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

		echo json_encode($result);
	}

    public function editar_periodoComision($id){
        
		$periodoComision = PeriodoComisione::find($id);
		//$prontoPago = ProntoPago::find($id);
		$id_periodoComision = $periodoComision->id_periodoComision;
		$periodoComision = PeriodoComisione::find($id_periodoComision);
		
        $periodoComision_model = new PeriodoComisione;
		//$tablaMaestra_model = new TablaMaestra;
		//$id_concepto = $concepto->id_concepto;
		//$concepto = Concepto::find($id_concepto);
		//$tipo_afectacion = $tablaMaestra_model->getMaestroByTipo(53);
        //$concepto_model = new concepto;
 
		return view('frontend.periodoComision.create',compact('id','descripcion','fecha_inicio','fecha_fin','estado'));
		
    }

    public function modal_periodoComision_nuevoPeriodoComision($id){
		
		$periodoComision = new PeriodoComisione;
		//$regione_model = new Regione;
		//$tablaMaestra_model = new TablaMaestra;
		//$tipo_afectacion = $tablaMaestra_model->getMaestroByTipo(53);
		//$moneda = $tablaMaestra_model->getMaestroByTipo(1);

		if($id>0){
			$periodoComision = PeriodoComisione::find($id);
		}else{
			$periodoComision = new PeriodoComisione;
		}
		
		//$region = $regione_model->getRegionAll();
		
		return view('frontend.periodoComision.modal_periodoComision_nuevoPeriodoComision',compact('id','periodoComision'));
	
	}

    public function send_periodoComision_nuevoPeriodoComision(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$periodoComision = new PeriodoComisione;
			//$codigo = $Concepto_model->getCodigoConcepto();
		}else{
			$periodoComision = PeriodoComisione::find($request->id);
			//$codigo = $request->codigo;
		}

		$fecha = Carbon::parse($request->fecha_inicio);
		$periodo_mes = $fecha->month;
		$periodo_año = $fecha->year;
		$periodoComision->descripcion = $periodo_mes.'/'.$periodo_año;
        $periodoComision->fecha_inicio = $request->fecha_inicio;
        $periodoComision->fecha_fin = $request->fecha_fin;
		$periodoComision->id_usuario = 1;
		$periodoComision->estado = 1;
		$periodoComision->id_usuario_inserta = $id_user;
		$periodoComision->save();
    }

	public function eliminar_periodoComision($id,$estado)
    {
		$periodoComision = PeriodoComisione::find($id);
		$periodoComision->estado = $estado;
		$periodoComision->save();

		echo $periodoComision->id;

    }
}
