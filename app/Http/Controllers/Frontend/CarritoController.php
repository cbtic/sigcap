<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\CarritoItem;
use Auth;
use App\Services\VisaService;

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
		return view('frontend.carrito.all',compact('carrito_deuda'));

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
			exit;
		} else {   
			$token = $visa->generateToken();
			//echo $amount;
			$data = $visa->generateAuthorization($amount, $purchaseNumber, $transactionToken, $token);
		}
		
		//print_r($data);exit();
		return view('frontend.carrito.pedido',compact('data','purchaseNumber'));

	}

}
