<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CoordinadorZonal;
use App\Models\Regione;
use App\Models\PeriodoComisione;
use App\Models\Agremiado;
use App\Models\Persona;
use App\Models\TablaMaestra;
use App\Models\Municipalidade;
use App\Models\ComisionSesione;
use App\Models\Comisione;
use App\Models\ComisionDelegado;
use App\Models\ComisionSesionDelegado;
use App\Models\MunicipalidadIntegrada;
use Auth;

class CoordinadorZonalController extends Controller
{
    public function __construct(){

		$this->middleware(function ($request, $next) {
			if(!Auth::check()) {
                return redirect('login');
            }
			return $next($request);
    	});
	}

    public function consulta_coordinadorZonal(){
        
		$tablaMaestra_model = new TablaMaestra;
		$coordinadorZonal_model = new CoordinadorZonal;
        $agremiado = new Agremiado;
        $coordinador_zonal = new CoordinadorZonal;
        $persona = new Persona;
        $periodo_model = new PeriodoComisione;
        $region_model = new Regione;
		$region = $region_model->getRegionAll();
        $periodo = $periodo_model->getPeriodoVigenteAll();
		$zonal = $tablaMaestra_model->getMaestroByTipo(117);
		$estado = $tablaMaestra_model->getMaestroByTipo(119);
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		
        return view('frontend.coordinador_zonal.all',compact('coordinador_zonal','region','periodo','agremiado','persona','zonal','estado','periodo_ultimo'));

    }

    public function listar_coordinadorZonal_ajax(Request $request){
	
		$coordinadorZonal_model = new CoordinadorZonal;
		$p[]=$request->periodo;
		$p[]=$request->numero_cap;//$request->nombre;
		$p[]=$request->agremiado;
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $coordinadorZonal_model->listar_coordinadorZonal_ajax($p);
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

	public function listar_coordinadorZonalSesion_ajax(Request $request){
	
		$coordinadorZonal_model = new CoordinadorZonal;
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]="";
        $p[]=$request->estado;
		$p[]=$request->NumeroPagina;
		$p[]=$request->NumeroRegistros;
		$data = $coordinadorZonal_model->listar_coordinadorZonalSesion_ajax($p);
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

    public function modal_coordinadorZonal_nuevoCoordinadorZonal($id){
		
		$coordinadorZonal = new CoordinadorZonal;
        $tablaMaestra_model = new TablaMaestra;
        $periodo_model = new PeriodoComisione;
        $agremiado_model = new Agremiado;
        $municipalidad_model = new Municipalidade;
		//$concepto_model = new Concepto;

		if($id>0){
			$coordinadorZonal = CoordinadorZonal::find($id);
            $agremiado = Agremiado::where("id",$coordinadorZonal->id_agremiado)->where("estado","1")->first();
            //$agremiado_model = Agremiado::find($id);
		}else{
			$coordinadorZonal = new CoordinadorZonal;
		}

        $periodo = $periodo_model->getPeriodoVigenteAll();
        $mes = $tablaMaestra_model->getMaestroByTipo(116);
        $estado_sesion = $tablaMaestra_model->getMaestroByTipo(109);
        $municipalidad = $municipalidad_model->getMunicipalidadOrden();
		
		//$concepto = $concepto_model->getConceptoAll();
		
		return view('frontend.coordinador_zonal.modal_coordinadorZonal_nuevoCoordinadorZonal',compact('id','agremiado','coordinadorZonal','periodo','mes','municipalidad','estado_sesion'));
	
	}

    public function send_coordinador_zonal_nuevoCoordinadorZonal(Request $request){
		
		$id_user = Auth::user()->id;
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$mensaje = "";
		
		/**********Comision**************/

		$denominacion = "COORDINADOR ZONAL ".$request->zonal;
		$comisionExiste = Comisione::where("denominacion",$denominacion)->first();
		
		if($comisionExiste){
			$id_comision = $comisionExiste->id;
			$id_municipalidad_integrada = $comisionExiste->id_municipalidad_integrada;
		}else{
		
			$municipalidadIntegrada = new MunicipalidadIntegrada();
			$municipalidadIntegrada->denominacion = $denominacion;
			$municipalidadIntegrada->id_vigencia = 374;
			$municipalidadIntegrada->id_tipo_agrupacion = 2;
			$municipalidadIntegrada->id_tipo_comision = 1;//edificaciones
			$municipalidadIntegrada->id_regional = 5;
			$municipalidadIntegrada->id_periodo_comision = $request->periodo;
			$municipalidadIntegrada->id_usuario_inserta = $id_user;
			$municipalidadIntegrada->save();
			$id_municipalidad_integrada = $municipalidadIntegrada->id;
		
			$comision = new Comisione();
			$comision->id_regional = $request->regional;
			$comision->id_periodo_comisiones = $request->periodo;
			$comision->id_tipo_comision = 1;
			$comision->denominacion = $denominacion;
			$comision->comision = "";
			$comision->id_municipalidad_integrada = $id_municipalidad_integrada;
			$comision->id_usuario_inserta = $id_user;
			$comision->id_dia_semana = 398;
			$comision->estado = "1";
			$comision->save();
			$id_comision = $comision->id;
		}
		
		/****************************************/
		
		if($agremiado){
				
            $coordinadorZonal = new CoordinadorZonal;
            $coordinadorZonal->id_regional = $request->regional;
            $coordinadorZonal->id_periodo = $request->periodo;
            $coordinadorZonal->id_agremiado = $agremiado->id;
            $coordinadorZonal->id_comision = $id_comision;
            $coordinadorZonal->id_muni_inte = $id_municipalidad_integrada;
            $coordinadorZonal->id_usuario_inserta = $id_user;
			$coordinadorZonal->id_zonal = $request->zonal;
			$coordinadorZonal->estado_coordinador = $request->estado_coordinador;
            $coordinadorZonal->save();

		}else{
			$mensaje = "El Numero de CAP no existe";
		}
		
		$result["mensaje"] = $mensaje;
		echo json_encode($result);
		
	}

    function send_coordinador_sesion(Request $request)
    {
        
		$id_user = Auth::user()->id;
		
        $agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
        $coordinador_zonal = CoordinadorZonal::where("id_agremiado",$agremiado->id)->where("estado","1")->first();
		$estado_sesion = $request->estado_sesion;
		$aprobar_pago = $request->aprobar_pago;
		$id_comision = $coordinador_zonal->id_comision;
        
        foreach($request->fecha as $key=>$row){
            
			/**********ComisionSesione**************/
            $comision_sesione = new ComisionSesione;
            $comision_sesione->id_regional = $coordinador_zonal->id_regional;
            $comision_sesione->id_periodo_comisione = $coordinador_zonal->id_periodo;
            $comision_sesione->id_tipo_sesion = 401;
            $comision_sesione->fecha_programado = $row;
            $comision_sesione->fecha_ejecucion = $row;
            //$comision_sesione->id_aprobado = 2;
            //$comision_sesione->observaciones = 1;
            $comision_sesione->id_comision = $id_comision;
            $comision_sesione->id_estado_sesion = 290;//$estado_sesion[$key];
            $comision_sesione->id_estado_aprobacion = $estado_sesion[$key];      
            $comision_sesione->id_usuario_inserta = $id_user;

            $comision_sesione->save();
			$id_comision_sesion = $comision_sesione->id;
			
			$coordinador = 0;
			
			/**********ComisionDelegado**************/
			$comisionDelegado = new ComisionDelegado;
			//$concursoInscripcion = ConcursoInscripcione::find($request->id_concurso_inscripcion);
			$comisionDelegado->id_regional = $coordinador_zonal->id_regional;
			$comisionDelegado->id_comision = $id_comision;
			$comisionDelegado->coordinador = $coordinador;
			$comisionDelegado->id_agremiado = $agremiado->id;
			$comisionDelegado->id_puesto = 22;
			$comisionDelegado->id_usuario_inserta = $id_user;
			$comisionDelegado->save();
			$id_delegado = $comisionDelegado->id;
			
			/**********ComisionSesionDelegado**************/
			$comisionSesionDelegado = new ComisionSesionDelegado();
			$comisionSesionDelegado->id_comision_sesion = $id_comision_sesion;
			$comisionSesionDelegado->id_delegado = $id_delegado;
			$comisionSesionDelegado->coordinador = $coordinador;
			$comisionSesionDelegado->id_profesion_otro = NULL;
			$comisionSesionDelegado->id_aprobar_pago = ($aprobar_pago[$key]==1)?2:1;
			$comisionSesionDelegado->observaciones = NULL;
			$comisionSesionDelegado->estado = 1;
			$comisionSesionDelegado->id_usuario_inserta = $id_user;
			$comisionSesionDelegado->save();

        }
    }
    
}
