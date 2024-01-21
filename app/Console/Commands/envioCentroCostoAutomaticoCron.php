<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\CentroCostoController;

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
    }
}
