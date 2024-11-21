<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\PersonaDetalle;
//use App\Models\DocumentoIdentidade;
use App\Models\TablaUbicacione;
use App\Models\Empresa;
use App\Models\Ubigeo;
use App\Models\UnidadTrabajo;
use App\Models\Contrato;
use App\Models\TablaMaestra;
use App\Models\Beneficiario;

//use App\Models\CondicionLaborale;

use Auth;

class PersonaController extends Controller
{
	/*
	public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}
	*/
	
    public function index(){
        //$persona_model = new Persona;
        //$persona = $persona_model->getPersonaAll();
        //return view('frontend.persona.all',compact('persona'));
        return view('frontend.persona.all');
    }

	public function create()
    {
        return view('frontend.persona.create');
    }

    public function listar_persona_ajax(Request $request){
		
		$persona_model = new Persona;
		$p[]=$request->numero_documento;
		$p[]=$request->persona;
		$p[]=$request->unidad;
		$p[]=$request->empresa;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $persona_model->listar_persona_ajax($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;
		
		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

		echo json_encode($result);
		//print_r ($result);
	}

    public function modal_persona($id){
		$id_user = Auth::user()->id;
		$persona = new Persona;
		if($id>0) $persona = Persona::find($id);else $persona = new Persona;

		//$tipo_documento = DocumentoIdentidade::all();
		$tablaMaestra_model = new TablaMaestra;		
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo("TIP_DOC");
		
		if($id>0) $persona_detalle = PersonaDetalle::where('id_persona', '=', $id)->where('estado', '=', 'A')->first();else $persona_detalle = new PersonaDetalle;
		//$persona_detalle = PersonaDetalle::where('id_persona', '=', $id)->where('estado', '=', 'A')->first();

		$tabla_model = new TablaUbicacione;		
		$profesiones = $tabla_model->getTablaUbicacionAll("tprofesiones","1");
		$condLaboral = $tabla_model->getTablaUbicacionAll("condicion_laborales","1");
		$tipPlanilla = $tabla_model->getTablaUbicacionAll("tplanillas","1");
		$banco = $tabla_model->getTablaUbicacionAll("tbancos","1");
		$regPension = $tabla_model->getTablaUbicacionAll("regimen_pensionarios","1");
		$afp = $tabla_model->getTablaUbicacionAll("tafps","1");
		$comisionAfp = $tabla_model->getTablaUbicacionAll("tipo_comisiones","1");
		$cargo = $tabla_model->getTablaUbicacionAll("tcargos","1");
		$nivel = $tabla_model->getTablaUbicacionAll("tniveles","1");
		$moneda = $tabla_model->getTablaUbicacionAll("tipo_monedas","1");
		$area_trabajo = $tabla_model->getTablaUbicacionAll("area_trabajos","1");

		$empresa_model = new Empresa();		
		$empresas = $empresa_model->getEmpresaAll("1");

		$ubigeo_model = new Ubigeo;
		$departamento = $ubigeo_model->getDepartamento("PER");

		$provincia = "";
		$distrito = "";

		//print_r ($departamento);
		//exit();

		if($persona_detalle->ubigeo!=""){
			$idDepartamento = substr($persona_detalle->ubigeo, 0, 2);
			$idProvincia = substr($persona_detalle->ubigeo, 0, 4);

			$provincia = $ubigeo_model->getProvincia($idDepartamento);
			$distrito = $ubigeo_model->getDistrito($idProvincia);
		}

		$unidad_trabajo = "";

		$unidad_model = new UnidadTrabajo;

		if($persona_detalle->id_area_trabajo!=""){

			$unidad_trabajo = $unidad_model->getUnidad($persona_detalle->id_area_trabajo);
			//UnidadTrabajo::where('id_area_trabajo', '=', $persona_detalle->id_area_trabajo)->where('estado', '=', '1')->first();
		}

		//print_r ($unidad_trabajo);exit();

		return view('frontend.persona.modal_persona',compact('id','persona','persona_detalle','tipo_documento','profesiones','empresas','condLaboral','tipPlanilla','banco','regPension','afp','comisionAfp','cargo','nivel','moneda','departamento','provincia','distrito','area_trabajo','unidad_trabajo'));
	}

    public function obtener_persona($tipo_documento,$numero_documento){

        $persona_model = new Persona;
        $sw = true;
        $persona = $persona_model->getPersona($tipo_documento,$numero_documento);
        $array["sw"] = $sw;
        $array["persona"] = $persona;
        echo json_encode($array);

    }
	
	public function obtener_persona_login($tipo_documento,$numero_documento){

        $persona_model = new Persona;
        $sw = true;
        $persona = $persona_model->getPersona($tipo_documento,$numero_documento);
        $array["sw"] = $sw;
        $array["persona"] = $persona;
        echo json_encode($array);

    }

	public function obtener_agremiado_login($numero_cap, $id_secret_code){

        $persona_model = new Persona;
        $sw = true;
        $agremiado = $persona_model->getAgremiadoDatos($numero_cap, $id_secret_code);
        $array["sw"] = $sw;
        $array["agremiado"] = $agremiado;
        echo json_encode($array);

    }

	public function obtener_proyectista($id_profesion,$buscar){

        $persona_model = new Persona;
        $sw = true;
		$proyectista = $persona_model->getProyectistaByProfesion($id_profesion,$buscar);

        $array["sw"] = $sw;
        $array["cantidad"] = count($proyectista);
        echo json_encode($array);

    }

	public function obtener_responsable($id_profesion,$buscar){

        $persona_model = new Persona;
        $sw = true;
		//$proyectista = $persona_model->getProyectistaByProfesion($id_profesion,$buscar);

        $array["sw"] = $sw;
        $array["cantidad"] = 0;//count($proyectista);
        echo json_encode($array);

    }

    public function send_persona(Request $request){
		
		if($request->id == 0){
			
			$codigo=$request->codigo;
			$telefono = $request->telefono;
			$email = $request->email;
			
			if($codigo==""){
				$array_tipo_documento = array('DNI' => 'DNI','CARNET_EXTRANJERIA' => 'CE','PASAPORTE' => 'PAS','RUC' => 'RUC','CEDULA' => 'CED','PTP/PTEP' => 'PTP/PTEP');
				$codigo = $array_tipo_documento[$request->tipo_documento]."-".$request->numero_documento;
			}
			if($telefono=="")$telefono="999999999";
			if($email=="")$email="mail@mail.com";
			
			$persona = new Persona;
			$persona->tipo_documento = $request->tipo_documento;
			$persona->numero_documento = $request->numero_documento;
			$persona->apellido_paterno = $request->apellido_paterno;
			$persona->apellido_materno = $request->apellido_materno;
			$persona->nombres = $request->nombres;
			$persona->codigo = $codigo;
			$persona->ocupacion = $request->ocupacion;
			$persona->fecha_nacimiento = "1990-01-01";
			$persona->sexo = "M";
			//$persona->telefono = "999999999";
			$persona->telefono = $telefono;
			//$persona->email = "mail@mail.com";
			$persona->email = $email;
			$persona->foto = "mail@mail.com";
			$persona->estado = "1";
            $persona->ruc = $request->ruc;
			$persona->save();
		}else{
			$persona = Persona::find($request->id);
			$persona->tipo_documento = $request->tipo_documento;
			$persona->numero_documento = $request->numero_documento;
			$persona->apellido_paterno = $request->apellido_paterno;
			$persona->apellido_materno = $request->apellido_materno;
			$persona->nombres = $request->nombres;
			$persona->codigo = $request->codigo;
			$persona->ocupacion = $request->ocupacion;
			$persona->telefono = $request->telefono;
			$persona->email = $request->email;
            $persona->ruc = $request->ruc;
            //print ($persona->ruc);exit();
			$persona->save();
		}
    }

	public function eliminar_persona($id,$estado)
    {
		$persona = Persona::find($id);
		$persona->estado = $estado;
		$persona->save();

		echo $persona->id;

    }

	public function buscar_persona($tipo_documento,$numero_documento){


		$sw = 1;//encontrado
		//$tarjeta = NULL;
		$persona = Persona::where('tipo_documento',$tipo_documento)->where('numero_documento',$numero_documento)->where('estado','A')->first();

		if($persona) $persona_detalle = PersonaDetalle::where('id_persona', '=', $persona->id)->where('estado', '=', 'A')->first();
		else $persona_detalle = new PersonaDetalle;


		
		if(!$persona){
			
			$persona_model = new Persona;
			$persona = $persona_model->getPersonaExt($this->getTipoDocumentoR($tipo_documento), $numero_documento);

			//print_r("tipo->".$tipo_documento);
			//print_r("numero->".$numero_documento);
			//print_r($persona);
			

			if($persona){
				
				$persona_act = new Persona;

				//print($persona->tipo_documento);
				$persona_act->tipo_documento = $tipo_documento;				
				$persona_act->numero_documento = $persona->numero_documento;
				$persona_act->apellido_paterno = $persona->apellido_paterno;
				$persona_act->apellido_materno = $persona->apellido_materno;
				$persona_act->nombres = $persona->nombres;
				$persona_act->fecha_nacimiento = $persona->fecha_nacimiento;
				$persona_act->sexo = $persona->sexo;			
				$persona_act->estado = 'A';
				$persona_act->save();

				$persona = Persona::where('tipo_documento',$tipo_documento)->where('numero_documento',$numero_documento)->where('estado','A')->first();
				//print_r("Persona Act -> ".$persona);
				
/*
				$persona_detalle_act = new PersonaDetalle;
				$persona_detalle_act->telefono = $persona->telefono;
				$persona_detalle_act->email = $persona->email;
				$persona_detalle_act->email = $persona->direccion;
				$persona_detalle_act->save();
*/

			}
				
			if(!$persona){
				$sw = 3;//no existe
				
				$arrContextOptions=array(
					"ssl"=>array(
						"verify_peer"=>false,
						"verify_peer_name"=>false,
					),
				);
				//$url = $this->apiperu_dev($numero_documento);
				//print_r($numero_documento);exit();
				$url = $persona_model->apiperu_dev($numero_documento);
				//print_r($url);exit();
				$datos = json_decode($url,true);
				if(isset($datos["data"])){
					$dato = $datos["data"];
					$persona = new Persona;
					$persona->tipo_documento = '1';
					$persona->numero_documento = $dato['numero'];
					$persona->apellido_paterno = $dato['apellido_paterno'];
					$persona->apellido_materno = $dato['apellido_materno'];
					$persona->nombres = $dato['nombres'];
					$persona->estado = 'A';
					$persona->save();

					$persona = Persona::where('tipo_documento',$tipo_documento)->where('numero_documento',$numero_documento)->where('estado','A')->first();
					

					$sw = 2;//encontrado en Reniec
				}		
			}
		}
		/*
		if(isset($persona->id) && $persona->id > 0){
			$persona_model = new Persona;
			$tarjeta = $persona_model->getTarjetaByIdPersona($persona->numero_documento);
		}
		*/

		//$sw = true;
		//print_r("sw -> ".$sw);
		//print_r("Persona Act -> ".$persona);

        $array["sw"] = $sw;
        $array["persona"] = $persona;
		$array["persona_detalle"] = $persona_detalle;
		//$array["tarjeta"] = $tarjeta;
        echo json_encode($array);

    }

	public function getTipoDocumento($tipo){
        $codigo = "";
		
        switch ($tipo) {
            case "DNI":
                $codigo = "1";
            break;
            case "CARNET_EXTRANJERIA":
                $codigo = "2";
            break;
            case "PASAPORTE":
                $codigo = "3";
            break;
            case "CEDULA":
                $codigo = "4";
            break;
            case "PTP/PTEP":
                $codigo = "5";
            break;                        
            default:
            $codigo = "";
        }

        return $codigo;

    }
	
	public function getTipoDocumentoR($id){
        $tipo = "";
		
        switch ($id) {
            case "1":
                $tipo = "DNI";
            break;
            case "2":
                $tipo = "CARNET_EXTRANJERIA2";
            break;
            case "3":
                $tipo = "PASAPORTE";
            break;
            case "4":
                $tipo = "CEDULA";
            break;
            case "5":
                $tipo = "PTP/PTEP";
            break;                        
            default:
            $tipo = "";
        }

        return $tipo;

    }
	public function list_persona($term)
    {
		$persona_model = new PersonaDetalle;
		$persona = $persona_model->getPersonaBuscar($term);
		return response()->json($persona);
    }
	
	public function modal_persona_contrato($id_persona){
		$tabla_model = new TablaUbicacione;		
		$cargo = $tabla_model->getTablaUbicacionAll("tcargos","1");
/*		
		$maestra_model = new TablaMaestra;
		$vacuna = $maestra_model->getMaestroByTipo('VACUNA');
		$fabricante = $maestra_model->getMaestroByTipo('FABRICANTE');
*/		
		$persona_contrato_model = new Contrato;
		$fecha_actual = $persona_contrato_model->fecha_actual();
		$contrato = $persona_contrato_model->getContratoByPersona($id_persona);

		//$id_user = Auth::user()->id;
		//$contrato = new Contrato();
		//if($id>0) $contrato = Contrato::find($id);else $contrato = new Contrato;

//		$persona = new Persona;
		//if($id>0) $persona = Persona::find($id);else $persona = new Persona;
//print_r ($contrato);
//exit();
		/*
		$dosis[1] = "1";
		$dosis[2] = "2";
		$dosis[3] = "3";
		$dosis[4] = "4";
		$dosis[5] = "5";
		return view('frontend.persona.modal_persona_contrato',compact('id_persona','fecha_actual','vacunas','vacuna','fabricante','dosis'));
		*/
		$id = 0;
		return view('frontend.persona.modal_persona_contrato',compact('id','id_persona','fecha_actual','contrato','cargo'));
	
	}

	function consulta_persona(){

		$tablaMaestra_model = new TablaMaestra;
		$persona = new Persona;
        $sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
        return view('frontend.persona.all_lista_persona',compact('persona','sexo','tipo_documento','grupo_sanguineo','nacionalidad'));

    }

	public function listar_persona2_ajax(Request $request){
	
		$persona_model = new Persona;
		$p[]=$request->tipo_documento;
		$p[]=$request->numero_documento;
		$p[]=$request->agremiado;
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]=$request->sexo;
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;

		//echo($p);exit();
		//echo($request->NumeroRegistros);
		$data = $persona_model->listar_persona2_ajax($p);
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

	public function modal_persona_nuevoPersona($id){
		
		$tablaMaestra_model = new TablaMaestra;
		$persona = new Persona;

		//$persona = new Persona;
		
		if($id>0){
			$persona = Persona::find($id);
			//echo($persona);
		}else{
			$persona = new Persona;
		}
		
		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(110);
		$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
        
		$ubigeo_model = new Ubigeo;
		$departamento = $ubigeo_model->getDepartamento();
		
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.persona.modal_persona_nuevoPersona',compact('id','persona','sexo','tipo_documento','grupo_sanguineo','nacionalidad','departamento'));
	
	}

	public function modal_persona_new(Request $request){
		
		$id_tipo_documento = $request->tipo_documento;
		$numero_documento = $request->numero_documento_;
		

		$tablaMaestra_model = new TablaMaestra;		
		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(110);

		return view('frontend.persona.modal_persona_new',compact('sexo','tipo_documento', 'id_tipo_documento', 'numero_documento'));
	}

	public function editar_persona($id){
        
		$persona = Persona::find($id);
		$tablaMaestra_model = new TablaMaestra;
		$id_persona = $persona->id_persona;
		
		$persona = Persona::find($id_persona);

		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
		$persona_model = new Persona;
        //$concepto_model = new concepto;
		
		return view('frontend.persona.create_mantenimiento',compact('persona','tipo_documento','sexo','grupo_sanguineo','nacionalidad','estado'));
		
    }

	public function send_persona_nuevoPersona(Request $request){

		/*$request->validate([
			'tipo_documento'=>'required',
			'numero_documento'=>'required | numeric | digits:8',
			'ruc'=>'numeric | digits:11',
			'nombre'=>'required',
			'apellido_paterno'=>'required',
			'apellido_materno'=>'required',
			'fecha_nacimiento'=>'required',
			'lugar_nacimiento'=>'required',
			'nacionalidad'=>'required',
			'sexo'=>'required',
			//'numero_celular'=>'required | numeric | digits:9',
			'correo'=>'required | email',
			'direccion'=>'required',
		]
		);*/

		$id_user = Auth::user()->id;
		$sw = true;
		$msg = "";

		//$persona_model = new Persona;

		if($request->img_foto!=""){
			$filepath_tmp = public_path('img/frontend/tmp_agremiado/');
			$filepath_nuevo = public_path('img/agremiado/');
			if (file_exists($filepath_tmp.$request->img_foto)) {
				copy($filepath_tmp.$request->img_foto, $filepath_nuevo.$request->img_foto);
			}
		}

		if($request->img_foto=="")$request->img_foto="ruta";
		
		if($request->id == 0){
			$buscapersona = Persona::where("numero_documento", $request->numero_documento)->where("estado", "1")->get();

			if ($buscapersona->count()==0){

				$persona = new Persona;
				$persona->id_tipo_documento = $request->tipo_documento;
				$persona->numero_documento = $request->numero_documento;
				$persona->apellido_paterno = $request->apellido_paterno;
				$persona->apellido_materno = $request->apellido_materno;
				$persona->nombres = $request->nombre;
				$persona->fecha_nacimiento = $request->fecha_nacimiento;
				//$persona->id_tipo_persona = 1;
				$persona->grupo_sanguineo = $request->grupo_sanguineo;
				$persona->id_ubigeo_nacimiento = $request->id_ubigeo_nacimiento;
				$persona->lugar_nacimiento = $request->lugar_nacimiento;
				//$persona->lugar_nacimiento = $request->img_foto;
				$persona->id_nacionalidad = $request->nacionalidad;
				$persona->numero_ruc = $request->ruc;
				$persona->id_sexo = $request->sexo;
				$persona->numero_celular = $request->numero_celular;
				$persona->correo = $request->correo;
				$persona->foto = $request->img_foto;
				$persona->direccion = $request->direccion;
				//$persona->estado = 1;
				$persona->id_usuario_inserta = $id_user;
				$persona->save();
			}else{
				
				$tablaMaestra_model = new TablaMaestra;		
				$tipo_documento = $tablaMaestra_model->getMaestroC(110,$request->tipo_documento);
				$sw = false;
				$msg = "El ".$tipo_documento[0]->denominacion." ingresado ya existe !!!";
			}
		}else {
			$persona = Persona::find($request->id);
			$persona->numero_ruc = $request->ruc;
			$persona->id_tipo_documento = $request->tipo_documento;
			$persona->numero_documento = $request->numero_documento;
			$persona->apellido_paterno = $request->apellido_paterno;
			$persona->apellido_materno = $request->apellido_materno;
			$persona->nombres = $request->nombre;
			$persona->fecha_nacimiento = $request->fecha_nacimiento;
			$persona->grupo_sanguineo = $request->grupo_sanguineo;
			$persona->id_ubigeo_nacimiento = $request->id_ubigeo_nacimiento;
			$persona->lugar_nacimiento = $request->lugar_nacimiento;
			$persona->id_nacionalidad = $request->nacionalidad;
			$persona->numero_ruc = $request->ruc;
			$persona->id_sexo = $request->sexo;
			$persona->numero_celular = $request->numero_celular;
			$persona->correo = $request->correo;
			$persona->foto = $request->img_foto;
			$persona->direccion = $request->direccion;
			$persona->id_usuario_inserta = $id_user;
			$persona->save();
		}
			//$persona = Persona::find($request->id);

			$array["sw"] = $sw;
			$array["msg"] = $msg;
			echo json_encode($array);
		
    }

	public function send_persona_new_(Request $request){
		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			/*
			$codigo=$request->codigo;
			$telefono = $request->telefono;
			$email = $request->email;
			
			if($codigo==""){
				$array_tipo_documento = array('DNI' => 'DNI','CARNET_EXTRANJERIA' => 'CE','PASAPORTE' => 'PAS','RUC' => 'RUC','CEDULA' => 'CED','PTP/PTEP' => 'PTP/PTEP');
				$codigo = $array_tipo_documento[$request->tipo_documento]."-".$request->numero_documento;
			}
			if($telefono=="")$telefono="999999999";
			if($email=="")$email="mail@mail.com";

			*/
			
			$persona = new Persona;
			$persona->id_tipo_documento = $request->tipo_documento;
			$persona->numero_documento = $request->numero_documento;
			$persona->apellido_paterno = $request->apellido_paterno;
			$persona->apellido_materno = $request->apellido_materno;
			$persona->nombres = $request->nombres;
			$persona->id_usuario_inserta = $id_user;
			
			/*
			$persona->codigo = $codigo;
			$persona->ocupacion = $request->ocupacion;
			$persona->fecha_nacimiento = "1990-01-01";
			$persona->sexo = "M";
			//$persona->telefono = "999999999";
			$persona->telefono = $telefono;
			//$persona->email = "mail@mail.com";
			$persona->email = $email;
			$persona->foto = "mail@mail.com";
			$persona->estado = "1";
            $persona->ruc = $request->ruc;
*/
			$persona->save();
			
		}else{
			$persona = Persona::find($request->id);
			$persona->tipo_documento = $request->tipo_documento;
			$persona->numero_documento = $request->numero_documento;
			$persona->apellido_paterno = $request->apellido_paterno;
			$persona->apellido_materno = $request->apellido_materno;
			$persona->nombres = $request->nombres;
/*
			$persona->codigo = $request->codigo;
			$persona->ocupacion = $request->ocupacion;
			$persona->telefono = $request->telefono;
			$persona->email = $request->email;
            $persona->ruc = $request->ruc;
            */
			$persona->save();
		}
    }

	public function send_persona_new(Request $request){

		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$persona = new Persona;
			$persona->id_usuario_inserta = $id_user;
		}else{
			$persona = Persona::find($request->id);
			$persona->id_usuario_actualiza = $id_user;
		}

		$persona->id_tipo_documento = $request->tipo_documento;
		$persona->numero_documento = $request->numero_documento;
		$persona->apellido_paterno = $request->apellido_paterno;
		$persona->apellido_materno = $request->apellido_materno;
		$persona->nombres = $request->nombres;
/*
		$persona->fecha_nacimiento = $request->fecha_nacimiento;
		$persona->id_tipo_persona = 1;
		$persona->grupo_sanguineo = $request->grupo_sanguineo;
		$persona->id_ubigeo_nacimiento =150101;
		$persona->lugar_nacimiento = $request->lugar_nacimiento;
		$persona->id_nacionalidad = $request->nacionalidad;
		$persona->numero_ruc = $request->ruc;
		$persona->id_sexo = $request->sexo;
		$persona->numero_celular = $request->numero_celular;
		$persona->correo = $request->correo;
		$persona->foto = $request->img_foto;
		$persona->direccion = $request->direccion;
		$persona->estado = 1;
*/		
		
		$persona->save();
    }

	public function send_persona_newBeneficiario(Request $request){

		$id_user = Auth::user()->id;
		
		if($request->id == 0){
			$persona = new Persona;
			$beneficiario = new Beneficiario;
			$persona->id_usuario_inserta = $id_user;
		}else{
			$persona = Persona::find($request->id);
			$persona->id_usuario_actualiza = $id_user;
		}

		$persona->id_tipo_documento = $request->tipo_documento;
		$persona->numero_documento = $request->numero_documento;
		$persona->apellido_paterno = $request->apellido_paterno;
		$persona->apellido_materno = $request->apellido_materno;
		$persona->nombres = $request->nombres;
		$persona->numero_celular = $request->celular;
		$persona->correo = $request->correo;
		$persona->fecha_nacimiento = $request->fecha_nacimiento;
		$persona->id_sexo = $request->sexo;
	
		$persona->save();

		/*$persona = Persona::where("numero_documento",$request->numero_documento)->where("estado","1")->first();
        $empresa = Empresa::where("ruc",$request->ruc)->where("estado","1")->first();

		$beneficiario->id_persona = $persona->id;
		$beneficiario->id_empresa = $empresa->id;
		$beneficiario->id_usuario_inserta = $id_user;
		$beneficiario->save();*/

    }

	public function upload(Request $request){

    	$filepath = public_path('img/frontend/tmp_agremiado/');
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath.$_FILES["file"]["name"]);
		echo $_FILES['file']['name'];
	}

	public function buscar_numero_documento($numero_documento){

		$sw = true;
		$msg = "";

		$persona = Persona::where('numero_documento',$numero_documento)->where('estado','1')->first();

		if($persona){

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

	public function modal_personaNuevo(Request $request){
		
		//$id_tipo_documento = $request->tipo_documento;
		$id_tipo_documento = 78;
		$numero_documento = $request->dni;
		

		$tablaMaestra_model = new TablaMaestra;		
		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);

		return view('frontend.persona.modal_personaNuevo',compact('sexo','tipo_documento', 'id_tipo_documento', 'numero_documento'));
	}

	public function modal_personaNuevoBeneficiario(Request $request){
		
		//$id_tipo_documento = $request->tipo_documento;
		$id_tipo_documento = 78;
		$numero_documento = $request->dni_;
		

		$tablaMaestra_model = new TablaMaestra;
		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);

		return view('frontend.persona.modal_personaNuevoBeneficiario',compact('sexo','tipo_documento', 'id_tipo_documento', 'numero_documento'));
	}


	public function obtenerPersona($numero_documento){

        $persona_model = new Persona;
        //$valorizaciones_model = new Valorizacione;
        $sw = true;

        //$persona = $persona_model->getPersonaDni($numero_documento);
		$persona = Persona::where('numero_documento',$numero_documento)->where('estado','1')->first();

        /*$array["sw"] = $sw;
        $array["persona"] = $persona;
        echo json_encode($array);*/

		if($persona){

			$array["persona"] = $persona;
			echo json_encode($array);
		}else{
			$sw = false;
			//$msg = "El DNI no está registrado como persona, vaya a mantenimiento de personas y registre primero a la persona.";
			//$array["error"] = "El DNI no está registrado como persona, vaya a mantenimiento de personas y registre primero a la persona.";
			$array["sw"] = $sw;
			//$array["msg"] = $msg;
			echo json_encode($array);
		}

    }

	public function obtener_datos_persona($dni_propietario){

		$persona_model = new Persona;
		$sw = true;

		$persona2 = Persona::where('numero_documento',$dni_propietario)->where('estado','1')->first();

		if($persona2)
		{
			$persona = $persona_model->getPersonaDniPropietario($dni_propietario);
			$array["sw"] = $sw;
			$array["persona"] = $persona;
			echo json_encode($array);
		}else {
			$array["persona"] = "0";
			echo json_encode($array);}

	}


}