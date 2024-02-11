<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\AgremiadoController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class envioAgremiadoAutomaticoCron extends Command
{
    protected $signature = 'envioAgremiadoAutomatico:cron';

    protected $description = 'Ejecuta la funcion importar_agremiado';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\AgremiadoController');
        app()->call([$controller, 'importar_agremiado']);
		
		$log = ['metodo' => "envioAgremiadoAutomatico:cron", 'description' => "Ejecuta la funcion importar_agremiado"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
}
