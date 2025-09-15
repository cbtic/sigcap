<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\PeriodoComisionController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class periodoComisionAutomaticoCron extends Command
{
    
    protected $signature = 'periodoComisionAutomatico:cron';

    protected $description = 'Ejecuta la funcion actualizarEstadoPeriodoComision';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\PeriodoComisionController');
        app()->call([$controller, 'actualizarEstadoPeriodoComision']);
		
		$log = ['metodo' => "periodoComisionAutomatico:cron", 'description' => "Ejecuta la funcion actualizarEstadoPeriodoComision"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
}
