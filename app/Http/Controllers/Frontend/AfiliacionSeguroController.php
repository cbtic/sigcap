<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AfiliacionSeguro;
use App\Models\Agremiado;
use App\Models\seguro_afiliado_parentesco;
use Illuminate\Http\Request;
use App\Models\Seguro_afiliado;
use App\Models\Regione;
use App\Models\seguro;
use App\Models\SegurosPlane;
use App\Models\Ubigeo;
use App\Models\TablaMaestra;

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
			$desc_cliente=$datosafiliado[0]->desc_cliente;
			$situacion=$datosafiliado[0]->denominacion;
			$id_seguro=$datosafiliado[0]->id_seguro;		
		} 
		else{
			$afiliado = new Seguro_afiliado;
			$cap_numero="";
			$desc_cliente="";
			$situacion="";
			$id_seguro="";
		} 
		
			

		$seguro_model = new seguro;
		$seguro = $seguro_model->getSeguroAll();
        
	
		//print_r ($departamento);
		//exit();
		//print_r ($numero_cap);exit();
	
		return view('frontend.afiliacion_seguro.modal_afiliado',compact('id','afiliado','seguro','cap_numero','desc_cliente','situacion','id_seguro'));

    }

	public function modal_parentesco($id){
		
		$id_user = Auth::user()->id;
	
        $seguro_parentesco=seguro_afiliado_parentesco::where('id_afiliacion', $id)->where('estado', '1')->get()->all();
		
		$datos_model= new seguro_afiliado_parentesco();
		$datos_seguro_agremiado=$datos_model-> getDatosSeguro($id);


		return view('frontend.afiliacion_seguro.modal_parentesco',compact('id','seguro_parentesco','datos_seguro_agremiado'));

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
		$id_user = Auth::user()->id;

        //print_r ($id_user);exit();
        
		if($request->id == 0){
			$afiliacion = new Seguro_afiliado();
			$afiliacion->id_usuario_inserta = $id_user;
		}else{
			$afiliacion =Seguro_afiliado::find($request->id);
			$afiliacion->id_usuario_actualiza = $id_user;
		}
		//id|id_regional|||     ||estado

		$afiliacion->id_regional = $request->id_regional;
        $afiliacion->id_plan = $request->id_plan;
		$afiliacion->id_agremiado = $request->id_agremiado;
		$afiliacion->fecha = $request->fecha;
		$afiliacion->observaciones = $request->observaciones;

		
        //print_r($afiliacion); exit();
        

		$afiliacion->save();
			
    }
    
    public function eliminar_municipalidad($id,$estado)
    {
		$municipalidad = Seguroe::find($id);
		$municipalidad->estado = $estado;
		$municipalidad->save();

		echo $municipalidad->id;

    }
					
	public function obtener_agremiado($id){
		
		$seguroafiliado_model = new Agremiado();
		$agremiado = $seguroafiliado_model->getAgremiado('NRO_CAP',$id);
		
		echo json_encode($agremiado);
	}

	public function obtener_plan($id){
		
		$seguroplan_model = new SegurosPlane();
		$plan = $seguroplan_model->getPlanBySeguro($id);
		
		echo json_encode($plan);
	}

	public function obtener_parentesco($id_agremiado){

        $parentesco_model = new Seguro_afiliado;
        $sw = true;
        $parentesco_lista = $parentesco_model->listar_parentesco_agremiado($id_agremiado);
        //print_r($parentesco);exit();
        return view('frontend.afiliacion_seguro.lista_parentesco',compact('parentesco_lista'));

    }
}






