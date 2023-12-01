<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Multa;
use App\Models\Multa_concepto;
use App\Models\Moneda;
use App\Models\Valorizacione;
use App\Models\AgremiadoMulta;
use App\Models\Agremiado;
use Carbon\Carbon;
use Auth;

class MultaController extends Controller
{
    function consulta_multa(){
        
        return view('frontend.multa.all');

    }

    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function listar_datosAgremiado_ajax(Request $request){
	
		$multa_model = new Multa;
		$p[]="";
		$p[]=$request->numero_cap;
		$p[]=$request->numero_documento;
		$p[]=$request->agremiado;
        $p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $multa_model->listar_datosAgremiado_ajax($p);
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

	public function listar_historialMulta_ajax(Request $request){
	
		$historialMulta_model = new Multa;
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $historialMulta_model->listar_historialMulta_ajax($p);
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

    public function editar_multa($id){
        
		$multa = Multa::find($id);
		$id_multa = $multa->id_multa;
		$multa = Multa::find($id_multa);

		$agremiado = Multa::find($id);
		$numero_cap = $agremiado->numero_cap;
		$agremiado = Multa::find($numero_cap);
		
        $multa_model = new Multa;
		//print_r($agremiado).exit();
		
		return view('frontend.multa.create',compact('agremiado','periodo','concepto','moneda','importe','fecha_inicio','fecha_fin','estado'));
		
    }

    public function modal_multa_nuevoMulta($id){
		
		//$id->moneda;
		$multa = new Multa;
        $multa_concepto_model = new Multa_concepto;
		$moneda_model = new Moneda;
		
		
		if($id>0){
			$agremiadoMulta = AgremiadoMulta::find($id);
			$id_agremiado = $agremiadoMulta->id_agremiado;
			$agremiado = Agremiado::find($id_agremiado);
			$numero_cap = $agremiado->numero_cap;
		}else{
			$agremiadoMulta = new AgremiadoMulta;
			$id_agremiado = "";
			$agremiado = new Agremiado;
			$numero_cap = "";
		}
		
        $multa = $multa_concepto_model->getMulta_conceptoAll();
		$moneda = $moneda_model->getMonedaAll();
		
		//$multa = Multa::where("estado","1")->get();
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.multa.modal_multa_nuevoMulta',compact('id','id_agremiado','agremiado','numero_cap','agremiadoMulta','multa','moneda'));
	
	}

	public function modal_multa_historialMulta($id){
		
		$historialMulta = new Multa;
		
		if($id>0){
			$historialMulta = Multa::find($id);
		}else{
			$historialMulta = new Multa;
		}
		
		//$multa = Multa::where("estado","1")->get();
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.multa.modal_multa_historialMulta',compact('id','historialMulta'));
	}

    public function send_multa_nuevoMulta(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$agremiadoMulta = new AgremiadoMulta;
		}else{
			$agremiadoMulta = AgremiadoMulta::find($request->id);
		}
		
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		
		$agremiadoMulta->id_agremiado = $agremiado->id;
		$agremiadoMulta->id_multa = $request->id_multa;
		$agremiadoMulta->fecha = Carbon::now()->format('Y-m-d');
		$agremiadoMulta->id_estado_pago = 1;
		$agremiadoMulta->id_concepto = 29;
		$agremiadoMulta->periodo = $request->periodo;
		$agremiadoMulta->estado = 1;
		$agremiadoMulta->id_usuario_inserta = $id_user;
		$agremiadoMulta->save();
		
		$id_multa = $agremiadoMulta->id;
		
		$multa = Multa::find($request->id_multa);
		
		$valorizacion = new Valorizacione;
		$valorizacion->id_modulo = 3;
		$valorizacion->pk_registro = $id_multa;
		$valorizacion->id_concepto = 29;
		$valorizacion->id_agremido = $agremiado->id;
		$valorizacion->id_persona = $agremiado->id_persona;
		$valorizacion->monto = $multa->monto;
		$valorizacion->id_moneda = $multa->id_moneda;
		$valorizacion->fecha = Carbon::now()->format('Y-m-d');
		$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
		//$valorizacion->estado = 1;
		$valorizacion->id_usuario_inserta = $id_user;
		$valorizacion->save();
    }

	public function eliminar_multa($id,$estado)
    {
		$agremiadoMulta = AgremiadoMulta::find($id);
		//$multa = Multa::find($id);
		//print_r($agremiadoMulta->id).exit();
		$agremiadoMulta->estado = $estado;
		$agremiadoMulta->save();

		echo $agremiadoMulta->id;
    }
}
