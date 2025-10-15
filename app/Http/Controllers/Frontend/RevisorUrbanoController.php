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
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use stdClass;
use Auth;

class RevisorUrbanoController extends Controller
{
    public function __construct(){
		/*
		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
		*/

		$this->middleware('auth');
		$this->middleware('can:Registro Revisor Urbano')->only(['consulta_revisorUrbano']);
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
		$situacion_venta = $tablaMaestra_model->getMaestroByTipo(11);

        return view('frontend.revisorUrbano.all',compact('agremiado','persona','tipo_documento','region','ubicacion_cliente','situacion_cliente','situacion_venta'));
    }

    public function listar_revisorUrbano_ajax(Request $request){
	
		$revisorUrbano_model = new RevisorUrbano;
		$p[]=$request->numero_cap;
		$p[]=$request->agremiado;//$request->ruc;
		$p[]="";
		$p[]=$request->situacion;
		$p[]=$request->codigo_itf;
        $p[]=$request->codigo_ru;
		$p[]=$request->situacion_pago;
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

		//var_dump($revisor_existe);exit;	
		
		if($agremiado){

		
			if(count($revisor_existe)==0){

				$agremiado_habilitado = Agremiado::where("numero_cap",$request->numero_cap)->where("id_situacion","73")->where("estado","1")->first();
				$agremiado_estado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();

				if($agremiado_habilitado){
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
					$valorizacion->descripcion = $concepto->denominacion." - ".$request->codigo_itf . " -  " . $codigo_ru;
					//$valorizacion->estado = 1;
					//print_r($valorizacion->descripcion).exit();
					$valorizacion->id_usuario_inserta = $id_user;
					$valorizacion->save();
				}else if($agremiado_estado->situacion==74){
					$mensaje = "El Agremiado esta INHABILITADO";
				}else if($agremiado_estado->situacion==83){
					$mensaje = "El Agremiado esta FALLECIDO";
				}else if($agremiado_estado->situacion==265){
					$mensaje = "El Agremiado esta en otra REGIONAL";
				}else if($agremiado_estado->situacion==266){
					$mensaje = "El Agremiado esta en otra PROVINCIA";
				}else if($agremiado_estado->situacion==267){
					$mensaje = "El Agremiado esta en el EXTRANJERO";
				}

			}else{
				$mensaje = "El Codigo ITF ya se encuentra registrado";
			}
		}else{
			$mensaje = "El Numero de CAP no existe";
		}
		
		$result["mensaje"] = $mensaje;
		echo json_encode($result);
		
	}

	public function eliminar_revisor_urbano($id,$estado)
    {
		$revisorUrbano = RevisorUrbano::find($id);
		$revisorUrbano->estado = $estado;
		$revisorUrbano->save();
		$idRevisorUrbano = $revisorUrbano->id; 

		$valorizacion = Valorizacione::where('pk_registro',$idRevisorUrbano)->where('id_modulo',8)->where('estado',1)->first();
		$valorizacion->estado = 0;
		$valorizacion->save();

		echo $revisorUrbano->id;
    }

	public function exportar_listar_revisor_urbano($numero_cap, $agremiado, $codigo_itf, $codigo_ru, $situacion_pago, $estado) {


		if($numero_cap==0)$numero_cap = "";
		if($agremiado=="0")$agremiado = "";
		if($codigo_itf=="0")$codigo_itf = "";
		if($codigo_ru=="0")$codigo_ru = "";
		if($situacion_pago==9)$situacion_pago = "";
		/*if($situacion_pago==0)$situacion_pago = "PE";
		if($situacion_pago==1)$situacion_pago = "P";
		if($situacion_pago==2)$situacion_pago = "E";
		if($situacion_pago==3)$situacion_pago = "A";*/
		if($estado==0)$estado = "";
		//var_dump($agremiado);exit();
		$revisorUrbano_model = new RevisorUrbano;
		$p[]=$numero_cap;
		$p[]=$agremiado;
		$p[]="";
		$p[]="";
		$p[]=$codigo_itf;
        $p[]=$codigo_ru;
		$p[]=$situacion_pago;
		$p[]=1;
		$p[]=1;
		$p[]=10000;
		$data = $revisorUrbano_model->listar_revisorUrbano_ajax($p);
	
		$variable = [];
		$n = 1;
		//array_push($variable, array("SISTEMA CAP"));
		//array_push($variable, array("CONSULTA DE CONCURSO","","","",""));
		array_push($variable, array("N","Numero CAP","Nombre","Fecha Colegiado","Situacion","Codigo ITF", "Codigo RU", "Fecha", "Serie", "Numero", "Situacion Documento Venta"));
		
		foreach ($data as $r) {
			//$nombres = $r->apellido_paterno." ".$r->apellido_materno." ".$r->nombres;
			
			$situacion_pago_texto = '';
			switch ($r->situacion_pago) {
				case 'P':
					$situacion_pago_texto = 'PAGADO';
					break;
				case 'PE':
					$situacion_pago_texto = 'PENDIENTE';
					break;
				case 'E':
					$situacion_pago_texto = 'EXONERADO';
					break;
				case 'ANULADO':
					$situacion_pago_texto = 'A';
					break;
				default:
					$situacion_pago_texto = $r->situacion_pago;
					break;
			}

			array_push($variable, array($n++,$r->numero_cap, $r->agremiado, $r->fecha_colegiado, $r->situacion,$r->codigo_itf,$r->codigo_ru, $r->fecha, $r->serie, $r->numero, $situacion_pago_texto));
		}
		
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'reporte_revisor_urbano.xlsx');
		
    }

}

class InvoicesExport implements FromArray
{
	protected $invoices;

	public function __construct(array $invoices)
	{
		$this->invoices = $invoices;
	}

	public function array(): array
	{
		return $this->invoices;
	}

}