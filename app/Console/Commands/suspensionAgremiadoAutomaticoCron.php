<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\SuspensionController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class suspensionAgremiadoAutomaticoCron extends Command
{
    
    protected $signature = 'suspensionAgremiadoAutomatico:cron';

    protected $description = 'Ejecuta la funcion actualizarSuspensionAgremiado';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\SuspensionController');
        app()->call([$controller, 'actualizarSuspensionAgremiado']);
		
		$log = ['metodo' => "suspensionAgremiadoAutomatico:cron", 'description' => "Ejecuta la funcion actualizarSuspensionAgremiado"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
	
}
