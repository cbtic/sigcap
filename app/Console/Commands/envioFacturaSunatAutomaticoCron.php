<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\FacturaController;

class envioFacturaSunatAutomaticoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'envioFacturaSunatAutomatico:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta la funcion envio_factura_sunat_automatico?exclusivo cada lunes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //\Log::info("Cron is working fine!");

        /*
           Write your database logic we bellow:
           Item::create(['name'=>'hello new']);
        */

        $hoy = Carbon::now()->format('Y-m-d');

        //app('\App\Http\Controllers\IngresoController::class')->estado_cuenta_automatico($hoy);
        $controller = app()->make('App\Http\Controllers\Frontend\ComprobanteController');
        app()->call([$controller, 'envio_factura_sunat_automatico'], [$hoy]);

        $this->info('SIGTP:Cron envioFacturaSunatAutomaticoCron Run successfully!');
    }
}
