<?php

namespace App\Http\Controllers\mobile;

use App\Http\Controllers\Controller;
use App\Mail\ContactUs;
use App\model\attraction;
use App\model\car;
use App\model\card;
use App\model\flight;
use App\model\flight_schedule;
use App\model\flight_schedule_connection;
use App\model\hotel;
use App\model\hotel_image;
use App\model\hotel_review;
use App\model\Location;
use App\model\location_page_content;
use App\model\package;
use App\model\room;
use App\model\testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MobileHomeController extends Controller
{
    public function __construct()
    {
        //rami_checking_mobile_destop_redirection();

    }
    public function home()
    {
        $data['site_title'] = get_rami_setting('homepage_title_text');
        $data['header_custom_code'] = get_rami_setting('homepage_header_custom_code');
        $data['footer_custom_code'] = get_rami_setting('homepage_footer_custom_code');
        $data['search'] = 1;
        $data['packages'] = package::where([['package_type', 1], ['package_status', 1], ['is_hot_deal', 1], ['package_start_date', '>=', date('Y-m-d')]]) /* ->orderBy('package_start_date', 'ASC')*/->orderBy('package_lowest_price', 'asc')->skip(0)->take(40)->get();
        $total_element = package::where([['package_type', 1], ['package_status', 1], ['is_hot_deal', 1], ['package_start_date', '>=', date('Y-m-d')]]) /* ->orderBy('package_start_date', 'ASC')*/->orderBy('package_lowest_price', 'asc')->get()->count();
        if ($total_element > $data['packages']->count()) {
            $data['show_load_more'] = 1;
        } else {
            $data['show_load_more'] = 0;
        }
        $data['fhcs'] = get_location_fhc();
        $data['fcs'] = get_location_fc();
        $data['flights_src'] = get_location_flight_src();
        $data['flights_desti'] = get_location_flight_desti();
        $data['accs'] = get_location_accomodation();
        $data['site_title'] = get_rami_setting('homepage_title_text');
        $data['header_custom_code'] = get_rami_setting('homepage_header_custom_code');
        $data['footer_custom_code'] = get_rami_setting('homepage_footer_custom_code');
        return view('mobile.pages.home', $data);
    }
    public function package_detail($id)
    {
        $package = package::find($id);
        if (empty($package)) {
            return redirect('/');
        }
        $data['site_title'] = $package->pkg_title_text;
        $data['header_custom_code'] = $package->header_custom_code;
        $data['footer_custom_code'] = $package->footer_custom_code;
        $data['package'] = $package;
        $data['hotel'] = $package->hotel;

        if (empty($package->hotel)) {
            return redirect('/');
        }
        $rooms = unserialize($package->package_hotel_room);
        if (empty($rooms)) {
            return redirect('/');
        }
        $count = 1;
        $hotel_card = array();
        if (!empty($package->hotel->hotel_card)) {
            $card = card::find($package->hotel->hotel_card);
            if (!empty($card)) {
                $hotel_card['title'] = $card->card_title;
                $hotel_card['price'] = get_rami_price_conversion_shekel_to_other(get_rami_price_conversion_to_shekel($card->price, $card->price_currency), 1);
                $hotel_card['link'] = $card['link'];
                $hotel_card['card_image'] = $card['image'];
            }
        }
        $data['hotel_card'] = $hotel_card;
        $data['hotel_include_taxtes'] = $package->hotel->hotel_include_local_tax;
        $new_rooms = array();
        foreach ($rooms as $room) {
            $room_details = room::find($room);
            if (empty($room_details)) {
                continue;
            }
            $new_rooms[$count]['id'] = $room_details->id;
            if (!empty($room_details->old_room_id)) {
                $new_rooms[$count]['room_code'] = $room_details->old_room_id . '-d';
            } else {
                $new_rooms[$count]['room_code'] = $room_details->id . '-d';
            }
            $new_rooms[$count]['title'] = $room_details->room_title;
            $new_rooms[$count]['room_desc'] = $room_details->room_desc;
            if (!empty($room_details->room_type_name)) {
                $new_rooms[$count]['room_type'] = $room_details->room_type_name->room_type;
            } else {
                $new_rooms[$count]['room_type'] = '';
            }
            $new_rooms[$count]['max_people'] = $room_details->max_people;
            $new_rooms[$count]['room_area'] = $room_details->room_area;
            $new_rooms[$count]['room_images'] = $room_details->room_images;
            $new_rooms[$count]['room_avalible'] = get_rami_package_room_avalible($package->id, $room_details->id);
            $count++;
        }
        $data['hotel_rooms'] = $new_rooms;
        //extra hotel here
        $data['hotel_extra1']=[];
        $data['hotel_extra1_rooms']=[];
        $data['hotel_extra1_amenities']=[];
        $data['hotel_extra1_features']=[];
        $data['hotel_extra2']=[];
        $data['hotel_extra2_rooms']=[];
        $data['hotel_extra2_amenities']=[];
        $data['hotel_extra2_features']=[];
        if($package->having_extra_hotel_1==1){
            $data['hotel_extra1'] = hotel::find($package->extra_hotel_1);
            $data['hotel_extra1_dates']=rami_get_require_date_format($package->extra_hotel_1_start_date, 'd/m').'-' .rami_get_require_date_format($package->extra_hotel_1_end_date, 'd/m');
            $data['hotel_extra1_amenities'] = unserialize($data['hotel_extra1']->hotel_amenities);
            $data['hotel_extra1_features'] = unserialize($data['hotel_extra1']->hotel_features);
            $hotel_extra1_rooms = unserialize($package->extra_hotel_1_rooms); 
            $data['hotel_extra1_gallery'] = hotel_image::where(['hotel_id' => $package->extra_hotel_1])->orderBy('sequence', 'desc')->get();
           $data['hotel_extra1_gallery_count'] = $data['hotel_extra1_gallery']->count() - 6;
           $hotel_card = array();
           if (!empty($data['hotel_extra1']->hotel_card)) {
                $card = card::find($data['hotel_extra1']->hotel_card);
                if (!empty($card)) {
                    $hotel_card['title'] = $card->card_title;
                    $hotel_card['price'] = get_rami_price_conversion_shekel_to_other(get_rami_price_conversion_to_shekel($card->price, $card->price_currency), 1);
                    $hotel_card['link'] = $card['link'];
                    $hotel_card['card_image'] = $card['image'];
                }
            }
            $data['hotel_extra1_card'] = $hotel_card;
            $new_rooms = array();
            $count=0;
            foreach ($hotel_extra1_rooms as $room) {
                $room_details = room::find($room);
                if (empty($room_details)) {
                    continue;
                }
                $new_rooms[$count]['id'] = $room_details->id;
                if (!empty($room_details->old_room_id)) {
                    $new_rooms[$count]['room_code'] = $room_details->old_room_id . '-d';
                } else {
                    $new_rooms[$count]['room_code'] = $room_details->id . '-d';
                }
                $new_rooms[$count]['title'] = $room_details->room_title;
                $new_rooms[$count]['room_desc'] = $room_details->room_desc;
                if (!empty($room_details->room_type_name)) {
                    $new_rooms[$count]['room_type'] = $room_details->room_type_name->room_type;
                } else {
                    $new_rooms[$count]['room_type'] = '';
                }
                $new_rooms[$count]['room_availble'] = get_rami_room_avalible($room_details->id, $package->package_start_date);
                $new_rooms[$count]['max_people'] = $room_details->max_people;
                $new_rooms[$count]['room_area'] = $room_details->room_area;
                $new_rooms[$count]['room_images'] = $room_details->room_images;
                $new_rooms[$count]['room_avalible'] = get_rami_package_room_avalible($package->id, $room_details->id);
                $count++;
            }
            $data['hotel_extra1_rooms']=$new_rooms;
        }
        if($package->having_extra_hotel_2==1){
           $data['hotel_extra2'] = hotel::find($package->extra_hotel_2);
           $data['hotel_extra2_dates']=rami_get_require_date_format($package->extra_hotel_2_start_date, 'd/m').'-' .rami_get_require_date_format($package->extra_hotel_2_end_date, 'd/m');
           $data['hotel_extra2_amenities'] = unserialize($data['hotel_extra2']->hotel_amenities);
           $data['hotel_extra2_features'] = unserialize($data['hotel_extra2']->hotel_features);
           $data['hotel_extra2_gallery'] = hotel_image::where(['hotel_id' => $package->extra_hotel_2])->orderBy('sequence', 'desc')->get();
           $data['hotel_extra2_gallery_count'] = $data['hotel_extra2_gallery']->count() - 6;
           $hotel_card = array();
           if (!empty($data['hotel_extra2']->hotel_card)) {
                $card = card::find($data['hotel_extra2']->hotel_card);
                if (!empty($card)) {
                    $hotel_card['title'] = $card->card_title;
                    $hotel_card['price'] = get_rami_price_conversion_shekel_to_other(get_rami_price_conversion_to_shekel($card->price, $card->price_currency), 1);
                    $hotel_card['link'] = $card['link'];
                    $hotel_card['card_image'] = $card['image'];
                }
            }
            $data['hotel_extra2_card'] = $hotel_card;
           $rooms = unserialize($package->extra_hotel_1_rooms);
           $hotel_extra2_rooms = unserialize($package->extra_hotel_2_rooms); 
            $new_rooms = array();
            $count=0;
            foreach ($hotel_extra2_rooms as $room) {
                $room_details = room::find($room);
                if (empty($room_details)) {
                    continue;
                }
                $new_rooms[$count]['id'] = $room_details->id;
                if (!empty($room_details->old_room_id)) {
                    $new_rooms[$count]['room_code'] = $room_details->old_room_id . '-d';
                } else {
                    $new_rooms[$count]['room_code'] = $room_details->id . '-d';
                }
                $new_rooms[$count]['title'] = $room_details->room_title;
                $new_rooms[$count]['room_desc'] = $room_details->room_desc;
                if (!empty($room_details->room_type_name)) {
                    $new_rooms[$count]['room_type'] = $room_details->room_type_name->room_type;
                } else {
                    $new_rooms[$count]['room_type'] = '';
                }
                $new_rooms[$count]['room_availble'] = get_rami_room_avalible($room_details->id, $package->package_start_date);
                $new_rooms[$count]['max_people'] = $room_details->max_people;
                $new_rooms[$count]['room_area'] = $room_details->room_area;
                $new_rooms[$count]['room_images'] = $room_details->room_images;
                $new_rooms[$count]['room_avalible'] = get_rami_package_room_avalible($package->id, $room_details->id);
                $count++;
            }
            $data['hotel_extra2_rooms']=$new_rooms;  
        }
        if((empty($package->extra_hotel_1))&&(empty($package->extra_hotel_2))){
            $data['hotel_dates']=rami_get_require_date_format($package->package_start_date, 'd/m').'-' .rami_get_require_date_format($package->package_end_date, 'd/m');
        }elseif(empty($package->extra_hotel_2)){
            if(rami_get_no_of_days_diff($package->package_start_date, $package->extra_hotel_1_start_date) >1){
               $data['hotel_dates']=rami_get_require_date_format($package->package_start_date, 'd/m').'-' .rami_get_require_date_format($package->extra_hotel_1_start_date, 'd/m'); 
               $data['hotel_dates'].=' ,'.rami_get_require_date_format($package->extra_hotel_1_end_date, 'd/m').'-' .rami_get_require_date_format($package->package_end_date, 'd/m');

            }else{
               $data['hotel_dates']=rami_get_require_date_format($package->extra_hotel_1_end_date, 'd/m').'-' .rami_get_require_date_format($package->package_end_date, 'd/m'); 
            }
        }else{
             if(rami_get_no_of_days_diff($package->package_start_date, $package->extra_hotel_1_start_date) >1){
               $data['hotel_dates']=rami_get_require_date_format($package->package_start_date, 'd/m').'-' .rami_get_require_date_format($package->extra_hotel_1_start_date, 'd/m');
               if(rami_get_no_of_days_diff($package->extra_hotel_1_end_date, $package->extra_hotel_2_start_date) >1){
                $data['hotel_dates'].=' ,'.rami_get_require_date_format($package->extra_hotel_1_end_date, 'd/m').'-' .rami_get_require_date_format($package->extra_hotel_2_start_date, 'd/m');
               }
               $data['hotel_dates'].=' ,'.rami_get_require_date_format($package->extra_hotel_2_end_date, 'd/m').'-' .rami_get_require_date_format($package->package_end_date, 'd/m'); 
            }else{
               if(rami_get_no_of_days_diff($package->extra_hotel_1_end_date, $package->extra_hotel_2_start_date) >0){
                $data['hotel_dates']=rami_get_require_date_format($package->extra_hotel_1_end_date, 'd/m').'-' .rami_get_require_date_format($package->extra_hotel_2_start_date, 'd/m');
               }
               $data['hotel_dates'].=' ,'.rami_get_require_date_format($package->extra_hotel_2_end_date, 'd/m').'-' .rami_get_require_date_format($package->package_end_date, 'd/m');
            }
        }
        $data['amenities'] = unserialize($package->hotel->hotel_amenities);
        $data['features'] = unserialize($package->hotel->hotel_features);
        $data['hotel_gallery'] = hotel_image::where(['hotel_id' => $package->hotel->id])->get();
        $data['hotel_reviews'] = hotel_review::where(['hotel_id' => $package->hotel->id])->get();
        $data['attractions'] = attraction::where(['attraction_location' => $package->hotel->hotel_location])->orderBy('attraction_sequence', 'ASC')->get();
        $location = Location::find($package->hotel->hotel_location);
        if (empty(!$location)) {
            $data['map'] = $location->loc_map;
        } else {
            $data['map'] = $location->package_desti->loc_map;
        }
        $filghts = unserialize($package->package_flight_sche);
        $prv_filghts = [];
        foreach ($filghts as $filght) {
            $flight_schedule = flight_schedule::find($filght);
            if ((empty($flight_schedule)) || (in_array($flight_schedule->id, $prv_filghts))) {
                continue;
            }
            $prv_filghts[] = $flight_schedule->id;
            $up_flights = array();
            $down_flights = array();
            if ($flight_schedule->flight_type_up == 2) {
                $flight_conn_up = flight_schedule_connection::where([['type', 1], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get();
                $total_count = $flight_conn_up->count();
                $int = 1;
                foreach ($flight_conn_up as $flight) {
                    if ($int == 1) {
                        $fligts_data[$count]['up_source'] = $flight->flight->location_desti->loc_name;
                        $fligts_data[$count]['up_depart_full_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                        $fligts_data[$count]['up_departure_time'] = $flight->departure_time;
                        $fligts_data[$count]['up_flight_no'] = $flight->flight->flight_number;

                    }
                    $up_flights[$int]['airline_name'] = $flight->flight->airline_name->airl_name_eng;
                    $up_flights[$int]['airline_logo'] = $flight->flight->airline_name->airl_logo_img;
                    $up_flights[$int]['depart_full_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                    $up_flights[$int]['departure_time'] = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                    $up_flights[$int]['depart_time_in_month_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                    $up_flights[$int]['arrival_time'] = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                    $up_flights[$int]['time_taken'] = rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                    $up_flights[$int]['arrival_time_in_month_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                    $up_flights[$int]['arrival_full_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->arrival_time, 'Y');
                    $up_flights[$int]['desti'] = $flight->flight->location_desti->loc_name;
                    $up_flights[$int]['source'] = $flight->flight->location_source->loc_name;
                    $up_flights[$int]['flight_no'] = $flight->flight->flight_number;
                    //$up_flights[$int]['time_taken']=rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                    if ($int == $total_count) {
                        $fligts_data[$count]['up_desti'] = $flight->flight->location_desti->loc_name;
                        $up_flights[$count]['up_desti_id'] = $flight->flight->location_desti->id;
                        $fligts_data[$count]['up_arrival_time'] = $flight->arrival_time;
                        $fligts_data[$count]['up_time_taken'] = rami_get_no_of_hours_min_diff($fligts_data[$count]['up_departure_time'], $fligts_data[$count]['up_arrival_time']);
                        $fligts_data[$count]['up_arrival_full_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->arrival_time, 'Y');

                    }
                    $int++;
                }
            } else {
                $fligts_data[$count]['up_airline_name'] = $flight_schedule->airline_name->airl_name_eng;
                $fligts_data[$count]['up_airline_logo'] = $flight_schedule->airline_name->airl_logo_img;
                $fligts_data[$count]['up_depart_full_date'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_departure_time, 'm')) . ' ' . rami_get_require_date_time_format($flight_schedule->up_departure_time, 'Y');
                $fligts_data[$count]['up_departure_time'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'H:i');
                $fligts_data[$count]['up_arrival_time'] = rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'H:i');
                $fligts_data[$count]['up_departure_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_departure_time, 'm'));
                $fligts_data[$count]['up_arrival_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'm'));
                $fligts_data[$count]['up_desti'] = get_location_name($flight_schedule->flight_name->flight_desti);
                $fligts_data[$count]['up_desti_id'] = $flight_schedule->flight_name->flight_desti;
                $fligts_data[$count]['up_source'] = get_location_name($flight_schedule->flight_name->flight_source);
                $fligts_data[$count]['up_flight_no'] = $flight_schedule->flight_name->flight_number;
                $fligts_data[$count]['up_time_taken'] = rami_get_no_of_hours_min_diff($flight_schedule->up_departure_time, $flight_schedule->up_arrival_time);
                $fligts_data[$count]['up_arrival_full_date'] = rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'Y');
            }
            if ($flight_schedule->flight_type_down == 2) {
                $flight_conn_down = flight_schedule_connection::where([['type', 2], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get();
                $total_count = $flight_conn_down->count();
                $int = 1;
                foreach ($flight_conn_down as $flight) {
                    if ($int == 1) {
                        $fligts_data[$count]['down_source'] = $flight->flight->location_desti->loc_name;
                        $fligts_data[$count]['down_depart_full_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                        $fligts_data[$count]['down_departure_time'] = $flight->departure_time;
                        $fligts_data[$count]['down_flight_no'] = $flight->flight->flight_number;
                    }
                    $down_flights[$int]['airline_name'] = $flight->flight->airline_name->airl_name_eng;
                    $down_flights[$int]['airline_logo'] = $flight->flight->airline_name->airl_logo_img;
                    $down_flights[$int]['depart_full_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                    $down_flights[$int]['departure_time'] = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                    $down_flights[$int]['depart_time_in_month_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                    $down_flights[$int]['time_taken'] = rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                    $down_flights[$int]['arrival_time'] = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                    $down_flights[$int]['arrival_time_in_month_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                    $down_flights[$int]['desti'] = $flight->flight->location_desti->loc_name;
                    $down_flights[$int]['source'] = $flight->flight->location_source->loc_name;
                    $down_flights[$int]['flight_no'] = $flight->flight->flight_number;
                    $down_flights[$int]['arrival_full_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->arrival_time, 'Y');
                    //$down_flights[$int]['time_taken']=rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                    if ($int == $total_count) {
                        $fligts_data[$count]['down_desti'] = $flight->flight->location_desti->loc_name;
                        $fligts_data[$count]['down_arrival_time'] = $flight->arrival_time;
                        $fligts_data[$count]['down_time_taken'] = rami_get_no_of_hours_min_diff($fligts_data[$count]['down_departure_time'], $fligts_data[$count]['down_arrival_time']);
                        $fligts_data[$count]['down_arrival_full_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->arrival_time, 'Y');

                    }
                    $int++;
                }
            } else {
                $fligts_data[$count]['down_airline_name'] = $flight_schedule->airline_name_down->airl_name_eng;
                $fligts_data[$count]['down_airline_logo'] = $flight_schedule->airline_name_down->airl_logo_img;
                $fligts_data[$count]['down_depart_full_date'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->down_departure_time, 'Y');
                $fligts_data[$count]['down_departure_time'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'H:i');
                $fligts_data[$count]['down_departure_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_departure_time, 'm'));
                $fligts_data[$count]['down_arrival_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'm'));
                $fligts_data[$count]['down_arrival_time'] = rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'H:i');
                $fligts_data[$count]['down_time_taken'] = rami_get_no_of_hours_min_diff($flight_schedule->down_departure_time, $flight_schedule->down_arrival_time);
                $fligts_data[$count]['down_desti'] = get_location_name($flight_schedule->flight_name_down->flight_desti);
                $fligts_data[$count]['down_source'] = get_location_name($flight_schedule->flight_name_down->flight_source);
                $fligts_data[$count]['down_flight_no'] = $flight_schedule->flight_name_down->flight_number;
                $fligts_data[$count]['down_arrival_full_date'] = rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'Y');
            }
            $fligts_data[$count]['up_flights'] = $up_flights;
            $fligts_data[$count]['down_flights'] = $down_flights;
            $fligts_data[$count]['id'] = $flight_schedule->id;
            $fligts_data[$count]['title'] = $flight_schedule->flight_sche_title;

            $count++;
        }
        $data['all_flights'] = $fligts_data;
        $cars = unserialize($package->package_car);
        $car_count = 1;
        foreach ($cars as $car) {
            $car_details = car::find($car);
            if (empty($car_details)) {
                continue;
            }
            if ($car_details->id == $package['cheapest_car']) {
                $car_data['first_car_title'] = $car_details->car_title;
                $car_data['first_car_des'] = $car_details->car_desc;
                $car_data['first_car_img'] = $car_details->image;
            }
            $car_data[$car_count]['car_title'] = $car_details->car_title;
            $car_data[$car_count]['id'] = $car_details->id;
            $car_data[$car_count]['loc_id'] = $car_details->location;
            $car_data[$car_count]['car_price'] = get_rami_round_num(get_rami_price_conversion_shekel_to_other(get_rami_car_price($car_details->id, $car_details->max_people, $package->package_start_date), 2));
            $car_count++;
        }
        if (empty($car_data['first_car_title'])) {
            $car_data['first_car_title'] = '';
        }if (empty($car_data['first_car_des'])) {
            $car_data['first_car_des'] = '';
        }if (empty($car_data['first_car_img'])) {
            $car_data['first_car_img'] = '';
        }
        $car_data = collect($car_data)->sortBy('car_price')->toArray();
        foreach ($car_data as $key => $value) {
            if (is_array($value)) {
                $car_data[$key]['car_price'] = '€' . $value['car_price'];
            }
        }

        $data['all_cars'] = $car_data;
        return view('mobile.pages.package_detail', $data);
    }
    public function fly_travel_packages(Request $request)
    {
        $where = array(['package_type', 3], ['package_status', 1]);
        if (!empty($request->fc_location)) {
            $where[] = array('package_flight_location', $request->fc_location);
        }
        $data['all_pkgs_fc'] = package::where($where)->get();
        return view('mobile.pages.fly_travel_packages', $data);
    }
    public function fly_travel_packages_detail($id)
    {
        $package = package::find($id);
        if (empty($package)) {
            return redirect('/');
        }
        $data['package'] = $package;
        $filghts = unserialize($package->package_flight_sche);
        if (empty($filghts)) {
            return redirect('/');
        }
        $count = 1;
        foreach ($filghts as $filght) {
            $flight_schedule = flight_schedule::find($filght);
            if (empty($flight_schedule)) {
                continue;
            }
            $fligts_data[$count]['id'] = $flight_schedule->id;
            $fligts_data[$count]['title'] = $flight_schedule->flight_sche_title;
            $fligts_data[$count]['up_airline_name'] = $flight_schedule->airline_name->airl_name_eng;
            $fligts_data[$count]['up_airline_logo'] = $flight_schedule->airline_name->airl_logo_img;
            $fligts_data[$count]['depart_full_date'] = get_week_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_departure_time, 'w')) . ' ,' . rami_get_require_date_time_format($flight_schedule->up_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->up_departure_time, 'Y');
            $fligts_data[$count]['up_departure_time'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'H:i');
            $fligts_data[$count]['up_arrival_full_date'] = get_week_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'w')) . ' ,' . rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'Y');
            $fligts_data[$count]['up_arrival_time'] = rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'H:i');
            $fligts_data[$count]['up_desti'] = get_location_name($flight_schedule->flight_name->flight_desti);
            $fligts_data[$count]['up_source'] = get_location_name($flight_schedule->flight_name->flight_source);
            $fligts_data[$count]['up_flight_no'] = $flight_schedule->flight_name->flight_number;
            $fligts_data[$count]['up_time_taken'] = rami_get_no_of_hours_min_diff($flight_schedule->up_departure_time, $flight_schedule->up_arrival_time);
            $fligts_data[$count]['down_airline_name'] = $flight_schedule->airline_name_down->airl_name_eng;
            $fligts_data[$count]['down_airline_logo'] = $flight_schedule->airline_name_down->airl_logo_img;
            $fligts_data[$count]['back_full_date'] = get_week_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_departure_time, 'w')) . ' ,' . rami_get_require_date_time_format($flight_schedule->down_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->down_departure_time, 'Y');
            $fligts_data[$count]['down_departure_time'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'H:i');
            $fligts_data[$count]['down_arrival_time'] = rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'H:i');
            $fligts_data[$count]['down_arrival_full_date'] = get_week_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'w')) . ' ,' . rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'Y');
            $fligts_data[$count]['down_time_taken'] = rami_get_no_of_hours_min_diff($flight_schedule->down_departure_time, $flight_schedule->down_arrival_time);
            $fligts_data[$count]['down_desti'] = get_location_name($flight_schedule->flight_name_down->flight_desti);
            $fligts_data[$count]['down_source'] = get_location_name($flight_schedule->flight_name_down->flight_source);
            $fligts_data[$count]['down_flight_no'] = $flight_schedule->flight_name_down->flight_number;
            $count++;
        }
        $data['all_flights'] = $fligts_data;
        $cars = unserialize($package->package_car);
        $car_count = 1;
        foreach ($cars as $car) {
            $car_details = car::find($car);
            if (empty($car_details)) {
                continue;
            }
            if ($car_details->id == $package['cheapest_car']) {
                $first_car_title = $car_details->car_title;
                $first_car_des = $car_details->car_desc;
                $first_car_img = $car_details->image;
            }
            $car_data[$car_count]['id'] = $car_details->id;
            $car_data[$car_count]['car_title'] = $car_details->car_title;
            $car_data[$car_count]['id'] = $car_details->id;
            $car_data[$car_count]['car_price'] = get_rami_round_num(get_rami_price_conversion_shekel_to_other(get_rami_car_price($car_details->id, $car_details->max_people, $package->package_start_date), 2));

            $car_count++;
        }
        if (empty($first_car_title)) {
            $first_car_title = '';
        }if (empty($first_car_des)) {
            $first_car_des = '';
        }if (empty($first_car_img)) {
            $first_car_img = '';
        }
        usort($car_data, 'car_array_comparision_price');
        $car_data['first_car_title'] = $first_car_title;
        $car_data['first_car_des'] = $first_car_des;
        $car_data['first_car_img'] = $first_car_img;
        $data['all_cars'] = $car_data;
        return view('mobile.pages.fly_travel_packages_detail', $data);
    }
    public function serach_flights(Request $request)
    {
        $where[] = array('up_departure_time', '>=', date('Y-m-d'));
        $where2 = array();
        $data['loc_name'] = "";
        $data['loc_id'] = '';
        $data['ser_start_date'] = '';
        $data['ser_end_date'] = '';
        $data['loc_source'] = "";
        $data['is_serach'] = 1;
        if (!empty($request->destination_location)) {
            $data['loc_name'] = get_location_name($request->destination_location);
            $data['loc_id'] = $request->destination_location;
            $where2[] = array('flight_desti', $request->destination_location);
        }if (!empty($request->source_location)) {
            $where2[] = array('flight_source', $request->source_location);
            $data['loc_source'] = $request->loc_source;
        }if (!empty($request->flight_start_date)) {
            $where[] = array('up_departure_time', '>=', $request->flight_start_date);
            $where[] = array('up_departure_time', '<', rami_get_add_days_to_date($request->flight_start_date, 1));
            $data['ser_start_date'] = $request->flight_start_date;
        }if (!empty($request->flight_end_date)) {
            //$where[]= array('up_departure_time', '<=',$request->flight_end_date);
            $data['ser_end_date'] = $request->flight_end_date;
        }if (!empty($request->flight_adult)) {
            session()->put('pack_adults', $request->flight_adult);
        }if (!empty($request->flight_child)) {
            session()->put('pack_childs', $request->flight_child);
        }if (!empty($request->flight_infant)) {
            session()->put('pack_infants', $request->flight_infant);
        }
        $flight_schedule = new flight_schedule();
        $data['all_flights_sche'] = $flight_schedule->flight_schedule_search_by_date($where, $where2);
        $total_element = $flight_schedule->flight_schedule_search_by_date($where, $where2, 1);
        if ($total_element > $data['all_flights_sche']->count()) {
            $data['show_load_more'] = 1;
        }
        return view('mobile.pages.flights', $data);
    }
    public function flights($loc_id)
    {
        $location = Location::find($loc_id);
        if (empty($location)) {
            return redirect('/');
        }
        $page_content = location_page_content::where([['loc_id', $loc_id], ['pkg_type', 4]])->get(['page_title', 'page_disc'])->first();
        if (!empty($page_content)) {
            $data['page_title'] = $page_content->page_title;
            $data['page_disc'] = $page_content->page_disc;
        } else {
            $data['page_title'] = '';
            $data['page_disc'] = '';
        }
        $data['site_title'] = $location->loc_flight_title_text;
        $data['header_custom_code'] = $location->loc_flight_header_custom_code;
        $data['footer_custom_code'] = $location->loc_flight_footer_custom_code;
        $data['loc_name'] = $location->loc_name;
        $data['loc_id'] = $loc_id;
        $data['ser_start_date'] = '';
        $data['ser_end_date'] = '';
        $data['ser_source'] = '';
        $data['loc_source'] = "";
        $data['is_serach'] = 0;
        $flight_schedule = new flight_schedule();
        $data['all_flights_sche'] = $flight_schedule->flight_schedule_front_by_location($loc_id);
        $total_element = $flight_schedule->flight_schedule_front_by_location($loc_id, 1);
        if ($total_element >= $data['all_flights_sche']->count()) {
            $data['show_load_more'] = 1;
        }
        return view('mobile.pages.flights', $data);
    }
    public function flight_detail($id)
    {
        $flight_schedule = flight_schedule::find($id);
        if (empty($flight_schedule)) {
            return redirect('/');
        }
        if (empty($flight_schedule->airline_name)) {
            return redirect('/');
        }
        if (empty($flight_schedule->airline_name_down)) {
            return redirect('/');
        }
        $data['site_title'] = $flight_schedule->flight_sche_title_text;
        $data['header_custom_code'] = $flight_schedule->flight_sche_header_custom_code;
        $data['footer_custom_code'] = $flight_schedule->flight_sche_footer_custom_code;
        $up_flights = array();
        $down_flights = array();
        if ($flight_schedule->flight_type_up == 2) {
            $flight_conn_up = flight_schedule_connection::where([['type', 1], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get();
            $total_count = $flight_conn_up->count();
            $int = 1;
            foreach ($flight_conn_up as $flight) {
                if ($int == 1) {
                    $fligts_data['up_source'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['up_depart_full_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                    $fligts_data['up_departure_time'] = $flight->departure_time;
                    $fligts_data['up_flight_no'] = $flight->flight->flight_number;
                    $fligts_data['up_airline_name'] = $flight->flight->airline_name->airl_name_eng;
                    $fligts_data['start_date'] = rami_get_require_date_time_format($flight->departure_time, 'Y-m-d');

                }
                $up_flights[$int]['airline_name'] = $flight->flight->airline_name->airl_name_eng;
                $up_flights[$int]['airline_logo'] = $flight->flight->airline_name->airl_logo_img;
                $up_flights[$int]['depart_full_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                $up_flights[$int]['departure_time'] = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                $up_flights[$int]['depart_time_in_month_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                $up_flights[$int]['arrival_time'] = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                $up_flights[$int]['time_taken'] = rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                $up_flights[$int]['arrival_time_in_month_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                $up_flights[$int]['arrival_full_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->arrival_time, 'Y');
                $up_flights[$int]['desti'] = $flight->flight->location_desti->loc_name;
                $up_flights[$int]['source'] = $flight->flight->location_source->loc_name;
                $up_flights[$int]['flight_no'] = $flight->flight->flight_number;
                //$up_flights[$int]['time_taken']=rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                if ($int == $total_count) {
                    $fligts_data['up_desti'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['up_arrival_time'] = $flight->arrival_time;
                    $fligts_data['up_time_taken'] = rami_get_no_of_hours_min_diff($fligts_data['up_departure_time'], $fligts_data['up_arrival_time']);
                    $fligts_data['up_arrival_full_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->arrival_time, 'Y');

                }
                $int++;
            }
        } else {
            $fligts_data['up_airline_name'] = $flight_schedule->airline_name->airl_name_eng;
            $fligts_data['up_airline_logo'] = $flight_schedule->airline_name->airl_logo_img;
            $fligts_data['up_depart_full_date'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_departure_time, 'm')) . ' ' . rami_get_require_date_time_format($flight_schedule->up_departure_time, 'Y');
            $fligts_data['up_departure_time'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'H:i');
            $fligts_data['up_arrival_time'] = rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'H:i');
            $fligts_data['up_departure_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_departure_time, 'm'));
            $fligts_data['up_arrival_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'm'));
            $fligts_data['up_desti'] = get_location_name($flight_schedule->flight_name->flight_desti);
            $fligts_data['up_source'] = get_location_name($flight_schedule->flight_name->flight_source);
            $fligts_data['up_flight_no'] = $flight_schedule->flight_name->flight_number;
            $fligts_data['up_time_taken'] = rami_get_no_of_hours_min_diff($flight_schedule->up_departure_time, $flight_schedule->up_arrival_time);
            $fligts_data['up_arrival_full_date'] = rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'Y');
            $fligts_data['start_date'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'Y-m-d');
        }
        if ($flight_schedule->flight_type_down == 2) {
            $flight_conn_down = flight_schedule_connection::where([['type', 2], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get();
            $total_count = $flight_conn_down->count();
            $int = 1;
            foreach ($flight_conn_down as $flight) {
                if ($int == 1) {
                    $fligts_data['down_source'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['down_depart_full_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                    $fligts_data['down_departure_time'] = $flight->departure_time;
                    $fligts_data['down_flight_no'] = $flight->flight->flight_number;
                    $fligts_data['down_airline_name'] = $flight->flight->airl_name_eng;
                    $fligts_data['end_date'] = rami_get_require_date_time_format($flight->departure_time, 'Y-m-d');
                }
                $down_flights[$int]['airline_name'] = $flight->flight->airline_name->airl_name_eng;
                $down_flights[$int]['airline_logo'] = $flight->flight->airline_name->airl_logo_img;
                $down_flights[$int]['depart_full_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                $down_flights[$int]['departure_time'] = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                $down_flights[$int]['depart_time_in_month_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                $down_flights[$int]['time_taken'] = rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                $down_flights[$int]['arrival_time'] = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                $down_flights[$int]['arrival_time_in_month_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                $down_flights[$int]['desti'] = $flight->flight->location_desti->loc_name;
                $down_flights[$int]['source'] = $flight->flight->location_source->loc_name;
                $down_flights[$int]['flight_no'] = $flight->flight->flight_number;
                $down_flights[$int]['arrival_full_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->arrival_time, 'Y');
                //$down_flights[$int]['time_taken']=rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                if ($int == $total_count) {
                    $fligts_data['down_desti'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['down_arrival_time'] = $flight->arrival_time;
                    $fligts_data['down_time_taken'] = rami_get_no_of_hours_min_diff($fligts_data['down_departure_time'], $fligts_data['down_arrival_time']);
                    $fligts_data['down_arrival_full_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->arrival_time, 'Y');

                }
                $int++;
            }
        } else {
            $fligts_data['down_airline_name'] = $flight_schedule->airline_name_down->airl_name_eng;
            $fligts_data['down_airline_logo'] = $flight_schedule->airline_name_down->airl_logo_img;
            $fligts_data['down_depart_full_date'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->down_departure_time, 'Y');
            $fligts_data['down_departure_time'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'H:i');
            $fligts_data['down_departure_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_departure_time, 'm'));
            $fligts_data['down_arrival_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'm'));
            $fligts_data['down_arrival_time'] = rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'H:i');
            $fligts_data['down_time_taken'] = rami_get_no_of_hours_min_diff($flight_schedule->down_departure_time, $flight_schedule->down_arrival_time);
            $fligts_data['down_desti'] = get_location_name($flight_schedule->flight_name_down->flight_desti);
            $fligts_data['down_source'] = get_location_name($flight_schedule->flight_name_down->flight_source);
            $fligts_data['end_date'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'Y-m-d');
            $fligts_data['down_flight_no'] = $flight_schedule->flight_name_down->flight_number;
            $fligts_data['down_arrival_full_date'] = rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'Y');
        }
        $fligts_data['up_flights'] = $up_flights;
        $fligts_data['down_flights'] = $down_flights;
        $fligts_data['id'] = $flight_schedule->id;
        $fligts_data['title'] = $flight_schedule->flight_sche_title;
        $fligts_data['num_available_seat'] = $flight_schedule->num_available_seat;
        $data['all_flight'] = $fligts_data;
        return view('mobile.pages.flight_detail', $data);
    }
    public function search_vacation_packages(Request $request)
    {
        $where = array(['package_type', 1], ['package_status', 1], ['package_start_date', '>=', date('Y-m-d')]);
        $data['loc_name'] = "";
        $data['loc_id'] = '';
        $data['ser_start_date'] = '';
        $data['page_title'] = '';
        $data['ser_end_date'] = '';
        $all_loc = array();
        if (!empty($request->pack_location)) {
            $all_loc = get_location_all_child_location($request->pack_location);
            $all_loc[] = $request->pack_location;
            $data['loc_name'] = get_location_name($request->pack_location);
            $data['loc_id'] = $request->pack_location;
        }if (!empty($request->pack_start_date)) {
            $where[] = array('package_start_date', '=', $request->pack_start_date);
            $data['ser_start_date'] = $request->pack_start_date;
        }if (!empty($request->pack_end_date)) {
            $where[] = array('package_end_date', '=', $request->pack_end_date);
            $data['ser_end_date'] = $request->pack_end_date;
        }if (!empty($request->pack_adult)) {
            session()->put('pack_adults', $request->pack_adult);
        }if (!empty($request->pack_child)) {
            session()->put('pack_childs', $request->pack_child);
        }if (!empty($request->pack_infant)) {
            session()->put('pack_infants', $request->pack_infant);
        }
        $data['all_pkgs_fhc'] = package::where($where)->orderBy('package_start_date', 'ASC')->orderBy('package_lowest_price', 'asc')->skip(0)->take(90)->get();
        $total_element = package::where($where)->count();
        if (!empty($all_loc)) {
            $data['all_pkgs_fhc'] = package::where($where)->whereIn('package_flight_location', $all_loc)->orderBy('package_start_date', 'ASC')->orderBy('package_lowest_price', 'asc')->skip(0)->take(90)->get();
            $total_element = package::where($where)->whereIn('package_flight_location', $all_loc)->count();
        }
        if ($total_element > 9) {
            $data['show_load_more'] = 1;
        }
        return view('mobile.pages.vacation_packages', $data);
    }
    public function loc_vacation_packages($loc_id)
    {
        $location = Location::find($loc_id);
        if (empty($location)) {
            return redirect('/');
        }
        $data['loc_id'] = $location->id;
        $data['ser_start_date'] = '';
        $data['ser_end_date'] = '';
        $page_content = location_page_content::where([['loc_id', $loc_id], ['pkg_type', 1]])->get(['page_title', 'page_disc'])->first();
        if (empty($page_content->page_title)) {
            $data['page_title'] = 'חבילות נופש באזור  ' . $location->loc_name;
            $data['page_disc'] = '';
        } else {
            $data['page_title'] = $page_content->page_title;
            $data['page_disc'] = $page_content->page_disc;
        }
        $all_loc = get_location_all_child_location($loc_id);
        $all_loc[] = $loc_id;
        $data['all_pkgs_fhc'] = package::where([['package_type', 1], ['package_status', 1], ['package_start_date', '>=', date('Y-m-d')]])->whereIn('package_flight_location', $all_loc)->orderBy('package_lowest_price', 'asc')->orderBy('package_start_date', 'ASC')->skip(0)->take(90)->get();
        $total_element = package::where([['package_flight_location', $loc_id], ['package_type', 1], ['package_status', 1], ['package_start_date', '>=', date('Y-m-d')]])->count();
        if ($total_element > 9) {
            $data['show_load_more'] = 1;
        }
        return view('mobile.pages.vacation_packages', $data);
    }
    public function accommodation($loc_id)
    {
        $location = Location::find($loc_id);
        if (empty($location)) {
            return redirect('/');
        }
        $all_loc = get_location_all_child_location($loc_id);
        $all_loc[] = $loc_id;
        $data['loc_id'] = $loc_id;
        $data['loc_name'] = $location->loc_name;
        $data['all_hotels'] = hotel::whereIn('hotel_location', $all_loc)->skip(0)->take(90)->orderBy('hotel_code', 'asc')->get();
        $total_element = hotel::whereIn('hotel_location', $all_loc)->count();
        if ($total_element > $data['all_hotels']->count()) {
            $data['show_load_more'] = 1;
        }
        return view('mobile.pages.accommodation', $data);
    }
    public function search_accommodation(Request $request)
    {
        $all_loc = [];
        $data['loc_id'] = '';
        $data['loc_name'] = '';
        $all_loc = array();
        if (!empty($request->accom_location)) {
            $all_loc = get_location_all_child_location($request->accom_location);
            $all_loc[] = $request->accom_location;
            $data['loc_id'] = $request->accom_location;
            $data['loc_name'] = get_location_name($request->accom_location);
        }
        if (!empty($all_loc)) {
            $data['all_hotels'] = hotel::whereIn('hotel_location', $all_loc)->skip(0)->take(90)->orderBy('hotel_code', 'asc')->orderBy('hotel_code', 'asc')->get();
            $total_element = hotel::whereIn('hotel_location', $all_loc)->count();
        } else {
            $data['all_hotels'] = hotel::skip(0)->take(90)->orderBy('hotel_code', 'asc')->orderBy('hotel_code', 'asc')->get();
            $total_element = hotel::count();
        }

        if ($total_element > $data['all_hotels']->count()) {
            $data['show_load_more'] = 1;
        }
        if (!empty($request->acc_adults)) {
            session()->put('pack_adults', $request->acc_adults);
        }if (!empty($request->acc_childs)) {
            session()->put('pack_childs', $request->acc_childs);
        }if (!empty($request->acc_infants)) {
            session()->put('pack_infants', $request->acc_infants);
        }
        return view('mobile.pages.accommodation', $data);
    }
    public function accommodation_detail($id)
    {
        $hotel = hotel::where([['slug', $id]])->get()->first();
        if (empty($hotel)) {
            $hotel = hotel::find($id);
        }
        if (empty($hotel)) {
            return redirect('/');
        }
        $rooms = $hotel->room;
        if (empty($rooms)) {
            return redirect('/');
        }
        $data['site_title'] = $hotel->hotel_title_text;
        $data['header_custom_code'] = $hotel->hotel_header_custom_code;
        $data['footer_custom_code'] = $hotel->hotel_footer_custom_code;
        $count = 1;
        $new_rooms = array();
        foreach ($rooms as $room) {
            $room_details = $room;
            if (empty($room_details)) {
                continue;
            }
            $new_rooms[$count]['id'] = $room_details->id;
            if (!empty($room_details->old_room_id)) {
                $new_rooms[$count]['room_code'] = $room_details->old_room_id . '-d';
            } else {
                $new_rooms[$count]['room_code'] = $room_details->id . '-d';
            }
            $new_rooms[$count]['title'] = $room_details->room_title;
            $new_rooms[$count]['room_desc'] = $room_details->room_desc;
            if (!empty($room_details->room_type_name)) {
                $new_rooms[$count]['room_type'] = $room_details->room_type_name->room_type;
            } else {
                $new_rooms[$count]['room_type'] = '';
            }
            $new_rooms[$count]['max_people'] = $room_details->max_people;
            $new_rooms[$count]['room_area'] = $room_details->room_area;
            $new_rooms[$count]['room_images'] = $room_details->room_images;
            $count++;
        }
        $data['hotel_rooms'] = $new_rooms;
        $data['hotel'] = $hotel;
        $hotel_card = array();
        if (!empty($hotel->hotel_card)) {
            $card = card::find($hotel->hotel_card);
            if (!empty($card)) {
                $hotel_card['title'] = $card->card_title;
                $hotel_card['price'] = get_rami_price_conversion_shekel_to_other(get_rami_price_conversion_to_shekel($card->price, $card->price_currency), 1);
                $hotel_card['link'] = $card['link'];
                $hotel_card['card_image'] = $card['image'];
            }
        }
        $data['hotel_card'] = $hotel_card;
        $data['amenities'] = unserialize($hotel->hotel_amenities);
        $data['features'] = unserialize($hotel->hotel_features);
        $data['hotel_location'] = $hotel->hotel_location;
        $data['attractions'] = attraction::where(['attraction_location' => $hotel->hotel_location])->orderBy('attraction_sequence', 'ASC')->get();
        $location = Location::find($hotel->hotel_location);
        if (empty(!$location)) {
            $data['map'] = $location->loc_map;
        } else {
            $data['map'] = "";
        }
        $data['similar_loc_hotels'] = hotel::where([['id', '!=', $id], ['hotel_location', $hotel->hotel_location]])->get();
        $data['similar_loc_hotels_count'] = $data['similar_loc_hotels']->count();
        $data['hotel_packages'] = package::where([['package_hotel', $id], ['package_type', 1], ['package_status', 1], ['package_start_date', '>', date('Y-m-d')]])->orderBy('package_start_date', 'ASC')->orderBy('package_lowest_price', 'asc')->get();
        $data['hotel_packages_count'] = $data['hotel_packages']->count();
        $data['hotel_code'] = $hotel->hotel_code;
        $data['hotel_desc'] = $hotel->hotel_desc;
        $data['hotel_gallery'] = hotel_image::where(['hotel_id' => $id])->get();
        return view('mobile.pages.accommodation_detail', $data);
    }
    public function testimonials()
    {
        $data['testimonials'] = testimonial::where('status', 1)->orderBy('testimonial_date', 'DESC')->skip(0)->take(40)->get();
        return view('mobile.pages.testimonials', $data);
    }
    public function submit_testimonial(Request $request)
    {
        $testimonial = new testimonial;
        $messages = [
        ];
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'title' => 'required',
            'email' => 'required|string|email|max:255',
            'remark' => 'required',
        ], $messages); /*
        $testimonial->user_id=$request->user_id;*/
        $testimonial->first_name = $request->first_name;
        $testimonial->last_name = $request->last_name;
        $testimonial->email = $request->email;
        $testimonial->title = $request->title;
        $testimonial->remark = $request->remark;
        $testimonial->testimonial_date = date('Y-m-d');
        $testimonial->status = 0;
        $testimonial->save();
        set_flash_msg('flash_success', 'המלצה הוגשה בהצלחה.');
        return redirect('/testimonials');
    }
    public function contact()
    {
        return view('mobile.pages.contact');
    }
    public function submit_contact(Request $request)
    {
        $messages = [
        ];
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            // 'interested_in'  => 'required',
        ], $messages);
        $user['first_name'] = $request->first_name;
        $user['last_name'] = $request->last_name;
        $user['phone'] = $request->phone;
        $user['email'] = $request->email;
        $user['msg'] = $request->msg_contact;
        $user['interested_in'] = $request->interested_in;
        
        if (!preg_match("/(?i)\b((?:https?:\/\/))/", $request->msg_contact)) { 
            if (rami_check_ban($user)) {
                Mail::to(get_rami_setting('notification_email_id'))->send(new ContactUs($user));
            }
        }

        set_flash_msg('flash_success', 'תודה רבה  <br> קיבלנו את פנייתכם  <br> נציג מטעמנו יחזור אליכם תוך 24 שעות.');
        return redirect('contact');
    }
    public function search_accommodation_hotel_code(Request $request)
    {
        $data['all_hotels'] = hotel::where([['hotel_code', 'like', '%' . $request->hotel_code . '%']])->skip(0)->take(80)->orderBy('hotel_code', 'asc')->orderBy('hotel_code', 'asc')->get();
        $total_element = hotel::where([['hotel_code', 'like', '%' . $request->hotel_code . '%']])->count();
        if ($total_element > $data['all_hotels']->count()) {
            $data['show_load_more'] = 1;
        }
        $data['hotel_code_text'] = $request->hotel_code;
        return view('mobile.pages.accommodation_search_hotel_code', $data);
    }
    public function tourist_info()
    {
        return view('mobile.pages.tourist_info');
    }
    public function blackforest_info()
    {
        return view('mobile.pages.blackforest_info');
    }
    public function blackforest_cards()
    {
        return view('mobile.pages.blackforest_cards');
    }
}