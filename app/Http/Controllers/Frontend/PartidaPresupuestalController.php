<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PartidaPresupuestale;
use Auth;

class PartidaPresupuestalController extends Controller
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
		$this->middleware('can:Partida Presupuestal')->only(['consulta_partida_presupuestal']);
	}


    public function importar_partida_presupuestal(){ 
		
		$ch = curl_init('http://webservice.limacap.org:8080/webservices.php?op=presupuestos');		
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
			
			$partidaPresupuestaleExiste = PartidaPresupuestale::where("codigo",$row->CODIGO)->where("estado",1)->get();
			
			if(count($partidaPresupuestaleExiste)==0){
				$partidaPresupuestal = new PartidaPresupuestale;
				$partidaPresupuestal->id_regional=5;
				$partidaPresupuestal->periodo=date("Y");
				$partidaPresupuestal->codigo = $row->CODIGO;
				$partidaPresupuestal->denominacion = $row->NOMBRE;
				$partidaPresupuestal->total_01 = $row->PRE01;
				$partidaPresupuestal->total_02 = $row->PRE02;
				$partidaPresupuestal->total_03 = $row->PRE03;
				$partidaPresupuestal->total_04 = $row->PRE04;
				$partidaPresupuestal->total_05 = $row->PRE05;
				$partidaPresupuestal->total_06 = $row->PRE06;
				$partidaPresupuestal->total_07 = $row->PRE07;
				$partidaPresupuestal->total_08 = $row->PRE08;
				$partidaPresupuestal->total_09 = $row->PRE09;
				$partidaPresupuestal->total_10 = $row->PRE10;
				$partidaPresupuestal->total_11 = $row->PRE11;
				$partidaPresupuestal->total_12 = $row->PRE12;
				$partidaPresupuestal->estado = 1;
				$partidaPresupuestal->id_usuario_inserta = 1;
				$partidaPresupuestal->save();
			}

			$partidaPresupuestaleExiste = PartidaPresupuestale::where("codigo",$row->CODIGO)->where("denominacion",$row->NOMBRE)->where("estado",1)->get();

			if(count($partidaPresupuestaleExiste)==0){

				$partidaPresupuestalAnt = PartidaPresupuestale::where("codigo",$row->CODIGO)->where("estado",1)->first();
				if($partidaPresupuestalAnt){
					$partidaPresupuestalAnt->estado = 0;
					$partidaPresupuestalAnt->save();
				}

				$partidaPresupuestal = new PartidaPresupuestale;
				$partidaPresupuestal->id_regional=5;
				$partidaPresupuestal->periodo=date("Y");
				$partidaPresupuestal->codigo = $row->CODIGO;
				$partidaPresupuestal->denominacion = $row->NOMBRE;
				$partidaPresupuestal->total_01 = $row->PRE01;
				$partidaPresupuestal->total_02 = $row->PRE02;
				$partidaPresupuestal->total_03 = $row->PRE03;
				$partidaPresupuestal->total_04 = $row->PRE04;
				$partidaPresupuestal->total_05 = $row->PRE05;
				$partidaPresupuestal->total_06 = $row->PRE06;
				$partidaPresupuestal->total_07 = $row->PRE07;
				$partidaPresupuestal->total_08 = $row->PRE08;
				$partidaPresupuestal->total_09 = $row->PRE09;
				$partidaPresupuestal->total_10 = $row->PRE10;
				$partidaPresupuestal->total_11 = $row->PRE11;
				$partidaPresupuestal->total_12 = $row->PRE12;
				$partidaPresupuestal->estado = 1;
				$partidaPresupuestal->id_usuario_inserta = 1;
				$partidaPresupuestal->save();

			}
			
		}
		
	}

	function consulta_partida_presupuestal(){

        return view('frontend.partida_presupuestal.all');
    }

    public function listar_partida_presupuestal_ajax(Request $request){
	
		$partida_presupuestal_model = new PartidaPresupuestale;
		$p[]=$request->denominacion;
		$p[]=$request->codigo;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $partida_presupuestal_model->listar_partida_presupuestal_ajax($p);
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
