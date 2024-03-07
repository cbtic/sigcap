<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RevisorUrbano;
use App\Models\TablaMaestra;
use App\Models\Agremiado;
use App\Models\Persona;
use App\Models\Regione;
use App\Models\Valorizacione;
use App\Models\Concepto;
use Carbon\Carbon;

use Auth;

class RevisorUrbanoController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_revisorUrbano(){

        $tablaMaestra_model = new TablaMaestra;
		$agremiado = new Agremiado;
        $persona = new Persona;
        $regione_model = new Regione;
        $region = $regione_model->getRegionAll();
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo(110);
        $ubicacion_cliente = $tablaMaestra_model->getMaestroByTipo(63);
        $situacion_cliente = $tablaMaestra_model->getMaestroByTipo(14);
		$situacion_venta = $tablaMaestra_model->getMaestroByTipo(92);

        return view('frontend.revisorUrbano.all',compact('agremiado','persona','tipo_documento','region','ubicacion_cliente','situacion_cliente','situacion_venta'));
    }

    public function listar_revisorUrbano_ajax(Request $request){
	
		$revisorUrbano_model = new RevisorUrbano;
		$p[]=$request->numero_cap;
		$p[]=$request->agremiado;//$request->ruc;
		$p[]="";
		$p[]="";
		$p[]=$request->codigo_itf;
        $p[]=$request->codigo_ru;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $revisorUrbano_model->listar_revisorUrbano_ajax($p);
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

    public function modal_revisorUrbano_nuevoRevisorUrbano($id){
		
		$revisorUrbano = new RevisorUrbano;
		
		if($id>0){
			$revisorUrbano = RevisorUrbano::find($id);
		}else{
			$revisorUrbano = new RevisorUrbano;
		}
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.revisorUrbano.modal_revisorUrbano_nuevoRevisorUrbano',compact('id','revisorUrbano'));
	
	}
	
	public function send_revisor_urbano(Request $request){
		
		$id_user = Auth::user()->id;
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$revisor_existe = RevisorUrbano::where("codigo_itf",$request->codigo_itf)->where("estado","1")->get();
		$mensaje = "";
		
		if($agremiado){
		
			if(count($revisor_existe)==0){
				
				$revisorUrbano_model = new RevisorUrbano;
				$codigo_ru = $revisorUrbano_model->getCodigoRU();
				
				$revisorUrbano = new RevisorUrbano;
				$revisorUrbano->id_agremiado = $agremiado->id;
				$revisorUrbano->codigo_itf = $request->codigo_itf;
				$revisorUrbano->codigo_ru = $codigo_ru;
				$revisorUrbano->estado = 1;
				$revisorUrbano->id_usuario_inserta = $id_user;
				$revisorUrbano->save();

				$concepto = Concepto::where("id",26523)->where("estado","1")->first();

				$valorizacion = new Valorizacione;
				$valorizacion->id_modulo = 8;
				$valorizacion->pk_registro = $revisorUrbano->id;
				$valorizacion->id_concepto = 26523;
				$valorizacion->id_agremido = $agremiado->id;
				$valorizacion->id_persona = $agremiado->id_persona;
				$valorizacion->monto = $concepto->importe;
				$valorizacion->id_moneda = $concepto->id_moneda;
				$valorizacion->fecha = Carbon::now()->format('Y-m-d');
				$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
				$valorizacion->descripcion = $concepto->denominacion." - ".$request->codigo_itf;
				//$valorizacion->estado = 1;
				//print_r($valorizacion->descripcion).exit();
				$valorizacion->id_usuario_inserta = $id_user;
				$valorizacion->save();
				
			}else{
				$mensaje = "El Codigo ITF ya se encuentra registrado";
			}
		}else{
			$mensaje = "El Numero de CAP no existe";
		}
		
		$result["mensaje"] = $mensaje;
		echo json_encode($result);
		
	}
	

}
