<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\AgremiadoController;

class envioAgremiadoCuotaVitalicioAutomaticoCron extends Command
{
    protected $signature = 'envioAgremiadoCuotaVitalicioAutomatico:cron';

    protected $description = 'Ejecuta la funcion importar_agremiado_cuota_vitalicio';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\AgremiadoController');
        app()->call([$controller, 'importar_agremiado_cuota_vitalicio']);
    }
}
