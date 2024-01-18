<?php

namespace App\Console\Commands;

//use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\CentroCostoController;

class envioCentroCostoAutomaticoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'envioCentroCostoAutomatico:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta la funcion importar_centro_costo';

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
        //$hoy = Carbon::now()->format('Y-m-d');
        $controller = app()->make('App\Http\Controllers\Frontend\CentroCostoController');
        app()->call([$controller, 'importar_centro_costo']);

        //$this->info('SIGCAP:Cron envioCentroCostoAutomaticoCron Run successfully!');
    }
}
