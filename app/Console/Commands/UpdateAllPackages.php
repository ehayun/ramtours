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

class UpdateAllPackages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ramitours:updatePackages {--package=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all packages cost - Run every 15 min';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function updateCars()
    {
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
                $cars = car::where('location', $fl_loc)->get();
                foreach ($cars as $car) {
                    $s_cars[$idx] = $car->id;
                    $idx++;
                }
            }

            $curr_pack->package_car = serialize($s_cars);
            $curr_pack->save();
        }
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pkg = $this->option('package');
        $c = new CartController;
        if (!$pkg) {
            $this->updateCars();
        }

        if (!$pkg) {
            $packages = package::where([['package_type', 1], ['package_status', 1]])->get();
        } else {
            $packages = package::where([['package_type', 1], ['package_status', 1], ['id', $pkg]])->get();
        }
        foreach ($packages as $curr_pack) {
            $res = [];
            $lowest = 1000000;
            $ss = [];
            // print "pkg: " . $curr_pack->id . " \n";
            // var_dump($curr_pack);
            // $this->setup_low_cost_for_package($package->id);
            $rooms = unserialize($curr_pack->package_hotel_room);
            $flights = unserialize($curr_pack->package_flight_sche);
            foreach ($flights as $flight) {
                $curr_flight = flight_schedule::find($flight);
                if (empty($curr_flight)) {
                    continue;
                }
                $fl_up = $curr_flight->flight_up;
                $fl = flight::find($fl_up);
                $fl_loc = $fl->flight_desti;
                $cars = unserialize($curr_pack->package_car);
                $rooms = unserialize($curr_pack->package_hotel_room);
                // var_dump($rooms);
                $first = true;
                $tmp = "";
                foreach ($cars as $car_id) {
                    $car = car::find($car_id);
                    if ($pkg) {
                        print "Car:: " . $car->id . "\n\n";
                    }
                    foreach ($rooms as $room) {
                        $r = room::find($room);
                        foreach ([2] as $adults) {
                            foreach ([0, 1, 2, 3, 4] as $childrens) {
                                if ($car->max_people >= $adults + $childrens) {
                                    if ($r->max_people >= $adults + $childrens) {
                                        if ($car->location == $fl_loc) {

                                            $h1 = $curr_pack->extra_hotel_1 ? $curr_pack->extra_hotel_1 : 0;
                                            $h2 = $curr_pack->extra_hotel_2 ? $curr_pack->extra_hotel_2 : 0;

                                            $mp = $car->max_people;

                                            $price = $c->offline_setup($curr_pack, $adults, $childrens, $curr_flight->id, $room, $car_id, $h1, $h2);
                                            $price_pp = $price / ($adults + $childrens);
                                            $tot = $adults + $childrens;

                                            $dt = $curr_pack->package_start_date;

                                            if ($pkg) {
                                                print "Car: " . $car->id . " " . $car->car_title . " [$mp]  [" . get_rami_car_price($car->id, $tot, $dt) . "]\n";
                                            }
                                            if ($pkg) {
                                                // print "$adults $childrens $room car: $car_id $price [[$lowest]] [[$price_pp]] [$mp] \n";
                                                // $res['adults'] = $adults;
                                                // $res['childrens'] = $childrens;
                                                // $res['car'] = $car_id;
                                                // $res['room'] = $r->id;
                                                // $res['flight'] = $curr_flight->id;
                                                // $res['price'] = $price;
                                                // $res['price_e'] = $price / 3.9;
                                                // $res['price_Per'] = $price / ($adults + $childrens);
                                                // print_r($res);
                                            }
                                            if ($lowest > $price_pp) {
                                                $tmp = session()->get('temp_cart');
                                                $res['adults'] = $adults;
                                                $res['childrens'] = $childrens;
                                                $res['car'] = $car_id;
                                                $res['room'] = $r->id;
                                                $res['flight'] = $curr_flight->id;
                                                $res['price'] = $price;
                                                $res['price_e'] = $price / 3.9;
                                                $res['price_Per'] = $price / ($adults + $childrens);
                                                $lowest = $price_pp;
                                                $ss = session()->get('temp_cart');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                // var_dump($tmp);
            }
            if ($pkg) {
                print $lowest . "\n";
                print_r($res);
            }
            $persons = $res['adults'] + $res['childrens'];
            $curr_pack->cheapest_room = $res['room'];
            $curr_pack->cheapest_car = $res['car'];
            $curr_pack->cheapest_flight_sche = $res['flight'];
            $curr_pack->total_price_in_euro = $res['price'];
            $curr_pack->package_lowest_price = $res['price'] / $persons;
            $curr_pack->total_persons_combinations = '2' . '&' . "$persons-2";
            $rooms = unserialize($curr_pack->package_hotel_room);
            if ($rooms == []) {
                $curr_pack->package_status = 0;
            }
            $curr_pack->save();
            // var_dump($ss);
        }
    }
}
