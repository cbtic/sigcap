<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Persona;
use App\Models\Agremiado;
use App\Models\TablaMaestra;
use App\Models\AgremidoCuota;
use App\Models\CajaIngreso;
use App\Models\Valorizacione;
use App\Models\Concepto;
use App\Models\ProntoPago;
use App\Models\Fraccionamiento;
use Illuminate\Support\Carbon;
use App\Models\Empresa;
use App\Models\Beneficiario;
use App\Models\Comprobante;
use App\Models\AgremiadoMulta;
use App\Models\TipoCambio;
use App\Models\Efectivo;
use App\Models\EfectivoDetalle;
use App\Models\Liquidacione;
use Barryvdh\DomPDF\Facade\Pdf;
use Auth;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Replace;

class IngresoController extends Controller
{

    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}
       
    public function create(){      
         
		$id_user = Auth::user()->id;
        $persona = new Persona;
        $caja_model = new TablaMaestra;
        $caja_ingreso_model = new CajaIngreso();
        //$pronto_pago_model = new ProntoPago;

        $caja = $caja_model->getCaja('91');
        $caja_usuario = $caja_ingreso_model->getCajaIngresoByusuario($id_user,'91');
        
        $tipo_documento = $caja_model->getMaestroByTipo(16);

        //$date = (new DateTime)->format("Y");
        $anio_actual = date("Y");


        $pronto_pago = ProntoPago::where("estado","1")->where("periodo",$anio_actual)->first();                
        $concepto = Concepto::where("id","26411")->first(); //CUOTA GREMIAL
       // $concepto = Concepto::where("codigo","00006")->where("estado","1")->where("periodo",$anio_actual)->first(); 


        
        $mes = [
            '' => 'Todos Meses','01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo',
            '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
            '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre',
            '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre',
        ];

        //$caja_usuario = $caja_model;
        //print_r($concepto);exit();

        return view('frontend.ingreso.create',compact('persona','caja','caja_usuario','tipo_documento','pronto_pago', 'concepto','mes'));

    }

    public function obtener_valorizacion($tipo_documento,$id_persona){
 
        $valorizaciones_model = new Valorizacione;
        $sw = true;
        //$valorizacion = $valorizaciones_model->getValorizacion($tipo_documento,$id_persona);
        //print_r($valorizacion);exit();
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));

    }

    public function listar_valorizacion(Request $request){


        $id_persona = $request->id_persona;
        
        $tipo_documento = $request->tipo_documento;

        $SelFracciona = $request->SelFracciona;

        $Exonerado = $request->Exonerado;

      // echo($Exonerado);exit();

        if($tipo_documento=="79")$id_persona = $request->empresa_id;

        $periodo = $request->cboPeriodo_b;
        $mes = $request->cboMes_b;
        //print_r($mes);exit();
        $tipo_couta = $request->cboTipoCuota_b;
        $concepto = $request->cboTipoConcepto_b;
        $filas = $request->cboFilas;

        $tipo_documento_b = $request->tipo_documento_b;

        //print_r($tipo_documento_b);exit();


        if($tipo_documento_b=="87"){
            $numero_documento_b = $request->numero_documento_b;
        }else{
            $numero_documento_b = "";
        }
        


        //print_r("-".$numero_documento_b);exit();


        $valorizaciones_model = new Valorizacione;
        $sw = true;
        

        if ($SelFracciona=="S"){
            $valorizacion = $valorizaciones_model->getValorizacionFrac($tipo_documento,$id_persona,$periodo,$tipo_couta,$concepto,$filas);
        }else{
            $valorizacion = $valorizaciones_model->getValorizacion($tipo_documento,$id_persona,$periodo,$mes,$tipo_couta,$concepto,$filas,$Exonerado,$numero_documento_b);
        }
        
      // var_dump($valorizacion);exit();
       
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));

    }
 
    public function listar_valorizacion_concepto(Request $request){
        $id_persona = $request->id_persona;
        $tipo_documento = $request->tipo_documento;
        if($tipo_documento=="79")$id_persona = $request->empresa_id;
        $valorizaciones_model = new Valorizacione;
        $resultado = $valorizaciones_model->getValorizacionConcepto($tipo_documento,$id_persona);
    /*
        $valorizaciones_model = new Valorizacione;
        $periodo = $valorizaciones_model->getPeridoValorizacion($tipo_documento,$id_persona);
*/
        //print_r($valorizacion);exit();
		return $resultado;

    }

    public function valida_deuda_vencida(Request $request){



        $id_persona = $request->id_persona;
        //print_r($id_persona);
        $tipo_documento = $request->tipo_documento;
        if($tipo_documento=="79")$id_persona = $request->empresa_id;
        $valorizaciones_model = new Valorizacione;
        $concepto = $request->cboTipoConcepto_b;
        $resultado = $valorizaciones_model->getValidaValorizacion($tipo_documento,$id_persona,$concepto);

        echo json_encode($resultado);

        //print_r($resultado);
        //exit();

        //return $resultado;

        /*

        $factura_detalle = $request->comprobante_detalle;

        $ind = 0;
        foreach($request->comprobante_detalles as $key=>$det){
            $valorizad[$ind] = $factura_detalle[$key];
            $ind++;
        }

        //print_r($valorizad); exit();

        $conceptos = "";
        $ids = "";

        foreach($valorizad as $value){

            $conceptos =  $value["id_concepto"].','.$conceptos;

            $ids=  $value["id"].','.$ids;

            //echo $value["id_concepto"];
            //echo "\n";
        }

        echo($conceptos);
        echo "\n";
        echo($ids);

        exit();



        $ind=0;

        print_r($request->comprobante_detalles); exit();
        foreach($request->comprobante_detalles as $key => $value){


            echo $value["id_concepto"];
            echo "\n";
            //exit();

            //$facturad[$ind] = $factura_detalle[$key];
           
            //print_r($factura_detalle['id_concepto']);
            //$id_concepto_det = $facturad[$ind]['id_concepto'];
            
            //$stotal= $stotal + $facturad[$ind]['total'];
            //$igv= $igv + $facturad[$ind]['igv'];

            $ind++;
        }

        */

/*
        $id_persona = $request->id_persona;
        $tipo_documento = $request->tipo_documento;
        if($tipo_documento=="79")$id_persona = $request->empresa_id;
        $valorizaciones_model = new Valorizacione;
        $resultado = $valorizaciones_model->getDeudaVencida($tipo_documento,$id_persona);
*/


        //print_r($valorizacion);exit();
//		return $resultado;


    }

    
    
    public function listar_valorizacion_periodo(Request $request){
        $id_persona = $request->id_persona;
        $tipo_documento = $request->tipo_documento;
        if($tipo_documento=="79")$id_persona = $request->empresa_id;
        
        $valorizaciones_model = new Valorizacione;
        $resultado = $valorizaciones_model->getPeridoValorizacion($tipo_documento,$id_persona);

        //print_r($resultado);exit();
		return $resultado;

    }

    public function listar_valorizacion_mes(Request $request){
        $id_persona = $request->id_persona;
        $tipo_documento = $request->tipo_documento;
        if($tipo_documento=="79")$id_persona = $request->empresa_id;
        
        $valorizaciones_model = new Valorizacione;
        $resultado = $valorizaciones_model->getMesValorizacion($tipo_documento,$id_persona);

        //print_r($resultado);exit();
		return $resultado;

    }

    public function obtener_pago($tipo_documento,$id_persona){       
        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $pago = $valorizaciones_model->getPago($tipo_documento,$id_persona);
        return view('frontend.ingreso.lista_pago',compact('pago'));

    }

    public function sendCaja(Request $request)
    {
        $valorizaciones_model = new Valorizacione;
		$id_user = Auth::user()->id;
        $datos[] = $request->accion;
        $datos[] = $id_user;
		
		$datos[] = $request->id_caja_ingreso;
        $datos[] = $request->id_caja;
        $datos[] = ($request->saldo_inicial=='')?0:$request->saldo_inicial;
        $datos[] = ($request->total_recaudado=='')?0:$request->total_recaudado;
        $datos[] = ($request->saldo_total=='')?0:$request->saldo_total;
		
        $datos[] = $request->estado;
        //print_r($datos);
        $id_caja_ingreso = $valorizaciones_model->registrar_caja_ingreso($datos);
        echo $id_caja_ingreso;
		
		//Session::put('id_caja', $request->id_caja);
        
    }

    public function sendCajaMoneda(Request $request)
    {
        $valorizaciones_model = new Valorizacione;
		$id_user = Auth::user()->id;
        $datos[] = $request->accion;
        $datos[] = $id_user;
		
		$datos[] = $request->id_caja_ingreso_soles;
        $datos[] = $request->id_caja_soles;
        $datos[] = ($request->saldo_inicial_soles=='')?0:$request->saldo_inicial_soles;
        $datos[] = ($request->total_recaudado_soles=='')?0:$request->total_recaudado_soles;
        $datos[] = ($request->saldo_total_soles=='')?0:$request->saldo_total_soles;
		
		$datos[] = $request->id_caja_ingreso_dolares;
        $datos[] = $request->id_caja_dolares;
        $datos[] = ($request->saldo_inicial_dolares=='')?0:$request->saldo_inicial_dolares;
        $datos[] = ($request->total_recaudado_dolares=='')?0:$request->total_recaudado_dolares;
        $datos[] = ($request->saldo_total_dolares=='')?0:$request->saldo_total_dolares;
		
        $datos[] = $request->estado;
        //print_r($datos);
        $id_caja_ingreso = $valorizaciones_model->registrar_caja_ingreso_moneda($datos);
        echo $id_caja_ingreso;
		
		//Session::put('id_caja', $request->id_caja);
        
    }

    public function modal_otro_pago($periodo, $id_persona, $id_agremiado, $tipo_documento){

        
        $conceptos_model = new Concepto;        
        $conceptos = $conceptos_model->getConceptoPeriodo($periodo);

    
		
		return view('frontend.ingreso.modal_otro_pago',compact('conceptos','periodo','id_persona','id_agremiado','tipo_documento' ));
	}

    public function modal_fraccionar($idConcepto, $id_persona, $id_agremiado, $total_fraccionar ){

        $concepto = Concepto::find($idConcepto);

        //$concepto = json_encode($concepto_model);

        //print_r(json_encode($concepto)); exit();
		
		return view('frontend.ingreso.modal_fraccionar',compact('concepto','total_fraccionar','id_persona','id_agremiado' ));
	}

    public function modal_exonerar( ){


        $concepto ="" ;

       // print_r(json_encode($concepto)); exit();
		
		return view('frontend.ingreso.modal_motivo_exonera',compact('concepto' ));
	}

    public function modal_fraccionamiento(Request $request){

        $id_concepto = $request->idConcepto;
        //print_r($id_concepto); //exit();

        $id_persona = $request->id_persona;
        $id_agremiado = $request->id_agremiado;
        $total_fraccionar = $request->total;
        //print_r($total_fraccionar); exit();

        $comprobante_detalle = $request->comprobante_detalle;
        $ind = 0;

       
        $tipo_documento = $request->tipo_documento;
        if($tipo_documento=="79")$id_persona = $request->empresa_id;

        $periodo = "";
        $tipo_couta = "1";
        $concepto = $request->cboTipoConcepto_b;
        $filas = "10000";

        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $valorizacion = $valorizaciones_model->getValorizacion_total($tipo_documento,$id_persona,$id_concepto);
  

        foreach($request->comprobante_detalles as $key=>$det){
            
            $comprobanted[$ind] = $comprobante_detalle[$key];
            $ind++;
        }

        //print_r($comprobanted); exit();

        //if ($id_concepto=="")$id_concepto=26411;
        //$concepto = Concepto::find(26411);

        $concepto = Concepto::where("codigo","00006")->first();
        
        
        //$comprobanted = json_encode($comprobanted_);

        //print_r($total_fraccionar); exit();
    
		return view('frontend.ingreso.modal_fraccionar',compact('concepto','total_fraccionar','id_persona','id_agremiado','comprobanted', 'valorizacion' ));
	}
    

    public function obtener_conceptos($perido){

        $conceptos_model = new Concepto;        
        $conceptos = $conceptos_model->getConceptoPeriodo($perido);
        //print_r($conceptos);exit();
        return view('frontend.ingreso.lista_conceptos',compact('conceptos'));

    }

    public function send_concepto(Request $request){
        $msg = "";
        $id_user = Auth::user()->id;
        $id_persona = $request->id_persona;
        $tipo_documento = $request->tipo_documento;
        $id_agremiado = $request->id_agremiado;

       // print_r($id_persona); exit();

        //if($tipo_documento=="79")$id_persona = $request->empresa_id;
            
        $concepto_detalle = $request->concepto_detalle;
        $ind = 0;
        foreach($request->concepto_detalles as $key=>$det){
            $conceptod[$ind] = $concepto_detalle[$key];
            $ind++;
        }

        foreach ($conceptod as $key => $value) {

            //$id_val = $value['id'];
            //echo( $id_val);

            $valorizacion = new Valorizacione;
            $valorizacion->id_modulo = 5;
            $valorizacion->pk_registro = 0;
            $valorizacion->id_concepto = $value['id'];
            if($tipo_documento=="79"){
                $valorizacion->id_empresa = $id_persona;    
            }else{
                $valorizacion->id_agremido = $id_agremiado;
                $valorizacion->id_persona = $id_persona;
                    
            }
            $valorizacion->monto = $value['importe'];
            $valorizacion->id_moneda = $value['id_moneda'];
            $valorizacion->fecha = Carbon::now()->format('Y-m-d');
            $valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');            
            $valorizacion->id_usuario_inserta = $id_user;
            $valorizacion->descripcion = $value['denominacion'];

            $valorizacion->valor_unitario = $value['importe'];
            $valorizacion->cantidad = "1";
            $valorizacion->otro_concepto = "1";


            $valorizacion->save();

            $msg = "ok";

        }

        
       // print_r($conceptod);
       // exit();

       echo $msg;

/*

        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $valorizacion = $valorizaciones_model->getValorizacion("89",$id_persona);
        //print_r($valorizacion);exit();
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));
*/
    }

    public function send_fracciona_deuda(Request $request){

        $msg = "";
        $id_user = Auth::user()->id;
        $id_persona = $request->id_persona;
        $id_agremiado = $request->id_agremiado;

        $id_concepto = $request->id_concepto;
        $Exonerado = $request->Exonerado;

        //print_r($id_concepto); exit();

        $id_pk = 0;
       // $id_concepto = 0;

        //print_r($request->valorizacion); exit();

        
/*
        foreach($request->valorizacion as $key=>$tmp){
            //$id_pk = $tmp['id'];
            $id_concepto = $tmp['id_concepto'];
        }
*/

/*
        foreach($request->valorizacion as $key=>$tmp){
            $id_pk = $tmp['id'];
        }
*/


        $fraccionamiento = new Fraccionamiento; 
        $fraccionamiento->cuotas = $request->cboCuotas;
        $fraccionamiento->monto = $request->txtTotalFrac;
        $fraccionamiento->porcentaje = $request->txtPorcentaje;
        $fraccionamiento->fecha_inicio = $request->txtFechaIni;
        $fraccionamiento->id_usuario_inserta = $id_user;

        $fraccionamiento->save();
        $id_fraccionamiento = $fraccionamiento->id;

        foreach($request->valorizacion as $key=>$tmp){

            $id_concepto_sel = $tmp['id_concepto'];
            
            if($id_concepto_sel==26411 or $id_concepto_sel==26412){
            
                $valorizacion_ = Valorizacione::find($tmp['id']);

                $valorizacion_->codigo_fraccionamiento = $id_fraccionamiento;
                $valorizacion_->estado = '0';
                $valorizacion_->save(); 

            }

        }

        /*
        $id_persona = $request->id_persona;
        $tipo_documento = $request->id_tipo_documento_;
        $valorizaciones_model = new Valorizacione;        
        $valorizacion = $valorizaciones_model->ActualizaValorizacion_pp($tipo_documento, $id_fraccionamiento, $id_persona);
*/



/*
        foreach($request->valorizacion as $key=>$val){

            $id = $val['id'];

            $valorizacion = Valorizacione::find($id);
            $valorizacion-> pk_fraccionamiento = $id_pk;
            $valorizacion-> estado = 0;
			$valorizacion->save();          
        }        
*/

        if($id_concepto == "26412"){
            $id_concepto="26527";
        }else{
            $id_concepto="26412";
        }

        //print_r($request->fraccionamiento); exit();

        foreach($request->fraccionamiento as $key=>$frac){

                $valorizacion = new Valorizacione;
                $valorizacion->id_modulo = 6;
                $valorizacion->pk_registro = 0;
                $valorizacion->id_concepto = $id_concepto; //26412;
                $valorizacion->id_agremido = $id_agremiado;
                $valorizacion->id_persona = $id_persona;
                $valorizacion->monto = $frac['total_frac'];
                $valorizacion->id_moneda = 1;
                $valorizacion->fecha = $frac['fecha_cuota'];
                $valorizacion->fecha_proceso = Carbon::now()->format('Y-m-d');            
                $valorizacion->id_usuario_inserta = $id_user;
                $valorizacion->descripcion = $frac['denominacion'];
                $valorizacion->codigo_fraccionamiento =  $id_fraccionamiento;

                $valorizacion->save();
            
        }
        
        

        $id_persona = $request->id_persona;
        $tipo_documento = $request->id_tipo_documento_;
        $periodo = $request->cboPeriodo_b;
        $mes = $request->cboMes_b;
        $tipo_couta = $request->cboTipoCuota_b;
        $concepto = $id_concepto;//26412;
        //$filas = $request->cboFilas;
        $filas = "10000";
        // print_r($concepto);exit();
        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $valorizacion = $valorizaciones_model->getValorizacion($tipo_documento,$id_persona,$periodo,$mes,$tipo_couta,$concepto,$filas,$Exonerado,"");
       
       
        return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));

    }

    public function modal_valorizacion_factura($id){
		
		$valorizaciones_model = new Valorizacione;
		$valorizacion = $valorizaciones_model->getValorizacionFactura($id);
		return view('frontend.ingreso.modal_valorizacion_factura',compact('valorizacion'));
	
	}

    public function modal_beneficiario_($periodo, $id_persona, $id_agremiado, $tipo_documento){
		
        $persona = new Persona();
        $empresa_model = new Empresa();
        $beneficiario_model = new Beneficiario();
        $empresa = $empresa_model->getEmpresaId($id_persona);
        $empresa_beneficiario = $beneficiario_model->getBeneficiarioId($empresa->id);
       
		//$beneficiario = new Beneficiario;
		//$valorizacion = $valorizaciones_model->getValorizacionFactura($id);
		return view('frontend.ingreso.modal_beneficiario_',compact('persona','empresa','id_persona','id_agremiado','tipo_documento','empresa_beneficiario'));
	
	}

    public function obtener_datos_actualizados($id_empresa){
	
		$beneficiario_model = new Beneficiario;
		$empresa_beneficiario = $beneficiario_model->getBeneficiarioId($id_empresa);
        $datos_formateados = [];

        foreach ($empresa_beneficiario as $beneficiario) {
            $datos_formateados[] = [
                'numero_documento' => $beneficiario->numero_documento,
                'nombres' => $beneficiario->nombres,
                'direccion' => $beneficiario->direccion,
                'numero_celular' => $beneficiario->numero_celular,
                'correo' => $beneficiario->correo,
                // Agrega más campos si es necesario
            ];
        }
        return response()->json($datos_formateados);
	
	}
	
	public function listar_empresa_beneficiario_ajax(Request $request){
	
		$beneficiario_model = new Beneficiario();
		$p[]=$request->id_concurso;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $beneficiario_model->listar_empresa_beneficiario($p);
		$iTotalDisplayRecords = isset($data[0]->totalrows)?$data[0]->totalrows:0;

		$result["PageStart"] = $request->NumeroPagina;
		$result["pageSize"] = $request->NumeroRegistros;
		$result["SearchText"] = "";
		$result["ShowChildren"] = true;
		$result["iTotalRecords"] = $iTotalDisplayRecords;
		$result["iTotalDisplayRecords"] = $iTotalDisplayRecords;
		$result["aaData"] = $data;

        //print_r(json_encode($result)); exit();
		echo json_encode($result);

	
	}

    public function send_beneficiario(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$beneficiario = new Beneficiario;
		}else{
			$beneficiario = Beneficiario::find($request->id);
		}
		$persona = Persona::where("numero_documento",$request->dni)->where("estado","1")->first();
        $empresa = Empresa::where("ruc",$request->ruc)->where("estado","1")->first();

		$beneficiario->id_persona = $persona->id;
		$beneficiario->id_empresa = $empresa->id;
		$beneficiario->id_usuario_inserta = $id_user;
		$beneficiario->save();
		
    }


    public function liquidacion_caja(){	
		$caja_model = new TablaMaestra;
        $caja = $caja_model->getMaestroByTipo("91");

        return view('frontend.ingreso.all_liquidacion_caja',compact('caja'));
    }
	
    public function caja_total(){
        
        $caja_model = new TablaMaestra;
        $caja = $caja_model->getMaestroByTipo("91");
        //print_r($caja);
        //print_r("/n");

        $caja_ingreso_model = new CajaIngreso();
        $caja_usuario = $caja_ingreso_model->getCajaUsuario();

        //print_r($caja_usuario); exit();


        return view('frontend.ingreso.all_caja_total',compact('caja_usuario'));
    }

    public function obtener_caja_condicion_pago(request $request){
 
        $id_usuario_caja = $request->id_usuario_caja;
        $fecha = $request->fecha;

        $caja_ingreso_model = new CajaIngreso();
        $resultado = $caja_ingreso_model->getCajaCondicionPago($id_usuario_caja, $fecha);

        return view('frontend.ingreso.lista_caja_condicion_pago',compact('resultado'));

    }

    public function obtener_caja_venta(Request $request){
        $id_usuario_caja = $request->id_usuario_caja;
        $fecha = $request->fecha;

        $caja_ingreso_model = new CajaIngreso();
        $resultado = $caja_ingreso_model->getCajaComprobante($id_usuario_caja, $fecha);
       
     
        return view('frontend.ingreso.lista_caja_venta',compact('resultado'));

    }

	public function modal_liquidacion($id){        
		$valorizaciones_model = new Valorizacione;

		return view('frontend.ingreso.modal_liquidacion',compact('id'));
	}


    public function modal_detalle_factura($id){
		
		$cajaIngreso = CajaIngreso::find($id);
        $tablaMaestra_model = new TablaMaestra;
		$factura_model = new Comprobante;
		$fecha_fin=$cajaIngreso->fecha_fin;
        $fecha_inicio = $cajaIngreso->fecha_inicio;
        
        //print_r($fecha_fin); exit();
		if($cajaIngreso->fecha_fin=="")$fecha_fin=$factura_model->fecha_hora_actual(); 

		$factura = $factura_model->getFacturaByCaja($cajaIngreso->id_caja, $fecha_inicio, $fecha_fin);

        $forma_pago = $tablaMaestra_model->getMaestroByTipo(104);

        $medio_pago = $tablaMaestra_model->getMaestroByTipo(19);

		return view('frontend.ingreso.modal_detalle_factura',compact('id','factura','forma_pago','medio_pago'));
	
	}
	

	public function updateCajaLiquidacion(Request $request)
    {
        $valorizaciones_model = new Valorizacione;
		$id_user = Auth::user()->id;
        $datos[] = "ul";
        $datos[] = $id_user;
        $datos[] = $request->id_caja_ingreso;
		$datos[] = $request->id_caja;
        $datos[] = "";
        $datos[] = "";
        $datos[] = ($request->saldo_liquidado=='')?0:$request->saldo_liquidado;
        $datos[] = $request->estado;
        //print_r($datos);
        $id_caja_ingreso = $valorizaciones_model->registrar_caja_ingreso($datos);
        
		//echo $id_caja_ingreso;
        return redirect('/ingreso/liquidacion_caja');
		
    }
    
    
	
	public function listar_liquidacion_caja_ajax(Request $request){
		
		$valorizaciones_model = new Valorizacione;
		$p[]=$request->fecha_inicio_desde;
		$p[]=$request->fecha_inicio_hasta;
		$p[]=$request->fecha_ini;
		$p[]=$request->fecha_fin;
		$p[]=$request->id_caja;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $valorizaciones_model->listar_liquidacion_caja_ajax($p);
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
	
	public function exportar_liquidacion_caja($fecha_inicio_desde,$fecha_inicio_hasta,$fecha_ini, $fecha_fin,$id_caja,$estado) {
		
		$valorizaciones_model = new Valorizacione;
		if($fecha_inicio_desde!=0)$fecha_inicio_desde = str_replace("-","/",$fecha_inicio_desde); else $fecha_inicio_desde = "";
		if($fecha_inicio_hasta!=0)$fecha_inicio_hasta = str_replace("-","/",$fecha_inicio_hasta); else $fecha_inicio_hasta = "";
		if($fecha_ini!=0)$fecha_ini = str_replace("-","/",$fecha_ini); else $fecha_ini = "";
		if($fecha_fin!=0)$fecha_fin = str_replace("-","/",$fecha_fin); else $fecha_fin = "";
		$p[]=$fecha_inicio_desde;
		$p[]=$fecha_inicio_hasta;
		$p[]=$fecha_ini;
		$p[]=$fecha_fin;
		$p[]=$id_caja;
		$p[]=$estado;
		$p[]=1;
		$p[]=10000;
		$data = $valorizaciones_model->listar_liquidacion_caja_ajax($p);
		
		$variable = [];
		$n = 1;
		array_push($variable, array("N","Usuario Caja", "Nombre Caja", "Tipo", "Estado", "Saldo Inicial", "Total Recaudado","Saldo Total","Fecha Inicio","Fecha Cierre","Usuario Contabilidad","Saldo Liquidado","Observacion"));
		foreach ($data as $r) {
			$estado = "";
			$disabled = "";
			if($r->estado == 0){
				$estado = "CERRADO";
				$disabled = "";
			}
			if($r->estado == 1){
				$estado = "ABIERTO";
				$disabled = "disabled='disabled'";
			}
			if($r->saldo_liquidado > 0){
				$estado = "LIQUIDADO";
				$disabled = "disabled='disabled'";
			}
			array_push($variable, array($n++,$r->usuario, $r->caja, $r->tipo,$estado, number_format($r->saldo_inicial,2), number_format($r->total_recaudado,2),number_format($r->saldo_total,2),$r->fecha_inicio, $r->fecha_fin, $r->usuario_contabilidad,($r->saldo_liquidado!="")?number_format($r->saldo_liquidado,2):0,$r->observacion));
		}
		
		$export = new InvoicesExport([$variable]);
		return Excel::download($export, 'liquidacion_caja.xlsx');
    }


    public function anula_fraccionamiento(Request $request)
    {
        $id_persona = $request->id_persona;
        $tipo_documento = $request->tipo_documento;
        if($tipo_documento=="79")$id_persona = $request->empresa_id;

        $codigo_fraccionamiento = $request->codigo_fraccionamiento;
        
        $valorizaciones_model = new Valorizacione;
        $resultado = $valorizaciones_model->getAnulaFraccionamiento($tipo_documento,$id_persona,$codigo_fraccionamiento);

        /*
        $periodo = "";
        $tipo_couta = "";
        $concepto = "";
        $filas = "10000";
        $valorizaciones_model = new Valorizacione;
        $sw = true;
        $valorizacion = $valorizaciones_model->getValorizacion($tipo_documento,$id_persona,$periodo,$tipo_couta,$concepto,$filas);
        
		return view('frontend.ingreso.lista_valorizacion',compact('valorizacion'));
		*/
    }

    public function anular_valorizacion(Request $request)
    {
        $id_user = Auth::user()->id;
        $factura_detalle = $request->comprobante_detalle;
        $ind = 0;
        foreach($request->comprobante_detalles as $key=>$det){
            $valorizad[$ind] = $factura_detalle[$key];
            
            //print_r($det['id']);
            $id = $det['id'];
            $valorizacion = Valorizacione::find($id);            
            $valorizacion-> estado = "0";
            $valorizacion-> id_usuario_actualiza = $id_user;
            $valorizacion->updated_at = Carbon::now()->format('Y-m-d');

            $valorizacion->save();  

            $ind++;
        }


    }
    public function exonerar_valorizacion(Request $request,$motivo){
        $msg = "";        
        $motivo_ = str_replace(['&', '/', '$', '\'', '\\'], '', $motivo);

        //echo($motivo_);exit();

        $id_user = Auth::user()->id;
        $nombre_user= Auth::user()->name;  //user::find ($id_user);
        //print_r($request->comprobante_detalle); exit();
        $opcion = $request->Exonerado; 

        foreach($request->comprobante_detalle as $key=>$val){

            $chek = $val['chek'];
            $id = $val['id'];
            
            if($chek==1){
                if($opcion=="0"){
                    $valorizacion = Valorizacione::find($id);            
                    $valorizacion-> exonerado = "1";
                    $valorizacion-> id_usuario_actualiza = $id_user;                    
                    $valorizacion-> exonerado_motivo = $motivo_ .  " usuario: ". $nombre_user . " Fecha: " . Carbon::now()->format('Y-m-d'); ;                    
                    $valorizacion->save();  
                   
                    //$agremiado_ = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
                    //$valorizacion_ = Valorizacione::where("id_concepto",26461)->where("id_agremido",$valorizacion->id_agremiado)->where("pagado",0)->where("exonerado",0)->where("id_modulo",3)->first();  
                    //echo $valorizacion->id_modulo;exit();
                    if($valorizacion->id_modulo=='3'){
                        echo $valorizacion->pk_registro;//exit();
                        $agremiado_multa = AgremiadoMulta::find($valorizacion->pk_registro);
                        if($agremiado_multa){
                            $agremiado_multa->id_estado_multa="2";
                            $agremiado_multa->save();    
                        }
                    }
                    $valorizacion_model = new Valorizacione;
                    $valorizacion_ = $valorizacion_model->getExonerado($valorizacion->id_agremido);
                    //print_r($valorizacion_);exit();
                    if($valorizacion_){
                            
                    }else{
                        $agremiado = Agremiado::find($valorizacion->id_agremido); 
                        $agremiado->id_situacion=73;
                        $agremiado->save();

                    }
                }

                if($opcion=="1"){
                    $valorizacion = Valorizacione::find($id);            
                    $valorizacion-> id_usuario_actualiza = $id_user;
                    $valorizacion-> exonerado = "0";
                    $valorizacion->save();  
                }

            }
                    
        }   
    
    }



    public function modal_consulta_persona(Request $request){
		
		//$id_tipo_documento = $request->tipo_documento;
		$id_tipo_documento = 78;
//		$numero_documento = "";
		

		$tablaMaestra_model = new TablaMaestra;
		$sexo = $tablaMaestra_model->getMaestroByTipo(2);
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo(110);

		return view('frontend.ingreso.modal_consulta_persona',compact('sexo','tipo_documento', 'id_tipo_documento'));
	}

    public function reporte_deudas_pdf($numero_cap, $id_concepto){

        if($id_concepto==0){$id_concepto='';}
		
		$caja_ingreso_model=new CajaIngreso;
        $agremiado_model=new Agremiado;
        $tipo_cambio_model= new TipoCambio;

        $datos_agremiado=$agremiado_model->getAgremiado(85,$numero_cap);
        $numero_cap=$datos_agremiado->numero_cap;
        $nombre_completo=$datos_agremiado->nombre_completo;
        //var_dump($datos_agremiado);exit();
		$datos_reporte_deudas=$caja_ingreso_model->datos_reporte_deudas($datos_agremiado->id, $id_concepto);
        $denominacion_reporte_deudas=$caja_ingreso_model->getDenominacionDeuda($datos_agremiado->id, $id_concepto);
        $tipo_cambio=$tipo_cambio_model->getTipoCambio();
        //var_dump($tipo_cambio);exit();
        $tipo_cambio_fecha=$tipo_cambio->fecha;  
        $tipo_cambio_valor_venta=$tipo_cambio->valor_venta;
		//$nombre=$datos[0]->numero_cap;
		//var_dump($denominacion_reporte_deudas);exit();
		//$numeroEnLetras = $this->numeroALetras($numero);

		Carbon::setLocale('es');

        $fecha_actual = Carbon::now()->format('d/m/Y');
        $hora_actual = Carbon::now()->format('H:i:s');

		//$carbonDate = new Carbon($fecha_actual);
	
		//$formattedDate = $carbonDate->timezone('America/Lima')->formatLocalized(' %d de %B %Y'); //->format('l, j F Y ');
		
		$pdf = Pdf::loadView('frontend.ingreso.reporte_deudas_pdf',compact('datos_agremiado','numero_cap','nombre_completo','datos_reporte_deudas','fecha_actual','hora_actual','denominacion_reporte_deudas','tipo_cambio_fecha','tipo_cambio_valor_venta'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

	}

    public function reporte_deudas_total_pdf($numero_cap, $id_concepto){

        if($id_concepto==0){$id_concepto='';}
		
		$caja_ingreso_model=new CajaIngreso;
        $agremiado_model=new Agremiado;
        $tipo_cambio_model= new TipoCambio;

        $datos_agremiado=$agremiado_model->getAgremiado(85,$numero_cap);
        $numero_cap=$datos_agremiado->numero_cap;
        $nombre_completo=$datos_agremiado->nombre_completo;
        //var_dump($datos_agremiado);exit();
		$datos_reporte_deudas=$caja_ingreso_model->getReporteDeudasTotal($datos_agremiado->id, $id_concepto);
        $denominacion_reporte_deudas=$caja_ingreso_model->getDenominacionDeudaTotal($datos_agremiado->id, $id_concepto);
        $tipo_cambio=$tipo_cambio_model->getTipoCambio();
        //var_dump($tipo_cambio);exit();
        $tipo_cambio_fecha=$tipo_cambio->fecha;  
        $tipo_cambio_valor_venta=$tipo_cambio->valor_venta;
		//$nombre=$datos[0]->numero_cap;
		//var_dump($denominacion_reporte_deudas);exit();
		//$numeroEnLetras = $this->numeroALetras($numero);

		Carbon::setLocale('es');

        $fecha_actual = Carbon::now()->format('d/m/Y');
        $hora_actual = Carbon::now()->format('H:i:s');

		//$carbonDate = new Carbon($fecha_actual);
	
		//$formattedDate = $carbonDate->timezone('America/Lima')->formatLocalized(' %d de %B %Y'); //->format('l, j F Y ');
		
		$pdf = Pdf::loadView('frontend.ingreso.reporte_deudas_total_pdf',compact('datos_agremiado','numero_cap','nombre_completo','datos_reporte_deudas','fecha_actual','hora_actual','denominacion_reporte_deudas','tipo_cambio_fecha','tipo_cambio_valor_venta'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

	}

    public function reporte_fraccionamiento_pdf($numero_cap){
		
		$caja_ingreso_model=new CajaIngreso;
        $agremiado_model=new Agremiado;
        $tipo_cambio_model= new TipoCambio;

        $datos_agremiado=$agremiado_model->getAgremiado(85,$numero_cap);
        $numero_cap=$datos_agremiado->numero_cap;
        $nombre_completo=$datos_agremiado->nombre_completo;
        //var_dump($datos_agremiado);exit();
		//$datos_reporte_deudas=$caja_ingreso_model->getReporteDeudasTotal($datos_agremiado->id);
        //$denominacion_reporte_deudas=$caja_ingreso_model->getDenominacionDeudaTotal($datos_agremiado->id);
        $tipo_cambio=$tipo_cambio_model->getTipoCambio();

        $deuda_cuota_fraccionamiento=$caja_ingreso_model->getDeudaCuotaFraccionamiento($datos_agremiado->id_p);

       // print_r ($deuda_cuota_fraccionamiento); exit();

        $cronograma_fraccionamiento=$caja_ingreso_model->getCronogramaFraccionamiento($datos_agremiado->id_p);


		Carbon::setLocale('es');

        $fecha_actual = Carbon::now()->format('d/m/Y');
        $hora_actual = Carbon::now()->format('H:i:s');
		
		$pdf = Pdf::loadView('frontend.ingreso.reporte_fraccionamiento_pdf',compact('datos_agremiado','numero_cap','nombre_completo','fecha_actual','hora_actual','tipo_cambio','deuda_cuota_fraccionamiento','cronograma_fraccionamiento'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

	}

    public function obtener_detalle_factura($id, $forma_pago, $estado_pago, $medio_pago, $total)
    {
        //$id
       // $detalle = ssdsd->fgfffg($id);
        //return view('frontend.ingreso.obtener_detalle_factura', compact('id','detalle'));
        if($forma_pago==0){$forma_pago='';}
        if($estado_pago==0){$estado_pago='';}
        if($medio_pago==0){$medio_pago='';}
        if($total==0){$total='';}

        $factura_model = new Comprobante;
        $cajaIngreso = CajaIngreso::find($id);

        $fecha_fin=$cajaIngreso->fecha_fin;
        $fecha_inicio = $cajaIngreso->fecha_inicio;
        
        //print_r($fecha_fin); exit();
		if($cajaIngreso->fecha_fin=="")$fecha_fin=$factura_model->fecha_hora_actual(); 
        
        $factura = $factura_model->getFacturaByCajaFiltro($cajaIngreso->id_caja, $fecha_inicio, $fecha_fin, $forma_pago, $estado_pago, $medio_pago,$total);
        print_r($factura);exit();
        return response()->json($factura);
    }

    public function modal_concepto_reporte($numero_cap){

        $conceptos_model = new Concepto;
        $concepto = $conceptos_model->getConceptoAllDenominacion2();

		return view('frontend.ingreso.modal_concepto_reporte',compact('numero_cap','concepto'));
	}

    public function valida_ultimo_pago($cap){
		
		$valorizacion_model = new Valorizacione;
        
        $año_actual = Carbon::now()->year;
        
		$pago_pronto_pago = $valorizacion_model->getPagosCuotaConstancia($cap, $año_actual);
		
		echo json_encode($pago_pronto_pago);
	}

    public function validar_pago($cap){
		
		$valorizacion_model = new Valorizacione;
        
		$ultimo_pago = $valorizacion_model->getUltimoPago($cap);
		
		echo json_encode($ultimo_pago);
	}

    public function validar_todos_pago($cap){
		
		$valorizacion_model = new Valorizacione;
        
		$ultima_cuota = $valorizacion_model->getUltimaCuota($cap);
		
		echo json_encode($ultima_cuota);
	}

    public function create_efectivo(){

        $caja_model = new TablaMaestra;
        $caja = $caja_model->getMaestroByTipo("91");

        return view('frontend.ingreso.create_efectivo',compact('caja'));

    }

    public function listar_consulta_efectivo_ajax(Request $request){
	
		$efectivo_model = new Efectivo;
		$p[]=$request->fecha;
		$p[]=$request->caja;
        $p[]="1";
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $efectivo_model->listar_consulta_efectivo_ajax($p);
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

    public function modal_efectivo_nuevoEfectivo($id){

        $caja_model = new TablaMaestra;

		if($id>0){
            $efectivo = Efectivo::find($id);
			$efectivo_detalle = EfectivoDetalle::where('id_efectivo',$efectivo->id)->get();
			
		}else{
			$efectivo = new Efectivo;
            $efectivo_detalle = new EfectivoDetalle;
		}

        $caja = $caja_model->getMaestroByTipo("91");
        $moneda = $caja_model->getMaestroByTipo("1");
        $tipo_monedas = $caja_model->getMaestroByTipo("133");

        //dd($efectivo_detalle);exit();
		return view('frontend.ingreso.modal_efectivo_nuevoEfectivo',compact('id','efectivo','caja','moneda','tipo_monedas','efectivo_detalle'));
	
	}

    public function modal_efectivo_detalle($id,$id_moneda){

        $caja_model = new TablaMaestra;
        $tipo_monedas = $caja_model->getMaestroByTipo("133");
        if($id>0){
            //$efectivo_detalle = EfectivoDetalle::where('id_efectivo',$id)->where('id_moneda',$id_moneda)->get();
            $efectivo_detalle_model = new EfectivoDetalle;
            $efectivo_detalle = $efectivo_detalle_model->getEfectivoDetalleByIdMonedaAndIdEfectivo($id,$id_moneda);
        }else{
            $efectivo_detalle = new EfectivoDetalle;
        }
        return view('frontend.ingreso.modal_efectivo_nuevoEfectivo_detalle',compact('id','id_moneda','tipo_monedas','efectivo_detalle'));

    }

    public function send_efectivo_nuevoEfectivo(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$efectivo = new Efectivo;
            $efectivo_detalle = new EfectivoDetalle;
		}else{
			$efectivo = Efectivo::find($request->id);
			$efectivo_detalle = EfectivoDetalle::where('id_efectivo',$efectivo->id);
		}
		
		$efectivo->id_caja = $request->caja;
		$efectivo->fecha = $request->fecha;
		$efectivo->importe_soles = $request->importe_soles;
		$efectivo->importe_dolares = $request->importe_dolares;
        //$efectivo->id_moneda = $request->moneda;
        $efectivo->estado = 1;
		$efectivo->id_usuario_inserta = $id_user;
		$efectivo->save();

        if($request->id == 0){
            
        }else{
			//$efectivo_detalle = EfectivoDetalle::where('id_efectivo',$efectivo->id);
		}
        
        $cantidad = $request->cantidad;
        $total = $request->total;
        $iddetalle = $request->iddetalle;
        $id_tipo_efectivo = $request->id_tipo_efectivo;

        foreach($iddetalle as $key=>$row){
            if($row==0){
                $efectivo_detalle = new EfectivoDetalle;
                $efectivo_detalle->id_moneda = $request->moneda;
                $efectivo_detalle->id_tipo_efectivo = $id_tipo_efectivo[$key];
            }else{
                $efectivo_detalle = EfectivoDetalle::find($row);
            }
            //$efectivo_detalle = new EfectivoDetalle;
            $efectivo_detalle->id_efectivo = $efectivo->id;
            $efectivo_detalle->cantidad = $cantidad[$key];
            $efectivo_detalle->total = $total[$key];
            //$efectivo_detalle->estado = 1;
            $efectivo_detalle->save();

        }
        /*
        foreach ($request->except(['_token', 'id', 'caja', 'fecha', 'importe_soles', 'importe_dolares', 'moneda']) as $key => $value) {
            if (strpos($key, '_') === false) {
                $codigo = $key;
                $cantidad = $value;
                $total = $request->input($codigo . '_');
    
                $efectivo_detalle = new EfectivoDetalle;
                $efectivo_detalle->id_efectivo = $efectivo->id;
                $efectivo_detalle->id_moneda = $request->moneda;
                $efectivo_detalle->id_tipo_efectivo = $codigo;
                $efectivo_detalle->cantidad = $cantidad;
                $efectivo_detalle->total = $total;
                //$efectivo_detalle->estado = 1;
                $efectivo_detalle->save();
            }
        }
        */
        return response()->json(['id' => $efectivo->id]); 

    }

    public function reporte_efectivo_caja_pdf($fecha, $caja){
		
		$efectivo_model=new Efectivo;

		$datos=$efectivo_model->datos_efectivo_caja($fecha, $caja);
		$caja=$datos[0]->caja;
		$fecha=$datos[0]->fecha;
		$moneda_soles=$datos[0]->moneda_soles;
		$moneda_dolares=$datos[0]->moneda_dolares;
		$cajero=$datos[0]->cajero;
		
		Carbon::setLocale('es');

		$pdf = Pdf::loadView('frontend.ingreso.reporte_efectivo_caja_pdf',compact('datos','caja','fecha','moneda_dolares','moneda_soles','cajero'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

	}

    public function reporte_efectivo_consolidado_pdf($fecha){
		
        $id_user = Auth::user()->id;

		$efectivo_model=new Efectivo;

		$datos=$efectivo_model->datos_efectivo_consolidado($fecha);

        if (empty($datos)) {
            return response()->json(['error' => 'No hay datos para la fecha seleccionada'], 404);
        }
        
		$fecha=$datos[0]->fecha;
        
        $nombre_usuario = Auth::user()->name;

		//$moneda_soles=$datos[0]->moneda_soles;
		//$moneda_dolares=$datos[0]->moneda_dolares;
		
		Carbon::setLocale('es');

		$pdf = Pdf::loadView('frontend.ingreso.reporte_efectivo_consolidado_pdf',compact('datos','fecha','nombre_usuario'));
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros

		return $pdf->stream();

	}

    public function validarCaja($caja, $fecha, $moneda, $id_efectivo){

        $efectivo_model = new Efectivo;

        $resultado = $efectivo_model->valida_caja($caja, $fecha, $moneda,$id_efectivo);

        echo json_encode($resultado);

    } 

    public function eliminar_efectivo($id,$estado)
    {
		$efectivo = Efectivo::find($id);
		$efectivo->estado = $estado;
		$efectivo->save();

		echo $efectivo->id;
    }

    public function modal_valoriza($id){
		
        $valoriza = Valorizacione::find($id);

        return view('frontend.ingreso.modal_valoriza',compact('valoriza'));

	}

    public function validar_estado_liquidacion($numero_documento){
 
        $liquidacion_model = new Liquidacione;
        $liquidacion = $liquidacion_model->getLiquidacionByCredipago($numero_documento);
        //dd($liquidacion);exit();

        return response()->json(['liquidacion' => $liquidacion]);

    }

}
