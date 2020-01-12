<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\model\flight_schedule;

use App\Mail\SendEmailAlert;
use Illuminate\Support\Facades\Mail;


class CheckAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ramitours:check_alerts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check flight alert and send email for that alert';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    function flight_schedule_alert($num)
    {
        $fld = "alert_date_$num";
        $msgFld = "alert_msg_$num";
        $flight_schedules = flight_schedule::where([[$fld, '=', date('Y-m-d')], ['num_available_seat', '>', 0]])->get();
        foreach ($flight_schedules as $flight_schedule) {
            $msg = $flight_schedule->$msgFld;
            $flight = $flight_schedule->flight_sche_title;
            //call mail function for mail alert 
            // $this->info($msg);
            Mail::send(new SendEmailAlert($flight, $msg));
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        for($i=1; $i<6; $i++) {
            $this->flight_schedule_alert($i);
        }
    }
}
