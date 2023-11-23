<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComisionMovilidade;
use App\Models\Regione;
use App\Models\MunicipalidadIntegrada;
use App\Models\PeriodoComisione;
use Auth;

class MovilidadController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_movilidad(){

		$municipalidadIntegrada_model = new MunicipalidadIntegrada;
		$comision_movilidades = new ComisionMovilidade;
		$periodoComision_model = new PeriodoComisione;
        //$tablaMaestra_model = new TablaMaestra;
		//$movilidad = new Movilidade;
        //$tipo_agrupacion = $tablaMaestra_model->getMaestroByTipo(99);
		$municipalidadIntegrada = $municipalidadIntegrada_model->getMuniIntegradaAll();
		$periodoComision = $periodoComision_model->getPeriodoComisionAll();

        return view('frontend.movilidad.all',compact('municipalidadIntegrada','comision_movilidades','periodoComision'));
    }

    public function listar_movilidad_ajax(Request $request){
	
		$movilidad_model = new ComisionMovilidade;
		$p[]=$request->comision;
		$p[]=$request->periodo;
        $p[]="";
        $p[]="";
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

	public function editar_movilidad($id){
        
		$municipalidadIntegrada_model = new MunicipalidadIntegrada;
		$periodoComision_model = new PeriodoComisione;
		$regione_model = new Regione;
        //$tablaMaestra_model = new TablaMaestra;
		//$movilidad = new Movilidade;
        //$tipo_agrupacion = $tablaMaestra_model->getMaestroByTipo(99);
		$municipalidadIntegrada = $municipalidadIntegrada_model->getMunicipalidadIntegradaAll();
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
        
        
		//$movilidad_model = new Movilidade;
		//$tablaMaestra_model = new TablaMaestra;
		//$tipo_afectacion = $tablaMaestra_model->getMaestroByTipo(53);
		//$moneda = $tablaMaestra_model->getMaestroByTipo(1);

		if($id>0){
			$comision_movilidades = ComisionMovilidade::find($id);
		}else{
			$comision_movilidades = new ComisionMovilidade;
		}
		
		
		//$tipoConcepto = $tipoConcepto_model->getTipoConceptoAll();
		$region = $regione_model->getRegionAll();
        $municipalidadIntegrada = $municipalidadIntegrada_model->getMunicipalidadIntegradaAll();
        $periodoComision = $periodoComision_model->getPeriodoComisionAll();
		
		return view('frontend.movilidad.modal_movilidad_nuevoMovilidad',compact('id','comision_movilidades','region','municipalidadIntegrada','periodoComision'));
	
	}

    public function send_movilidad_nuevoMovilidad(Request $request){
		
		$id_user = Auth::user()->id;
		//$movilidad_model = new Movilidade;

		if($request->id == 0){
			$comision_movilidades = new ComisionMovilidade;
			//$codigo = $movilidad_model->getCodigoConcepto();
		}else{
			$comision_movilidades = ComisionMovilidade::find($request->id);
			//$codigo = $request->codigo;
		}
		
		$comision_movilidades->id_municipalidad_integrada = $request->comision;
		$comision_movilidades->id_periodo_comisiones = $request->periodo;
		$comision_movilidades->id_regional = $request->regional;
		$comision_movilidades->monto = $request->monto;
		$comision_movilidades->estado = 1;
		$comision_movilidades->id_usuario_inserta = $id_user;
		$comision_movilidades->save();
    }

    public function eliminar_movilidad($id,$estado)
    {
		$comision_movilidades = ComisionMovilidade::find($id);
		$comision_movilidades->estado = $estado;
		$comision_movilidades->save();

		echo $comision_movilidades->id;

    }

}
