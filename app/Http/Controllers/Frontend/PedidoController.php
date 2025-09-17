<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Carrito;
use App\Models\Pedido;
use Auth;

class PedidoController extends Controller
{
    public function index(){
        
		$usuario = Auth::user();
		$id_persona = $usuario->id_persona;
		$tipo_documento = 85;
		
		$carrito_model = new Carrito;
        //$pedido_model = new Pedido;
		//$pedido = $pedido_model->getPedidoByUsuario($usuario->id);
		$agremiado = $carrito_model->getAgremiado($tipo_documento,$id_persona);
		
		return view('frontend.carrito.all_pedido',compact(/*'pedido',*/'id_persona','agremiado'));

    }

    public function listar_pedido(Request $request){

		$usuario = Auth::user();
		$id_persona = $usuario->id_persona;
		$tipo_documento = 85;
		$pedido_model = new Pedido;
		$pedido = $pedido_model->getPedidoByUsuario($usuario->id);

		return view('frontend.carrito.lista_pedido',compact('pedido'));

	}

    public function show($id){

		$pedido = Pedido::find($id);
		$data = json_decode($pedido->response);
		$purchaseNumber = $pedido->purchase_number;

		return view('frontend.carrito.show_pedido',compact('data','purchaseNumber','id'));

	}

}
