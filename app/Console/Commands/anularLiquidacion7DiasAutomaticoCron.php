<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\DerechoRevisionController;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class anularLiquidacion7DiasAutomaticoCron extends Command
{
    
    protected $signature = 'anularLiquidacion7DiasAutomaticoCron:cron';

    protected $description = 'Ejecuta la funcion anularLiquidacion7Dias';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\DerechoRevisionController');
        app()->call([$controller, 'anularLiquidacion7Dias']);
		
		$log = ['metodo' => "anularLiquidacion7DiasAutomaticoCron:cron", 'description' => "Ejecuta la funcion anularLiquidacion7Dias"];
		$logCentroCosto = new Logger('job_log');
		$logCentroCosto->pushHandler(new StreamHandler(storage_path('logs/job_log.log')), Logger::INFO);
		$logCentroCosto->info('job_log', $log);
    }
	
}
