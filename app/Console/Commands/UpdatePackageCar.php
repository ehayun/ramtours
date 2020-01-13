<?php

namespace App\Console\Commands;

use App\Http\Controllers\automation\AutomationController;
use Illuminate\Console\Command;

use App\model\car;
use App\model\flight;
use App\model\flight_schedule;
use App\model\package;
use App\model\room;

use App\Http\Controllers\secure\CartController;

class UpdatePackageCar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ramitours:updateCarPackages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all packages cars - Run every 11 min';

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

        $c = new CartController;

        $packages = package::where([['package_type', 1], ['package_status', 1]])->get();
        foreach ($packages as $curr_pack) {
            $flights = unserialize($curr_pack->package_flight_sche);
            $s_cars = [];
            $idx = 0;
            foreach ($flights as $flight) {
                $curr_flight = flight_schedule::find($flight);
                if (empty($curr_flight)) {
                    continue;
                }
                $fl_up = $curr_flight->flight_up;
                $fl = flight::find($fl_up);
                $fl_loc = $fl->flight_desti;
                $cars = car::where('location',$fl_loc)->get();
                foreach($cars as $car) {
                    $s_cars[$idx] = $car->id;
                    $idx++;
                }
            }
            
            $curr_pack->package_car = serialize($s_cars);
            $curr_pack->save();
        }
    }
}
