<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\IngresoController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class envioCajaAutomaticoCron extends Command
{
    protected $signature = 'envioCajaAutomatico:cron {--accion=}';

    protected $description = 'Ejecuta la funcion automatico_caja_ingreso';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $accion = $this->option('accion');
        $controller = app()->make('App\Http\Controllers\Frontend\IngresoController');
        app()->call([$controller, 'automatico_caja_ingreso'], ['accion' => $accion]);
		
		$log = ['metodo' => "envioCajaAutomatico:cron", 'description' => "Ejecuta la funcion automatico_caja_ingreso con accion={$accion}"];
		$logCajaIngreso = new Logger('job_log');
		$logCajaIngreso->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCajaIngreso->info('job_log', $log);
    }
}
