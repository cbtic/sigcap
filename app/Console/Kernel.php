<?php 

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        Commands\envioFacturaSunatAutomaticoCron::class,
		Commands\envioCentroCostoAutomaticoCron::class,
		Commands\envioPartidaPresupuestalAutomaticoCron::class,
        Commands\envioPlanContableAutomaticoCron::class,
		Commands\envioAgremiadoAutomaticoCron::class,
		Commands\envioAgremiadoCuotaAutomaticoCron::class,
		Commands\envioAgremiadoCuotaFechaAutomaticoCron::class,
		Commands\envioAgremiadoCuotaVitalicioAutomaticoCron::class,
        Commands\prontoPagoAutomaticoCron::class,
        Commands\periodoComisionAutomaticoCron::class,
		Commands\suspensionAgremiadoAutomaticoCron::class,
		Commands\envioAgremiadoAutomaticoFraccionamientoCron::class
    ];

    protected function schedule(Schedule $schedule)
    {
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
		$schedule->command('envioCentroCostoAutomatico:cron')->dailyAt('23:02');
		
		$schedule->command('envioPartidaPresupuestalAutomatico:cron')->dailyAt('08:00');
		$schedule->command('envioPartidaPresupuestalAutomatico:cron')->dailyAt('12:00');
		$schedule->command('envioPartidaPresupuestalAutomatico:cron')->dailyAt('16:00');
		$schedule->command('envioPartidaPresupuestalAutomatico:cron')->dailyAt('23:02');
		
		$schedule->command('envioPlanContableAutomatico:cron')->dailyAt('08:00');
		$schedule->command('envioPlanContableAutomatico:cron')->dailyAt('12:00');
		$schedule->command('envioPlanContableAutomatico:cron')->dailyAt('16:00');
		$schedule->command('envioPlanContableAutomatico:cron')->dailyAt('23:02');
		
		/************NUEVOS***************/
		
        //$schedule->command('envioAgremiadoAutomatico:cron')->dailyAt('16:50');
        //$schedule->command('envioAgremiadoAutomatico:cron')->dailyAt('16:57');
        $schedule->command('envioAgremiadoAutomatico:cron')->dailyAt('17:00');

        $schedule->command('envioAgremiadoAutomatico:cron')->dailyAt('12:01');
        //$schedule->command('envioAgremiadoCuotaAutomatico:cron')->dailyAt('22:32');
        $schedule->command('envioAgremiadoCuotaFechaAutomatico:cron')->dailyAt('23:50');
        
        $schedule->command('envioAgremiadoCuotaVitalicioAutomatico:cron')->dailyAt('01:00');

        $schedule->command('prontoPagoAutomatico:cron')->dailyAt('00:05');

        $schedule->command('periodoComisionAutomatico:cron')->dailyAt('00:07');
		
		$schedule->command('suspensionAgremiadoAutomatico:cron')->dailyAt('00:07');
		
		$schedule->command('envioAgremiadoAutomaticoFraccionamiento:cron')->dailyAt('22:55');

    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
