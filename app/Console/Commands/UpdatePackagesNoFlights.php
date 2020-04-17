<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\model\flight;
use App\model\flight_schedule;
use App\model\package;

class UpdatePackagesNoFlights extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ramitours:updateNoFlights';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'remove packages without flights';

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
        $packages = package::where([['package_type', 1], ['package_status', 1]])->get();
        foreach ($packages as $curr_pack) {
            $flights = unserialize($curr_pack->package_flight_sche);
            $num = 0;
            foreach ($flights as $flight) {
                $curr_flight = flight_schedule::find($flight);
                if (empty($curr_flight)) {
                  $num++;  
                }
            }
            if ($num > 0) {
                $count = sizeof($flights);
                // $this->info("Package " . $curr_pack->id . " has empty flight $num $count");
                if ($count == $num) {
                    // $this->info("will be deleted");
                    $curr_pack->delete();
                }
            }
        }
    }
}
