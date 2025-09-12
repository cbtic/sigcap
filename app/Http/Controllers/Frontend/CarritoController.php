<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agremiado;
use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\User;
use App\Models\Persona;
use App\Models\Comprobante;
use App\Models\ComprobanteDetalle;
use App\Models\Valorizacione;
use App\Models\TablaMaestra;
use App\Models\Empresa;
use Auth;
use App\Services\VisaService;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Log;
use DateTime;

use Barryvdh\DomPDF\Facade\Pdf;
use stdClass;
use Illuminate\Contracts\View\View;

class CarritoController extends Controller
{
    
    public function index(){
        
		$usuario = Auth::user();
		$id_persona = $usuario->id_persona;
		//$persona = Ag::find($id_persona);
		//$agremiadoExiste = Agremiado::where("numero_cap",$request->numero_cap)->where("estado",1)->get();
		//$numero_documento = $persona->numero_documento;
		//echo $numero_documento;exit();
		//$id_persona = 291290;
		$tipo_documento = 85;
		$periodo = "";
        $mes = "";
		$tipo_couta = "";
		$concepto = "";
		$filas = "";
		$Exonerado = "";
		$numero_documento_b = "";

		$carrito_model = new Carrito;
		//$agremiado_model = new Agremiado;
		$carrito_deuda = $carrito_model->getCarritoDeuda($tipo_documento,$id_persona,$periodo,$mes,$tipo_couta,$concepto,$filas,$Exonerado,$numero_documento_b);
		$agremiado = $carrito_model->getAgremiado($tipo_documento,$id_persona);

		$p[]=$id_persona;
		$p[]="v";
		$prontopago = $carrito_model->genera_prontopago($p);

		return view('frontend.carrito.all',compact('carrito_deuda','prontopago','id_persona','agremiado'));

    }
	
	public function cargar_comprobante(Request $request){

		$usuario = Auth::user();
		$id_persona = $usuario->id_persona;
		$tipo_documento = 85;
		//echo $id_persona;
		//$carrito_model = new Carrito;
		//$carrito_deuda = $carrito_model->getCarritoDeuda($tipo_documento,$id_persona,$periodo,$mes,$tipo_couta,$concepto,$filas,$Exonerado,$numero_documento_b);
		$trans = $request->trans;
		$TipoF = $request->TipoF;
        
        if ($TipoF == 'FT') {$titulo = 'Nueva Factura';}
        if ($TipoF == 'BV') {$titulo = 'Nueva Boleta de Venta';}
        if ($TipoF == 'NCF') {$titulo = 'Nueva Nota Crédito Factura';}
        if ($TipoF == 'NCB') {$titulo = 'Nueva Nota Crédito Boleta de Venta';}
        if ($TipoF == 'NDF') {$titulo = 'Nueva Nota Dévito Factura';}
        if ($TipoF == 'NDB') {$titulo = 'Nueva Nota Dévito Boleta de Venta';}
        if ($TipoF == 'TK') {$titulo = 'Nuevo Ticket';}

		$empresa_model = new Empresa;
		$serie_model = new TablaMaestra;
		$tabla_model = new TablaMaestra;

		if ($trans == 'FA'){
            $serie = $serie_model->getMaestroC('95',$TipoF); 
            $serie_default = $serie[0]->predeterminado;
            $MonAd = 0;
            $total   = 100;//$request->total;
            $stotal   = 100;//$request->stotal;            
            $igv   = 18;//$request->igv;
            $deudaTotal   = 100;//$request->deudaTotal; 
            $adelanto   = 'N';

            if ($MonAd != '0' && $total <> $MonAd){
                $total   = $MonAd;
                $adelanto   = 'S';
            }else{
                $MonAd = 0;
            }

			$factura_detalle = array();
			$facturad = array();
			
            $id_concepto_pp = 0;//$request->id_concepto_pp;

            $ubicacion = "";//1;//$request->id_ubicacion;
            $persona = $id_persona;//$request->id_persona;
            $tipoDocP = $tipo_documento;//84;//$request->tipo_documento;
			$empresa_id = "";//1;//$request->empresa_id;

            if($tipoDocP == "78" && $TipoF == 'FT'){
                $empresa_id = $request->empresa_id;
            }
			
            if ($TipoF == 'BV' || $TipoF == 'TK'){


                if($persona==''){
                    $persona=-1; 
                }
                $empresa = $empresa_model->getPersonaId_BV($persona);

				if(!$empresa){
					$empresa = $empresa_model->getEmpresaId($ubicacion);
				}
            }
            else{
                
                if ($tipoDocP == "79"){
                    $empresa = $empresa_model->getEmpresaId($ubicacion);
                }
                else{
                    $empresa = $empresa_model->getPersonaId($persona);
                }
                
            }

            if ($tipoDocP=="79"){
                $id_cliente=$ubicacion;
            }
            else{
                $id_cliente=$persona;
            }

            $comprobante_model = new Comprobante;
            $nc = $comprobante_model->getncById($id_cliente,/*1*/$tipo_documento,$id_concepto_pp);
            
        }
        if ($trans == 'FN'){
            $serie = $serie_model->getMaestroC('95',$TipoF);

        }
        if ($trans == 'FE'){

            $fac_id = $request->fac_id;
            $facturas = Comprobante::where('id', $fac_id)->first();
            $TipoF =  $facturas->fac_tipo;

            if ($TipoF == 'FT') {$titulo = 'Edita Factura';}
            if ($TipoF == 'BV') {$titulo = 'Edita Boleta de Venta';}
            if ($TipoF == 'NCF') {$titulo = 'Edita Nota Crédito Factura';}
            if ($TipoF == 'NCB') {$titulo = 'Edita Nota Crédito Boleta de Venta';}
            if ($TipoF == 'NDF') {$titulo = 'Edita Nota Dévito Factura';}
            if ($TipoF == 'NDB') {$titulo = 'Edita Nota Dévito Boleta de Venta';}
            if ($TipoF == 'TK') {$titulo = 'Edita Ticket';}

            $facturad = ComprobanteDetalle::where([
                'serie' => $facturas->fac_serie,
                'numero' => $facturas->fac_numero,
                'tipo' => $facturas->fac_tipo
            ])->get();

        }

		$pedido = Pedido::find($request->id_pedido);
		$pedido_item = PedidoItem::where("pedido_id",$request->id_pedido)->get();
		
        //print_r($empresa);
		return view('frontend.carrito.show_ajax',compact('trans','serie','empresa','pedido_item','pedido','titulo','empresa'));

	}

	public function listar_deuda(Request $request){

		$usuario = Auth::user();
		$id_persona = $usuario->id_persona;
		$tipo_documento = 85;

		//$periodo = "";
        //$mes = "";
		//$tipo_couta = "";
		//$concepto = "";
		//$filas = "";
		//$Exonerado = "";
		//$numero_documento_b = "";

		$SelFracciona = $request->SelFracciona;
        $Exonerado = $request->Exonerado;

        if($tipo_documento=="79")$id_persona = $request->empresa_id;

        $periodo = $request->cboPeriodo_b;
        $mes = $request->cboMes_b;
        $tipo_couta = $request->cboTipoCuota_b;
        $concepto = $request->cboTipoConcepto_b;
        $filas = $request->cboFilas;
        $tipo_documento_b = $request->tipo_documento_b;

        if($tipo_documento_b=="87"){
            $numero_documento_b = $request->numero_documento_b;
        }else{
            $numero_documento_b = "";
        }

		$carrito_model = new Carrito;
		$carrito_deuda = $carrito_model->getCarritoDeuda($tipo_documento,$id_persona,$periodo,$mes,$tipo_couta,$concepto,$filas,$Exonerado,$numero_documento_b);


		return view('frontend.carrito.lista_valorizacion',compact('carrito_deuda'));

	}

	public function listar_valorizacion_concepto(Request $request){
        
		//$id_persona = $request->id_persona;
        //$tipo_documento = $request->tipo_documento;
        
		$usuario = Auth::user();
		$id_persona = $usuario->id_persona;
		$tipo_documento = 85;

		if($tipo_documento=="79")$id_persona = $request->empresa_id;
        $valorizaciones_model = new Valorizacione;
        $resultado = $valorizaciones_model->getValorizacionConcepto($tipo_documento,$id_persona);
    
		return $resultado;

    }

	public function listar_valorizacion_periodo(Request $request){
        
		//$id_persona = $request->id_persona;
        //$tipo_documento = $request->tipo_documento;

		$usuario = Auth::user();
		$id_persona = $usuario->id_persona;
		$tipo_documento = 85;

        if($tipo_documento=="79")$id_persona = $request->empresa_id;
        
        $valorizaciones_model = new Valorizacione;
        $resultado = $valorizaciones_model->getPeridoValorizacion($tipo_documento,$id_persona);

        return $resultado;

    }

	public function listar_valorizacion_mes(Request $request){
        
		//$id_persona = $request->id_persona;
        //$tipo_documento = $request->tipo_documento;

		$usuario = Auth::user();
		$id_persona = $usuario->id_persona;
		$tipo_documento = 85;

        if($tipo_documento=="79")$id_persona = $request->empresa_id;
        
        $valorizaciones_model = new Valorizacione;
        $resultado = $valorizaciones_model->getMesValorizacion($tipo_documento,$id_persona);

        return $resultado;

    }

    public function detalle(VisaService $visa){
        
		$env = config('visa.development') ? 'dev' : 'prd';
		$merchantId = config("visa.$env.merchant_id");
		$user       = config("visa.$env.user");
		$password   = config("visa.$env.pwd");
		$urlSession = config("visa.$env.url_session");
		$urlJs = config("visa.$env.url_js");

		$total_general=0;
		$usuario = Auth::user();
    	$carrito = Carrito::where('usuario_id', $usuario->id)->with('items')->first();
		//print_r($carrito);exit();
		$carrito_model = new Carrito;
		if($carrito){
			$carrito_items = $carrito_model->getCarritoDetalle($carrito->id);
			$total_general = $carrito_items[0]->total_general;
		}else{
			$carrito_items = NULL;
		}

		$token = $visa->generateToken();
		$sesion = $visa->generateSession($total_general, $token);
		$purchaseNumber = $visa->generatePurchaseNumber();
		
		// guardo en sesión
		session([
			'purchaseNumber' => $purchaseNumber,
			'amount' => $total_general
		]);
		
		return view('frontend.carrito.all_detalle',compact('carrito_items','total_general','purchaseNumber','merchantId','sesion','urlJs'));

    }

    public function item(Request $request){

		$valorizacion_id = $request->valorizacion_id;
		//echo $valorizacion_id;exit();
        $carrito_model = new Carrito;
		$valorizacion = $carrito_model->getCarritoDeudaById($valorizacion_id)[0];
		//print_r($valorizacion);exit();
		return view('frontend.carrito.item',compact('valorizacion_id','valorizacion'));

    }

	public function agregar(Request $request)
    {
		
        $request->validate([
            'valorizacion_id' => 'required|exists:valorizaciones,id',
            'cantidad'    => 'required|integer|min:1',
        ]);
		
        $usuario = Auth::user();
		
        // 1. Buscar o crear carrito del usuario (o token invitado)
        $carrito = Carrito::firstOrCreate(
            ['usuario_id' => $usuario->id],
            [
                'subtotal'       => 0,
                'descuento_total'=> 0,
                'impuesto_total' => 0,
                'envio_total'    => 0,
                'total_general'  => 0,
            ]
        );

        // 2. Obtener producto y precio
		$carrito_model = new Carrito;
		$valorizacion = $carrito_model->getCarritoDeudaById($request->valorizacion_id)[0];
        $precio   = $valorizacion->valor_unitario;
		
        // 3. Verificar si ya existe item en el carrito (misma variante)
        $item = CarritoItem::where('carrito_id', $carrito->id)
            	->where('valorizacion_id', $valorizacion->id)
            	->first();

        if ($item) {
            // Si ya existe, actualizar cantidad y total
            $item->cantidad += $request->cantidad;
            $item->total = $item->cantidad * $item->precio_unitario;
            $item->save();
			
        } else {
            // Si no existe, crear nuevo item
            $item = CarritoItem::create([
                'carrito_id'          => $carrito->id,
                'valorizacion_id'     => $valorizacion->id,
                'fecha_vencimiento'	  => $valorizacion->fecha,
                'nombre'              => $valorizacion->descripcion,
                'precio_unitario'     => $precio,
                'cantidad'            => $request->cantidad,
                'total'         	  => $precio * $request->cantidad,
            ]);
			
        }
		
        // 4. Recalcular totales del carrito
        $this->recalcularTotales($carrito);

		/*
        return response()->json([
            'mensaje' => 'Producto agregado al carrito',
            'carrito' => $carrito->load('items'),
        ]);
		*/
		
		// Redirigir al detalle del carrito con un mensaje
		return redirect('/carrito/detalle')->with('success', 'Producto agregado al carrito');
    }

	public function eliminar($id) 
	{
		$usuario = Auth::user();

		// Buscar el item asegurando que pertenezca al carrito del usuario logueado
		$item = CarritoItem::where('id', $id)
			->whereHas('carrito', function ($q) use ($usuario) {
				$q->where('usuario_id', $usuario->id);
			})
			->firstOrFail();

		$carrito = $item->carrito;

		// Eliminar el item
		$item->delete();

		// Recalcular totales del carrito
		$this->recalcularTotales($carrito);

		// Si el carrito quedó vacío, lo puedes eliminar también
		if ($carrito->items()->count() == 0) {
			$carrito->delete();
		}

		return redirect('/carrito/detalle')->with('success', 'Producto eliminado del carrito');
	}

	public function agregar_prontopago(Request $request)
    {
		
        $request->validate([
            'valorizacion_id' => 'required|exists:valorizaciones,id',
            'cantidad'    => 'required|integer|min:1',
        ]);
		
        $usuario = Auth::user();
				
		$carrito_model = new Valorizacione;

		$p[]=$request->valorizacion_id;
		$p[]="v";
		$prontopago = $carrito_model->genera_prontopago($p)[0];
		
		//print_r($prontopago);
		//exit();
		
        // 1. Buscar o crear carrito del usuario (o token invitado)
        $carrito = Carrito::firstOrCreate(
            ['usuario_id' => $usuario->id],
            [
                'subtotal'       => 0,
                'descuento_total'=> $prontopago->descuento,
                'impuesto_total' => 0,
                'envio_total'    => 0,
                'total_general'  => 0,
            ]
        );
		//exit();
        // 2. Obtener producto y precio

		//$valorizacion = $carrito_model->getCarritoDeudaById($request->valorizacion_id)[0];
        $precio   = $prontopago->pu;
		
        // 3. Verificar si ya existe item en el carrito (misma variante)
        $item = CarritoItem::where('carrito_id', $carrito->id)
            	->where('valorizacion_id', 0)
            	->first();

        if ($item) {
            // Si ya existe, actualizar cantidad y total
            /*
			$item->cantidad += $request->cantidad;
            $item->total = $item->cantidad * $item->precio_unitario;
            $item->save();
			*/
			
        } else {
            // Si no existe, crear nuevo item
            $item = CarritoItem::create([
                'carrito_id'          => $carrito->id,
                'valorizacion_id'     => 0,
                'fecha_vencimiento'	  => $prontopago->fecha,
                'nombre'              => $prontopago->descripcion,
                'precio_unitario'     => $precio,
                'cantidad'            => $prontopago->cantidad,
                'total'         	  => $prontopago->total,
            ]);
			//print_r($item);
        }
		//exit();
        // 4. Recalcular totales del carrito
        $this->recalcularTotalesProntoPago($carrito);

		/*
        return response()->json([
            'mensaje' => 'Producto agregado al carrito',
            'carrito' => $carrito->load('items'),
        ]);
		*/
		
		// Redirigir al detalle del carrito con un mensaje
		return redirect('/carrito/detalle')->with('success', 'Producto agregado al carrito');
    }

    /**
     * Recalcular totales del carrito
     */
    private function recalcularTotales(Carrito $carrito)
    {
        $subtotal = $carrito->items()->sum('total');

        $carrito->subtotal       = $subtotal;
        $carrito->descuento_total= 0; // luego se aplica cupón
        $carrito->impuesto_total = 0; // si manejas IGV
        $carrito->envio_total    = 0; // si hay costo de envío
        $carrito->total_general  = $subtotal;
        $carrito->save();
    }

	private function recalcularTotalesProntoPago(Carrito $carrito)
    {
        $subtotal = $carrito->items()->sum('total');

        $carrito->subtotal       = $subtotal;
        //$carrito->descuento_total= 0; // luego se aplica cupón
        $carrito->impuesto_total = 0; // si manejas IGV
        $carrito->envio_total    = 0; // si hay costo de envío
        $carrito->total_general  = $subtotal;
        $carrito->save();
    }

	public function finalizar(Request $request,VisaService $visa)
    {
		
		$transactionToken = $request->transactionToken;
		$email = $request->customerEmail;
		//$amount = $request->amount;
		//$purchaseNumber = $request->purchaseNumber;
		$channel = $request->channel;

		// recupero desde la sesión
		$amount = session('amount');
		$purchaseNumber = session('purchaseNumber');
		
		$env = config('visa.development') ? 'dev' : 'prd';
		$merchantId = config("visa.$env.merchant_id");
		$user       = config("visa.$env.user");
		$password   = config("visa.$env.pwd");
		$urlSession = config("visa.$env.url_session");
		$urlJs = config("visa.$env.url_js");

		if ($channel == "pagoefectivo") {
			//$url = $_POST["url"];
			//header('Location: '.$url);
			return redirect()->away($request->url);
			//exit;
		} 

		$token = $visa->generateToken();
		$data = $visa->generateAuthorization($amount, $purchaseNumber, $transactionToken, $token);
		
		$carrito = Carrito::where('usuario_id', auth()->id())->first();

		$pedido = Pedido::create([
			'purchase_number' => $purchaseNumber,
			'amount'          => $amount,
			'email'           => $email,
			'usuario_id'      => auth()->id(),
			'token_invitado'  => $carrito->token_invitado,
			'subtotal'        => $carrito->subtotal,
			'descuento_total' => $carrito->descuento_total,
			'impuesto_total'  => $carrito->impuesto_total,
			'envio_total'     => $carrito->envio_total,
			'total_general'   => $carrito->total_general,
			'estado'          => 'pagado', // o pendiente, según respuesta de Visa
			'response'        => json_encode($data),
		]);

		// 4. Guardar los ítems del carrito en pedido_items
		foreach ($carrito->items as $item) {
			PedidoItem::create([
				'pedido_id'        => $pedido->id,
				'valorizacion_id'  => $item->valorizacion_id,
				'nombre'           => $item->nombre,
				'fecha_vencimiento'=> $item->fecha_vencimiento,
				'precio_unitario'  => $item->precio_unitario,
				'cantidad'         => $item->cantidad,
				'total'            => $item->total,
			]);
			$valorizacion_id = $item->valorizacion_id;
		}

		// 5. Eliminar carrito
		$carrito->delete();

		/*		
		if($valorizacion_id==0){
			$usuario = User::find($pedido->usuario_id);
			$carrito_model = new Valorizacione;
			
			$p[]=$usuario->id_persona;
			$p[]="c";
			$prontopago = $carrito_model->genera_prontopago($p)[0];
			$id_factura = $prontopago->id_comprobante;

		}else{
			$id_factura = $this->factura($pedido);
		}
		
		$factura = Comprobante::find($id_factura);
		
        if (is_null($factura->id_comprobante_ncnd) || $factura->id_comprobante_ncnd==0){
            $factura_referencia = Comprobante::where('id', -1)->get();
            $ref_comprobante="";
            $ref_tipo="";
        }   
        else {
            $factura_referencia = Comprobante::where('id', $factura->id_comprobante_ncnd)->get()[0];
            $ref_comprobante=  $factura_referencia->serie . " - " .$factura_referencia->numero ;
            $ref_tipo=$factura_referencia->tipo;
        };
		
        $facd_serie = $factura->serie;
        $facd_numero = $factura->numero;
        $facd_tipo = $factura->tipo;
       
        $tipo_comp = ($facd_tipo=="FT")?"01":"03";
        $fecha_comp = $factura->fecha;
        $fecha_comp = (new DateTime($fecha_comp))->format('Ymd');

        if ($factura->ruta_comprobante != null)
        {
            $rutapdf = 'storage/' . $tipo_comp .'_'. $facd_serie .'_'. $facd_numero .'_'. $fecha_comp.'.pdf';
        }
        else{
            $rutapdf = $factura->ruta_comprobante;
        }

		$id_guia = 0;
        $datos_model = new Comprobante;
		
        $datos=  $datos_model->getDatosByComprobante($id_factura);
        $cronograma =  $datos_model->getCronogramaPagos($id_factura);
        $usuario_caja =  $datos_model->getComprobanteCajaUsuario($id_factura);
       
        $factura_detail_model = new ComprobanteDetalle;
        $factura_detalles = ComprobanteDetalle::where([
            'serie' => $facd_serie,
            'numero' => $facd_numero,
            'tipo' => $facd_tipo
        ])->get();
		*/
		
		/**********************/
		//print_r($data);exit();
		//return view('frontend.carrito.pedido',compact('data','purchaseNumber','pedido','factura','factura_detalles','id_guia','datos','cronograma','ref_comprobante','ref_tipo','usuario_caja'));

		return redirect('/carrito/show/'.$pedido->id)->with('success', 'Producto eliminado del carrito');

	}

	public function show($id){

		$pedido = Pedido::find($id);
		
		/*
		$trans ='FA';
		//$TipoF = $request->TipoF;
		$TipoF = "FTFT";
        
        if ($TipoF == 'FTFT') {$TipoF = 'FT'; $titulo = 'Nueva Factura';}
        if ($TipoF == 'BVBV') {$TipoF = 'BV'; $titulo = 'Nueva Boleta de Venta';}
        if ($TipoF == 'NCFT') {$TipoF = 'NCF'; $titulo = 'Nueva Nota Crédito Factura';}
        if ($TipoF == 'NCBV') {$TipoF = 'NCB'; $titulo = 'Nueva Nota Crédito Boleta de Venta';}
        if ($TipoF == 'NDFT') {$TipoF = 'NDF'; $titulo = 'Nueva Nota Dévito Factura';}
        if ($TipoF == 'NDBV') {$TipoF = 'NDB'; $titulo = 'Nueva Nota Dévito Boleta de Venta';}
        if ($TipoF == 'TKTK') {$TipoF = 'TK'; $titulo = 'Nuevo Ticket';}

		$empresa_model = new Empresa;
		$serie_model = new TablaMaestra;
		$tabla_model = new TablaMaestra;

		if ($trans == 'FA'){
            $serie = $serie_model->getMaestroC('95',$TipoF); 
            $serie_default = $serie[0]->predeterminado;
            $MonAd = 0;
            $total   = 100;//$request->total;
            $stotal   = 100;//$request->stotal;            
            $igv   = 18;//$request->igv;
            $deudaTotal   = 100;//$request->deudaTotal; 
            $adelanto   = 'N';

            if ($MonAd != '0' && $total <> $MonAd){
                $total   = $MonAd;
                $adelanto   = 'S';
            }else{
                $MonAd = 0;
            }

			$factura_detalle = array();
			$facturad = array();
			
            $id_concepto_pp = 0;//$request->id_concepto_pp;

            $ubicacion = 1;//$request->id_ubicacion;
            $persona = 1;//$request->id_persona;
            $tipoDocP = 84;//$request->tipo_documento;
			$empresa_id = 1;//$request->empresa_id;

            if($tipoDocP == "78" && $TipoF == 'FT'){
                $empresa_id = $request->empresa_id;
            }
			
            if ($TipoF == 'BV' || $TipoF == 'TK'){


                if($persona==''){
                    $persona=-1; 
                }
                $empresa = $empresa_model->getPersonaId_BV($persona);

				if(!$empresa){
					$empresa = $empresa_model->getEmpresaId($ubicacion);
				}
            }
            else{
                
                if ($tipoDocP == "79"){
                    $empresa = $empresa_model->getEmpresaId($ubicacion);
                }
                else{
                    $empresa = $empresa_model->getPersonaId($persona);
                }
                
            }

            if ($tipoDocP=="79"){
                $id_cliente=$ubicacion;
            }
            else{
                $id_cliente=$persona;
            }

            $comprobante_model = new Comprobante;
            $nc = $comprobante_model->getncById($id_cliente,1 $request->tipo_documento,$id_concepto_pp);
            
        }
        if ($trans == 'FN'){
            $serie = $serie_model->getMaestroC('95',$TipoF);

        }
        if ($trans == 'FE'){

            $fac_id = $request->fac_id;
            $facturas = Comprobante::where('id', $fac_id)->first();
            $TipoF =  $facturas->fac_tipo;

            if ($TipoF == 'FT') {$titulo = 'Edita Factura';}
            if ($TipoF == 'BV') {$titulo = 'Edita Boleta de Venta';}
            if ($TipoF == 'NCF') {$titulo = 'Edita Nota Crédito Factura';}
            if ($TipoF == 'NCB') {$titulo = 'Edita Nota Crédito Boleta de Venta';}
            if ($TipoF == 'NDF') {$titulo = 'Edita Nota Dévito Factura';}
            if ($TipoF == 'NDB') {$titulo = 'Edita Nota Dévito Boleta de Venta';}
            if ($TipoF == 'TK') {$titulo = 'Edita Ticket';}

            $facturad = ComprobanteDetalle::where([
                'serie' => $facturas->fac_serie,
                'numero' => $facturas->fac_numero,
                'tipo' => $facturas->fac_tipo
            ])->get();

        }

		$pedido_item = PedidoItem::where("pedido_id",$pedido->id)->get();
		*/

		$data = json_decode($pedido->response);
		$purchaseNumber = $pedido->purchase_number;
		
		/*
		return view('frontend.carrito.show',compact('data','purchaseNumber',
					'trans','serie','empresa','facturad','stotal','igv','total','pedido_item','pedido'));
		*/

		return view('frontend.carrito.show',compact('data','purchaseNumber','id'/*,'factura','factura_detalles','id_guia','datos','cronograma','ref_comprobante','ref_tipo','usuario_caja'*/,
					/*'trans','serie','empresa','facturad','stotal','igv','total','pedido_item','pedido'*/));

	}

	public function ver_comprobante($id){

		$factura = Comprobante::find($id);
		
        $facd_serie = $factura->serie;
        $facd_numero = $factura->numero;
        $facd_tipo = $factura->tipo;
		$ref_tipo="";
        $ref_comprobante="";

        $tipo_comp = ($facd_tipo=="FT")?"01":"03";
        $fecha_comp = $factura->fecha;
        $fecha_comp = (new DateTime($fecha_comp))->format('Ymd');

        if ($factura->ruta_comprobante != null)
        {
            $rutapdf = 'storage/' . $tipo_comp .'_'. $facd_serie .'_'. $facd_numero .'_'. $fecha_comp.'.pdf';
        }
        else{
            $rutapdf = $factura->ruta_comprobante;
        }

        $id_guia = 0;
        
        $datos_model = new Comprobante;
		
        $datos=  $datos_model->getDatosByComprobante($id);
        

        $factura_detalles = ComprobanteDetalle::where([
            'serie' => $facd_serie,
            'numero' => $facd_numero,
            'tipo' => $facd_tipo
        ])->get();
		
		return view('frontend.carrito.show_comprobante',compact('id','factura','factura_detalles','id_guia','datos','ref_tipo','ref_comprobante'));

	}

	public function ver_comprobante_pdf($id){
		
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', '1200');
		
		$comprobante = Comprobante::find(481031);
		$facd_serie = $comprobante->serie;
        $facd_numero = $comprobante->numero;
        $facd_tipo = $comprobante->tipo;
		$comprobante_detalles = ComprobanteDetalle::where([
            'serie' => $facd_serie,
            'numero' => $facd_numero,
            'tipo' => $facd_tipo
        ])->get();

		$pdf = Pdf::loadView('pdf.ver_comprobante',compact('comprobante','comprobante_detalles'));
		$pdf->getDomPDF()->set_option("enable_php", true);
		
		$pdf->setPaper('A4'); // Tamaño de papel (puedes cambiarlo según tus necesidades)
		
    	$pdf->setOption('margin-top', 20); // Márgen superior en milímetros
   		$pdf->setOption('margin-right', 50); // Márgen derecho en milímetros
    	$pdf->setOption('margin-bottom', 20); // Márgen inferior en milímetros
    	$pdf->setOption('margin-left', 100); // Márgen izquierdo en milímetros
		
		return $pdf->stream('ver_comprobante.pdf');
	
	}

	public function send_comprobante(Request $request)
	{
		$pedido = Pedido::find($request->id_pedido);
		
		$facturas_model = new Comprobante;
		$usuario_id=$pedido->usuario_id;
		$usuario = User::find($usuario_id);

		$serieF=$request->serieF;
		$id_tipo_afectacion_pp=30;
		$tipoF=$request->TipoF;
		$ubicacion_id=$usuario->id_persona;
		$id_persona_act=$usuario->id_persona;
		$total = $pedido->total_general;
		$ubicacion_id2="0";
		$id_persona2="0";
		$id_caja=3;
		$descuento=0;
		$id_user=$usuario_id;
		$id_moneda=1;
		$id_nc=0;

		//echo $serieF.",".$id_tipo_afectacion_pp.",".$tipoF.",".$ubicacion_id.",". 
		//$id_persona_act.",".round($total, 2).",".$ubicacion_id2.",".$id_persona2.",0,".$id_caja.",".$descuento.",'f',".$id_user.",".$id_moneda.",".$id_nc;

		$id_factura = $facturas_model->registrar_factura_moneda($serieF,$id_tipo_afectacion_pp,$tipoF,$ubicacion_id, 
		$id_persona_act, round($total, 2),$ubicacion_id2,$id_persona2,0, $id_caja,$descuento,'f',$id_user, $id_moneda, $id_nc);
		
		$factura = Comprobante::find($id_factura);
		$fac_serie = $factura->serie;
		$fac_numero = $factura->numero;
		
        //if (isset($factura_upd->tipo_cambio)) $factura_upd->tipo_cambio = $request->tipo_cambio;
        $factura->estado_pago =  "C";//$request->estado_pago;
        $factura->id_forma_pago =  "1";//$request->id_formapago_;
        $factura->tipo_operacion = "0101";//$request->id_tipooperacion_;
        $id_persona = $id_persona_act;
        $id_empresa = $ubicacion_id;//$request->ubicacion;

        if ($id_persona != "") $factura->id_persona = $id_persona;
        if ($id_empresa != "") $factura->id_empresa = $id_empresa;

        //$factura_upd->observacion = $request->observacion;
        $factura->save();

		$pedido_item = PedidoItem::where("pedido_id",$pedido->id)->get();
		foreach ($pedido_item as $key => $value) {
			
			$total = $value->total;
			$pu_   = $value->precio_unitario;
			$id_concepto=26411;
			$cod_contable="";
			$descuento = 0;
			$item = $key + 1;

			$id_factura_detalle = $facturas_model->registrar_factura_moneda($serieF, $fac_numero, $tipoF, 
			$value->cantidad, $id_concepto, $pu_, $value->nombre, $cod_contable, $item, 
			$id_factura, $descuento,'d',$id_user,$id_moneda, 0);

			if ($value['id_concepto'] != '26464') {
			
				$facturaDet_upd = ComprobanteDetalle::find($id_factura_detalle);

				$facturaDet_upd->pu = $value->precio_unitario;
				$facturaDet_upd->importe = $value->total;
				$facturaDet_upd->igv_total = 0;
				$facturaDet_upd->precio_venta = $value->precio_unitario;
				$facturaDet_upd->valor_venta_bruto = $value->total;
				$facturaDet_upd->valor_venta = $value->total;
				//$facturaDet_upd->unidad = $value['unidad_medida_item'];
				$facturaDet_upd->save();
			}
		
			$valoriza_upd = Valorizacione::find($value->valorizacion_id);                       
			$valoriza_upd->id_comprobante = $id_factura;
			$valoriza_upd->pagado = "1";
			$valoriza_upd->valor_unitario = $value->precio_unitario;
			$valoriza_upd->cantidad = $value->cantidad;
			$valoriza_upd->save();
			
        }
		

        $facturas_model->registrar_deuda_persona($id_persona);
        
		//return $id_factura;

		return response()->json([
            'sw' => true,
            'id_factura' => $id_factura,
        ]);

	}

	public function factura($pedido)
	{

		$facturas_model = new Comprobante;
		$usuario_id=$pedido->usuario_id;
		$usuario = User::find($usuario_id);

		$serieF="B040";
		$id_tipo_afectacion_pp=30;
		$tipoF="BV";
		$ubicacion_id=$usuario->id_persona;
		$id_persona_act=$usuario->id_persona;
		$total = $pedido->total_general;
		$ubicacion_id2="0";
		$id_persona2="0";
		$id_caja=3;
		$descuento=0;
		$id_user=$usuario_id;
		$id_moneda=1;
		$id_nc=0;

		//echo $serieF.",".$id_tipo_afectacion_pp.",".$tipoF.",".$ubicacion_id.",". 
		//$id_persona_act.",".round($total, 2).",".$ubicacion_id2.",".$id_persona2.",0,".$id_caja.",".$descuento.",'f',".$id_user.",".$id_moneda.",".$id_nc;

		$id_factura = $facturas_model->registrar_factura_moneda($serieF,$id_tipo_afectacion_pp,$tipoF,$ubicacion_id, 
		$id_persona_act, round($total, 2),$ubicacion_id2,$id_persona2,0, $id_caja,$descuento,'f',$id_user, $id_moneda, $id_nc);

		$factura = Comprobante::find($id_factura);
		$fac_serie = $factura->serie;
		$fac_numero = $factura->numero;

		
		$pedido_item = PedidoItem::where("pedido_id",$pedido->id)->get();
		foreach ($pedido_item as $key => $value) {
			
			$total = $value->total;
			$pu_   = $value->precio_unitario;
			$id_concepto=26411;
			$cod_contable="";
			$descuento = 0;
			$item = $key + 1;

			$id_factura_detalle = $facturas_model->registrar_factura_moneda($serieF, $fac_numero, $tipoF, 
			$value->cantidad, $id_concepto, $pu_, $value->nombre, $cod_contable, $item, 
			$id_factura, $descuento,'d',$id_user,$id_moneda, 0);

			$valoriza_upd = Valorizacione::find($value->valorizacion_id);                       
			$valoriza_upd->id_comprobante = $id_factura;
			$valoriza_upd->pagado = "1";
			$valoriza_upd->valor_unitario = $value->precio_unitario;
			$valoriza_upd->cantidad = $value->cantidad;
			$valoriza_upd->save();
			
        }
		
		return $id_factura;

	}

                    
	

}
