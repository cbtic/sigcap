<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificado;
use App\Models\TablaMaestra;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Auth;
class CertificadoController extends Controller
{
    function consultar_certificado(){

        return view('frontend.certificado.all');
    }



    public function listar_certificado(Request $request){
       
		$certificado_model = new Certificado();
        
        $p[]=$request->cap;
		$p[]=$request->nombre;
		$p[]=$request->estado;          
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
        //print_r(json_encode($p)); exit();
		$data = $certificado_model->listar_certificado($p);
        
     
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

    public function modal_certificado($id){
		
		$id_user = Auth::user()->id;
		$certificado = new Certificado();
        $certificado_model = new Certificado();
        
        if($id>0)  {
            $certificado = Certificado::find($id);
			//$afiliado=Seguro_afiliado::find($id);
            $datos_agremiado=$certificado_model->datos_agremiado_certificado($id);

            $cap_numero=$datos_agremiado[0]->numero_cap;
			$desc_cliente=$datos_agremiado[0]->agremiado;
			$situacion=$datos_agremiado[0]->tipo_certificado;
			$situacion=$datos_agremiado[0]->tipo_certificado;
			$situacion=$datos_agremiado[0]->tipo_certificado;
			
		} 
		else{
			$certificado = new Certificado;
			
            $cap_numero="";
			$desc_cliente="";
			$situacion="";
			$id_seguro="";
		} 
        
        $tablaMaestra_model = new TablaMaestra;
	
		
		$tipo_certificado = $tablaMaestra_model->getMaestroByTipo(100);

		//$regione_model = new Regione;
		//$region = $regione_model->getRegionAll();
		//print_r ($unidad_trabajo);exit();

		return view('frontend.certificado.modal_certificado',compact('id','certificado','tipo_certificado','cap_numero','desc_cliente','situacion'));

    }

	
	public function certificado_vista($id){
		
		$id_user = Auth::user()->id;

        $certificado=certificado::where('id', $id)->where('estado', '1')->get()->all();
       
       
		return view('frontend.certificado.modal_certificado_vista',compact('id','certificado'));

    }


	public function valida_pago(Request $request){
       
		$certificado_model = new Certificado();
        
        $pidagremiado=$request->idagremiado;
		$pserie=$request->serie;
		$pnumero=$request->numero;          
		$pconcepto=$request->concepto;
		
        //print_r(json_encode($p)); exit();
		$data = $certificado_model->valida_pago($pidagremiado,$pserie,$pnumero,$pconcepto);
       
		$array["fecha_e"] = "06/11/2023";
        $array["vigencia"] = "20";
		$array["codigo"] = "001-2023";

		echo json_encode($data);

	}

	public function send_certificado(Request $request){
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$certificado = new Certificado;
		}else{
			$certificado = Certificado::find($request->id);
		}
		
		$certificado->fecha_solicitud = $request->fecha_sol;
		$certificado->fecha_emision = $request->fecha_emi;
		$certificado->id_agremiado = $request->idagremiado;

		$certificado->dias_validez = $request->validez;
		$certificado->especie_valorada = $request->ev;
		$certificado->codigo =$request->codigo; 
		$certificado->observaciones =$request->observaciones;
		$certificado->estado =1;
		$certificado->id_tipo =$request->tipo;
		$certificado->id_usuario_inserta = $id_user;
	
		$certificado->save();
		
		        
    }
	public function eliminar_certificado($id){

		$segurosPlane = Certificado::find($id);
		$segurosPlane->estado= "0";
		$segurosPlane->save();
		
		echo "success";

    }

	public function certificado_pdf($id){
		
		$datos_model=new certificado;

		$datos=$datos_model->datos_agremiado_certificado($id);
		$nombre=$datos[0]->numero_cap;
		$fecha_emision=$datos[0]->fecha_emision;
		$trato=$datos[0]->id_sexo;

		$numero = $datos[0]->dias_validez;
		$numeroEnLetras = $this->numeroALetras($numero); 
		

		if ($trato==3) {
			$tratodesc="EL ARQUITECTO ";
			$faculta="facultado";
		}
		else{
			$tratodesc="LA ARQUITECTA ";
			$faculta="facultada";
		}

		Carbon::setLocale('es');


		// Crear una instancia de Carbon a partir de la fecha
		$carbonDate = new Carbon($fecha_emision);

		// Formatear la fecha en un formato largo

	
		$formattedDate = $carbonDate->timezone('America/Lima')->formatLocalized('%A %d de %B %Y'); //->format('l, j F Y ');
		
		
		$pdf = Pdf::loadView('frontend.certificado.certificado_pdf',compact('datos','nombre','formattedDate','tratodesc','faculta','numeroEnLetras'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
    	//return $pdf->download('invoice.pdf');
		//return view('frontend.certificado.certificado_pdf');

	}

	function numeroALetras($numero) { 
		$unidades = array('', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'); 
		$decenas = array('', 'Diez', 'Veinte', 'Treinta', 'Cuarenta', 'Cincuenta', 'Sesenta', 'Setenta', 'Ochenta', 'Noventa'); 
		 
		if ($numero < 10) { 
			return $unidades[$numero]; 
		} elseif ($numero < 20) { 
			return 'dieci' . $unidades[$numero - 10]; 
		} elseif ($numero < 100) { 
			$decena = floor($numero / 10); 
			$unidad = $numero % 10; 
			$texto = $decenas[$decena]; 
			if ($unidad > 0) { 
				$texto .= ' y ' . $unidades[$unidad]; 
			} 
			return $texto; 
		} 
	}
}




		