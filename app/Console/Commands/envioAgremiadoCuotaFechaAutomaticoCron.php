<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\AgremiadoController;

class envioAgremiadoCuotaFechaAutomaticoCron extends Command
{
    protected $signature = 'envioAgremiadoCuotaFechaAutomatico:cron';

    protected $description = 'Ejecuta la funcion importar_agremiado_cuota_fecha';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $controller = app()->make('App\Http\Controllers\Frontend\AgremiadoController');
        app()->call([$controller, 'importar_agremiado_cuota_fecha']);
    }
}
