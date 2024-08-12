<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PeriodoComisione;
use App\Models\PeriodoComisionDetalle;
use Carbon\Carbon;
use App\Models\TablaMaestra;
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
		$tablaMaestra_model = new TablaMaestra;
		$periodoComision = new PeriodoComisione;
		
        $tipo = $tablaMaestra_model->getMaestroByTipo(101);
        return view('frontend.periodoComision.all',compact('periodoComision','tipo'));

    }

    public function listar_consulta_periodoComision_ajax(Request $request){
	
		$periodoComision_model = new PeriodoComisione;
		$p[]=$request->descripcion;
		$p[]=$request->tipo;
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
		$tablaMaestra_model = new TablaMaestra;
		//$regione_model = new Regione;
		//$tablaMaestra_model = new TablaMaestra;
		//$tipo_afectacion = $tablaMaestra_model->getMaestroByTipo(53);
		//$moneda = $tablaMaestra_model->getMaestroByTipo(1);

		if($id>0){
			$periodoComision = PeriodoComisione::find($id);
		}else{
			$periodoComision = new PeriodoComisione;
		}
		
		$tipo_concurso = $tablaMaestra_model->getMaestroByTipo(101);
		//$region = $regione_model->getRegionAll();



		$listaPeriodoComisionDetalle = PeriodoComisionDetalle::where([
            'id_periodo_comision' => $id
        ])->where('estado', '=', '1')->orderBy("id","asc")->get();

		
		return view('frontend.periodoComision.modal_periodoComision_nuevoPeriodoComision',compact('id','periodoComision','tipo_concurso','listaPeriodoComisionDetalle'));
	
	}

    public function send_periodoComision_nuevoPeriodoComision(Request $request){
		
		/*$request->validate([
			'fecha_inicio'=>'required',
			'fecha_fin'=>'required',
		]
		);*/
		//print("asdasd");exit();

		$periodoActivo = PeriodoComisione::where("activo", 1)->where("estado", "1")->first();

		
		if ($periodoActivo) {
			
			$periodoActivo->activo = 0;
			$periodoActivo->save();
		}

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$periodoComision = new PeriodoComisione;
			//$codigo = $Concepto_model->getCodigoConcepto();
		}else{
			$periodoComision = PeriodoComisione::find($request->id);
			//$codigo = $request->codigo;
		}
		

		$fecha_ini = Carbon::parse($request->fecha_inicio);
		$periodo_dia_ini = $fecha_ini->day;
		$periodo_mes_ini = $fecha_ini->month;
		$periodo_año_ini = $fecha_ini->year;
		$fecha_fi = Carbon::parse($request->fecha_fin);
		$periodo_dia_fin = $fecha_fi->day;
		$periodo_mes_fin = $fecha_fi->month;
		$periodo_año_fin= $fecha_fi->year;
		$periodoComision->descripcion = $periodo_dia_ini.'/'.$periodo_mes_ini.'/'.$periodo_año_ini.' - '.$periodo_dia_fin.'/'.$periodo_mes_fin.'/'.$periodo_año_fin;
        $periodoComision->fecha_inicio = $request->fecha_inicio;
        $periodoComision->fecha_fin = $request->fecha_fin;
		$periodoComision->activo = $request->fijar_periodo;
		$periodoComision->id_tipo_concurso = $request->tipo;
		$fecha_actual = Carbon::now()->format('Y-m-d');
		
		/*if(($fecha_actual >= $request->fecha_inicio) && ($fecha_actual <= $request->fecha_fin)) {
			$periodoComision->estado = 1;		
		}else{
			$periodoComision->estado = 0;	
		}*/

		if(($fecha_actual >= $request->fecha_inicio) && ($fecha_actual <= $request->fecha_fin)) {
			$periodoComision->estado = 1;
		}else{
			$periodoComision->estado = 0;
		}

		//print_r($fecha_actual);exit();

		//print_r($periodoComision->estado);
		//print_r($request->fecha_inicio);
		//print_r($request->fecha_fin);
		//$periodoComision->id_usuario = 1;
		//$periodoComision->estado = 1;
		$periodoComision->id_usuario_inserta = $id_user;
		$periodoComision->save();

		$idPeriodoComision= $periodoComision->id;



		$periodoComision_model = new PeriodoComisione;
		$resultado = $periodoComision_model->actualizarInactivoPeriodoComisionDertalle($idPeriodoComision);

		$comienzo = Carbon::parse($request->fecha_inicio);
		$final = Carbon::parse($request->fecha_fin);
		
		for($i = $comienzo; $i <= $final; $i->modify('+1 month')){
			//echo $i->format("Ym") . "\n";
			$perido_d = $i->format("Ym");
			$periodoComisionDetalle = PeriodoComisionDetalle::where("id_periodo_comision", $idPeriodoComision)->where("denominacion", $perido_d)->first();
			print_r($periodoComisionDetalle);exit();

			if ($periodoComisionDetalle){
				$periodoComisionDet = new PeriodoComisionDetalle;

			}else{
				$periodoComisionDet = PeriodoComisionDetalle::find($periodoComisionDetalle->id);
			}

			$periodoComisionDet->id_periodo_comision = $idPeriodoComision;
			$periodoComisionDet->denominacion = $perido_d;
			$periodoComisionDet->estado = "1";
			$periodoComisionDet->activo = "0";
			$periodoComisionDet->id_usuario_inserta = $id_user;
			$periodoComisionDet->save();

		}

    }

	public function eliminar_periodoComision($id,$estado)
    {
		$periodoComision = PeriodoComisione::find($id);
		$periodoComision->estado = $estado;
		$periodoComision->save();

		echo $periodoComision->id;

    }

	public function actualizarEstadoPeriodoComision()
    {
		$periodoComision_model = new PeriodoComisione;

		$periodoComision_model->actualizarActivoPeriodoComision();
		$periodoComision_model->actualizarInactivoPeriodoComision();
    }
}
