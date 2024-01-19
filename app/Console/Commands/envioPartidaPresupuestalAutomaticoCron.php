<?php

namespace App\Console\Commands;

//use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Http\Controllers\Frontend\PartidaPresupuestalController;

class envioPartidaPresupuestalAutomaticoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'envioPartidaPresupuestalAutomatico:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta la funcion importar_partida_presupuestal';

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
        $controller = app()->make('App\Http\Controllers\Frontend\PartidaPresupuestalController');
        app()->call([$controller, 'importar_partida_presupuestal']);

        //$this->info('SIGCAP:Cron envioPartidaPresupuestalAutomaticoCron Run successfully!');
    }
}
