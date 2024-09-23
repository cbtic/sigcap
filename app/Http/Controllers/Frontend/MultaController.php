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
use App\Models\TablaMaestra;
use Carbon\Carbon;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use stdClass;
use App\Models\Concepto;

class MultaController extends Controller
{
    function consulta_multa(){
        
        return view('frontend.multa.all');

    }

	function consulta_multa_mantenimiento(){
        
		$tablaMaestra_model = new TablaMaestra;
		$multa = new Multa;
        $moneda = $tablaMaestra_model->getMaestroByTipo(1);

        return view('frontend.multa.all_mantenimiento',compact('moneda','multa'));

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

	public function listar_multa_ajax(Request $request){
	
		$multa_model = new Multa;
		$p[]=$request->denominacion;
		$p[]=$request->monto;
		$p[]=$request->moneda;
		$p[]="";
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $multa_model->listar_multa_ajax($p);
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
		$tablaMaestra_model = new TablaMaestra;
		
		if($id>0){
			$agremiadoMulta = AgremiadoMulta::find($id);
			$id_agremiado = $agremiadoMulta->id_agremiado;
			$agremiado = Agremiado::find($id_agremiado);
			$numero_cap = $agremiado->numero_cap;
			$multa_1 = Multa::find($agremiadoMulta->id_multa);
			$moneda_1 = TablaMaestra::find($multa_1->id_moneda);
		}else{
			$agremiadoMulta = new AgremiadoMulta;
			$id_agremiado = "";
			$agremiado = new Agremiado;
			$numero_cap = "";
			$multa_1 = NULL;
			$moneda_1 = NULL;
		}
		
        $multa = $multa_concepto_model->getMulta_conceptoAll();
		//$moneda = $moneda_model->getMonedaAll();
		
		//$multa = Multa::where("estado","1")->get();
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		$estado_multa = $tablaMaestra_model->getMaestroByTipo(120);
		
		return view('frontend.multa.modal_multa_nuevoMulta',compact('id','id_agremiado','agremiado','numero_cap','agremiadoMulta','multa'/*,'moneda'*/,'multa_1','moneda_1','moneda_1','estado_multa'));
	
	}

	public function modal_multa_nuevoMultaMantenimiento($id){
		
		//$id->moneda;
		$multa = new Multa;
		$concepto_model = new Concepto;
		$tablaMaestra_model = new TablaMaestra;

        $moneda = $tablaMaestra_model->getMaestroByTipo(1);
		$concepto = $concepto_model->getConceptoAllDenominacionMulta();
		
		if($id>0){
			$multa = Multa::find($id);
		}else{
			$multa = new Multa;
		}
		
        //$multa = $multa_concepto_model->getMulta_conceptoAll();
		//$moneda = $moneda_model->getMonedaAll();
		
		//$multa = Multa::where("estado","1")->get();
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.multa.modal_multa_nuevoMultaMantenimiento',compact('id','moneda','multa','concepto'));
	
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
			$agremiado = new Agremiado;
			
		}else{
			$agremiadoMulta = AgremiadoMulta::find($request->id);
		}
		
		$agremiado_ = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$multa = Multa::where("id",$request->id_multa)->where("estado","1")->first();
		$concepto = Concepto::where("id",$multa->id_concepto)->where("estado","1")->first();

		$agremiadoMulta->id_agremiado = $agremiado_->id;
		$agremiadoMulta->id_multa = $request->id_multa;
		//$id_concepto= Multa::find($request->id_multa);
		$agremiadoMulta->fecha = Carbon::now()->format('Y-m-d');
		$agremiadoMulta->id_estado_pago = 1;
		$agremiadoMulta->id_concepto = $multa->id_concepto;
		$agremiadoMulta->periodo = $request->periodo;
		
		$agremiadoMulta->id_estado_multa = $request->id_estado_multa;
		$agremiadoMulta->observacion_multa = $request->observacion_multa;
		
		//$agremiadoMulta->estado = 1;
		$agremiadoMulta->id_usuario_inserta = $id_user;
		$agremiadoMulta->save();

		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

		$agremiado->id_situacion = 74;

		$agremiado->save();
		
		$id_multa = $agremiadoMulta->id;
		
		if($request->id_estado_multa==1){
		
			$multa = Multa::find($request->id_multa);
			
			$valorizacion = new Valorizacione;
			$valorizacion->id_modulo = 3;
			$valorizacion->pk_registro = $id_multa;
			$valorizacion->id_concepto = $multa->id_concepto;
			$valorizacion->id_agremido = $agremiado_->id;
			$valorizacion->id_persona = $agremiado_->id_persona;
			$valorizacion->monto = $multa->monto;
			$valorizacion->id_moneda = $multa->id_moneda;
			$valorizacion->fecha = Carbon::now()->format('Y-m-d');
			$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
			$valorizacion->descripcion = $multa->denominacion;
			//$valorizacion->estado = 1;
			//print_r($valorizacion->descripcion).exit();
			$valorizacion->id_usuario_inserta = $id_user;
			$valorizacion->save();
			
		}else{
		
			$valorizaciones = Valorizacione::where("pk_registro",$request->id)->where("id_modulo", "3")->where("estado","1")->first();
			if(isset($valorizaciones->id)){
				$id_valorizaciones = $valorizaciones->id;
				$valorizacion = Valorizacione::find($id_valorizaciones);
				$valorizacion->estado = 0;
				$valorizacion->save();
			}
		}
		
    }
	
	public function send_multa_nuevoMultaMantenimiento(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$multa = new Multa;
		}else{
			$multa = Multa::find($request->id);
		}
		
		$multa->denominacion = $request->denominacion;
		$multa->monto = $request->monto;
		$multa->id_moneda = $request->moneda;
		$multa->id_concepto = $request->concepto;
		$multa->id_usuario_inserta = $id_user;
		$multa->save();
		
    }

	public function upload_multa(Request $request){
		
		$filename = date("YmdHis") . substr((string)microtime(), 1, 6);
		$type="";
		$filepath = public_path('img/multa/');
		
		$type=$this->extension($_FILES["file"]["name"]);
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $filename.".".$type);
		
    	
		//move_uploaded_file($_FILES["file"]["tmp_name"], $filepath.$_FILES["file"]["name"]);
		//echo $_FILES['file']['name'];
		
		$archivo = $filename.".".$type;
		
		$this->importar_multa($archivo);
		
	}
	
	function extension($filename){$file = explode(".",$filename); return strtolower(end($file));}
	
	public function importar_multa($archivo){
		
		$id_user = Auth::user()->id;
		//$multas = Excel::toArray(new stdClass(), "img/multa/multa.xlsx");
		$multas = Excel::toArray(new stdClass(), "img/multa/".$archivo);
		
		foreach($multas as $key=>$row){
			
			foreach($row as $key2=>$row2){
				if($key2>0){
					$cap = $row2[0];
					$periodo = $row2[1];
					$id_multa = $row2[2];
					$id_estado_multa = $row2[3];
					
					$agremiado = Agremiado::where("numero_cap",$cap)->where("estado","1")->first();
					
					if($agremiado){
					
						$agremiadoMultaExiste = AgremiadoMulta::where("id_agremiado",$agremiado->id)->where("id_multa",$id_multa)->where("periodo",$periodo)->where("id_concepto","26461")->where("estado","1")->whereNotNull("id_estado_multa")->first();
						if(!$agremiadoMultaExiste){
						
							$agremiadoMulta = new AgremiadoMulta;	
							$agremiadoMulta->id_agremiado = $agremiado->id;
							$agremiadoMulta->id_multa = $id_multa;
							$agremiadoMulta->fecha = Carbon::now()->format('Y-m-d');
							$agremiadoMulta->id_estado_pago = 1;
							$agremiadoMulta->id_concepto = 26461;
							$agremiadoMulta->periodo = $periodo;
							$agremiadoMulta->id_estado_multa = $id_estado_multa;
							$agremiadoMulta->estado = 1;
							$agremiadoMulta->id_usuario_inserta = $id_user;
							$agremiadoMulta->save();

							$id_multa_agremiado = $agremiadoMulta->id;
		
							$multa = Multa::find($id_multa);
							$concepto = Concepto::where("id",$multa->id_concepto)->where("estado","1")->first();
							
							$valorizacion = new Valorizacione;
							$valorizacion->id_modulo = 3;
							$valorizacion->pk_registro = $id_multa_agremiado;
							$valorizacion->id_concepto = $multa->id_concepto;
							$valorizacion->id_agremido = $agremiado->id;
							$valorizacion->id_persona = $agremiado->id_persona;
							$valorizacion->monto = $multa->monto;
							$valorizacion->id_moneda = $multa->id_moneda;
							$valorizacion->fecha = Carbon::now()->format('Y-m-d');
							$valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');
							$valorizacion->descripcion = $concepto->denominacion ." - " . $periodo ." - ". $multa->denominacion;
							$valorizacion->id_usuario_inserta = $id_user;
							$valorizacion->save();

							$agremiado_ = Agremiado::find($agremiado->id);
							$agremiado_->id_situacion = 74;
							$agremiado_->save();
							
						}
					}
				}
			}
		}
	}

	public function eliminar_multa($id,$estado)
    {
		$agremiadoMulta = AgremiadoMulta::find($id);
		$valorizaciones = Valorizacione::where("pk_registro",$id)->where("id_modulo", "3")->where("estado","1")->first();

		//$multa = Multa::find($id);
		//print_r($agremiadoMulta->id).exit();

		$id_valorizaciones = $valorizaciones->id;
		$valorizacion = Valorizacione::find($id_valorizaciones);
		$valorizacion->estado = $estado;
		//print_r($id_valorizaciones).exit();
		$agremiadoMulta->estado = $estado;
		$agremiadoMulta->save();
		$valorizacion->save();

		echo $agremiadoMulta->id;
    }

	public function eliminar_multa_mantenimiento($id,$estado)
    {
		$multa = Multa::find($id);
		$multa->estado = $estado;
		$multa->save();

		echo $multa->id;
    }
}
