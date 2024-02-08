<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Adelanto;
use App\Models\Persona;
use App\Models\TablaMaestra;
use App\Models\Agremiado;
use App\Models\Adelanto_detalle;
use Carbon\Carbon;
use Auth;

class AdelantoController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_adelanto(){

		$tablaMaestra_model = new TablaMaestra;
		$persona = new Persona;
        $sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
        return view('frontend.adelanto.all_lista_adelanto',compact('persona','sexo','tipo_documento','grupo_sanguineo','nacionalidad'));

    }

	public function listar_adelanto_ajax(Request $request){
	
		$adelanto_model = new Adelanto;
		$p[]=$request->numero_cap;
		$p[]=$request->agremiado;//$request->numero_documento;
		$p[]="";
		$p[]="";
		$p[]="";
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $adelanto_model->listar_adelanto_ajax($p);
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



	public function modal_adelanto_nuevoAdelanto($id){
		
		$tablaMaestra_model = new TablaMaestra;
		$adelanto = new Adelanto;
        $persona = new Persona;
        $agremiado = new Agremiado;

		//$persona = new Persona;
		
		if($id>0){
			$adelanto = Adelanto::find($id);
			$id_agremiado = $adelanto->id_agremiado;
			$agremiado = Agremiado::find($id_agremiado);
			$id_persona = $agremiado->id_persona;
			$persona = Persona::find($id_persona);
			
		}else{
			$adelanto = new Adelanto;
			$persona = new Persona;
			$agremiado = new Agremiado;
		}
		//echo($id); 
		//print_r($persona); exit();

		$tipo_documento = $tablaMaestra_model->getMaestroC(16,85);
		
		return view('frontend.adelanto.modal_adelanto_nuevoAdelanto',compact('id','agremiado','persona','adelanto','tipo_documento'));
	
	}

	public function modal_detalle_adelanto($id){
		
		$tablaMaestra_model = new TablaMaestra;
		$adelanto = new Adelanto;
        $persona = new Persona;
        $agremiado = new Agremiado;
		
		//$persona = new Persona;
		
		if($id>0){
			$adelanto = Adelanto::find($id);
			$persona = Persona::find($id);
			$agremiado = Agremiado::find($id);
			$adelanto_detalle_model = new Adelanto_detalle;
			$adelanto_detalle = $adelanto_detalle_model->getAdelantoDetalleId($adelanto->id);
		}else{
			$adelanto = new Adelanto;
			$persona = new Persona;
			$agremiado = new Agremiado;
		}

		
		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroC(16,85);
		
		return view('frontend.adelanto.modal_detalle_adelanto',compact('id','agremiado','adelanto_detalle','persona','adelanto','sexo','tipo_documento'));
	
	}

    public function buscar_numero_cap($numero_cap){

		$sw = true;
		$msg = "";

		$agremiado = Agremiado::where('numero_cap',$numero_cap)->where('estado','1')->first();

		if($agremiado){

            $persona = new Persona;
            $id_persona = $agremiado->id_persona;
            $persona = Persona::find($id_persona);

			$array["persona"] = $persona;
		}else{
			$sw = false;
			//$msg = "El DNI no está registrado como persona, vaya a mantenimiento de personas y registre primero a la persona.";
			//$array["error"] = "El DNI no está registrado como persona, vaya a mantenimiento de personas y registre primero a la persona.";
			$array["sw"] = $sw;
			//$array["msg"] = $msg;
		}
		
        echo json_encode($array);
	}

    public function send_adelanto_nuevoAdelanto(Request $request){
		
		/*$request->validate([
			'nombre'=>'required',
		]
		);*/

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$adelanto = new Adelanto;
			$adelanto_detalle = new Adelanto_detalle;
		}else{
			$adelanto = Adelanto::find($request->id);
		}
		
        //$id_agremiado = buscar_numero_cap($numero_cap);
        $agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

		$adelanto->id_agremiado = $agremiado->id;
        $adelanto->id_periodo_delegado = '1';
        $adelanto->fecha = Carbon::now()->format('Y-m-d');
        $adelanto->nro_total_cuotas = $request->numero_cuota;
        $adelanto->total_adelanto = $request->monto;
		//$profesion->estado = 1;
		$adelanto->id_usuario_inserta = $id_user;
		$adelanto->save();

		$pago_mes=$request->monto/$request->numero_cuota;
		
		$fechaActual = Carbon::now();

		for ($i = 1; $i <= $request->numero_cuota; $i++) {
			
			$adelanto_detalle = new Adelanto_detalle;
			$adelanto_detalle->id_adelento=$adelanto->id;
			$adelanto_detalle->id_periodo_delegado='1';
			$adelanto_detalle->numero_cuota=$i;
			$adelanto_detalle->adelanto_pagar=$pago_mes;

			$ultimoDiaMes = $fechaActual->copy()->addMonths($i)->endOfMonth();
			$adelanto_detalle->fecha_pago=$ultimoDiaMes;
			
			$adelanto_detalle->id_usuario_inserta=$id_user;
			$adelanto_detalle->save();
			
		}
    }

	public function eliminar_adelanto($id,$estado)
    {
		$adelanto = Adelanto::find($id);
		$adelanto->estado = $estado;
		$adelanto->save();

		echo $adelanto->id;
    }
}
