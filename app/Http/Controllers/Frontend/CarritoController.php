<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\CarritoItem;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\User;
use App\Models\Comprobante;
use App\Models\Valorizacione;
use Auth;
use App\Services\VisaService;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Log;

class CarritoController extends Controller
{
    
    public function index(){
        
		$usuario = Auth::user();
		$id_persona = $usuario->id_persona;

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
		$carrito_deuda = $carrito_model->getCarritoDeuda($tipo_documento,$id_persona,$periodo,$mes,$tipo_couta,$concepto,$filas,$Exonerado,$numero_documento_b);
		
		$p[]=$id_persona;
		$p[]="v";
		$prontopago = $carrito_model->genera_prontopago($p);

		return view('frontend.carrito.all',compact('carrito_deuda','prontopago','id_persona'));

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

		if($valorizacion_id==0){
			$usuario = User::find($pedido->usuario_id);
			$carrito_model = new Carrito;
			
			$p[]=$usuario->id_persona;
			$p[]="c";
			$prontopago = $carrito_model->genera_prontopago($p);

		}else{
			$this->factura($pedido);
		}
		
		//print_r($data);exit();
		return view('frontend.carrito.pedido',compact('data','purchaseNumber','pedido'));

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
		

	}

                    
	

}
