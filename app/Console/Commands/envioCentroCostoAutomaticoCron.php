<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\CentroCostoController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class envioCentroCostoAutomaticoCron extends Command
{
    protected $signature = 'envioCentroCostoAutomatico:cron';

    protected $description = 'Ejecuta la funcion importar_centro_costo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\CentroCostoController');
        app()->call([$controller, 'importar_centro_costo']);
		
		$log = ['metodo' => "envioCentroCostoAutomatico:cron", 'description' => "Ejecuta la funcion importar_centro_costo"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
		
    }
}
