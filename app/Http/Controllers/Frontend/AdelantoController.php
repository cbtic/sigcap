<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Adelanto;
use App\Models\Persona;
use App\Models\TablaMaestra;
use App\Models\Agremiado;
use App\Models\Adelanto_detalle;
use App\Models\PeriodoComisione;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
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
		$periodoComisione_model = new PeriodoComisione;

        $sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
		$mes = $tablaMaestra_model->getMaestroByTipo(116);
		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		
        return view('frontend.adelanto.all_lista_adelanto',compact('persona','sexo','tipo_documento','grupo_sanguineo','nacionalidad','mes','periodo','periodo_ultimo','periodo_activo'));

    }

	public function listar_adelanto_ajax(Request $request){
	
		$adelanto_model = new Adelanto;
		$p[]=$request->numero_cap;
		$p[]=$request->agremiado;//$request->numero_documento;
		$p[]=$request->periodo;
		$p[]=$request->mes_reintegro;
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
		$periodoComisione_model = new PeriodoComisione;

		//$persona = new Persona;
		
		if($id>0){
			$adelanto = Adelanto::find($id);
			$id_agremiado = $adelanto->id_agremiado;
			$agremiado = Agremiado::find($id_agremiado);
			$id_persona = $agremiado->id_persona;
			$persona = Persona::find($id_persona);
			$adelanto_detalle_model = new Adelanto_detalle;
			$adelanto_fecha = $adelanto_detalle_model->getAdelantoFechaPagoId($id);
			$fecha_pago=$adelanto_fecha[0]->fecha_pago;
			$periodo_ = PeriodoComisione::find($adelanto->id_periodo_comision);
			//var_dump($adelanto_fecha[0]->fecha_pago);exit();

			
		}else{
			$adelanto = new Adelanto;
			$persona = new Persona;
			$agremiado = new Agremiado;
			$fecha_pago=null;
			$periodo_ = NULL;
		}
		//echo($id); 
		//print_r($persona); exit();

		$tipo_documento = $tablaMaestra_model->getMaestroC(16,85);
		$tiene_recibo = $tablaMaestra_model->getMaestroByTipo(121);
		$periodo = $periodoComisione_model->getPeriodoAllByFecha();
		
		return view('frontend.adelanto.modal_adelanto_nuevoAdelanto',compact('id','agremiado','persona','adelanto','tipo_documento','tiene_recibo','fecha_pago','periodo_','periodo'));
	
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
			$adelanto->id_agremiado = $request->delegado;
			$adelanto->fecha = Carbon::now()->format('Y-m-d');
		}else{
			$adelanto = Adelanto::find($request->id);
			$adelanto->id_agremiado = $request->id_delegado_;
			
		}
		
        //$id_agremiado = buscar_numero_cap($numero_cap);
        //$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

        $adelanto->id_periodo_comision = $request->id_periodo;
        $adelanto->nro_total_cuotas = $request->numero_cuota;
        $adelanto->total_adelanto = $request->monto;
		$adelanto->id_tiene_recibo = $request->id_tiene_recibo;
		//$profesion->estado = 1;
		$adelanto->id_usuario_inserta = $id_user;
		$adelanto->save();

		$pago_mes=$request->monto/$request->numero_cuota;
		
		$fechaActual = Carbon::now();

		
			
			if($request->id == 0){
				for ($i = 1; $i <= $request->numero_cuota; $i++) {
				$adelanto_detalle = new Adelanto_detalle;

				$adelanto_detalle->id_adelento=$adelanto->id;
				//$adelanto_detalle->id_periodo_delegado='1';
				$adelanto_detalle->numero_cuota=$i;
				$adelanto_detalle->adelanto_pagar=$pago_mes;

				$ultimoDiaMes = $fechaActual->copy()->addMonths($i)->endOfMonth();
				$adelanto_detalle->fecha_pago=$ultimoDiaMes;
				
				$adelanto_detalle->id_usuario_inserta=$id_user;
				$adelanto_detalle->save();
			}
			}else{

				$adelanto_detalle = Adelanto_detalle::where("id_adelento",$adelanto->id)->update(['estado'=>0]);

				for ($i = 1; $i <= $request->numero_cuota; $i++) {

					$adelanto_detalle = new Adelanto_detalle;
					$adelanto_detalle->id_adelento=$adelanto->id;
					//$adelanto_detalle->id_periodo_delegado='1';
					$adelanto_detalle->numero_cuota=$i;
					$adelanto_detalle->adelanto_pagar=$pago_mes;
		
					$ultimoDiaMes = $fechaActual->copy()->addMonths($i)->endOfMonth();
					$adelanto_detalle->fecha_pago=$ultimoDiaMes;
					
					$adelanto_detalle->id_usuario_inserta=$id_user;
					$adelanto_detalle->save();
				}
			}
				
    }

	public function send_detalle_adelanto(Request $request){

		$id_user = Auth::user()->id;

		//var_dump($request);exit();
		if($request->id == 0){
			$adelanto = new Adelanto;
			$adelanto_detalle = new Adelanto_detalle;
		}else{
			$adelanto = Adelanto::find($request->id);
			if(!$adelanto){
				// Maneja el caso donde no se encuentra el Adelanto
				return response()->json(['error' => 'Adelanto no encontrado'], 404);
			}
			$adelanto_detalle = Adelanto_detalle::where('id_adelento', $adelanto->id)->get();
			
		}

		$adelantoPagar = json_decode($request->input('adelanto_pagar'));
		$idAdelantoDetalle = json_decode($request->input('id_adelanto_detalle'));
		$fecha = json_decode($request->input('fecha'));
		//var_dump($idAdelantoDetalle);exit;
		
		foreach($adelantoPagar as $key => $monto){
			$adelanto_detalle = Adelanto_detalle::where('id', $idAdelantoDetalle[$key])->first();
			
			$nuevoDetalle = Adelanto_detalle::find($adelanto_detalle->id);
			
			$nuevoDetalle->adelanto_pagar = $monto;
			$nuevoDetalle->id_adelento = $adelanto->id;
			$nuevoDetalle->fecha_pago = $fecha[$key];
			//$nuevoDetalle->numero_cuota = $idAdelantoDetalle[$key];
			$nuevoDetalle->save();
		}
    }

	public function eliminar_adelanto($id,$estado)
    {
		$adelanto = Adelanto::find($id);
		$adelanto->estado = $estado;
		$adelanto->save();

		$adelanto_detalle = Adelanto_detalle::where('id_adelento', $id)->get();

		foreach($adelanto_detalle as $key => $row){
			$detalle = Adelanto_detalle::find($row->id);
			$detalle->estado = $estado;
			$detalle->save();
		}

		echo $adelanto->id;
    }

	public function obtener_datos_adelanto($id_agremiado){
		
		$adelanto_model = new Adelanto;
		$datos_adelanto = $adelanto_model->getDatosAdelanto($id_agremiado);
		
		return response()->json($datos_adelanto);
	}

	public function descargar_pdf_adelanto($periodo,$numero_cap,$agremiado,$mes_reintegro,$estado)
	{

		if($periodo==0)$periodo = "";
		if($numero_cap=="0")$numero_cap = "";
		if($agremiado=="0")$agremiado = "";
		if($mes_reintegro==0)$mes_reintegro = "";
		if($estado==0)$estado = "";

		$adelanto_model = new Adelanto;
		$p[]=$numero_cap;
		$p[]=$agremiado;
		$p[]=$periodo;
		$p[]=$mes_reintegro;
		$p[]="";
        $p[]=$estado;
		$p[]=1;
		$p[]=10000;
		$data = $adelanto_model->listar_adelanto_ajax($p);

		$periodo_actual = PeriodoComisione::find($periodo);

		$denominacion_periodo = $periodo_actual->descripcion;
		$incio_periodo = Carbon::parse($periodo_actual->fecha_inicio);
		$fin_periodo = Carbon::parse($periodo_actual->fecha_fin);
		$mesesEnLetras ="";

			if($mes_reintegro==""){

			$period = CarbonPeriod::create($incio_periodo,'1 month', $fin_periodo);

			$meses = [];

			foreach($period as $date){
				$meses[] = $date->format('n');
			}

			$meses_unicos = array_values(array_unique($meses));

			sort($meses_unicos);

			foreach($meses_unicos as $meses_numero){
				$mesEnLetras = $this->mesesALetras($meses_numero);
				$mesesEnLetras .= $mesEnLetras . ",";
			}

			$mesEnLetras = rtrim($mesesEnLetras,',');

		}else{
			$mesEnLetras = $this->mesesALetras($mes_reintegro);
		}
		

		$pdf = Pdf::loadView('frontend.adelanto.descargar_pdf_adelanto',compact('data','denominacion_periodo','mesEnLetras'));
		$pdf->getDomPDF()->set_option("enable_php", true);
		
		//$pdf->setPaper('A4', 'landscape'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream('descargar_pdf_adelanto.pdf');
	}

	function mesesALetras($mes) { 
		$meses = array('','enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'setiembre','octubre','noviembre','diciembre'); 
		return $meses[$mes];
	}
}
