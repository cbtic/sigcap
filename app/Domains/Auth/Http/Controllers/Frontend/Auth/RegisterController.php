<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Domains\Auth\Services\UserService;
use App\Rules\Captcha;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;
use App\Models\Persona;
use App\Models\Empresa;
use App\Models\TablaMaestra;
use App\Exceptions\GeneralException;

use Illuminate\Http\Request;
use App\Domains\Auth\Models\User;
use App\Models\Proyectista;
use App\Models\Agremiado;
use App\Models\RegistroProyectista;
use App\Models\ProfesionOtro;
use App\Models\PersonaResponsable;
/**
 * Class RegisterController.
 */
class RegisterController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * RegisterController constructor.
     *
     * @param  UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Where to redirect users after registration.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(homeRoute());
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        abort_unless(config('boilerplate.access.user.registration'), 404);
		
		$tablaMaestra_model = new TablaMaestra;
		$tipo_documento = $tablaMaestra_model->getMaestroByTipo("16");

        return view('frontend.auth.register',compact('tipo_documento'));
    }
	
	public function showRegistrationProyForm()
    {
        abort_unless(config('boilerplate.access.user.registration'), 404);
		
		$tablaMaestra_model = new TablaMaestra;
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo("16");
		$profesion = $tablaMaestra_model->getMaestroByTipo("131");

        return view('frontend.auth.registerProy',compact('tipo_documento','profesion'));
    }

    public function showRegistrationRespForm()
    {
        abort_unless(config('boilerplate.access.user.registration'), 404);
		
		$tablaMaestra_model = new TablaMaestra;
        $tipo_documento = $tablaMaestra_model->getMaestroByTipo("132");

        return view('frontend.auth.registerResp',compact('tipo_documento'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')],
            'password' => array_merge(['max:100'], PasswordRules::register($data['email'] ?? null)),
            'terms' => ['required', 'in:1'],
            'g-recaptcha-response' => ['required_if:captcha_status,true', new Captcha],
        ], [
            'terms.required' => __('You must accept the Terms & Conditions.'),
            'g-recaptcha-response.required_if' => __('validation.required', ['attribute' => 'captcha']),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Domains\Auth\Models\User|mixed
     *
     * @throws \App\Domains\Auth\Exceptions\RegisterException
     */
    protected function create(array $data)
    {
		$persona = Persona::where("id_tipo_documento",$data["id_tipo_documento"])->where("numero_documento",$data["numero_documento"])->first();
		//print_r($persona);
		
		if(isset($persona->id)){
		
			$id_persona = $persona->id;
			$data["id_persona"] = $id_persona;
			
			abort_unless(config('boilerplate.access.user.registration'), 404);

        	return $this->userService->registerUser($data);
		
		}else{
			
			//return redirect('register');
			throw new GeneralException(__('No se puede crear el usuario, no pertenece al colegio de arquitectos, ni al personal administrativos del colegio.'));
			//return route(homeRoute());
			
		}
		
		//print_r($data);
		//exit();
        
    }

    function registerProy(Request $request){

        ini_set('memory_limit', '4400M');
        
        if($request->id_profesion==1){
            $agremiado = Agremiado::where("numero_cap",$request->numero_cap)->first();
            $persona = Persona::find($agremiado->id_persona);
            $numero_documento_reg = $persona->numero_documento;
        }

        if($request->id_profesion==2){

            $buscapersona = Persona::where("numero_documento", $request->numero_documento)->where("estado", "1")->get();

			if ($buscapersona->count()==0){

				$persona = new Persona;
				$persona->id_tipo_documento = $request->id_tipo_documento;
				$persona->numero_documento = $request->numero_documento;
				$persona->apellido_paterno = $request->apellido_paterno;
				$persona->apellido_materno = $request->apellido_materno;
				$persona->nombres = $request->nombre;
				$persona->numero_celular = $request->celular;
				$persona->correo = $request->email;
				$persona->direccion = $request->direccion;
				$persona->id_usuario_inserta = 1;
				$persona->save();
                $id_persona = $persona->id;
                $numero_documento_reg = $persona->numero_documento;
			}else{
                $id_persona = $buscapersona[0]->id;
                $numero_documento_reg = $buscapersona[0]->numero_documento;
            }

            $profesionOtro = new ProfesionOtro;
            $profesionOtro->colegiatura = $request->colegiatura;
            $profesionOtro->colegiatura_abreviatura = "CIP";
            $profesionOtro->id_persona = $id_persona;
            $profesionOtro->id_profesion = $request->id_profesion;
            $profesionOtro->celular1 = $request->celular;
            $profesionOtro->celular2 = $request->telefono;
            $profesionOtro->email1 = $request->email;
            $profesionOtro->email2 = $request->email2;
            $profesionOtro->direccion = $request->direccion;
            $profesionOtro->codigo_secreto = $request->secret_code;
            $profesionOtro->estado = "1";
            $profesionOtro->id_usuario_inserta = 1;
            $profesionOtro->ruta_firma = NULL;
            $profesionOtro->id_solicitud = NULL;
            $profesionOtro->id_tipo_profesional = NULL;
            $profesionOtro->id_tipo_proyectista = 1;
            $profesionOtro->save();
        }

        $user = new User;
        $user->email = $request->email;
        $user->name = $request->nombre;
        $user->password = $request->password;
        $user->save();

        $proyectista = new RegistroProyectista;

        $numero_documento_reg = $request->numero_documento;

        $path = "img/proyectista";
        if (!is_dir($path)) {
            mkdir($path);
        }

        if (isset($_FILES["ruta_firma"]) && $_FILES["ruta_firma"]["error"] == UPLOAD_ERR_OK) {

            $path = "img/proyectista/".$numero_documento_reg;
            if (!is_dir($path)) {
                mkdir($path);
            }

            $filepath = public_path($path.'/');

            $filename = "firma_".date("YmdHis") . substr((string)microtime(), 1, 6);
            $type=$this->extension($_FILES["ruta_firma"]["name"]);
            $filenamefirma=$filename.".".$type;

            move_uploaded_file($_FILES["ruta_firma"]["tmp_name"], $filepath.$filenamefirma);

            $proyectista->ruta_firma = $path."/".$filenamefirma;
        }

        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == UPLOAD_ERR_OK) {

            $path = "img/proyectista/".$numero_documento_reg;
            if (!is_dir($path)) {
                mkdir($path);
            }

            $filepath = public_path($path.'/');

            $filename = "foto_".date("YmdHis") . substr((string)microtime(), 1, 6);
            $type=$this->extension($_FILES["foto"]["name"]);
            $filenamefoto=$filename.".".$type;

            move_uploaded_file($_FILES["foto"]["tmp_name"], $filepath.$filenamefoto);

            $proyectista->foto = $path."/".$filenamefoto;
        }
        
        if($request->id_profesion==1){
            $proyectista->id_agremiado = $agremiado->id;
            $proyectista->id_profesion_otro = NULL;
        }

        if($request->id_profesion==2){
            $proyectista->id_agremiado = NULL;
            $proyectista->id_profesion_otro = $profesionOtro->id;
        }

        $proyectista->id_profesion = $request->id_profesion;
        $proyectista->estado = "1";
        $proyectista->save();

        return redirect()->route('frontend.auth.login')->withFlashSuccess(__('Se registro correctamente.'));

    }

    function extension($filename){$file = explode(".",$filename); return strtolower(end($file));}

    function registerResp(Request $request){

        ini_set('memory_limit', '4400M');
        
        $numero_documento_reg = $request->numero_documento;

        $ruta_firma="";
        $foto="";

        $path = "img/responsable";
        if (!is_dir($path)) {
            mkdir($path);
        }

        if (isset($_FILES["ruta_firma"]) && $_FILES["ruta_firma"]["error"] == UPLOAD_ERR_OK) {

            $path = "img/responsable/".$numero_documento_reg;
            if (!is_dir($path)) {
                mkdir($path);
            }

            $filepath = public_path($path.'/');

            $filename = "firma_".date("YmdHis") . substr((string)microtime(), 1, 6);
            $type=$this->extension($_FILES["ruta_firma"]["name"]);
            $filenamefirma=$filename.".".$type;

            move_uploaded_file($_FILES["ruta_firma"]["tmp_name"], $filepath.$filenamefirma);

            $ruta_firma = $path."/".$filenamefirma;
        }

        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == UPLOAD_ERR_OK) {

            $path = "img/responsable/".$numero_documento_reg;
            if (!is_dir($path)) {
                mkdir($path);
            }

            $filepath = public_path($path.'/');

            $filename = "foto_".date("YmdHis") . substr((string)microtime(), 1, 6);
            $type=$this->extension($_FILES["foto"]["name"]);
            $filenamefoto=$filename.".".$type;

            move_uploaded_file($_FILES["foto"]["tmp_name"], $filepath.$filenamefoto);

            $foto = $path."/".$filenamefoto;
        }


        if($request->id_tipo_documento==2){
            $empresa = new Empresa;
            if($ruta_firma!="")$empresa->ruta_firma = $ruta_firma;
            //if($foto!="")$empresa->foto = $foto;
            $empresa->ruc = $request->numero_documento;
            $empresa->nombre_comercial = $request->nombre;
            $empresa->razon_social = $request->nombre;
            $empresa->telefono = $request->celular;
            $empresa->telefono_fijo = $request->telefono;
            $empresa->correo = $request->email;
            $empresa->correo2 = $request->email2;
            $empresa->direccion = $request->direccion;
            $empresa->id_usuario_inserta = 1;
            $empresa->save();
            $id_empresa = $empresa->id;
            $id_persona = NULL;
        }else{

            $persona = new Persona;
            if($ruta_firma!="")$persona->ruta_firma = $ruta_firma;
            if($foto!="")$persona->foto = $foto;
            $persona->id_tipo_documento = $request->id_tipo_documento;
            $persona->numero_documento = $request->numero_documento;
            $persona->apellido_paterno = $request->apellido_paterno;
            $persona->apellido_materno = $request->apellido_materno;
            $persona->nombres = $request->nombre;
            $persona->numero_celular = $request->celular;
            $persona->telefono_fijo = $request->telefono;
            $persona->correo = $request->email;
            $persona->correo2 = $request->email2;
            $persona->direccion = $request->direccion;
            $persona->id_usuario_inserta = 1;
            $persona->save();
            $id_persona = $persona->id;
            $id_empresa = NULL;
        }

        $personaResponsable = new PersonaResponsable;
        $personaResponsable->id_persona = $id_persona;
        $personaResponsable->id_empresa = $id_empresa;
        $personaResponsable->id_usuario_inserta = 1;
        $personaResponsable->save();

        $user = new User;
        $user->email = $request->email;
        $user->name = $request->nombre;
        $user->password = $request->password;
        $user->save();

        return redirect()->route('frontend.auth.login')->withFlashSuccess(__('Se registro correctamente.'));

    }


}
