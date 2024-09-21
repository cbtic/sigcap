<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DelegadoTributo;
use App\Models\TablaMaestra;
use App\Models\Agremiado;
use App\Models\ComisionDelegado;
use App\Models\PeriodoComisione;
use App\Models\Persona;
use App\Models\Parametro;
use Auth;

class DelegadoTributoController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    function consulta_delegadoTributo(){

        $periodoComisione_model = new PeriodoComisione;
        $tablaMaestra_model = new TablaMaestra;

        $periodo = $periodoComisione_model->getPeriodoAllByFecha();
        $tipo_tributo = $tablaMaestra_model->getMaestroByTipo(77);

        return view('frontend.delegadoTributo.all',compact('periodo','tipo_tributo'));
    }

    public function listar_delegadoTributo_ajax(Request $request){
	
		$delegadoTributo_model = new DelegadoTributo;
		$p[]=$request->periodo;
		$p[]=$request->anio;
		$p[]=$request->delegado;
		$p[]=$request->tributo;
		$p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $delegadoTributo_model->listar_delegadoTributo_ajax($p);
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

    public function modal_nuevoDelegadoTributo($id){
		
		
		$delegadoTributo = new DelegadoTributo;
        $tablaMaestra_model = new TablaMaestra;
        $agremiado_model = new Agremiado;
        $periodoComisione_model = new PeriodoComisione;
        $parametro_model = new Parametro;
		
		if($id>0){
			$delegadoTributo = DelegadoTributo::find($id);
            $periodo_ = PeriodoComisione::find($delegadoTributo->id_periodo_comision);
            $agremiado_ = Agremiado::find($delegadoTributo->id_agremiado);
            $persona_ = Persona::find($agremiado_->id_persona);
		}else{
			$delegadoTributo = new DelegadoTributo;
            $periodo_ = NULL;
            $agremiado_ = NULL;
            $persona_ = NULL;
		}
		
        $agremiado = $agremiado_model->getAgremiadoRLAll();
        $tipo_tributo = $tablaMaestra_model->getMaestroByTipo(77);
        $bancos = $tablaMaestra_model->getMaestroByTipo(49);
        $emite = $tablaMaestra_model->getMaestroByTipo(103);
        $periodo = $periodoComisione_model->getPeriodoAllByFecha();
        $periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
        $anio_actual = date('Y');
        $parametro = $parametro_model->getParametroAnio($anio_actual);
        
        //$concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionDelegadoTributo($id_periodo);
        
        
		//$universidad = $tablaMaestra_model->getMaestroByTipo(85);
		//$especialidad = $tablaMaestra_model->getMaestroByTipo(86);
		
		return view('frontend.delegadoTributo.modal_nuevoDelegadoTributo',compact('id','delegadoTributo','tipo_tributo','bancos','agremiado','periodo','periodo_ultimo','periodo_activo','periodo_','emite','agremiado_','persona_','parametro'));
	
	}

    public function obtener_datos_delegado($periodo){

        $comisionDelegado_model = new ComisionDelegado;
        //$valorizaciones_model = new Valorizacione;
        $concurso_inscripcion = $comisionDelegado_model->getConcursoInscripcionDelegadoTributo($periodo);
        //var_dump($concurso_inscripcion);exit();
        $agremiados = array();
        foreach ($concurso_inscripcion as $registro) {
            $agremiados[] = $registro;
        }
        $array = array(
            "agremiado" => $agremiados
        );
        //$array["agremiado"] = $concurso_inscripcion;
        echo json_encode($array);

    }

    public function send_delegadoTributo(Request $request){
		
		$id_user = Auth::user()->id;

		if($request->id == 0){
			$delegadoTributo = new DelegadoTributo;
            $delegadoTributo->id_agremiado = $request->delegado;
            $delegadoTributo->anio = $request->anio;
		}else{
			$delegadoTributo = DelegadoTributo::find($request->id);
            $delegadoTributo->id_agremiado = $request->id_delegado_;
            $delegadoTributo->anio = $request->anio_;
		}
        
        $delegadoTributo->id_periodo_comision = $request->id_periodo;
		$delegadoTributo->id_tipo_tributo = $request->tipo_tributo;
		$delegadoTributo->id_tipo_operacion = $request->emite;
		$delegadoTributo->id_banco = $request->entidad_financiera;
        $delegadoTributo->numero_cuenta = $request->numero_cuenta;
        $delegadoTributo->cci = $request->cci;
        $delegadoTributo->fecha_solicitud = $request->fecha_solicitud;
        $delegadoTributo->fecha_inicio = $request->fecha_inicio;
        $delegadoTributo->fecha_fin = $request->fecha_fin;
		$delegadoTributo->id_usuario_inserta = $id_user;
		$delegadoTributo->save();
		
    }

    public function eliminar_delegadoTributo($id,$estado)
    {
		$delegadoTributo = DelegadoTributo::find($id);
		$delegadoTributo->estado = $estado;
		$delegadoTributo->save();

		echo $delegadoTributo->id;
    }

    public function validar_delegado($id_delegado){

        $delegado_cantidad = DelegadoTributo::where("id_agremiado",$id_delegado)->where("estado","1")->count();

       return $delegado_cantidad;
    }
}
