<?php

namespace App\Http\Controllers\secure;

use App\Http\Controllers\Controller;
use App\model\car;
use App\model\flight_schedule;
use App\model\hotel;
use App\model\package;
use App\model\room;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function offline_setup($package, $adults, $childs, $flight, $room_id, $car_id,  $h1, $h2, $infants = 0, $cart_id = 0)
    {

        $this->setup_temp_cart($package, $adults, $childs, $infants, $cart_id);
        $cars[] = ['car_id' => $car_id, 'car_class_id' => 'A'];
        $rooms[] = ['room_id' => $room_id, 'room_class_id' => 1];
        $extra_hotel1_rooms[] = ['room_id' => $h1, 'room_class_id' => 1];
        $extra_hotel2_rooms[] = ['room_id' => $h2, 'room_class_id' => 1];
        // $flight = ;
        $card = 0;

        $car_response = $this->put_cars_in_temp_cart($cars, $adults, $childs, $infants, $package->package_start_date);

        $room_response = $this->put_rooms_in_temp_cart($rooms, $adults, $childs, $package->package_start_date, $package->id, 0, true);
        if ($package->having_extra_hotel_1 == 1) {
            $extra_hotel1_room_response = $this->put_rooms_in_temp_cart($extra_hotel1_rooms, $adults, $childs, $package->extra_hotel_1_start_date, $package->id, 1, true);
        } else {
            $extra_hotel1_room_response = array();
        }
        if ($package->having_extra_hotel_2 == 1) {
            $extra_hotel2_room_response = $this->put_rooms_in_temp_cart($extra_hotel2_rooms, $adults, $childs, $package->extra_hotel_2_start_date, $package->id, 2, true);
        } else {
            $extra_hotel2_room_response = array();
        }
        $flight_response = $this->put_flights_in_temp_cart($flight, $adults, $childs, true);
        $card = $this->put_card_in_temp_cart($package, $adults, $childs, $card);
        $total = $this->put_profit_total_in_temp_cart($package);
        if ($flight_response > 0) {
            $total = 100000;
        }

        return $total;
    }

    public function setup_cart(Request $request)
    {
        if ($request->package_type < 4) {
            $package = package::where([['package_status', 1], ['id', $request->package_id]])->first();
            if (empty($package)) {
                return response()->json(array('msg' => 'Something Went Wrong', 'status' => 'fail'), 200);
            }
            if (empty($package->package_type != $request->package_type) && ($request->package_type > 4)) {
                return response()->json(array('msg' => 'Something Went Wrong', 'status' => 'fail'), 200);
            }
            if ($request->package_type == 1) {
                $this->setup_temp_cart($package, $request->adults, $request->childs, $request->infants, $request->cart_id);
                $car_response = $this->put_cars_in_temp_cart($request->cars, $request->adults, $request->childs, $request->infants, $package->package_start_date);
                $room_response = $this->put_rooms_in_temp_cart($request->rooms, $request->adults, $request->childs, $package->package_start_date, $package->id, 0);
                if ($package->having_extra_hotel_1 == 1) {
                    $extra_hotel1_room_response = $this->put_rooms_in_temp_cart($request->extra_hotel1_rooms, $request->adults, $request->childs, $package->extra_hotel_1_start_date, $package->id, 1);
                } else {
                    $extra_hotel1_room_response = array();
                }
                if ($package->having_extra_hotel_2 == 1) {
                    $extra_hotel2_room_response = $this->put_rooms_in_temp_cart($request->extra_hotel2_rooms, $request->adults, $request->childs, $package->extra_hotel_2_start_date, $package->id, 2);
                } else {
                    $extra_hotel2_room_response = array();
                }
                $flight_response = $this->put_flights_in_temp_cart($request->flight, $request->adults, $request->childs);
                $card = $this->put_card_in_temp_cart($package, $request->adults, $request->childs, $request->card);
                $total = $this->put_profit_total_in_temp_cart($package);

                return response()->json(array('msg' => 'item added to cart', 'status' => 'success', 'error_room' => $room_response, 'extra_hotel1_room_error' =>                    $extra_hotel1_room_response, 'extra_hotel2_room_error' =>                    $extra_hotel2_room_response, 'error_fligts' => $flight_response, 'total_euro' => $total), 200);
            }
            // if ($request->package_type == 3) {
            //     $this->setup_temp_cart($package, $request->adults, $request->childs, $request->cart_id);
            //     $car_response = $this->put_cars_in_temp_cart($request->cars, $request->adults, $request->childs, $package->package_start_date);
            //     $flight_response = $this->put_flights_in_temp_cart($request->flight, $request->adults, $request->childs);
            //     $total = $this->put_profit_total_in_temp_cart($package);
            //     return response()->json(array('msg' => 'item added to cart', 'status' => 'success', 'error_fligts' => $flight_response, 'total_euro' => $total), 200);
            // }

        } elseif ($request->package_type = 5) {
            $this->setup_temp_cart('', $request->adults, $request->childs, $request->infants, $request->cart_id);
            $flight_response = $this->put_only_flights_in_temp_cart($request->flight, $request->adults, $request->childs);
            $total = $this->put_profit_total_in_temp_cart('');
            return response()->json(array('msg' => 'item added to cart', 'status' => 'success', 'error_fligts' => $flight_response, 'total_usd' => $total), 200);
        } else {
            return response()->json(array('msg' => 'some thing wrong', 'status' => 'error'), 200);
        }
    }
    public function put_card_in_temp_cart($package, $adults, $childs, $card)
    {
        // if(($card==1)&&(!empty($package->hotel->card))){
        //     $total_person=$adults+$childs;
        //     $pack_card['card_price_in_skl_per_family']=get_rami_price_conversion_to_shekel($package->hotel->card->price, $package->hotel->card->price_currency);
        //     $pack_card['card_max_people']=$package->hotel->card->max_people;
        //     if($pack_card['card_max_people']<$total_person){
        //         $card_unit=$total_person/$pack_card['card_max_people'];
        //         $card_unit=get_rami_round_num($card_unit);
        //     }else{
        //         $card_unit=1;
        //     }
        //     $pack_card['card_unit']=$card_unit;
        //     $card_total_price=$pack_card['pack_card_total_price']=$card_unit*$pack_card['card_price_in_skl_per_family'];
        // }
        if ($card == 1) {
            $pack_card = [];
            $card_total_price = get_rami_price_conversion_to_shekel(265, 2);
        } else {
            $pack_card = [];
            $card_total_price = 0;
        }
        $prv_temp_cart = session()->get('temp_cart');
        $prv_temp_cart['pack_card'] = $pack_card;
        $prv_temp_cart['pack_card_total_price'] = $card_total_price;
        session()->put('temp_cart', $prv_temp_cart);
    }
    public function put_cars_in_temp_cart($cars, $adults, $childs, $infants, $date)
    {
        $total_peoples = $adults + $childs + $infants;
        $car_booked_for = 0;
        $car_price = 0;
        $all_cars = array();
        foreach ($cars as $car) {
            if (empty($car)) {
                continue;
            } elseif (empty($car['car_id'])) {
                continue;
            }
            $current_car = car::find($car['car_id']);
            if (!empty($current_car)) {
                $remaining_person = $total_peoples - $car_booked_for;
                $max_people = $current_car->max_people;
                $car_profit = 0;
                $all_cars[$car['car_class_id']] = array(
                    'car_id' => $current_car->id,
                    'title' => $current_car->car_title,
                );
                if ($remaining_person == 0) {
                    $price = get_rami_car_price($current_car->id, $max_people, $date);
                    $all_cars[$car['car_class_id']]['price'] = $price;
                    $car_price += $price;
                } elseif ($max_people <= $remaining_person) {
                    $price = get_rami_car_price($current_car->id, $max_people, $date);
                    $all_cars[$car['car_class_id']]['price'] = $price;
                    $car_price += $price;
                    $car_booked_for += $max_people;
                } else {
                    $price = get_rami_car_price($current_car->id, $remaining_person, $date);
                    $all_cars[$car['car_class_id']]['price'] = $price;
                    $car_price += $price;
                    $car_booked_for += $remaining_person;
                }
            }
        }
        $prv_temp_cart = session()->get('temp_cart');
        $prv_temp_cart['cars'] = $all_cars;
        $prv_temp_cart['car_booked_for'] = $car_booked_for;
        $prv_temp_cart['car_per_day_price_in_skl'] = $car_price;
        session()->put('temp_cart', $prv_temp_cart);
    }
    public function put_rooms_in_temp_cart($rooms, $adults, $childs, $date, $pakage_id, $room_hotel_extra = 0, $check_room = true)
    {
        $total_peoples = $adults + $childs;
        $room_booked_for = 0;
        $room_price = 0;
        $all_rooms = array();
        $remove_room = array();
        $no_of_room_require = array();
        foreach ($rooms as $room) {
            if (empty($room)) {
                continue;
            } elseif (empty($room['room_id'])) {
                continue;
            }
            $current_room = room::find($room['room_id']);
            if (!empty($current_room)) {
                if (!empty($no_of_room_require[$room['room_id']])) {
                    $no_of_room_require[$room['room_id']] = ++$no_of_room_require[$room['room_id']];
                } else {
                    $no_of_room_require[$room['room_id']] = 1;
                }
                $var_new = $no_of_room_require[$room['room_id']];
                $total_room_avalible = get_rami_package_room_avalible($pakage_id, $current_room->id);
                if ($check_room) {
                    if ($var_new > $total_room_avalible) {
                        $remove_room[] = $room['room_class_id'];
                        continue;
                    }
                }
                $remaining_person = $total_peoples - $room_booked_for;
                $max_people = $current_room->max_people;
                $all_rooms[$room['room_class_id']] = array(
                    'room_id' => $current_room->id,
                    'title' => $current_room->room_title,
                );
                if ($remaining_person == 0) {
                    $price = get_rami_room_price($current_room->id, $max_people, $date);
                    $all_rooms[$room['room_class_id']]['price'] = $price;
                    $room_price += $price;
                } elseif ($max_people <= $remaining_person) {
                    $price = get_rami_room_price($current_room->id, $max_people, $date);
                    $all_rooms[$room['room_class_id']]['price'] = $price;
                    $room_price += $price;
                    $room_booked_for += $max_people;
                } else {
                    $price = get_rami_room_price($current_room->id, $remaining_person, $date);
                    $all_rooms[$room['room_class_id']]['price'] = $price;
                    $room_price += $price;
                    $room_booked_for += $remaining_person;
                }
            }
        }
        $prv_temp_cart = session()->get('temp_cart');
        if ($room_hotel_extra == 0) {
            $prv_temp_cart['rooms'] = $all_rooms;
            $prv_temp_cart['room_booked_for'] = $room_booked_for;
            $prv_temp_cart['room_per_day_price_in_skl'] = $room_price;
        } else {
            $prv_temp_cart['extra_hotel_' . $room_hotel_extra . '_rooms'] = $all_rooms;
            $prv_temp_cart['extra_hotel_' . $room_hotel_extra . '_room_booked_for'] = $room_booked_for;
            $prv_temp_cart['extra_hotel_' . $room_hotel_extra . '_room_per_day_price_in_skl'] = $room_price;
        }

        session()->put('temp_cart', $prv_temp_cart);
        return $remove_room;
    }
    public function put_flights_in_temp_cart($flight, $adults, $childs, $check_flight = true)
    {
        $total_peoples = $adults + $childs;
        $flight_id = 0;
        $error_flight = 0;
        $flight_sch_booked_for = 0;
        $fligt_price = 0;
        $flight_profit = 0;
        $flight_sch = flight_schedule::find($flight);
        $flight_package_profit = 0;
        if (!empty($flight_sch)) {
            if ($check_flight) {
                $f_price = get_rami_flight_price($flight_sch->id);
                $flight_package_profit = $flight_sch->package_profit;
                $flight_profit = $flight_sch->flight_profit;


                if ($flight_sch->num_available_seat >= $total_peoples) {
                    $flight_id = $flight_sch->id;
                    $flight_sch_booked_for = $total_peoples;
                    /* Eli Hayun */
                    $flight_package_profit = $flight_sch->package_profit;
                    /* === */
                    $fligt_price = $total_peoples * get_rami_flight_price($flight_sch->id) ;
                } else {
                    $error_flight = $flight_sch->id;
                }
            } else {
                $flight_id = $flight_sch->id;
                $flight_sch_booked_for = $total_peoples;
                /* Eli Hayun */
                $flight_package_profit = $flight_sch->package_profit;
                /* === */
                $fligt_price = $total_peoples * get_rami_flight_price($flight_sch->id) ;
            }
        }
        $prv_temp_cart = session()->get('temp_cart');
        $prv_temp_cart['flight_profit'] = $flight_profit;
        $prv_temp_cart['flight_sch'] = $flight_id;
        $prv_temp_cart['filght_total_price_in_skl'] = $fligt_price;
        $prv_temp_cart['flight_sch_booked_for'] = $flight_sch_booked_for;

        // +++ EH 5-Dec-2019
        $prv_temp_cart['flight_for_package'] = $flight_package_profit;

        session()->put('temp_cart', $prv_temp_cart);
        return $error_flight;
    }
    public function put_only_flights_in_temp_cart($flight, $adults, $childs)
    {
        $total_peoples = $adults + $childs;
        $flight_id = 0;
        $error_flight = 0;
        $flight_sch_booked_for = 0;
        $fligt_price = 0;
        $flight_package_profit = 0;
        $flight_sch = flight_schedule::find($flight);
        if (!empty($flight_sch)) {
            if ($flight_sch->num_available_seat >= $total_peoples) {
                $flight_id = $flight_sch->id;
                /* Eli Hayun */
                $flight_package_profit = $flight_sch->package_profit;
                /* === */
                $flight_sch_booked_for = $total_peoples;
                $fligt_price = $total_peoples * get_rami_flight_price_for_single_flight($flight_sch->id);
            } else {
                $error_flight = $flight_sch->id;
            }
        }
        $prv_temp_cart = session()->get('temp_cart');
        $prv_temp_cart['flight_sch'] = $flight_id;
        $prv_temp_cart['filght_total_price_in_skl'] = get_rami_round_num(get_rami_price_conversion_to_shekel($fligt_price, 1));
        $prv_temp_cart['flight_sch_booked_for'] = $flight_sch_booked_for;
        // +++ EH 5-Dec-2019
        $prv_temp_cart['flight_for_package'] = $flight_package_profit;

        session()->put('temp_cart', $prv_temp_cart);
        return $error_flight;
    }
    public function put_profit_total_in_temp_cart($package)
    {
        //car calulted for extra one day as per calculation.
        $prv_temp_cart = session()->get('temp_cart');
        //dd($prv_temp_cart);
        if (empty($package)) {
            $total = $prv_temp_cart['filght_total_price_in_skl'];
            $per_infants_taxes = get_rami_price_conversion_to_shekel(150, 1);
            $prv_temp_cart['per_infants_taxes'] = $per_infants_taxes;
            $infants_taxes_total = $per_infants_taxes * $prv_temp_cart['infants'];
            $total += $infants_taxes_total;
            $prv_temp_cart['total_price_in_skl'] = get_rami_round_num($total);
            $prv_temp_cart['per_person_in_skl'] = $total / $prv_temp_cart['total_peoples'];
            $prv_temp_cart['total_price_in_euro'] = get_rami_round_num(get_rami_price_conversion_shekel_to_other($total, 2));
            $prv_temp_cart['total_price_in_usd'] = get_rami_round_num(get_rami_price_conversion_shekel_to_other($total, 1));
            session()->put('temp_cart', $prv_temp_cart);
            return $prv_temp_cart['total_price_in_usd'];
        }
        $hotel_infants_price_per_day = 0;
        $hotel_details = hotel::find($package->package_hotel);
        if (!empty($hotel_details)) {
            if (!empty($hotel_details->infant_price)) {
                $hotel_infants_price_per_day = get_rami_price_conversion_to_shekel($hotel_details->infant_price, $hotel_details->infant_price_currency);
            }
        }
        $extra_hotel_1_infants_price_per_day = 0;
        if ($package->having_extra_hotel_1 == 1) {
            $hotel_details = hotel::find($package->extra_hotel_1);
            if (!empty($hotel_details)) {
                if (!empty($hotel_details->infant_price)) {
                    $extra_hotel_1_infants_price_per_day = get_rami_price_conversion_to_shekel($hotel_details->infant_price, $hotel_details->infant_price_currency);
                }
            }
        }
        $extra_hotel_2_infants_price_per_day = 0;
        if ($package->having_extra_hotel_2 == 1) {
            $hotel_details = hotel::find($package->extra_hotel_2);
            if (!empty($hotel_details)) {
                if (!empty($hotel_details->infant_price)) {
                    $extra_hotel_2_infants_price_per_day = get_rami_price_conversion_to_shekel($hotel_details->infant_price, $hotel_details->infant_price_currency);
                }
            }
        }
        //per_adults_extra charge 30EURO per day after 2 adults
        $per_adults_extra_charge = get_rami_price_conversion_to_shekel(30, 2) * $prv_temp_cart['no_of_days'];
        $prv_temp_cart['per_adults_extra_charge'] = $per_adults_extra_charge;
        $adults_total_extra_charge = $per_adults_extra_charge * ($prv_temp_cart['adults'] - 2);
        $prv_temp_cart['adults_total_extra_charge'] = $adults_total_extra_charge;
        // per_infants_taxes 150usd
        $per_infants_taxes = get_rami_price_conversion_to_shekel(150, 1);
        $prv_temp_cart['per_infants_taxes'] = $per_infants_taxes;
        $infants_taxes_total = $per_infants_taxes * $prv_temp_cart['infants'];
        //we 
        $prv_temp_cart['hotel_infants_price_per_day'] = $prv_temp_cart['infants'] * $hotel_infants_price_per_day;
        $prv_temp_cart['extra_hotel_1_infants_price_per_day'] = $prv_temp_cart['infants'] * $extra_hotel_1_infants_price_per_day;
        $prv_temp_cart['extra_hotel_2_infants_price_per_day'] = $prv_temp_cart['infants'] * $extra_hotel_2_infants_price_per_day;

        $no_of_days = $prv_temp_cart['no_of_days'];
        $main_hotel_days = $prv_temp_cart['no_of_days'] - $prv_temp_cart['extra_hotel_1_days'] - $prv_temp_cart['extra_hotel_2_days'];
        $extra_hotel1_days = $prv_temp_cart['extra_hotel_1_days'];
        $extra_hotel2_days = $prv_temp_cart['extra_hotel_2_days'];
        $car_total_price = $prv_temp_cart['car_per_day_price_in_skl'] * ($no_of_days + 1);

        $room_total_price = $prv_temp_cart['room_per_day_price_in_skl'] * $main_hotel_days;
        $hotel_infants_price_total = $prv_temp_cart['hotel_infants_price_per_day'] * $main_hotel_days;

        $extra_hotel_1_room_total_price = $prv_temp_cart['extra_hotel_1_room_per_day_price_in_skl'] * $extra_hotel1_days;
        $extra_hotel_1_infants_price_total = $prv_temp_cart['extra_hotel_1_infants_price_per_day'] * $extra_hotel1_days;

        $extra_hotel_2_room_total_price = $prv_temp_cart['extra_hotel_2_room_per_day_price_in_skl'] * $extra_hotel2_days;
        $extra_hotel_2_infants_price_total = $prv_temp_cart['extra_hotel_2_infants_price_per_day'] * $extra_hotel2_days;

        /*
        We have to calculate the package profit according to flight package profit if exist
        ================================================================= --- Added by Eli Hayun 5-Dec-2019
         */
        $is_fix_package = $package->is_fix_profit == 1;

        $flight_package_profit = $prv_temp_cart['flight_for_package'];
        $flight_profit = $prv_temp_cart['flight_profit'];

        $total = $car_total_price + $room_total_price + $extra_hotel_1_room_total_price 
        + $extra_hotel_2_room_total_price + $prv_temp_cart['filght_total_price_in_skl'] 
        + $hotel_infants_price_total + $extra_hotel_1_infants_price_total + $extra_hotel_2_infants_price_total 
        + $infants_taxes_total + $adults_total_extra_charge + $prv_temp_cart['pack_card_total_price'];

        $package_profit_per_person = get_rami_pakage_profit($package->id, $total);

        if (!$is_fix_package) {
            if ($flight_package_profit != 0) {
                $package_profit_per_person = $flight_package_profit;
            } else {
                $package_profit_per_person = $flight_profit;
            }
        }

        /*
        if (!$is_fix_package) {
        if ($flight_package_profit > 0) {
        if ($package_profit_per_person > $flight_package_profit) {
        $package_profit_per_person = $flight_package_profit;
        }
        }
        }
         */
        $package_profit = ($prv_temp_cart['adults'] + $prv_temp_cart['childs']) * $package_profit_per_person;

        /*
        ================================ Up to here
         */
        $total += $package_profit;
        $total = get_rami_round_num($total);

        $prv_temp_cart['car_total_price_in_skl'] = $car_total_price;
        $prv_temp_cart['room_total_price_in_skl'] = $room_total_price;
        $prv_temp_cart['extra_hotel_1_room_total_price_in_skl'] = $extra_hotel_1_room_total_price;
        $prv_temp_cart['extra_hotel_2_room_total_price_in_skl'] = $extra_hotel_2_room_total_price;
        $prv_temp_cart['profit_in_skl'] = $package_profit;
        $prv_temp_cart['profit_per_person_in_skl'] = $package_profit_per_person;
        $prv_temp_cart['total_price_in_skl'] = get_rami_round_num($total);
        $prv_temp_cart['per_person_in_skl'] = $total / $prv_temp_cart['total_peoples'];
        $prv_temp_cart['total_price_in_euro'] = get_rami_round_num(get_rami_price_conversion_shekel_to_other($total, 2));
        $prv_temp_cart['total_price_in_usd'] = get_rami_round_num(get_rami_price_conversion_shekel_to_other($total, 1));
        session()->put('temp_cart', $prv_temp_cart);/*
            
            dd(session()->get('temp_cart'));*/
        return $prv_temp_cart['total_price_in_euro'];
    }
    public function setup_temp_cart($package, $adults, $childs, $infants, $cart_id)
    {
        if (empty($package)) {
            $temp_cart = array(
                'cart_id' => $cart_id,
                'pakage_components' => get_package_type(4),
                'package_type' => 5,
                'adults' => $adults,
                'childs' => $childs,
                'infants' => $infants,
                'total_peoples' => $adults + $childs,
                'total_peoples_for_car' => $adults + $childs + $infants,
                'flight_sch_booked_for' => 0,
                'total_price_in_skl' => 0,
                'total_price_in_euro' => 0,
                'total_price_in_usd' => 0,
                'filght_total_price_in_skl' => 0,
                'per_person_in_skl' => 0,
                'flight_sch' => 0,
            );
        } else {
            $temp_cart = array(
                'package_id' => $package->id,
                'cart_id' => $cart_id,
                'start_date' => $package->package_start_date,
                'end_date' => $package->package_end_date,
                'no_of_days' => rami_get_no_of_days_diff($package->package_start_date, $package->package_end_date),
                'pakage_components' => get_package_type($package->package_type),
                'package_type' => $package->package_type,
                'adults' => $adults,
                'childs' => $childs,
                'infants' => $infants,
                'total_peoples' => $adults + $childs,
                'total_peoples_for_car' => $adults + $childs + $infants,
                'room_booked_for' => 0,
                'car_booked_for' => 0,
                'flight_sch_booked_for' => 0,
                'total_price_in_skl' => 0,
                'having_extra_hotel_1' => 0,
                'having_extra_hotel_2' => 0,
                'extra_hotel_1_days' => 0,
                'extra_hotel_2_days' => 0,
                'extra_hotel_1_room_total_price_in_skl' => 0,
                'extra_hotel_2_room_total_price_in_skl' => 0,
                'extra_hotel_1_room_per_day_price_in_skl' => 0,
                'extra_hotel_2_room_per_day_price_in_skl' => 0,
                'extra_hotel_1_room_booked_for' => 0,
                'extra_hotel_2_room_booked_for' => 0,
                'room_booked_for' => 0,
                'total_price_in_euro' => 0,
                'total_price_in_usd' => 0,
                'car_total_price_in_skl' => 0,
                'car_per_day_price_in_skl' => 0,
                'room_total_price_in_skl' => 0,
                'room_per_day_price_in_skl' => 0,
                'filght_total_price_in_skl' => 0,
                'profit_in_skl' => 0,
                'per_person_in_skl' => 0,
                'flight_sch' => 0,
                'rooms' => array(),
                'extra_hotel_1_rooms' => array(),
                'extra_hotel_2_rooms' => array(),
                'cars' => array(),
            );
            if ($package->having_extra_hotel_1 == 1) {
                $temp_cart['having_extra_hotel_1'] = 1;
                $temp_cart['extra_hotel_1_days'] = rami_get_no_of_days_diff($package->extra_hotel_1_start_date, $package->extra_hotel_1_end_date);
            }
            if ($package->having_extra_hotel_2 == 1) {
                $temp_cart['having_extra_hotel_2'] = 1;
                $temp_cart['extra_hotel_2_days'] = rami_get_no_of_days_diff($package->extra_hotel_2_start_date, $package->extra_hotel_2_end_date);
            }
        }
        session()->put('temp_cart', $temp_cart);
        //dd(session()->get('temp_cart'));
        return true;
    }
    public function verify_cart(Request $request)
    {
        $car_error = 0;
        $flight_error = 0;
        $room_error = 0;
        $extra_hotel_1_room_error = 0;
        $extra_hotel_2_room_error = 0;
        $temp_cart = session()->get('temp_cart');
        if (empty($temp_cart)) {
            //return response()->json(array('msg' => 'Cart Is empty', 'status' => 'fail', 'car_error' => $car_error, 'room_error' => $room_error, 'flight_error' => $flight_error), 200);
            $car_error = 1;
            $flight_error = 1;
            $room_error = 1;
            return response()->json(array('msg' => 'עגלת הקניות ריקה  ', 'status' => 'fail', 'car_error' => $car_error, 'room_error' => $room_error, 'flight_error' => $flight_error), 200);
        }
        if ($temp_cart['cart_id'] != $request->cart_id) {
            session()->forget('temp_cart');
            //return response()->json(array('msg' => 'Cart Is empty', 'status' => 'fail', 'car_error' => $car_error, 'room_error' => $room_error, 'flight_error' => $flight_error), 200);
            return response()->json(array('msg' => 'עגלת הקניות ריקה  ', 'status' => 'fail', 'car_error' => $car_error, 'room_error' => $room_error, 'flight_error' => $flight_error), 200);
        }
        if ($temp_cart['package_type'] == 1) {

            if ($temp_cart['total_peoples_for_car'] > $temp_cart['car_booked_for']) {
                $car_error = 1;
            }
            if ($temp_cart['total_peoples'] > $temp_cart['room_booked_for']) {
                $room_error = 1;
            }
            if ($temp_cart['total_peoples'] > $temp_cart['flight_sch_booked_for']) {
                $flight_error = 1;
            }
            if (($temp_cart['total_peoples'] > $temp_cart['extra_hotel_1_room_booked_for']) && ($temp_cart['having_extra_hotel_1'] == 1)) {
                $extra_hotel_1_room_error = 1;
            }
            if (($temp_cart['total_peoples'] > $temp_cart['extra_hotel_2_room_booked_for']) && ($temp_cart['having_extra_hotel_2'] == 1)) {
                $extra_hotel_2_room_error = 1;
            }
            if (($car_error == 1) || ($room_error == 1) || ($flight_error == 1) || ($extra_hotel_1_room_error == 1) || ($extra_hotel_2_room_error == 1)) {
                return response()->json(array('msg' => '', 'status' => 'fail', 'car_error' => $car_error, 'room_error' => $room_error, 'flight_error' => $flight_error, 'extra_hotel_1_room_error' => $extra_hotel_1_room_error, 'extra_hotel_2_room_error' => $extra_hotel_2_room_error), 200);
            } else {
                session()->put('rami_pack_cart', $temp_cart);
                //dd(session('rami_pack_cart'));
                session()->forget('temp_cart');
                return response()->json(array('msg' => 'item added to cart', 'status' => 'success', 'url' => '/order-passengers'), 200);
            }
        }
        if ($temp_cart['package_type'] == 3) {
            if ($temp_cart['total_peoples'] > $temp_cart['car_booked_for']) {
                $car_error = 1;
            }
            if ($temp_cart['total_peoples'] > $temp_cart['flight_sch_booked_for']) {
                $flight_error = 1;
            }
            if (($car_error == 1) || ($room_error == 1) || ($flight_error == 1)) {
                return response()->json(array('msg' => '', 'status' => 'fail', 'car_error' => $car_error, 'flight_error' => $flight_error), 200);
            } else {

                session()->put('rami_pack_cart', $temp_cart);
                session()->forget('temp_cart');
                return response()->json(array('msg' => 'item added to cart', 'status' => 'success', 'url' => '/order-passengers'), 200);
            }
        }
        if ($temp_cart['package_type'] == 5) {
            if ($temp_cart['total_peoples'] > $temp_cart['flight_sch_booked_for']) {
                $flight_error = 1;
            }
            if (($car_error == 1) || ($room_error == 1) || ($flight_error == 1)) {
                return response()->json(array('msg' => '', 'status' => 'fail', 'car_error' => $car_error, 'flight_error' => $flight_error), 200);
            } else {

                session()->put('rami_pack_cart', $temp_cart);
                session()->forget('temp_cart');
                return response()->json(array('msg' => 'item added to cart', 'status' => 'success', 'url' => '/order-passengers'), 200);
            }
        }
    }
}
