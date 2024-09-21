<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\AgremiadoController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class envioAgremiadoAutomaticoFraccionamientoCron extends Command
{
    protected $signature = 'envioAgremiadoAutomaticoFraccionamiento:cron';

    protected $description = 'Ejecuta la funcion agremiado_inhabilita_fraccionamiento';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\AgremiadoController');
        app()->call([$controller, 'agremiado_inhabilita_fraccionamiento']);
		
		$log = ['metodo' => "envioAgremiadoAutomaticoFraccionamiento:cron", 'description' => "Ejecuta la funcion agremiado_inhabilita_fraccionamiento"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
}
