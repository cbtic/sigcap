<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AsientoPlanilla;
use App\Models\TablaMaestra;

use App\Models\PlanContable;
use App\Models\CentroCosto;
use App\Models\PartidaPresupuestale;

use App\Models\PeriodoComisione;
use App\Models\PeriodoComisionDetalle;

use PDO;


//use App\Models\CondicionLaborale;

use Auth;
use Symfony\Component\Mime\Crypto\SMimeEncrypter;

class AsientoPlanillaController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}
	
    public function index(){

		$anio = range(date('Y'), date('Y') - 20); 		
		$mes = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];

		$mes_actual = date("m");

		$periodoComisione_model = new PeriodoComisione;
		$periodo = $periodoComisione_model->getPeriodoAll();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();

		$periodoDet = $periodoComisione_model->getPeriodoDetAll();
		$periodoDet_ultimo = PeriodoComisionDetalle::where("estado",1)->orderBy("id","desc")->first();
		$periodoDet_activo = PeriodoComisionDetalle::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();


        return view('frontend.asiento.all',compact('periodo','periodo_activo', 'periodo_ultimo','periodoDet','periodoDet_activo', 'periodoDet_ultimo', 'anio', 'mes','mes_actual'));
    }

	public function create()
    {
        return view('frontend.persona.create');
    }

    public function listar_asiento_ajax(Request $request){
		
		$asiento_model = new AsientoPlanilla;
		
		$p[]=$request->cuenta;
		$p[]=$request->denominacion;
		$p[]=$request->tipo_cuenta;
		$p[]=$request->centro_costo;
		$p[]=$request->partida_presupuestal;
		$p[]=$request->codigo_financiero;
		$p[]=$request->medio_pago;
		$p[]=$request->origen;

		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $asiento_model->listar_asiento_ajax($p);

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

    function consulta_asiento(){

		//$tablaMaestra_model = new TablaMaestra;
		//$persona = new Persona;
        //$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		//$tipo_documento = $tablaMaestra_model->getMaestroByTipo(16);
		//$grupo_sanguineo = $tablaMaestra_model->getMaestroByTipo(90);
		//$nacionalidad = $tablaMaestra_model->getMaestroByTipo(5);
        return view('frontend.persona.all_lista_asiento',compact(''));

    }

	public function modal_asiento($id){
		$id_user = Auth::user()->id;
		
		
		if($id>0){
			$asiento = AsientoPlanilla::find($id);
		}else{
			$asiento = new AsientoPlanilla;
		}
		
		$tablaMaestra_model = new TablaMaestra;
        $sw = true;
		$plan_contable = PlanContable::where('estado','1')->orderBy('id', 'desc')->get()->all();        
		$tipo_cuenta = $tablaMaestra_model->getMaestroByTipo(122);
		$centro_costo = CentroCosto::where('estado','1')->orderBy('id', 'desc')->get()->all();
		$partida_presupuestal = PartidaPresupuestale::where('estado','1')->orderBy('id', 'desc')->get()->all();
		$medio_pago = $tablaMaestra_model->getMaestroByTipo(108);

		//print_r($array);exit();
		return view('frontend.asiento.modal_asiento',compact('id','asiento','plan_contable', 'tipo_cuenta', 'centro_costo', 'partida_presupuestal', 'medio_pago'));
	}

	public function send_asiento(Request $request){

		$id_user = Auth::user()->id;

		$cuenta = $request->cuenta;
		$denominacion = $request->denominacion ;
		$tipo_cuenta = $request->tipo_cuenta ;
		$centro_costo = $request->centro_costo;
		$partida_presupuestal = $request->partida_presupuestal ;
		$codigo_financiero =  $request->codigo_financiero;
		$medio_pago = $request->medio_pago ;
		$origen = $request->origen;
		
		if($request->id == 0){									
			$asignar = new AsientoPlanilla;
	
			$asignar->id_plan_contable = $cuenta;
			$asignar->denominacion = $denominacion;
			$asignar->id_tipo_cuenta = $tipo_cuenta;
			$asignar->id_centro_costo = $centro_costo;
			$asignar->id_partida_presupuestal = $partida_presupuestal;
			$asignar->id_codigo_financiero = $codigo_financiero;
			$asignar->id_medio_pago = $medio_pago;
			$asignar->id_origen = $origen;

			$asignar->id_usuario_inserta = $id_user;

			$asignar->save();
		}else{
			$asignar = AsientoPlanilla::find($request->id);

			$asignar->id_plan_contable = $cuenta;
			$asignar->denominacion = $denominacion;
			$asignar->id_tipo_cuenta = $tipo_cuenta;
			$asignar->id_centro_costo = $centro_costo;
			$asignar->id_partida_presupuestal = $partida_presupuestal;
			$asignar->id_codigo_financiero = $codigo_financiero;
			$asignar->id_medio_pago = $medio_pago;
			$asignar->id_origen = $origen;

			$asignar->save();
		}
    }

	public function eliminar_asiento($id,$estado)
    {
		$asignar = AsientoPlanilla::find($id);
		$asignar->estado = $estado;
		$asignar->save();

		echo $asignar->id;

    }

    public function obtener_asiento_planilla(Request $request){
		
		$anio = $request->anio;
		$mes = $request->mes;
		$periodo = $request->id_periodo;
		$tipo = $request->Tipo_b;

		//echo($tipo); exit();

		$asiento_planilla_model = new AsientoPlanilla;
		$asientoPlanilla = $asiento_planilla_model->ListarAsientoPlanilla($anio, $mes, $periodo,$tipo);

        return view('frontend.asiento.lista_asiento_planilla',compact('asientoPlanilla'));

    }

	public function generar_asiento_planilla(Request $request){
		//exit("hola");
		$anio =$request->anio;
		$mes =$request->mes;
		$periodo =$request->periodo;
		$id_periodo =$request->id_periodo;
		$tipo =$request->tipo;

		//print_r($id_periodo_bus); exit();

		$asiento_planilla_model = new AsientoPlanilla;
		$data = $asiento_planilla_model->generar_asiento_planilla($tipo,$id_periodo ,$anio, $mes);

		$result["aaData"] = $data;

		echo json_encode($result);
	
	}

	public function importar_vou_siscont($periodo,$anio, $mes){ 
		
		$_mes=intval($mes);
		$_anio=intval($anio);
		 
		//$periodo = 1054;
		if ($mes=='12'){
			$_mes=1;
			$_anio=$_anio+1;
		}
			else{
				$_mes=$_mes+1;
			}
			
		
		$ch = curl_init('http://190.119.30.106:9090/planillas2.php');
		
		$postData = [
					'mes' => sprintf("%02d", $_mes),
					'anio' => $anio
				];
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true); // Habilitar método POST
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData); // Enviar los datos del formulario
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, []);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		
		$resultWebApi = curl_exec($ch);
		
		if($errno = curl_errno($ch)) {
			$error_message = curl_strerror($errno);
			echo "cURL error ({$errno}):\n {$error_message}";
		}
		
		$dataWebApi = json_decode($resultWebApi);

		//print_r($dataWebApi);
		foreach($dataWebApi as $row){
			

			$asiento_planilla_model = new AsientoPlanilla;
			$VouExiste = $asiento_planilla_model->getVouporID($row->MESV ,$row->T, $row->VOU,$row->RUT);
			
			if(count($VouExiste)==0){
				$asiento_planilla_model->InsertaVou(
					$row->MESV,
					$row->T,
					$row->VOU,
					$row->NUMERO,
					$row->RUT
				);
			}

			
		}
		//Asigna al mes del comprobante 
		$asiento_planilla_model = new AsientoPlanilla;
			$asientoPlanilla = $asiento_planilla_model->AsignarVou( $periodo,$_anio, $_mes);

			
		
	}

	public function enviar_planilla_siscont(Request $request){ 
	
		$fecha_inicio=$request->fecha_inicio;
		$fecha_fin=$request->fecha_fin;
		 
		
	$tipoodocumentofact='02';
	$tipoodocumentofactcancela='13';


		$asiento_planilla_model = new AsientoPlanilla;
		$sentencia = $asiento_planilla_model->ListarAsientoExportar($fecha_inicio ,$fecha_fin,1);

		//print_r($sentencia); exit();
		//$planilla = $sentencia->fetchAll(PDO::FETCH_OBJ);

					foreach($sentencia as $siscont){


					$tipoodocumento='6';

					$moneda='D';
					if($siscont->id_moneda=='1'){ $moneda='S'; }

					$tipoodocumentofact='01';
					if($siscont->id_tipo_documento=='1'){ $tipoodocumentofact='03'; }

					$origen='06';


					$centrocostos=$siscont->centro_costo;
					$controlpresupuestos=$siscont->presupuesto;

					$tipoodocumentofactcancela='02';

					if($siscont->tipo=='CANCELACION'){
					$origen='09';
					$centrocostos='';
					$controlpresupuestos='';
					$tipoodocumentofactcancela='13';
					}

					$data[]=array(
					'origen'=>$origen,
					'vou'=>''.$siscont->vou,
					'fecha'=>date("d/m/Y", strtotime($siscont->fecha_documento)),
					'cuenta'=>$siscont->cuenta,
					'debe'=>''.round($siscont->debe, 2),
					'haber'=>''.round($siscont->haber, 2),
					'moneda'=>$moneda,
					'tc'=>$siscont->tipo_cambio,
					'doc'=>$tipoodocumentofactcancela,
					'numero'=>$siscont->numero_comprobante,
					'fechad'=>date("d/m/Y", strtotime($siscont->fecha_documento)),
					'fechav'=>date("d/m/Y", strtotime($siscont->fecha_vencimiento)),
					'codigo'=>$siscont->numero_ruc,
					'cc'=>$centrocostos,
					'pre'=>$controlpresupuestos,
					'fe'=>'',
					'glosa'=>$siscont->glosa,
					'tl'=>'',
					'neto1'=>'',
					'neto2'=>'',
					'neto3'=>'',
					'neto4'=>'',
					'neto5'=>'',
					'neto6'=>'',
					'neto7'=>'',
					'neto8'=>'',
					'neto9'=>'',
					'igv'=>'',
					'rdoc'=>'',
					'rnum'=>'',
					'rfec'=>'',
					'snum'=>'',	
					'sfec'=>'',
					'ruc'=>$siscont->numero_ruc,
					'rs'=>$siscont->desc_cliente_sunat,
					'tipo'=>'5',
					'tdoci'=>$tipoodocumento,
					'mpago'=>'',
					'ape1'=>'',
					'ape2'=>'',
					'nombre'=>'',
					'tbien'=>'',
					'refmonto'=>'0.00'
					);
					
					

					}

		$asiento_planilla_model = new AsientoPlanilla;
		$sentencia = $asiento_planilla_model->ListarAsientoExportar($fecha_inicio ,$fecha_fin,2);
		//print_r($sentencia); exit();
		//$planilla = $sentencia->fetchAll(PDO::FETCH_OBJ);

		foreach($sentencia as $siscont){



			$tipoodocumento='6';

			$moneda='D';
			if($siscont->id_moneda=='1'){ $moneda='S'; }

			$tipoodocumentofact='01';
			if($siscont->id_tipo_documento=='1'){ $tipoodocumentofact='03'; }

			$origen='06';


			$centrocostos=$siscont->centro_costo;
			$controlpresupuestos=$siscont->presupuesto;

			$formapago='';
			$mediopago='';


			$tipoodocumentofact='13';
			if($siscont->cuenta=='1692'){
				$origen='09';
				$centrocostos='';
				$controlpresupuestos='';
				
				$formapago=$siscont->codigo_financiero;
				$mediopago=$siscont->medio_pago;
				$tipoodocumentofact='02';
				
				}

				
			//$siscont->glosa.$siscont->tipo,

				$data[]=array(
				'origen'=>$origen,
				'vou'=>''.$siscont->vou.'|'.$siscont->tipo,
				'fecha'=>date("d/m/Y", strtotime($siscont->fecha_documento)),
				'cuenta'=>$siscont->cuenta,
				'debe'=>''.round($siscont->debe, 2),
				'haber'=>''.round($siscont->haber, 2),
				'moneda'=>$moneda,
				'tc'=>$siscont->tipo_cambio,
				'doc'=>$tipoodocumentofact,
				'numero'=>$siscont->numero_comprobante,
				'fechad'=>date("d/m/Y", strtotime($siscont->fecha_documento)),
				'fechav'=>date("d/m/Y", strtotime($siscont->fecha_vencimiento)),
				'codigo'=>$siscont->numero_ruc,
				'cc'=>$centrocostos,
				'pre'=>$controlpresupuestos,
				'fe'=>''.$formapago,
				'glosa'=>$siscont->glosa,
				'tl'=>'',
				'neto1'=>'',
				'neto2'=>'',
				'neto3'=>'',
				'neto4'=>'',
				'neto5'=>'',
				'neto6'=>'',
				'neto7'=>'',
				'neto8'=>'',
				'neto9'=>'',
				'igv'=>'',
				'rdoc'=>'',
				'rnum'=>'',
				'rfec'=>'',
				'snum'=>'',	
				'sfec'=>'',
				'ruc'=>$siscont->numero_ruc,
				'rs'=>$siscont->desc_cliente_sunat,
				'tipo'=>'5',
				'tdoci'=>$tipoodocumento,
				'mpago'=>''.$mediopago,
				'ape1'=>'',
				'ape2'=>'',
				'nombre'=>'',
				'tbien'=>'',
				'refmonto'=>'0.00'
				);	
					

		}
					
					$databuild_string = json_encode($data);
					header('Content-Type: application/json');
        			echo $databuild_string;
		
		
	}


}