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
use App\Models\CoordinadorZonalDetalle;
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
		$municipalidad_modal = new Municipalidade;
		$region = $region_model->getRegionAll();
        $periodo = $periodo_model->getPeriodoAll();
		$zonal = $tablaMaestra_model->getMaestroByTipo(117);
		$estado_aprobacion = $tablaMaestra_model->getMaestroByTipo(109);
		$estado = $tablaMaestra_model->getMaestroByTipo(119);
		$municipalidad = $municipalidad_modal->getMunicipalidadOrden();
		$periodo_ultimo = PeriodoComisione::where("estado",1)->orderBy("id","desc")->first();
		$periodo_activo = PeriodoComisione::where("estado",1)->where("activo",1)->orderBy("id","desc")->first();
		$meses =[1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Setiembre',
		10=>'Octubre',11=>'Noviembre',12=>'Diciembre'];
		$mes_actual = date('m');
		
		
        return view('frontend.coordinador_zonal.all',compact('coordinador_zonal','region','periodo','agremiado','persona','zonal','estado','periodo_ultimo','estado_aprobacion','periodo_activo','meses','mes_actual','municipalidad'));

    }

    public function listar_coordinadorZonal_ajax(Request $request){
	
		$coordinadorZonal_model = new CoordinadorZonal;
		$p[]=$request->periodo;
		$p[]=$request->numero_cap;//$request->nombre;
		$p[]=$request->agremiado;
		$p[]=$request->id_municipalidad;
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
		$p[]=$request->periodo;
		$p[]=$request->agremiado;
		$p[]=$request->mes;
		$p[]="";
		$p[]="";
		$p[]="";
		$p[]=$request->estado_aprobado;
		$p[]=$request->fecha_inicio_bus;
		$p[]=$request->fecha_fin_bus;
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
	
	public function upload_informe(Request $request){
		
		$path = "img/informe";
        if (!is_dir($path)) {
            mkdir($path);
        }
		
		$path = "img/informe/tmp";
        if (!is_dir($path)) {
            mkdir($path);
        }
		
    	$filepath = public_path('img/informe/tmp/');
		move_uploaded_file($_FILES["file"]["tmp_name"], $filepath.$_FILES["file"]["name"]);
		echo $_FILES['file']['name'];
		
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
			$persona = Persona::where("id",$agremiado->id_persona)->where("estado","1")->first();
            //$agremiado_model = Agremiado::find($id);
			$coordinadorZonalDetalle = CoordinadorZonalDetalle::where('id_tipo_coordinador',$coordinadorZonal->id_zonal)->where("estado","1")->first();
			$zonal = $tablaMaestra_model->getMaestroC(117,$coordinadorZonal->id_zonal);
			//var_dump($zonal);exit();
		}else{
			$coordinadorZonal = new CoordinadorZonal;
		}

        $periodo = $periodo_model->getPeriodoAll();
        $mes = $tablaMaestra_model->getMaestroByTipo(116);
        $estado_sesion = $tablaMaestra_model->getMaestroByTipo(109);
		if($coordinadorZonalDetalle){
			$municipalidad = $municipalidad_model->getMunicipalidadCoordinador($id,$coordinadorZonalDetalle->periodo);
		}else{
			$municipalidad = $municipalidad_model->getMunicipalidadCoordinador($id,null);
		}
        
		//$concepto = $concepto_model->getConceptoAll();
		
		return view('frontend.coordinador_zonal.modal_coordinadorZonal_nuevoCoordinadorZonal',compact('id','agremiado','coordinadorZonal','periodo','mes','municipalidad','estado_sesion','persona','zonal'));
	
	}

    public function send_coordinador_zonal_nuevoCoordinadorZonal(Request $request){
		

		$id_user = Auth::user()->id;
		$agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
		$mensaje = "";
		
		if($request->id == 0){
			$coordinadorZonal = new CoordinadorZonal;
		}else{
			$coordinadorZonal = CoordinadorZonal::find($request->id);
		}

		/**********Comision**************/

		//var_dump($request->zonal_texto);exit();
		$denominacion = $request->zonal_texto;
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
				
            //$coordinadorZonal = new CoordinadorZonal;
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
        //$coordinador_zonal = CoordinadorZonal::where("id_agremiado",$agremiado->id)->where("estado","1")->first();
		$coordinador_zonal = CoordinadorZonal::find($request->id);
		$estado_sesion = $request->estado_sesion;
		$aprobar_pago = $request->aprobar_pago;
		$municipalidad = $request->municipalidad;
		$id_comision = $coordinador_zonal->id_comision;
        $img_foto = $request->img_foto;
		
        foreach($request->fecha as $key=>$row){
            
			$filepath_tmp = public_path('img/informe/tmp/');
			$filepath_nuevo = public_path('img/informe/');
			
			if(isset($img_foto[$key]) && $img_foto[$key]!=""){
				if (file_exists($filepath_tmp.$img_foto[$key])) {
					copy($filepath_tmp.$img_foto[$key], $filepath_nuevo.$img_foto[$key]);
				}
			}
			/**********ComisionSesione**************/
            $comision_sesione = new ComisionSesione;
            $comision_sesione->id_regional = $coordinador_zonal->id_regional;
            $comision_sesione->id_periodo_comisione = $coordinador_zonal->id_periodo;
            $comision_sesione->id_tipo_sesion = 401;
            $comision_sesione->fecha_programado = $row;
            $comision_sesione->fecha_ejecucion = $row;
			if(isset($img_foto[$key]) && $img_foto[$key]!="")$comision_sesione->ruta_informe = "img/informe/".$img_foto[$key];
            //$comision_sesione->id_aprobado = 2;
            //$comision_sesione->observaciones = 1;
            $comision_sesione->id_comision = $id_comision;
			$comision_sesione->id_municipalidad = $municipalidad[$key];    
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
			$comisionSesionDelegado->id_agremiado = $agremiado->id;
			$comisionSesionDelegado->coordinador = $coordinador;
			$comisionSesionDelegado->id_profesion_otro = NULL;
			//$comisionSesionDelegado->id_aprobar_pago = ($aprobar_pago[$key]==1)?2:1;
			$comisionSesionDelegado->id_aprobar_pago = $aprobar_pago[$key];
			$comisionSesionDelegado->observaciones = NULL;
			$comisionSesionDelegado->estado = 1;
			$comisionSesionDelegado->id_usuario_inserta = $id_user;
			$comisionSesionDelegado->save();

        }
    }

	public function eliminar_coordinador_zonal($id,$estado)
    {
		$coordinadorZonal = CoordinadorZonal::find($id);
		$coordinadorZonal->estado = $estado;
		$coordinadorZonal->save();

		echo $coordinadorZonal->id;
    }
	
	

	public function obtener_coordinador($id)
	{
		$coordinador_zonal_model = new CoordinadorZonal;
		$coordinador_zonal = $coordinador_zonal_model->getCoordinadorZonalById($id);
		
		echo json_encode($coordinador_zonal);
	}
	
	public function modal_coordinadorZonal_editarCoordinadorZonal($id){
		
		$coordinadorZonal = new CoordinadorZonal;
        $tablaMaestra_model = new TablaMaestra;
        $periodo_model = new PeriodoComisione;
        $agremiado_model = new Agremiado;
        $municipalidad_model = new Municipalidade;
		$regione_model = new Regione;

		//$coordinadorZonal = CoordinadorZonal::find($id);
		//$agremiado = Agremiado::where("id",$coordinadorZonal->id_agremiado)->where("estado","1")->first();
		$sesion_delegado = ComisionSesionDelegado::find($id);
		//$agremiado_model = Agremiado::find($id);

		/*$sesion_delegado_modal = new ComisionSesionDelegado;
		$datos_sesion = $sesion_delegado_modal->getSesionCoordinador($id);*/

		$agremiado = Agremiado::where("id",$sesion_delegado->id_agremiado)->where("estado","1")->first();
		$persona = Persona::where("id",$agremiado->id_persona)->where("estado","1")->first();
		$comision_sesion = ComisionSesione::where("id",$sesion_delegado->id_comision_sesion)->where("estado","1")->first();
		$comision = Comisione::where("id",$comision_sesion->id_comision)->where("estado","1")->first();

		$comision_model = new Comisione;

		$comision_ = $comision_model->getAllComision($comision_sesion->id);

		$comision_nombre = $comision_->comision;

		$numero_cap = $agremiado->numero_cap;
		$periodo = $comision_sesion->id_periodo_comisione;
		$id_aprobar_pago =$sesion_delegado->id_aprobar_pago;
		

        $periodo = $periodo_model->getPeriodoAll();
        $mes = $tablaMaestra_model->getMaestroByTipo(116);
        $estado_sesion = $tablaMaestra_model->getMaestroByTipo(109);
		$aprobar_pago = [2=>"Si",1=>"No"];
        $municipalidad = $municipalidad_model->getMunicipalidadOrden();
		$region = $regione_model->getRegionAll();
		$tipo_comision = $tablaMaestra_model->getMaestroByTipo(102);
		
		//$concepto = $concepto_model->getConceptoAll();
		
		return view('frontend.coordinador_zonal.modal_coordinadorZonal_editarCoordinadorZonal',compact('id','periodo','mes','municipalidad','estado_sesion','agremiado','comision_sesion','region','tipo_comision','comision','persona','aprobar_pago','id_aprobar_pago','comision_','comision_nombre'));
	
	}

	function send_coordinador_sesion_editar(Request $request)
    {
        
		$id_user = Auth::user()->id;
		
        $agremiado = Agremiado::where("numero_cap",$request->numero_cap)->where("estado","1")->first();
        //$coordinador_zonal = CoordinadorZonal::where("id_agremiado",$agremiado->id)->where("estado","1")->first();
		$comisionSesionDelegado = ComisionSesionDelegado::find($request->id);
		$comisionSesion = ComisionSesione::find($comisionSesionDelegado->id_comision_sesion);

		

        $img_foto = $request->img_foto;
		
            
		/*$filepath_tmp = public_path('img/informe/tmp/');
		$filepath_nuevo = public_path('img/informe/');
		
		if(isset($img_foto[$key]) && $img_foto[$key]!=""){
			if (file_exists($filepath_tmp.$img_foto[$key])) {
				copy($filepath_tmp.$img_foto[$key], $filepath_nuevo.$img_foto[$key]);
			}
		}*/
		
		
		/**********ComisionDelegado**************/
		$comisionSesion->fecha_programado = $request->fecha_programada_;
		$comisionSesion->fecha_ejecucion = $request->fecha_ejecucion_;
		$comisionSesion->id_estado_aprobacion = $request->estado_sesion_;
		$comisionSesion->id_municipalidad = $request->municipalidad_;
		$comisionSesion->id_usuario_inserta = $id_user;
		$comisionSesion->save();
		
		/**********ComisionSesionDelegado**************/
		$comisionSesionDelegado->id_aprobar_pago = $request->aprobar_pago_;
		$comisionSesionDelegado->id_usuario_inserta = $id_user;
		$comisionSesionDelegado->save();

        
    }

	public function modal_informes($id){
		 
		$coordinador_zonal_model = new CoordinadorZonal;
        $informe = $coordinador_zonal_model->getInformeById($id);
		
        return view('frontend.coordinador_zonal.modal_informes',compact('informe'));
		
    }
}
