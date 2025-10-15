<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CentroCosto;
use Auth;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CentroCostoController extends Controller
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
		$this->middleware('can:Centro de costos')->only(['consulta_centro_costo']);
	}

    public function importar_centro_costo(){ 
	
		$ch = curl_init('http://webservice.limacap.org:8080/webservices.php?op=centrocostos');		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		));
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$resultWebApi = curl_exec($ch);
		
		if($errno = curl_errno($ch)) {
			$error_message = curl_strerror($errno);
			echo "cURL error ({$errno}):\n {$error_message}";
		}
		
		$dataWebApi = json_decode($resultWebApi);
		
		foreach($dataWebApi as $row){
		
			$centroCostoExiste = CentroCosto::where("codigo",$row->CODIGO)->where("estado",1)->get();
			
			if(count($centroCostoExiste)==0){
				$centroCosto = new CentroCosto;
				$centroCosto->id_regional=5;
				$centroCosto->periodo=date("Y");
				$centroCosto->codigo = $row->CODIGO;
				$centroCosto->denominacion = $row->NOM;
				$centroCosto->total_debe = ($row->TDEBE!="")?$row->TDEBE:0;
				$centroCosto->total_haber = ($row->THABER!="")?$row->THABER:0;
				$centroCosto->estado = 1;
				$centroCosto->id_usuario_inserta = 1;
				$centroCosto->save();
			}

			$centroCostoExiste = CentroCosto::where("codigo",$row->CODIGO)->where("denominacion",$row->NOM)->where("estado",1)->get();

			if(count($centroCostoExiste)==0){

				$centroCostoAnt = CentroCosto::where("codigo",$row->CODIGO)->where("estado",1)->first();
				if($centroCostoAnt){
					$centroCostoAnt->estado = 0;
					$centroCostoAnt->save();
				}

				$centroCosto = new CentroCosto;
				$centroCosto->id_regional=5;
				$centroCosto->periodo=date("Y");
				$centroCosto->codigo = $row->CODIGO;
				$centroCosto->denominacion = $row->NOM;
				$centroCosto->total_debe = ($row->TDEBE!="")?$row->TDEBE:0;
				$centroCosto->total_haber = ($row->THABER!="")?$row->THABER:0;
				$centroCosto->estado = 1;
				$centroCosto->id_usuario_inserta = 1;
				$centroCosto->save();

			}
			
		}
		
	}
	
	public function test(){ 
			
		$log = ['metodo' => "dfdfccdcd", 'description' => "ddcdcc"];
		$logCentroCosto = new Logger('centro_costo_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/centro_costo_log.log')), Logger::INFO);
		$logCentroCosto->info('centro_costo_log', $log);		
		
	}	

	function consulta_centro_costo(){

        return view('frontend.centro_costo.all');
    }

    public function listar_centro_costo_ajax(Request $request){
	
		$centro_costo_model = new CentroCosto;
		$p[]=$request->denominacion;
		$p[]=$request->codigo;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $centro_costo_model->listar_centro_costo_ajax($p);
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
	
}
