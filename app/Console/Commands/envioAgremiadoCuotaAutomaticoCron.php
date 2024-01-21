<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\AgremiadoController;

class envioAgremiadoCuotaAutomaticoCron extends Command
{
    protected $signature = 'envioAgremiadoCuotaAutomatico:cron';

    protected $description = 'Ejecuta la funcion importar_agremiado_cuota';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\AgremiadoController');
        app()->call([$controller, 'importar_agremiado_cuota']);
    }
}
