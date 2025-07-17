<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AfiliacionSeguro;
use App\Models\Agremiado;
use App\Models\seguro_afiliado_parentesco;
use Illuminate\Http\Request;
use App\Models\Seguro_afiliado;
use App\Models\SegurosPlane;
use App\Models\Regione;
use App\Models\Seguro;
use App\Models\Ubigeo;
use App\Models\TablaMaestra;
use App\Models\Valorizacione;
use Carbon\Carbon;
use Auth;


class AfiliacionSeguroController extends Controller
{
    function consulta_afiliacion_seguro(){

        return view('frontend.afiliacion_seguro.all');
    }

    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    //
    public function listar_afiliacion_seguro(Request $request){
	
		$afiliacionseguro_model = new Seguro_afiliado();
		$p[]=$request->cap;
        $p[]=$request->nombre;
        $p[]=$request->seguro;
		$p[]=$request->estado;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;  
		$data = $afiliacionseguro_model->listar_afiliacion_seguro($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;

    

		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

        //print_r(json_encode($result)); exit();
		echo json_encode($result);

	
	}

    public function listar_parentesco(Request $request){
	
		$parentesco_model = new Seguro_afiliado();

		

		$p[]=$request->id_afilliacion;
		$p[]=$request->estado;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $parentesco_model->listar_parentesco($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;

		//print_r($data); exit();
		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;
		
       // print_r(json_encode($p)); exit();
		echo json_encode($result);

		//return view('frontend.afiliacion_seguro.modal_parentesco',compact('result'));
	
	}

    public function editar_municipalidad($id){
        
		$municipalidad = Seguro::find($id);
		$id_municipalidad = $$municipalidad->id;
		$municipalidad = Seguro::find($id);
		
		
		return view('frontend.empresa.create',compact('ruc','nombre_comercial','razon_social','direccion','representante','estado'));
		
    }

    public function modal_afiliado($id){
		$id_user = Auth::user()->id;
		$afiliado_model = new Seguro_afiliado;
		
		if($id>0)  {
			$afiliado=Seguro_afiliado::find($id);

			$datosafiliado=$afiliado_model->datos_afiliacion_seguro($id);

			$cap_numero=$datosafiliado[0]->numero_cap;
			$desc_cliente=$datosafiliado[0]->agremiado;
			$situacion=$datosafiliado[0]->situacion;
			$id_seguro=$datosafiliado[0]->id_seguro;
			$id_plan = $datosafiliado[0]->id_seguro;
		} 
		else{
			$afiliado = new Seguro_afiliado;
			$cap_numero="";
			$desc_cliente="";
			$situacion="";
			$id_seguro="";
			$fecha=Carbon::now()->format('Y-m-d');
		} 

		$seguro_model = new Seguro;
		$seguro = $seguro_model->getSeguroAll();

	
		//print_r ($id_plan);
		//exit();
		//print_r ($numero_cap);exit();
	
		return view('frontend.afiliacion_seguro.modal_afiliado',compact('id','afiliado','seguro','cap_numero','desc_cliente','situacion','id_seguro'));

    }

	public function modal_parentesco($id){
		
		$id_user = Auth::user()->id;
	
        //$seguro_parentesco=seguro_afiliado_parentesco::where('id_afiliacion', $id)->where('estado', '1')->get()->all();
		
		$datos_model= new seguro_afiliado_parentesco();
		$datos_seguro_agremiado=$datos_model->getDatosSeguro_act($id);


		return view('frontend.afiliacion_seguro.modal_parentesco',compact('id',/*'seguro_parentesco',*/'datos_seguro_agremiado'));

    }

	public function send_parentesco_fila(Request $request){
		$id_user = Auth::user()->id;
		//print_r ($id_user);exit();
        //print_r ($request);exit();
        
		if($request->id == 0){
			$afiliacion = new seguro_afiliado_parentesco();
			$afiliacion->id_usuario_inserta = $id_user;
		}else{
			$afiliacion =seguro_afiliado_parentesco::find($request->id);
			$afiliacion->id_usuario_actualiza = $id_user;
		}
		//id|id_regional|||     ||estado

		$afiliacion->id_afiliacion = $request->idafiliacion;
        $afiliacion->id_agremiado = $request->id_agremiado;
		$afiliacion->id_familia = $request->idfamilia;		
	
        //print_r($afiliacion); exit();
        

		$afiliacion->save();
			
    }

    public function send_afiliacion(Request $request){
		
		$msg = "";
		$id_user = Auth::user()->id;
		
		$seguroplan_model = new SegurosPlane();
		$seguroplan = $seguroplan_model->getSeguroByIdAgramieadoAndIdSeguro($request->id_agremiado,$request->id_plan,$request->fecha);

		if($seguroplan){
			$id_plan = $seguroplan->id_plan;
			$edad = $seguroplan->edad;
			$id_sexo = $seguroplan->id_sexo;
			
			if($request->id == 0){
				$afiliacion = new Seguro_afiliado();
				$afiliacion->id_usuario_inserta = $id_user;
			}else{
				$afiliacion =Seguro_afiliado::find($request->id);
				$afiliacion->id_usuario_actualiza = $id_user;
			}

			$afiliacion->id_regional = $request->id_regional;
			$afiliacion->id_seguro = $request->id_plan;
			$afiliacion->id_agremiado = $request->id_agremiado;
			$afiliacion->fecha = $request->fecha;
			$afiliacion->observaciones = $request->observaciones;
			$afiliacion->save();
			$id_afilicacion = $afiliacion->id;
			
			$seguro_afiliado_parentesco = new seguro_afiliado_parentesco;
			$seguro_afiliado_parentesco->id_afiliacion = $id_afilicacion;
			$seguro_afiliado_parentesco->id_agremiado = $request->id_agremiado;
			$seguro_afiliado_parentesco->id_familia = 0;
			$seguro_afiliado_parentesco->edad = $edad;
			$seguro_afiliado_parentesco->sexo = $id_sexo;
			$seguro_afiliado_parentesco->id_plan = $id_plan;
			$seguro_afiliado_parentesco->id_usuario_inserta = $id_user;
			$seguro_afiliado_parentesco->save();
			
			$seguro_afiliado_parentesco_model = new seguro_afiliado_parentesco;
			$seguro_afiliado_parentesco_model->seguro_agremiado_cuota($id_afilicacion);
		}else{
			$msg = "El plan del seguro no puede asignarse a este agremiado";
		}

		$respuesta["msg"] = $msg;
		echo json_encode($respuesta);

    }
    

	public function desafiliar_seguro($id)
	{
		$seguro_afiliado_parentesco_model = new seguro_afiliado_parentesco;
		
		$seguro_afiliado_parentesco_model->desafiliar_afiliado_seguro_cuota($id);

	}

    public function eliminar_afiliacion($id,$estado)
    {
		$afiliacionSeguro = AfiliacionSeguro::find($id);
		$afiliacionSeguro->estado = $estado;
		$afiliacionSeguro->save();

		echo $afiliacionSeguro->id;
		
		$seguro_afiliado_parentesco_model = new seguro_afiliado_parentesco;
		
		$seguro_afiliado_parentesco_model->eliminar_afiliado_seguro_cuota($id);

    }
					
	public function obtener_agremiado($id){
		
		$seguroafiliado_model = new Agremiado();
		$agremiado = $seguroafiliado_model->getAgremiado('85',$id);
		//print_r($agremiado); exit();
		echo json_encode($agremiado);
	}

	public function obtener_plan($id){
		
		$seguroplan_model = new SegurosPlane();
		$plan = $seguroplan_model->getSeguroById($id);
		
		echo json_encode($plan);
	}

	public function obtener_parentesco($id_afiliacion,$id_agremiado,$id_seguro){

        $parentesco_model = new Seguro_afiliado;
        $sw = true;
        $parentesco_lista = $parentesco_model->listar_parentesco_agremiado($id_afiliacion,$id_agremiado,$id_seguro);
        //print_r($parentesco_lista);exit();
        return view('frontend.afiliacion_seguro.lista_parentesco',compact('parentesco_lista'));

    }
	
	public function send_seguro_afiliado_parentesco(Request $request){
		
		$id_user = Auth::user()->id;
		$parentescos = $request->parentescos;
		$parentesco = $request->parentesco;
		
		$seguro_afiliado = Seguro_afiliado::find($request->id_afiliacion);
		$id_seguro = $seguro_afiliado->id_seguro;
		/*$seguro_plan = SegurosPlane::where("id_seguro",$id_seguro)->where("estado","1")->first();
		$id_plan = $seguro_plan->id_plan;
		$segurosPlan = SegurosPlane::find($id_plan);
		$id_seguro = $segurosPlan->id_seguro;*/
		$seguro = Seguro::find($id_seguro);
		$id_concepto = $seguro->id_concepto;
		
		if(isset($parentescos)){
		foreach($parentescos as $key=>$row){
			$seguro_afiliado_parentesco = new seguro_afiliado_parentesco;
			$seguro_afiliado_parentesco->id_afiliacion = $request->id_afiliacion;
			$seguro_afiliado_parentesco->id_agremiado = $parentesco[$key]["id_agremiado"];
			$seguro_afiliado_parentesco->id_familia = $parentesco[$key]["id_familia"];
			$seguro_afiliado_parentesco->edad = $parentesco[$key]["edad"];
			$seguro_afiliado_parentesco->sexo = $parentesco[$key]["sexo"];
			$seguro_afiliado_parentesco->id_plan= $parentesco[$key]["id_plan"];
			$seguro_afiliado_parentesco->id_usuario_inserta = $id_user;
			$seguro_afiliado_parentesco->save();
			$id_seguro_afiliado_parentesco = $seguro_afiliado_parentesco->id;
			
			/************************/
			
			/*
			$segurosPlanF = SegurosPlane::find($parentesco[$key]["id_plan"]);
			
			$valorizacion = new Valorizacione;
			$valorizacion->id_modulo = 4;
			$valorizacion->pk_registro = $id_seguro_afiliado_parentesco;
			$valorizacion->id_concepto = $id_concepto;
			$valorizacion->id_agremido = $parentesco[$key]["id_agremiado"];
			$valorizacion->monto = $segurosPlanF->monto;
			$valorizacion->id_moneda = 1;
			$valorizacion->fecha = Carbon::now()->format('Y-m-d');
			$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
			$valorizacion->estado = 1;
			$valorizacion->id_usuario_inserta = $id_user;
			$valorizacion->save();
			*/
			/***********************/
			
			/************************/			
			
		}
		
		}
		
		$seguro_afiliado_parentesco_model = new seguro_afiliado_parentesco;
		
		$seguro_afiliado_parentesco_model->seguro_agremiado_cuota($request->id_afiliacion);
		
	
	}
	
	
}






