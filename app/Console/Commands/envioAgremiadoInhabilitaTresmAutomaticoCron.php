<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\AgremiadoController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class envioAgremiadoInhabilitaTresmAutomaticoCron extends Command
{
    protected $signature = 'envioAgremiadoInhabilitaTresmAutomatico:cron';

    protected $description = 'Ejecuta la funcion automatico_agremiado_inhabilita_tresm';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\AgremiadoController');
        app()->call([$controller, 'automatico_agremiado_inhabilita_tresm']);
		
		$log = ['metodo' => "envioAgremiadoInhabilitaTresmAutomatico:cron", 'description' => "Ejecuta la funcion automatico_agremiado_inhabilita_tresm"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
}
