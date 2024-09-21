<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\PlanContableController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class envioPlanContableAutomaticoCron extends Command
{
    protected $signature = 'envioPlanContableAutomatico:cron';

    protected $description = 'Ejecuta la funcion importar_plan_contable';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\PlanContableController');
        app()->call([$controller, 'importar_plan_contable']);
		
		$log = ['metodo' => "envioPlanContableAutomatico:cron", 'description' => "Ejecuta la funcion importar_plan_contable"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
		
    }
}
