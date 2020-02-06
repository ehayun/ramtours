<?php

namespace App\Http\Controllers\ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\model\testimonial;
use App\model\package;
use App\model\flight_schedule;
use App\model\hotel;
use Validator;
use App\Mail\ContactUs;
use Illuminate\Support\Facades\Mail;

class AjaxController extends Controller 
{
    public function ajax_for_load_more(Request $request){
    	if(!empty($request->page)){
    		$page=$request->page;
    	}else{
    		$page=1;
    	}
    	if(!empty($request->no_of_element)){
    		$no_of_element=$request->no_of_element;
    	}else{
    		$no_of_element=4;
    	}
    	if($page==1){
    		$skip=0;
    	}else{
    		$skip=($page-1)*$no_of_element;
    	}
    	$is_last_page=$no_of_element*$page;
    	if($request->type==1){
    		$data['testimonials'] = testimonial::where('status',1)->skip($skip)->take($no_of_element)->orderBy('testimonial_date', 'DESC')->get();
    		$total_element=testimonial::where('status',1)->count();
    		if($total_element<=$is_last_page){
    			$is_last_page=1;
    		}else{
    			$is_last_page=0;
    		}
            if($request->is_mobile==1){
                $html=view('mobile.load_more.testimonial_load_more',$data)->render();
            }else{
                $html=view('frontend.load_more.testimonials',$data)->render();
            }    		
    		if(!empty($data['testimonials'])){
    			return response()->json(array('html' => $html, 'is_last_page'=>$is_last_page, 'status' => 'success'), 200);
    		}else{
    			return response()->json(array('msg' => "No more records.", 'status' => 'error'), 200);
    		}
    	}elseif($request->type==2){
    		$data['packages'] = package::where([['package_type', 1], ['package_status', 1], ['is_hot_deal', 1], ['package_start_date',  '>=', date('Y-m-d')]])->skip($skip)->take($no_of_element)->get();
    		$total_element=package::where([['package_type', 1], ['package_status', 1], ['is_hot_deal', 1]])->count();
    		if($total_element<=$is_last_page){
    			$is_last_page=1;
    		}else{
    			$is_last_page=0;
    		}
            $html=view('mobile.load_more.home_packages',$data)->render();  		
    		if(!empty($data['packages'])){
    			return response()->json(array('html' => $html, 'is_last_page'=>$is_last_page, 'status' => 'success'), 200);
    		}else{
    			return response()->json(array('msg' => "No more records.", 'status' => 'error'), 200);
    		}
    	}
    }
    function ajax_for_package_load_more(Request $request){
        if(!empty($request->page)){
            $page=$request->page;
        }else{
            $page=1;
        }
        if(!empty($request->no_of_element)){
            $no_of_element=$request->no_of_element;
        }else{
            $no_of_element=4;
        }
        if($page==1){
            $skip=0;
        }else{
            $skip=($page-1)*$no_of_element;
        }
        $is_last_page=$no_of_element*$page;
        $where=array(['package_type', 1],['package_status', 1], ['package_start_date',  '>=', date('Y-m-d')]);
        if (!empty($request->pack_location)) {
            $all_loc=get_location_all_child_location($request->pack_location);
            $all_loc[]=$request->pack_location;
        }if (!empty($request->pack_start_date)) {
            $where[]= array('package_start_date', '=', $request->pack_start_date);
        }if (!empty($request->pack_end_date)) {
            $where[]= array('package_end_date', '=',$request->pack_end_date);
        }
        $data['all_pkgs_fhc'] = package::where($where)->whereIn('package_flight_location', $all_loc)->orderBy('package_lowest_price', 'asc')->orderBy('package_start_date', 'ASC')->skip($skip)->take($no_of_element)->get();
        $total_element=package::where($where)->count();
        if($total_element<=$is_last_page){
            $is_last_page=1;
        }else{
            $is_last_page=0;
        }
        if(!empty($request->is_mobile)){
            $html=view('mobile.load_more.packages',$data)->render(); 
        }else{
            $html=view('frontend.load_more.packages',$data)->render();
        }
        if(!empty($data['all_pkgs_fhc'])){
            return response()->json(array('html' => $html, 'is_last_page'=>$is_last_page, 'status' => 'success'), 200);
        }else{
            return response()->json(array('msg' => "No more records.", 'status' => 'error'), 200);
        }

    }
    function ajax_for_flight_load_more(Request $request){
        if(!empty($request->page)){
            $page=$request->page;
        }else{
            $page=1;
        }
        if(!empty($request->no_of_element)){
            $no_of_element=$request->no_of_element;
        }else{
            $no_of_element=4;
        }
        if($page==1){
            $skip=0;
        }else{
            $skip=($page-1)*$no_of_element;
        }
        $is_last_page=$no_of_element*$page;
        $loc_id=$request->flight_location;
        $where[]=array('up_departure_time', '>=', date('Y-m-d'));
        $where2=array();
        if (!empty($request->flight_location)) {
            $where2[]= array('flight_desti', $request->flight_location);
        }if (!empty($request->flight_location_source)) {
            $where2[]= array('flight_source', $request->flight_location_source);
        }if (!empty($request->flight_start_date)) {
            $where[]= array('up_departure_time', '>=',$request->flight_start_date);
            $where[]= array('up_departure_time', '<',rami_get_add_days_to_date($request->flight_start_date,1));
        }if (!empty($request->flight_end_date)) {
            $where[]= array('down_departure_time', '>=',$request->flight_end_date);
            $where[]= array('down_departure_time', '<',rami_get_add_days_to_date($request->flight_end_date,1));
        }
        $flight_schedule= new flight_schedule();
        if(!empty($request->is_serach)){
            $data['all_flights_sche']=$flight_schedule->flight_schedule_search_by_date($where, $where2, 0, $skip,$no_of_element );
            $total_element=$flight_schedule->flight_schedule_search_by_date($where, $where2, 1);
        }else{
            $data['all_flights_sche']=$flight_schedule->flight_schedule_front_by_location($loc_id,0,$skip,$no_of_element);
            $total_element=$flight_schedule->flight_schedule_front_by_location($loc_id,1);
        }
        if($total_element<=$is_last_page){
            $is_last_page=1;
        }else{
            $is_last_page=0;
        }
        if(!empty($request->is_mobile)){
            $html=view('mobile.load_more.flights',$data)->render();   
        }else{
            $html=view('frontend.load_more.flights',$data)->render();   
        }    
        if(!empty($data['all_flights_sche'])){
            return response()->json(array('html' => $html, 'is_last_page'=>$is_last_page, 'status' => 'success'), 200);
        }else{
            return response()->json(array('msg' => "No more records.", 'status' => 'error'), 200);
        }

    }
    function ajax_for_hotel_load_more(Request $request){
        if(!empty($request->page)){
            $page=$request->page;
        }else{
            $page=1;
        }
        if(!empty($request->no_of_element)){
            $no_of_element=$request->no_of_element;
        }else{
            $no_of_element=4;
        }
        if($page==1){
            $skip=0;
        }else{
            $skip=($page-1)*$no_of_element;
        }
        $is_last_page=$no_of_element*$page;
        $loc_id=$request->hotel_location;
        $hotel_code=$request->hotel_code;
        $all_loc=get_location_all_child_location($loc_id);
        $all_loc[]=$loc_id;
        $data['all_hotels'] = hotel::skip($skip)->take($no_of_element)->orderBy('hotel_code', 'asc')->get();
        $total_element=hotel::all()->count(); 
        if(!empty($loc_id)){
           $data['all_hotels'] = hotel::whereIn('hotel_location', $all_loc)->skip($skip)->take($no_of_element)->orderBy('hotel_code', 'asc')->get();
            $total_element=hotel::whereIn('hotel_location', $all_loc)->count(); 
        }
        if(!empty($hotel_code)){
            $data['all_hotels'] = hotel::where([['hotel_code', 'like', '%'.$request->hotel_code.'%']])->skip($skip)->take($no_of_element)->orderBy('hotel_code', 'asc')->orderBy('hotel_code', 'asc')->get();
        }

        if($total_element<=$is_last_page){
            $is_last_page=1;
        }else{
            $is_last_page=0;
        }
         if(!empty($request->is_mobile)){

            $html=view('mobile.load_more.hotels',$data)->render();   
        }else{
            $html=view('frontend.load_more.hotels',$data)->render();   
        }   
               
        if(!empty($data['all_hotels'])){
            return response()->json(array('html' => $html, 'is_last_page'=>$is_last_page, 'status' => 'success'), 200);
        }else{
            return response()->json(array('msg' => "No more records.", 'status' => 'error'), 200);
        }
    }

    function ajax_for_packages_location_dates(Request $request){
        $where=array(['package_type', 1],['package_status', 1], ['package_start_date',  '>=', date('Y-m-d')]);
        $all_loc=array();
        if (!empty($request->pack_location)) {
            $all_loc=get_location_all_child_location($request->pack_location);
            $all_loc[]=$request->pack_location;
            //$where[]= array('package_flight_location', $request->pack_location);
        }
        $pack_dates=package::where($where)->whereIn('package_flight_location', $all_loc)->orderBy('package_lowest_price', 'DESC')->get(['package_start_date','package_lowest_price', 'package_end_date']);
       
         if(!empty($pack_dates)){
            return response()->json(array('pack_dates' => $pack_dates, 'status' => 'success'), 200);
        }else{
            return response()->json(array('msg' => "No more records.", 'status' => 'error'), 200);
        }

    }
    function ajax_for_flights_src_desti_dates(Request $request){
        $where[]=array('up_departure_time', '>=', date('Y-m-d'));
        $where2=array();
        if (!empty($request->desti)) {
            $where2[]= array('flight_desti', $request->desti);
        }if (!empty($request->src)) {
            $where2[]= array('flight_source', $request->src);
        }
        $flight_schedule= new flight_schedule();
        $flights_dates=$flight_schedule->flight_schedule_dates_by_src_desti($where, $where2);
        $count=0;
        $flight_new_date=array();
        foreach ($flights_dates as $flight) {
             $flight_new_date[$count]['up_departure_time']=rami_get_require_date_time_format($flight->up_departure_time,'Y-m-d'); 
              $flight_new_date[$count]['flight_price']=get_rami_flight_price_for_single_flight($flight->id); 
              $flight_new_date[$count]['down_departure_time']=rami_get_require_date_time_format($flight->down_departure_time,'Y-m-d'); 
             $count++;
        }
        usort($flight_new_date, 'flight_array_comparision_price');
         if(!empty($flight_new_date)){
            return response()->json(array('flights_dates' => $flight_new_date, 'status' => 'success'), 200);
        }else{
            return response()->json(array('msg' => "No more records.", 'status' => 'error'), 200);
        }

    }

     function ajax_for_submit_contact_form(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name_contact' => 'required',
            'last_name_contact' => 'required',
            'email_contact' => 'required|email',
            'phone_contact' => 'required',
            'msg_contact' => 'required',
        ]);
        if ($validator) {
            $user['first_name']=$request->first_name_contact;
            $user['last_name']=$request->last_name_contact;
            $user['phone']=$request->phone_contact;
            $user['email']=$request->email_contact;
            $user['msg']=$request->msg_contact;

            if (!preg_match("/(?i)\b((?:https?:\/\/))/", $request->msg_contact)) { 
                if (rami_check_ban($user)) {
                    Mail::to(get_rami_setting('notification_email_id'))->send(new ContactUs($user));
                }
            }



            return response()->json(['status' => 'success'], 200);

        }else{
            return response()->json(['status' => 'fail'], 200);
        }
        
    }
}