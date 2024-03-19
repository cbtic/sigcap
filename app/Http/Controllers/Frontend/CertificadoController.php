<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificado;
use App\Models\TablaMaestra;
use App\Models\Proyecto;
use App\Models\DerechoRevision;
use App\Models\Agremiado;
use App\Models\Ubigeo;
use App\Models\Persona;
use App\Models\Empresa;
use App\Models\Presupuesto;
use App\Models\Solicitude;
use App\Models\Proyectista;
use App\Models\UsoEdificacione;
use App\Models\Propietario;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Auth;
class CertificadoController extends Controller
{
    function consultar_certificado(){

        return view('frontend.certificado.all');
    }

	function consultar_certificado_tipo3(){

        return view('frontend.certificado.all_tipo3');
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
		$certificado_model2 = new Certificado();
		$tablaMaestra_model = new TablaMaestra;
		$proyecto = new Proyecto();

		$proyecto_model = new Proyecto();
		//$nombre_proyecto = $proyecto_model->obtenerNombreProyecto();
        
        if($id>0)  {
            $certificado = Certificado::find($id);
			//$afiliado=Seguro_afiliado::find($id);
            $datos_agremiado=$certificado_model->datos_agremiado_certificado($id);

            $cap_numero=$datos_agremiado[0]->numero_cap;
			$desc_cliente=$datos_agremiado[0]->agremiado;
			$email1=$datos_agremiado[0]->email1;
			$situacion=$datos_agremiado[0]->situacion;


			//$situacion=$datos_agremiado[0]->tipo_certificado;
			//$situacion=$datos_agremiado[0]->tipo_certificado;
			
			$tipo_certificado = $tablaMaestra_model->getMaestroByTipo(100);
			$tipo_tramite = $tablaMaestra_model->getMaestroByTipo(44);
			$tipo_tramite_tipo3 = $tablaMaestra_model->getMaestroByTipo(38);
			
			
			$nombre_proyecto=$certificado_model2->datos_agremiado_certificado1($id);
			$nombre_proy=$nombre_proyecto[0]->id_solicitud;
		} 
		else{
			$certificado = new Certificado;
			
            $cap_numero="";
			$desc_cliente="";
			$situacion="";
			$id_seguro="";
			$email1="";
			$tipo_certificado = $tablaMaestra_model->getMaestroByTipo(100);
			$tipo_tramite = $tablaMaestra_model->getMaestroByTipo(44);
			$tipo_tramite_tipo3 = $tablaMaestra_model->getMaestroByTipo(38);
			$nombre_proy="";
			
		} 
        
		//$regione_model = new Regione;
		//$region = $regione_model->getRegionAll();
		//print_r ($unidad_trabajo);exit();

		return view('frontend.certificado.modal_certificado',compact('id','certificado','tipo_tramite_tipo3','tipo_certificado','cap_numero','desc_cliente','situacion','email1','proyecto','tipo_tramite','nombre_proy'));

    }

	public function modal_certificado_tipo3($id){
		
		$id_user = Auth::user()->id;
		$tablaMaestra_model=new TablaMaestra;
		$ubigeo_model = new Ubigeo;

		if($id>0){
			$proyecto = Proyecto::find($id);
			$propietario = new Propietario;
			$empresa = new Empresa;
			$persona = new Persona;
			$certificado = new Certificado;
			$agremiado = new Agremiado;
		}else{
			$proyecto = new Proyecto;
			$propietario = new Propietario;
			$empresa = new Empresa;
			$persona = new Persona;
			$certificado = new Certificado;
			$agremiado = new Agremiado;
		}
        

		$tipo_tramite = $tablaMaestra_model->getMaestroByTipo(38);
		$sitio = $tablaMaestra_model->getMaestroByTipo(33);
		$tipo_direccion = $tablaMaestra_model->getMaestroByTipo(35);
		$departamento = $ubigeo_model->getDepartamento();
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$tipo_obra = $tablaMaestra_model->getMaestroByTipo(29);
		$tipo_proyectista = $tablaMaestra_model->getMaestroByTipo(41);
		$tipo_uso = $tablaMaestra_model->getMaestroByTipo(111);
		$tipo_proyecto = $tablaMaestra_model->getMaestroByTipo(24);
		

		return view('frontend.certificado.modal_certificado_tipo3',compact('id','empresa','tipo_proyecto','tipo_uso','tipo_proyectista','tipo_obra','certificado','tipo_documento','tipo_tramite','departamento','sitio','tipo_direccion','propietario','agremiado','persona','proyecto'));

    }

	public function send_proyecto_tipo3(Request $request){

		$id_user = Auth::user()->id;

		if($request->id == 0){
			$proyecto = new Proyecto;
			$propietario = new Propietario;
			$proyectistaPrincipal = new Proyectista;
			$solicitud = new Solicitude;
			$presupuesto = new Presupuesto;
			$usoEdificacione = new UsoEdificacione;
		}else{
			$proyecto = Proyecto::find($request->id);
		}
		
		$numero_cap_asociado = $request->numero_cap_asociado;
		$agremiado = Agremiado::where("id",$request->idagremiado_)->where("estado","1")->first();
		$persona = Persona::where("numero_documento",$request->dni_propietario)->where("estado","1")->first();
		$empresa = Empresa::where("ruc",$request->ruc_propietario)->where("estado","1")->first();		
		
		$proyectistaPrincipal->id_agremiado = $agremiado->id;
		$proyectistaPrincipal->celular = $agremiado->celular1;
		$proyectistaPrincipal->email = $agremiado->email1;
		$proyectistaPrincipal->id_usuario_inserta = $id_user;
		
		
		if($persona->id){
			$propietario->id_persona = $persona->id;
			$propietario->representante = $request->nombre_propietario;
			$propietario->celular = $request->celular_dni;
			$propietario->email = $request->email_dni;
		}else{
			$propietario->id_empresa = $empresa->id;
			$propietario->representante = $empresa-> representante;
			$propietario->celular = $request->telefono_ruc;
			$propietario->email = $request->email_ruc;
		}
		$propietario->id_usuario_inserta = $id_user;
		$propietario->save();
		

		$proyecto->id_ubigeo = $request->distrito;
		$proyecto->id_tipo_sitio = $request->sitio;
		$proyecto->nombre = $request->nombre_proyecto;
		$proyecto->direccion = $request->direccion_tipo;
		$proyecto->id_tipo_proyecto = $request->tipo_proyecto;
		$proyecto->id_usuario_inserta = $id_user;
		$proyecto->save();

		$presupuesto->id_tipo_obra = $request->tipo_obra;
		$presupuesto->area_techada = $request->area_techada;
		$presupuesto->total_presupuesto = $request->valor_obra;
		$presupuesto->id_usuario_inserta = $id_user;
		$presupuesto->save();

		$usoEdificacione->id_tipo_uso = $request->tipo_uso;
		$usoEdificacione->area_techada = $request->area_techada;
		$usoEdificacione->id_usuario_inserta = $id_user;
		$usoEdificacione->save();
		
		$solicitud->id_regional = 5;
		$solicitud->fecha_registro = Carbon::now()->format('Y-m-d');
		$solicitud->direccion = $request->direccion_tipo;
		$solicitud->id_ubigeo = $request->distrito;
		$solicitud->tipo_proyecto = $request->tipo_proyecto;
		$solicitud->valor_obra = $request->valor_obra;
		$solicitud->area_total = $request->area_techada;
		$solicitud->id_proyecto = $proyecto->id;
		$solicitud->id_proyectista = $proyectistaPrincipal->id;
		$solicitud->id_usuario_inserta = $id_user;
		$solicitud->save();
		
		foreach($numero_cap_asociado as $row){
			$proyectista = new Proyectista;
			$agremiado = Agremiado::where("numero_cap",$row)->where("estado","1")->first();
			$proyectista->id_solicitud = $solicitud->id;
			$proyectista->id_agremiado = $agremiado->id;
			$proyectista->celular = $agremiado->celular1;
			$proyectista->email = $agremiado->email1;
			$proyectista->id_usuario_inserta = $id_user;
			$proyectista->save();
		}
		
		$proyectistaPrincipal->id_solicitud = $solicitud->id;
		$proyectistaPrincipal->save();
		
		$propietario->id_solicitud = $solicitud->id;
		$propietario->save();

		$presupuesto->id_solicitud = $solicitud->id;
		$presupuesto->save();

		$usoEdificacione->id_solicitud = $solicitud->id;
		$usoEdificacione->save();


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
		
		$certificado_model = new Certificado;
		
		if($request->id == 0){
			$certificado = new Certificado;
			$codigo = $certificado_model->getCodigoCertificado($request->tipo);
			$certificado->codigo = $codigo;
		}else{
			$certificado = Certificado::find($request->id);
		}
		
		$certificado->fecha_solicitud = $request->fecha_sol;
		$certificado->fecha_emision = $request->fecha_emi;
		$certificado->id_agremiado = $request->idagremiado;
		$certificado->id_tipo_tramite = $request->tipo_tramite;
		$certificado->dias_validez = $request->validez;
		$certificado->especie_valorada = $request->ev;
		//$certificado->codigo = getCodigoCertificado($request->tipo);//$request->codigo; 
		$certificado->observaciones =$request->observaciones;
		$certificado->estado =1;
		$certificado->id_tipo =$request->tipo;
		if($request->id_tipo==1 || $request->id_tipo==2){
			$certificado->id_solicitud = $request->nombre_proyecto;
		}
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
		$tramite = $datos[0]->tipo_tramite;
		
		$numeroEnLetras = $this->numeroALetras($numero); 
		

		if ($trato==3) {
			$tratodesc="EL ARQUITECTO ";
			$faculta="facultado";
			$habilita="HABILITADO";
			$inscripcion="inscrito";
		}
		else{
			$tratodesc="LA ARQUITECTA ";
			$faculta="facultada";
			$habilita="HABILITADA";
			$inscripcion="inscrita";
		}

		Carbon::setLocale('es');

		// Crear una instancia de Carbon a partir de la fecha
		$carbonDate = new Carbon($fecha_emision);

		// Formatear la fecha en un formato largo

	
		$formattedDate = $carbonDate->timezone('America/Lima')->formatLocalized(' %d de %B %Y'); //->format('l, j F Y ');
		
		
		$pdf = Pdf::loadView('frontend.certificado.certificado_pdf',compact('datos','nombre','inscripcion','habilita','formattedDate','tratodesc','faculta','numeroEnLetras'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
    	//return $pdf->download('invoice.pdf');
		//return view('frontend.certificado.certificado_pdf');

	}

	public function certificado_tipo1_pdf($id){
		
		$datos_model=new Certificado;
		$solicitud_model = new DerechoRevision;
		$tablaMaestra_model=new TablaMaestra;
		$datos2_model=new Certificado;
		$ubigeo_model=new Ubigeo;

		$tipo_proyecto = $tablaMaestra_model->getMaestroByTipo(41);

		$certificado = Certificado::where("id",$id)->where("estado","1")->first();

		$agremiado = Agremiado::where("id",$certificado->id_agremiado)->where("estado","1")->first();

		$tipo_proyectistas=$datos2_model->datos_agremiado_certificado1($id);

		//$tipo_proyectista=$proyectista->tipo_proyectista;

		$datos=$datos_model->datos_agremiado_certificado($id);
		$nombre=$datos[0]->numero_cap;
		$fecha_emision=$datos[0]->fecha_emision;
		$trato=$datos[0]->id_sexo;
		
		$numero = $datos[0]->dias_validez;
		$numeroEnLetras = $this->numeroALetras($numero); 
		

		if ($trato==3) {
			$tratodesc="EL ARQUITECTO ";
			$faculta="facultado";
			$habilita="HABILITADO";
		}
		else{
			$tratodesc="LA ARQUITECTA ";
			$faculta="facultada";
			$habilita="HABILITADA";
		}

		//$tipo_proyectistas = $solicitud_model->getSolicitudNumeroCap($agremiado->numero_cap);

		$nombre_proyectista=$tipo_proyectistas[0]->tipo_proyectista;
		$direccion_proyecto=$tipo_proyectistas[0]->direccion;
		$lugar_proyecto=$tipo_proyectistas[0]->lugar;
		$nombre_propietario=$tipo_proyectistas[0]->propietario;
		$valor_unit=$tipo_proyectistas[0]->valor_unitario;
		$tipo_obra=$tipo_proyectistas[0]->tipo_obras;
		$sub_tipo_uso_=$tipo_proyectistas[0]->sub_tipo_uso;
		//$departamento=$ubigeo_model->obtenerDepartamento($tipo_proyectistas[0]->id_departamento);
		//$departamento_numero=$tipo_proyectistas[0]->id_departamento;
		//$departamento=$ubigeo_model->obtenerDepartamento($departamento_numero);

		Carbon::setLocale('es');


		// Crear una instancia de Carbon a partir de la fecha
		$carbonDate = new Carbon($fecha_emision);

		// Formatear la fecha en un formato largo

	
		$formattedDate = $carbonDate->timezone('America/Lima')->formatLocalized(' %d de %B %Y'); //->format('l, j F Y ');
		
		
		$pdf = Pdf::loadView('frontend.certificado.certificado_tipo1_pdf',compact('datos','nombre','formattedDate','tratodesc','faculta','numeroEnLetras','habilita','tipo_proyectistas','nombre_proyectista','direccion_proyecto','lugar_proyecto','nombre_propietario','valor_unit','tipo_obra','sub_tipo_uso_'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
    	//return $pdf->download('invoice.pdf');
		//return view('frontend.certificado.certificado_pdf');

	}

	public function certificado_tipo2_pdf($id){
		
		$datos_model=new Certificado;
		$solicitud_model = new DerechoRevision;
		$tablaMaestra_model=new TablaMaestra;
		$datos2_model=new Certificado;
		$ubigeo_model=new Ubigeo;

		$tipo_proyecto = $tablaMaestra_model->getMaestroByTipo(41);

		$certificado = Certificado::where("id",$id)->where("estado","1")->first();

		$agremiado = Agremiado::where("id",$certificado->id_agremiado)->where("estado","1")->first();

		$tipo_proyectistas=$datos2_model->datos_agremiado_certificado2($id);

		//$tipo_proyectista=$proyectista->tipo_proyectista;

		$datos=$datos_model->datos_agremiado_certificado($id);
		$nombre=$datos[0]->numero_cap;
		$fecha_emision=$datos[0]->fecha_emision;
		$trato=$datos[0]->id_sexo;
		
		$numero = $datos[0]->dias_validez;
		$numeroEnLetras = $this->numeroALetras($numero); 
		

		if ($trato==3) {
			$tratodesc="EL ARQUITECTO ";
			$faculta="facultado";
			$habilita="HABILITADO";
		}
		else{
			$tratodesc="LA ARQUITECTA ";
			$faculta="facultada";
			$habilita="HABILITADA";
		}

		//$tipo_proyectistas = $solicitud_model->getSolicitudNumeroCap($agremiado->numero_cap);

		$nombre_proyectista=$tipo_proyectistas[0]->tipo_proyectista;
		$direccion_proyecto=$tipo_proyectistas[0]->direccion;
		$lugar_proyecto=$tipo_proyectistas[0]->lugar;
		$nombre_propietario=$tipo_proyectistas[0]->propietario;
		$valor_unit=$tipo_proyectistas[0]->valor_unitario;
		$tipo_tramite=$tipo_proyectistas[0]->tipo_tramite;
		$tipo_uso=$tipo_proyectistas[0]->tipo_uso;
		$zonificacion=$tipo_proyectistas[0]->zonificacion;
		$area_total=$tipo_proyectistas[0]->area_total;
		//$departamento=$ubigeo_model->obtenerDepartamento($tipo_proyectistas[0]->id_departamento);
		//$departamento_numero=$tipo_proyectistas[0]->id_departamento;
		//$departamento=$ubigeo_model->obtenerDepartamento($departamento_numero);

		Carbon::setLocale('es');


		// Crear una instancia de Carbon a partir de la fecha
		$carbonDate = new Carbon($fecha_emision);

		// Formatear la fecha en un formato largo

	
		$formattedDate = $carbonDate->timezone('America/Lima')->formatLocalized(' %d de %B %Y'); //->format('l, j F Y ');
		
		
		$pdf = Pdf::loadView('frontend.certificado.certificado_tipo2_pdf',compact('datos','nombre','formattedDate','tratodesc','faculta','numeroEnLetras','habilita','tipo_proyectistas','nombre_proyectista','direccion_proyecto','lugar_proyecto','nombre_propietario','valor_unit','tipo_tramite','tipo_uso','zonificacion','area_total'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
    	//return $pdf->download('invoice.pdf');
		//return view('frontend.certificado.certificado_pdf');

	}

	public function certificado_tipo3_pdf($id){
		
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
			$cita="del citado arquitecto";
			$inscripcion="inscrito";
			$habilita="HABILITADO";
		}
		else{
			$tratodesc="LA ARQUITECTA ";
			$faculta="facultada";
			$cita="de la citada arquitecta";
			$inscripcion="inscrita";
			$habilita="HABILITADA";
		}

		Carbon::setLocale('es');


		// Crear una instancia de Carbon a partir de la fecha
		$carbonDate = new Carbon($fecha_emision);

		// Formatear la fecha en un formato largo

	
		$formattedDate = $carbonDate->timezone('America/Lima')->formatLocalized(' %d de %B %Y'); //->format('l, j F Y ');
		
		
		$pdf = Pdf::loadView('frontend.certificado.certificado_tipo3_pdf',compact('datos','nombre','cita','habilita','inscripcion','formattedDate','tratodesc','faculta','numeroEnLetras'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();
    	//return $pdf->download('invoice.pdf');
		//return view('frontend.certificado.certificado_pdf');

	}

	public function constancia_pdf($id){
		
		$datos_model=new certificado;

		$datos=$datos_model->datos_agremiado_certificado($id);
		$nombre=$datos[0]->numero_cap;
		$fecha_emision=$datos[0]->fecha_emision;
		$trato=$datos[0]->id_sexo;
		$fecha_colegiado=$datos[0]->fecha_colegiado;

		$numero = $datos[0]->dias_validez;
		$tramite = $datos[0]->tipo_tramite;
		
		//$numeroEnLetras = $this->numeroALetras($numero); 
		

		if ($trato==3) {
			$tratodesc="EL ARQUITECTO ";
			$tratodesc_minuscula="el arquitecto ";
			$faculta="facultado";
			$habilita="habilitado";
			$articulo="EL";
			$inscripcion="inscrito";
		}
		else{
			$tratodesc="LA ARQUITECTA ";
			$tratodesc_minuscula="la arquitecta ";
			$faculta="facultada";
			$habilita="habilitada";
			$articulo="LA";
			$inscripcion="inscrita";
		}

		Carbon::setLocale('es');


		// Crear una instancia de Carbon a partir de la fecha
		$carbonDate = new Carbon($fecha_emision);

		$carbonDate_colegiado = new Carbon($fecha_colegiado);

		// Formatear la fecha en un formato largo

	
		$formattedDate = $carbonDate->timezone('America/Lima')->formatLocalized(' %d de %B %Y'); //->format('l, j F Y ');
		
		$formattedDate_colegiado = $carbonDate_colegiado->timezone('America/Lima')->formatLocalized(' %d de %B %Y');
		
		$pdf = Pdf::loadView('frontend.certificado.constancia_pdf',compact('datos','nombre','inscripcion','formattedDate','tratodesc','faculta','articulo','formattedDate_colegiado','tratodesc_minuscula','habilita'));
		
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
		} elseif ($numero == 11) { 
				return "Once";
		} elseif ($numero == 12) { 
				return "Doce";
		} elseif ($numero == 13) { 
				return "Trece";
		} elseif ($numero == 14) { 
				return "Catorce";
		} elseif ($numero == 15) { 
				return "Quince"; 
		} elseif ($numero > 15 and $numero < 20) { 
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

	public function certificado_tipo($id){
			
		$certificado_model = new Certificado;
		$tipo_certificado = $certificado_model->getTipoCertificado($id);
		echo json_encode($tipo_certificado);
		
	}
}




		