<?php

namespace App\Domains\Auth\Http\Controllers\Frontend\Auth;

use App\Domains\Auth\Services\UserService;
use App\Rules\Captcha;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\PasswordRules;
use App\Models\Persona;
use App\Models\TablaMaestra;
use App\Exceptions\GeneralException;
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

        return view('frontend.auth.registerProy',compact('tipo_documento'));
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
}
