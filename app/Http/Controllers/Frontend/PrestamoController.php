<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Persona;
use App\Models\TablaMaestra;
use App\Models\Agremiado;
use Carbon\Carbon;
use Auth;

class PrestamoController extends Controller
{

    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_prestamo(){

		$tablaMaestra_model = new TablaMaestra;
		$persona = new Persona;
        $sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
        return view('frontend.prestamo.all_lista_prestamo',compact('persona','sexo','tipo_documento','grupo_sanguineo','nacionalidad'));

    }

	public function listar_prestamo_ajax(Request $request){
	
		$prestamo_model = new Prestamo;
		$p[]="";
		$p[]="";//$request->numero_documento;
		$p[]="";
		$p[]="";
		$p[]="";
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $prestamo_model->listar_prestamo_ajax($p);
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

	public function modal_prestamo_nuevoPrestamo($id){
		
		$tablaMaestra_model = new TablaMaestra;
		$prestamo = new Prestamo;
        $persona = new Persona;
        $agremiado = new Agremiado;

		//$persona = new Persona;
		
		if($id>0){
			$prestamo = Prestamo::find($id);
		}else{
			$prestamo = new Prestamo;
		}
		
		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroC(16,85);
		$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
        

		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.prestamo.modal_prestamo_nuevoPrestamo',compact('id','agremiado','persona','prestamo','sexo','tipo_documento','grupo_sanguineo','nacionalidad'));
	
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

    public function send_prestamo_nuevoPrestamo(Request $request){
		
		/*$request->validate([
			'nombre'=>'required',
		]
		);*/

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$prestamo = new Prestamo;
		}else{
			$prestamo = Prestamo::find($request->id);
		}
		
        $id_agremiado = buscar_numero_cap($numero_cap);

		$prestamo->id_agremiado = $request->id_agremiado;
        $prestamo->id_periodo_delegado = '1';
        $prestamo->id_tipo_prestamo = $request->tipo_prestamo;
        $prestamo->fecha = Carbon::now()->format('Y-m-d');
        $prestamo->nro_total_cuotas = $request->numero_cuota;
        $prestamo->total_prestamo = $request->monto;
		//$profesion->estado = 1;
		$prestamo->id_usuario_inserta = $id_user;
		$prestamo->save();
    }

	public function eliminar_profesion($id,$estado)
    {
		$profesion = Profesione::find($id);
		$profesion->estado = $estado;
		$profesion->save();

		echo $profesion->id;
    }
}
