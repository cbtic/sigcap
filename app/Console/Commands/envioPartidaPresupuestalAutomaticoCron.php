<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\PartidaPresupuestalController;

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
    }
}
