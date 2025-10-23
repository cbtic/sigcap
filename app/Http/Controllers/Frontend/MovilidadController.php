<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComisionMovilidade;
use App\Models\Movilidade;
use App\Models\Regione;
use App\Models\MunicipalidadIntegrada;
use App\Models\PeriodoComisione;
use App\Models\TablaMaestra;
use App\Models\Comisione;
use Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromArray;
use stdClass;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MovilidadController extends Controller
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
		$this->middleware('can:Movilidad')->only(['consulta_movilidad']);
	}

    function consulta_movilidad(){

		$municipalidadIntegrada_model = new MunicipalidadIntegrada;
		$comision_movilidades = new ComisionMovilidade;
		$periodoComision_model = new PeriodoComisione;
		$tablaMaestra_model = new TablaMaestra;
        //$tablaMaestra_model = new TablaMaestra;
		//$movilidad = new Movilidade;
        //$tipo_agrupacion = $tablaMaestra_model->getMaestroByTipo(99);
		$municipalidadIntegrada = $municipalidadIntegrada_model->getMuniIntegradaAll();
		$periodoComision = $periodoComision_model->getPeriodoComisionAll();
		$tipoComision = $tablaMaestra_model->getMaestroByTipo(102);
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		
        return view('frontend.movilidad.all',compact('municipalidadIntegrada','comision_movilidades','periodoComision','tipoComision','periodo_ultimo','periodo_activo'));
    }

    public function listar_movilidad_ajax(Request $request){
	
		$movilidad_model = new ComisionMovilidade;
		$p[]=$request->comision;
		$p[]=$request->periodo;
        $p[]="";
        $p[]="";
		$p[]=$request->tipo_comision;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $movilidad_model->listar_movilidad_ajax($p);
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
	
	public function ver_movilidad_pdf($id_periodo,$anio,$mes){
		
		$comisionMovilidad_model = new ComisionMovilidade;
		$movilidad_model = new Movilidade;
		
		$periodo = PeriodoComisione::find($id_periodo);
		/*
		$p[]="";
		$p[]=$id_periodo;
        $p[]="";
        $p[]="";
		$p[]="";
		$p[]="1";
		$p[]="1";
		$p[]="1000";
		$movilidad = $movilidad_model->listar_movilidad_ajax($p);
		*/
		$movilidad = $comisionMovilidad_model->getMovilidadByPeriodo($id_periodo,$anio,$mes);
		$meses = $movilidad_model->getMesByPeriodo($id_periodo);
		
		$dias = array('L','M','M','J','V','S','D');

		$mes_ = ltrim($mes, '0');
		$mesEnLetras = $this->mesesALetras($mes_);
		
		$pdf = Pdf::loadView('pdf.ver_movilidad',compact('movilidad','anio','mesEnLetras','mes','meses','id_periodo','periodo'));
		$pdf->getDomPDF()->set_option("enable_php", true);
		
		$pdf->setPaper('A3', 'landscape'); // Tama�o de papel (puedes cambiarlo seg�n tus necesidades)
    	$pdf->setOption('margin-top', 20); // M�rgen superior en mil�metros
   		$pdf->setOption('margin-right', 50); // M�rgen derecho en mil�metros
    	$pdf->setOption('margin-bottom', 20); // M�rgen inferior en mil�metros
    	$pdf->setOption('margin-left', 100); // M�rgen izquierdo en mil�metros

		return $pdf->stream('ver_movilidad.pdf');
	
	}

	public function ver_movilidad_excel_old($id_periodo,$anio,$mes){
		
		$comisionMovilidad_model = new ComisionMovilidade;
		$movilidad_model = new Movilidade;
		
		$periodo = PeriodoComisione::find($id_periodo);
		
		$movilidad = $comisionMovilidad_model->getMovilidadByPeriodo($id_periodo,$anio,$mes);
		$meses = $movilidad_model->getMesByPeriodo($id_periodo);
		
		$dias = array('L','M','M','J','V','S','D');

		$mes_ = ltrim($mes, '0');
		$mesEnLetras = $this->mesesALetras($mes_);
		
		//$pdf = Pdf::loadView('pdf.ver_movilidad',compact('movilidad','anio','mesEnLetras','mes','meses','id_periodo','periodo'));
		
		$variable = [];
		$n = 1;

		$array_cabecera = array("N","Municipalidad");

		foreach($meses as $keym=>$m){
			$array_cabecera[] = $m->mes;
			
		}
		
		array_push($variable, $array_cabecera);
		
		foreach ($movilidad as $key=>$r) {

			$array_cuerpo = array(($key+1),$r->comision);

			foreach($meses as $keym=>$m){
				$movilidadMes = \App\Models\ComisionMovilidade::getMovilidadMesByPeriodoAndMunicipalidad($id_periodo,$anio,$m->mes_,$r->id_municipalidad_integrada);
				$array_cuerpo[] = (isset($movilidadMes->monto))?$movilidadMes->monto:"0";
			}

			array_push($variable, $array_cuerpo);
		}
		
		$export = new InvoicesExport3([$variable]);
		return Excel::download($export, 'lista_movilidad.xlsx');
	
	}

	function mesesALetras($mes) { 
		$meses = array('','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SETIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'); 
		return $meses[$mes];
	}
	

	public function editar_movilidad($id){
        
		$municipalidadIntegrada_model = new MunicipalidadIntegrada;
		$periodoComision_model = new PeriodoComisione;
		$regione_model = new Regione;
        //$tablaMaestra_model = new TablaMaestra;
		//$movilidad = new Movilidade;
        //$tipo_agrupacion = $tablaMaestra_model->getMaestroByTipo(99);
		$municipalidadIntegrada = $municipalidadIntegrada_model->getMuniIntegradaAll();
		$periodoComision = $periodoComision_model->getPeriodoComisionAll();
		$comision_movilidades = ComisionMovilidade::find($id);
        $movilidad_model = new ComisionMovilidade;
		$region = $regione_model->getRegionAll();
		
		return view('frontend.concepto.create',compact('id','municipalidadIntegrada','periodoComision','region','importe','estado'));
		
    }

    public function modal_movilidad_nuevoMovilidad($id){
		
		$comision_movilidades = new ComisionMovilidade;
		$regione_model = new Regione;
        $municipalidadIntegrada_model = new MunicipalidadIntegrada;
        $periodoComision_model = new PeriodoComisione;
		$tablaMaestra_model = new TablaMaestra;
		

		if($id>0){
			$comision_movilidades = ComisionMovilidade::find($id);
		}else{
			$comision_movilidades = new ComisionMovilidade;
		}
		
		
		//$tipoConcepto = $tipoConcepto_model->getTipoConceptoAll();
		$region = $regione_model->getRegionAll();
        $municipalidadIntegrada = $municipalidadIntegrada_model->getMuniIntegradaAll();
        $periodoComision = $periodoComision_model->getPeriodoAll();
		$tipoComision = $tablaMaestra_model->getMaestroByTipo(102);
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		

		return view('frontend.movilidad.modal_movilidad_nuevoMovilidad',compact('id','comision_movilidades','region','municipalidadIntegrada','periodoComision','tipoComision','periodo_ultimo','periodo_activo'));
	
	}

	public function obtener_comision($periodo,$tipo_comision){
			
		$muniIntegrada_model = new MunicipalidadIntegrada;
		$comision = $muniIntegrada_model->getMuniIntegradaByPeriodoAndTipComision($periodo,$tipo_comision);
		echo json_encode($comision);
		
	}

	public function obtener_comision_movilidad($periodo,$tipo_comision){
			
		$muniIntegrada_model = new MunicipalidadIntegrada;
		$comision = $muniIntegrada_model->getMuniIntegradaByPeriodoAndTipComisionMovilidad($periodo,$tipo_comision);
		echo json_encode($comision);
		
	}

    public function send_movilidad_nuevoMovilidad(Request $request){
		
		$request->validate([
			'comision'=>'required',
			'periodo'=>'required',
			'regional'=>'required',
			'monto'=>'required | numeric',
		]
		);

		$id_user = Auth::user()->id;
		//$movilidad_model = new Movilidade;

		if($request->id == 0){
			$comision_movilidades = new ComisionMovilidade;
			//$codigo = $movilidad_model->getCodigoConcepto();
			$comision_movilidades->id_usuario_inserta = $id_user;
		}else{
			$comision_movilidades = ComisionMovilidade::find($request->id);
			//$codigo = $request->codigo;
			$comision_movilidades->id_usuario_actualiza = $id_user;
		}
		
		$comision_movilidades->id_municipalidad_integrada = $request->comision;
		$comision_movilidades->id_periodo_comisiones = $request->periodo;
		$comision_movilidades->id_regional = $request->regional;
		$comision_movilidades->monto = $request->monto;
		$comision_movilidades->id_tipo_comision = $request->tipo_comision;
		//$comision_movilidades->estado = 1;
		$comision_movilidades->save();
    }

    public function eliminar_movilidad($id,$estado)
    {
		$id_user = Auth::user()->id;

		$comision_movilidades = ComisionMovilidade::find($id);
		$comision_movilidades->estado = $estado;
		$comision_movilidades->id_usuario_actualiza = $id_user;
		$comision_movilidades->save();

		echo $comision_movilidades->id;

    }

	public function ver_movilidad_excel($id_periodo,$anio,$mes){
		
		return Excel::download(new MovilidadDataExport($id_periodo,$anio,$mes), 'movilidad.xlsx');
	
	}

}

class InvoicesExport3 implements FromArray
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

class MovilidadDataExport implements FromView, ShouldAutoSize{

	use Exportable;

	protected $id_periodo;
	protected $anio;
	protected $mes;

	public function __construct($id_periodo,$anio,$mes)
	{
		$this->id_periodo = $id_periodo;
		$this->anio = $anio;
		$this->mes = $mes;
	}
	
	function mesesALetras($mes) { 
		$meses = array('','ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SETIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'); 
		return $meses[$mes];
	}

	public function view() : View{

		$comisionMovilidad_model = new ComisionMovilidade;
		$movilidad_model = new Movilidade;
		$anio = $this->anio;
		$mes = $this->mes;
		$id_periodo = $this->id_periodo;

		$periodo = PeriodoComisione::find($this->id_periodo);
		
		$movilidad = $comisionMovilidad_model->getMovilidadByPeriodo($this->id_periodo,$this->anio,$this->mes);
		$meses = $movilidad_model->getMesByPeriodo($this->id_periodo);
		
		$dias = array('L','M','M','J','V','S','D');

		$mes_ = ltrim($this->mes, '0');
		$mesEnLetras = $this->mesesALetras($mes_);

		return view('pdf.ver_movilidad_excel',compact('movilidad','anio','mesEnLetras','mes','meses','id_periodo','periodo'));
	}

}
