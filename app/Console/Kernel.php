<?php 

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\envioFacturaSunatAutomaticoCron::class,
		Commands\envioCentroCostoAutomaticoCron::class,
		Commands\envioPartidaPresupuestalAutomaticoCron::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('activitylog:clean')->daily();
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('07:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('08:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('09:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('10:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('11:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('12:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('13:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('14:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('15:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('17:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('19:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('21:00');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('23:00');
		$schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('23:50');
        $schedule->command('envioFacturaSunatAutomatico:cron')->dailyAt('23:59');
		
		$schedule->command('envioCentroCostoAutomatico:cron')->dailyAt('08:00');
		$schedule->command('envioCentroCostoAutomatico:cron')->dailyAt('12:00');
		$schedule->command('envioCentroCostoAutomatico:cron')->dailyAt('16:00');
		$schedule->command('envioCentroCostoAutomatico:cron')->dailyAt('22:32');
		
		$schedule->command('envioPartidaPresupuestalAutomatico:cron')->dailyAt('08:00');
		$schedule->command('envioPartidaPresupuestalAutomatico:cron')->dailyAt('12:00');
		$schedule->command('envioPartidaPresupuestalAutomatico:cron')->dailyAt('16:00');
		$schedule->command('envioPartidaPresupuestalAutomatico:cron')->dailyAt('22:32');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
