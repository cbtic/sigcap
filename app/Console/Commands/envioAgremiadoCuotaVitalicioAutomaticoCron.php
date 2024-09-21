<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\AgremiadoController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class envioAgremiadoCuotaVitalicioAutomaticoCron extends Command
{
    protected $signature = 'envioAgremiadoCuotaVitalicioAutomatico:cron';

    protected $description = 'Ejecuta la funcion importar_agremiado_cuota_vitalicio';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\AgremiadoController');
        app()->call([$controller, 'importar_agremiado_cuota_vitalicio']);
		
		$log = ['metodo' => "envioAgremiadoCuotaVitalicioAutomatico:cron", 'description' => "Ejecuta la funcion importar_agremiado_cuota_vitalicio"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
}
