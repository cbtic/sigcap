<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\PartidaPresupuestalController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class envioPartidaPresupuestalAutomaticoCron extends Command
{
    protected $signature = 'envioPartidaPresupuestalAutomatico:cron';

    protected $description = 'Ejecuta la funcion importar_partida_presupuestal';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\PartidaPresupuestalController');
        app()->call([$controller, 'importar_partida_presupuestal']);
		
		$log = ['metodo' => "envioPartidaPresupuestalAutomatico:cron", 'description' => "Ejecuta la funcion importar_partida_presupuestal"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
}
