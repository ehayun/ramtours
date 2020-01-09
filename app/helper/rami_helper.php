<?php
use App\model\airline;
use App\model\car;
use App\model\car_price;
use App\model\flight;
use App\model\flight_schedule;
use App\model\flight_schedule_connection;
use App\model\hotel;
use App\model\hotel_amenity;
use App\model\hotel_feature;
use App\model\hotel_image;
use App\model\hotel_type;
use App\model\Location;
use App\model\package;
use App\model\package_room_stock;
use App\model\page;
use App\model\page_palcehloder;
use App\model\room;
use App\model\room_price;
use App\model\room_stock;
use App\model\setting;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent;

if (!function_exists('rami_checking_mobile_destop_redirection')) {
    function rami_checking_mobile_destop_redirection()
    {
        return '0';
        $agent = new Agent();
        $htp = 'http://';
        if (Request::isSecure()) {
            $htp = 'https://';
        }
        if ($agent->isMobile() || $agent->isTablet()) {
            if (request()->getHttpHost() != config('constant.MOBILE_URL')) {
                Redirect::to($htp . config('constant.MOBILE_URL'))->send();
            }
        } else {
            if (request()->getHttpHost() != config('constant.DESKTOP_URL')) {
                Redirect::to($htp . config('constant.DESKTOP_URL'))->send();
            }
        }
    }
}
if (!function_exists('rami_checking_is_mobile')) {
    function rami_checking_is_mobile()
    {
        $agent = new Agent();
        if ($agent->isMobile() || $agent->isTablet()) {
            return 1;
        } else {
            return 0;
        }
    }
}
if (!function_exists('get_form_error_msg')) {
    function get_form_error_msg($errors, $field_name)
    {
        if ($errors->has($field_name)) {
            $form_error = '<label id="' . $field_name . '-error" class="error" for="' . $field_name . '">' . $errors->first($field_name) . '</label>';
            return $form_error;
        }
    }
}
if (!function_exists('set_flash_msg')) {
    function set_flash_msg($msgtype, $msg)
    {
        session()->flash($msgtype, $msg);
    }
}
if (!function_exists('show_flash_msg')) {
    function show_flash_msg()
    {
        $flash = '';
        if (session()->has('flash_success')) {
            $flash = '<div class="alert alert-success alert-dismissible m-t-10 align-justify" role="alert">';
            $flash .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            $flash .= '<span aria-hidden="true">×</span></button>';
            $flash .= session()->get('flash_success');
            $flash .= '</div>';
            // $flash .= 'Success! ' . session()->get('flash_success');
            $flash .= '</div>';
        }if (session()->has('flash_warning')) {
            $flash = '<div class="alert alert-warning alert-dismissible m-t-10 align-justify" role="alert">';
            $flash .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            $flash .= '<span aria-hidden="true">×</span></button>';
            $flash .= 'Warning! ' . session()->get('flash_warning');
            $flash .= '</div>';
        }if (session()->has('flash_info')) {
            $flash = '<div class="alert alert-info alert-dismissible m-t-10 align-justify" role="alert">';
            $flash .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            $flash .= '<span aria-hidden="true">×</span></button>';
            $flash .= 'Info! ' . session()->get('flash_info');
            $flash .= '</div>';
        }if (session()->has('flash_error')) {
            $flash = '<div class="alert alert-danger alert-dismissible m-t-10 align-justify" role="alert">';
            $flash .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            $flash .= '<span aria-hidden="true">×</span></button>';
            $flash .= 'Error! ' . session()->get('flash_error');
            $flash .= '</div>';
        }
        return $flash;
    }
}
if (!function_exists('make_breadcrumb_admin')) {
    function make_breadcrumb_admin()
    {
        $routes = Route::currentRouteName();
        $routes = explode('.', $routes);
        if (rami_check_backend_language_dir_rtl() == 1) {
            $class = 'float-md-left';
        } else {
            $class = 'float-md-right';
        }
        $breadcrumb = '<ul class="breadcrumb ' . $class . '">';
        $breadcrumb .= '<li class="breadcrumb-item"><a href="' . route('admin') . '"><i class="zmdi zmdi-home"></i> Home </a></li>';
        $res_routes = array('airline', 'location', 'flight', 'setting', 'flight-schedule', 'hotel', 'room', 'package', 'vehical', 'car', 'attraction', 'package-person', 'hotel-type', 'room-type', 'hotel-amenities', 'hotel-features', 'reviews', 'testimonial', 'card');
        foreach ($routes as $route) {
            if (($route == 'admin') || ($route == 'index')) {
                continue;
            }
            if (in_array($route, $res_routes)) {
                $route_url = route($route . '.index');
            } else {
                $route_url = url()->current();
            }
            $breadcrumb .= '<li class="breadcrumb-item"><a href="' . $route_url . '">' . $route . '</a></li>';
        }
        $breadcrumb .= '</ul>';
        return $breadcrumb;
    }
}
if (!function_exists('checking_array_is_empty_for_val')) {
    function checking_array_is_empty_for_val($compair_array, $compair_prop)
    {
        if (!empty($compair_array)) {
            if (!empty($compair_array[$compair_prop])) {
                return $compair_array[$compair_prop];
            } else {
                return '';
            }
        } else {
            return '';
        }
    }
}
if (!function_exists('checking_object_is_empty_for_val')) {
    function checking_object_is_empty_for_val($compair_obj, $compair_prop)
    {
        if (!empty($compair_obj)) {
            if (!empty($compair_obj->{$compair_prop})) {
                return $compair_obj->{$compair_prop};
            } else {
                return '';
            }
        } else {
            return old($input);
        }
    }
}
if (!function_exists('get_edit_input_pvr_old_value')) {
    function get_edit_input_pvr_old_value($input, $prv_value = '')
    {
        if ((!empty($prv_value)) && (empty(old($input)))) {
            return $prv_value;
        } else {
            return old($input);
        }
    }
}
if (!function_exists('get_edit_input_pvr_old_value_with_obj')) {
    function get_edit_input_pvr_old_value_with_obj($input, $compair_obj, $compair_prop)
    {
        if ((!empty($compair_obj->{$compair_prop})) && (empty(old($input)))) {
            return $compair_obj->{$compair_prop};
        } else {
            return old($input);
        }
    }
}

if (!function_exists('get_edit_select_check_pvr_old_value_with_obj')) {
    function get_edit_select_check_pvr_old_value_with_obj($input, $compair_obj, $compair_prop, $current_ele, $type, $prv_input = "")
    {
        if ((!empty($compair_obj->{$compair_prop})) && (empty(old($input)))) {
            $select = $compair_obj->{$compair_prop};
        } elseif (!empty(old($input))) {
            $select = old($input);
        } else {
            $select = $prv_input;
        }
        if ($select == $current_ele) {
            if ($type == 'select') {
                return 'selected="true"';
            } else {
                return 'checked="true"';
            }
        } else {
            return '';
        }
    }
}
if (!function_exists('get_edit_select_check_pvr_old_value_with_obj_serlizie')) {
    function get_edit_select_check_pvr_old_value_with_obj_serlizie($input, $compair_obj, $compair_prop, $current_ele, $type)
    {
        if ((!empty($compair_obj->{$compair_prop})) && (empty(old($input)))) {
            $select_array = @unserialize($compair_obj->{$compair_prop});
            //checking serlize object
            if ($select_array !== false) {
                $select_array = $select_array;
            } else {
                $select_array = [$compair_obj->{$compair_prop}];
            }
        } elseif (!empty(old($input))) {
            $select_array = old($input);
        }
        if (empty($select_array)) {
            $select_array = array();
        }
        if (in_array($current_ele, $select_array)) {
            if ($type == 'select') {
                return 'selected="true"';
            } else {
                return 'checked="true"';
            }
        } else {
            return '';
        }
    }
}

if (!function_exists('get_edit_select_check_pvr_old_value')) {
    function get_edit_select_check_pvr_old_value($input, $prv_value, $current_ele, $type)
    {
        if ((!empty($prv_value)) && (empty(old($input)))) {
            $select = $prv_value;
        } else {
            $select = old($input);
        }
        if ($select == $current_ele) {
            if ($type == 'select') {
                return 'selected="true"';
            } else {
                return 'checked="true"';
            }
        } else {
            return '';
        }
    }
}
if (!function_exists('rami_get_prv_serialize_data')) {
    function rami_get_prv_serialize_data($input, $compair_obj, $compair_prop)
    {
        if ((!empty($compair_obj->{$compair_prop})) && (empty(old($input)))) {
            $select_array = unserialize($compair_obj->{$compair_prop});
        } elseif (!empty(old($input))) {
            $select_array = old($input);
        }
        if (empty($select_array)) {
            $select_array = array();
        }
        return implode(',', $select_array);

    }
}

if (!function_exists('rami_get_prv_serialize_data_array')) {
    function rami_get_prv_serialize_data_array($input, $compair_obj, $compair_prop)
    {
        if ((!empty($compair_obj->{$compair_prop})) && (empty(old($input)))) {
            $select_array = unserialize($compair_obj->{$compair_prop});
        } elseif (!empty(old($input))) {
            $select_array = old($input);
        }
        if (empty($select_array)) {
            $select_array = array();
        }
        return $select_array;

    }
}
if (!function_exists('str_char_limit')) {
    function str_char_limit($attr, $limit)
    {
        if (strlen($attr) > $limit) {
            return substr($attr, 0, $limit) . '...';
        } else {
            return substr($attr, 0, $limit);
        }
    }
}
if (!function_exists('get_cur_user_name')) {
    function get_cur_user_name()
    {
        if (!empty(auth::user()->id)) {
            return (auth::user()->fname) . " " . (auth::user()->lname);
        } else {
            return "";
        }
    }
}
if (!function_exists('get_cur_user_srt_email')) {
    function get_cur_user_srt_email()
    {
        if (!empty(auth::user()->id)) {
            $email = auth::user()->email;
            if (strlen($email) < 12) {
                return $email;
            } else {
                return substr($email, 0, 12) . '...';
            }

        } else {
            return "";
        }
    }
}
if (!function_exists('get_cur_user_email')) {
    function get_cur_user_email()
    {
        if (!empty(auth::user())) {
            $email = auth::user()->email;
            return $email;
        } else {
            return "";
        }
    }
}
if (!function_exists('get_cur_user_image')) {
    function get_cur_user_image()
    {
        if (!empty(auth::user())) {
            $img = auth::user()->image;
        }
        if (!empty($img)) {
            return rami_get_file_url($img);
        } else {
            return rami_get_file_url("profile/default/rami_profile.png");
        }
    }
}

// berfor using this helper storage fascade is needed
if (!function_exists('rami_file_uploading')) {
    function rami_file_uploading($file, $type, $id, $prv_file)
    {
        if ($type == 'location') {
            $dir = 'loc';
        } elseif ($type == 'airline') {
            $dir = 'airline';
        } elseif ($type == 'hotel') {
            $dir = 'hotel';
        } elseif ($type == 'room') {
            $dir = 'room';
        } elseif ($type == 'user') {
            $dir = 'profile';
        } elseif ($type == 'page') {
            $dir = 'page';
        } elseif ($type == 'brand') {
            $dir = 'brand';
        } elseif ($type == 'card') {
            $dir = 'card';
        } elseif ($type == 'gallery') {
            $dir = 'gallery';
        } else {
            $dir = 'other';
        }
        if (!empty($prv_file)) {
            Storage::delete($prv_file);
        }
        $extension = $file->extension();
        $file_name = $id . '_' . $type . '_' . strtotime(date('d-m-Y H:i:s')) . rand(01, 100) . '.' . $extension;
        return Storage::putFileAs($dir, new File($file), $file_name);
    }
}

if (!function_exists('rami_get_least_package')) {
    function rami_get_least_package($combination)
    {
        $idx = -1;
        $a = explode("&", $combination);
        if (isset($a[1])) {
            $b = explode("-", $a[1]);
            $idx = $b[0] - $b[1];
        }
        return $idx;
    }
}

if (!function_exists('rami_get_file_url')) {
    function rami_get_file_url($file)
    {
        if (empty($file)) {
            return '';
        }

        $url = Storage::url($file);
        return $url;
    }

}

if (!function_exists('rami_get_file_delete')) {
    function rami_get_file_delete($file)
    {
        if (empty($file)) {
            return '';
        }
        Storage::delete($file);
        return '';
    }
}

if (!function_exists('cal_distance_bw_two_points')) {
    function cal_distance_bw_two_points($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }
}

if (!function_exists('get_rami_setting')) {
    function get_rami_setting($setting)
    {
        $set_value = setting::get_rami_setting($setting);
        return $set_value;
    }
}
if (!function_exists('get_rami_page_placeholder')) {
    function get_rami_page_placeholder($name, $type)
    {
        $set_value = page_palcehloder::get_page_placeholder($name, 1);
        return $set_value;
    }
}

if (!function_exists('rami_setup_backend_language')) {
    function rami_setup_backend_language()
    {
        $backend_lang = get_rami_setting('backend_lang');
        $lang_array = array('en', 'he');
        if (in_array($backend_lang, $lang_array)) {
            App::setLocale($backend_lang);
        } else {
            App::setLocale('he');
        }

    }
}
if (!function_exists('rami_get_backend_language_dir')) {
    function rami_get_backend_language_dir()
    {
        $backend_lang_dir = get_rami_setting('backend_lang_direction');
        return $backend_lang_dir;

    }
}
if (!function_exists('rami_get_langauage_dir')) {
    function rami_get_langauage_dir($lang)
    {
        if ($lang == 'en') {
            return 'ltr';
        } elseif ($lang == 'he') {
            return 'rtl';
        } else {
            return 'ltr';
        }

    }
}

if (!function_exists('rami_check_backend_language_dir_rtl')) {
    function rami_check_backend_language_dir_rtl()
    {
        $dir = rami_get_backend_language_dir();
        if ($dir == 'rtl') {
            return 1;
        } else {
            return 0;
        }

    }
}

if (!function_exists('get_loctions_by_parent_id')) {
    function get_loctions_by_parent_id($loc_par)
    {
        return Location::where('loc_par', $loc_par)->get();
    }
}
if (!function_exists('get_loctions_child_option')) {
    function get_loctions_child_option($loc_par, $selected = "", $select_name = '', $level = 1)
    {
        $child_locations = get_loctions_by_parent_id($loc_par);
        $new_level = $level + 1;
        $option = '';
        if (!empty(old($select_name))) {
            $selected = old($select_name);
        }
        foreach ($child_locations as $child_location) {
            if ($child_location->id == $loc_par) {
                break;
            }
            $space = "";
            for ($i = 1; $i <= $level; $i++) {
                $space .= '--';
            }
            $select = '';
            if ($selected == $child_location->id) {
                $select = 'selected="true"';
            }
            $option .= '<option value="' . $child_location->id . '" ' . $select . '>' . $space . '&nbsp;' . $child_location->loc_name . '</option>';
            $option .= get_loctions_child_option($child_location->id, $selected, $select_name, $new_level);
        }
        return $option;
    }
}
if (!function_exists('rami_get_hotel_single_image')) {
    function rami_get_hotel_single_image($hotel_id)
    {
        $images = hotel_image::where(['hotel_id' => $hotel_id])->orderBy('sequence', 'DESC')->get()->first();
        if (!empty($images)) {
            // return rami_get_file_url('ramtours/' . $images->image);
            return rami_get_file_url($images->image);
        } else {
            return url('/assets/front/images/rtah4.jpg');
        }
    }
}
if (!function_exists('rami_get_no_of_days_diff')) {
    function rami_get_no_of_days_diff($start_date, $end_date)
    {
        $no_of_days = Carbon::parse($start_date)->diffInDays($end_date);
        return $no_of_days;
    }
}
if (!function_exists('rami_get_no_of_year_diff')) {
    function rami_get_no_of_year_diff($start_date, $end_date)
    {
        $no_of_days = Carbon::parse($start_date)->diffInYears($end_date);
        return $no_of_days;
    }
}
if (!function_exists('rami_get_no_of_hours_min_diff')) {
    function rami_get_no_of_hours_min_diff($start_time, $end_time)
    {
        $diff = Carbon::parse($start_time)->diffInHours($end_time);
        $diff2 = Carbon::parse($start_time)->diffInMinutes($end_time);
        $diff2 = $diff2 % 60;
        return $diff . ':' . $diff2;
    }
}
if (!function_exists('rami_get_require_date_format')) {
    function rami_get_require_date_format($date, $format)
    {
        $new_date = Carbon::createFromFormat('Y-m-d', $date);
        return $new_date->format($format);
    }
}
if (!function_exists('rami_get_require_date_time_format')) {
    function rami_get_require_date_time_format($date, $format)
    {
        $new_date = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        return $new_date->format($format);
    }
}
if (!function_exists('rami_get_add_days_to_date')) {
    function rami_get_add_days_to_date($date, $days)
    {
        $new_date = Carbon::createFromFormat('Y-m-d', $date);
        $new_date->addDays($days);
        $new_date = $new_date->toDateString();
        return $new_date;
    }
}
if (!function_exists('rami_vacation_pkg_del_top_text')) {
    function rami_vacation_pkg_del_top_text($loc_id)
    {
        if ($loc_id == 21 || $loc_id == 53 || $loc_id == 55) {
            $text = '<ul>
                    <li> טיסה סדירה הכוללת מזוודה 23 קילו  וארוחה </li>
                    <li>דירת נופש או חדר במלון על פי בסיס האירוח</li>
                    <li> רכב שכור למשך השהייה הכולל ביטוחים.
					</li>
            </ul>';

        } elseif ($loc_id == 82) {
            $text = '<ul>
					 			<li> טיסה סדירה הכוללת מזוודה 23 קילו לאדם</li>
			                    <li>דירת נופש או חדר במלון על פי בסיס האירוח</li>
			                    <li> רכב שכור למשך השהייה הכולל ביטוחים.
								</li>
			 		</ul>';

        } else {
            $text = '';
        }
        return $text;
    }
}
if (!function_exists('rami_vacation_pkg_html')) {
    function rami_vacation_pkg_html($pkgs_fhc, $col = 3)
    {
        $hotel_id = $pkgs_fhc->package_hotel;
        $pack_loc_id = $pkgs_fhc->package_flight_location;
        $hotel_details = hotel::find($hotel_id);
        if (!empty($hotel_details)) {
            $hotel_types = unserialize($hotel_details->hotel_type);
            $hotel_types = implode('-', $hotel_types);
            $hotel_star = $hotel_details->hotel_star;
        } else {
            $hotel_types = '';
            $hotel_star = '';
        }
        $pack_loction = Location::find($pack_loc_id);
        $flight_locations = '';
        $filght_sheds = unserialize($pkgs_fhc->package_flight_sche);
        $filght_sheds = flight_schedule::find($filght_sheds[0]);
        if (!empty($filght_sheds)) {
            $flight = flight::find($filght_sheds->flight_up);
            if (!empty($flight->location_desti)) {
                $flight_locations = $flight->location_desti->loc_name;
            }
        }
        $pack_loction_name = '';
        $hotel_code = '';
        $room_reserved = get_rami_package_room_avalible_total($pkgs_fhc->id);
        $no_of_days = rami_get_no_of_days_diff($pkgs_fhc->package_start_date, $pkgs_fhc->package_end_date);
        $start_date = rami_get_require_date_format($pkgs_fhc->package_start_date, 'd/m');
        $end_date = rami_get_require_date_format($pkgs_fhc->package_end_date, 'd/m');
        if (empty($no_of_days)) {
            $no_of_days = 1;
        }
        if (empty($room_reserved)) {
            $room_reserved = 1;
        }
        if (!empty($hotel_details)) {
            $hotel_code = $hotel_details->hotel_code;
        }
        if (!empty($pack_loction->loc_name)) {
            $pack_loction_name = $pack_loction->loc_name;
        }
        $html = '';
        $html .= '	<div class="col-md-' . $col . ' flightss filterable" data-type="' . $hotel_types . '" data-star="' . $hotel_star . '">';
        $html .= '        <div class="home-product-box">';
        $html .= '          <div class="content-image clearfix">';
        if (!empty($hotel_details->card)) {
            $html .= '            <div class="cards"><img src="' . url('assets/front/images/rt-cardimg.png') . '"></div>';
        }
        // if($pkgs_fhc->instant_approval==1){
        //     $html .= '            <div class="inst-approv"><img src="' . url('assets/front/images/approval.png') . '"></div>';
        // }
        $html .= '         <a href="' . url('package/' . $pkgs_fhc->id) . '"><img width="340" height="214" src="' . rami_get_hotel_single_image($hotel_id) . '" class="img-fluid" alt=""></a>';
        $html .= '          <div class="date_code">';
        $html .= '             <div class="dates">';
        $html .= '              <span class="pack-date">';
        $html .= '              <img src="' . url('assets/front/images/frm-cal.png') . '"> ' . $start_date . '-' . $end_date . '  </span>';
        $html .= '             </div>';
        $html .= '             <div class="ref_id_cont">';
        $html .= '                <span class="ref_id">' . $hotel_code . '</span>';
        $html .= '              </div>';
        $html .= '          </div>';
        $html .= '          </div>';
        $html .= '          <div class="pakinner">';
        $html .= '            <div class="home-product-inner-box">';
        $html .= '            <div class="content-image-heading">';
        $html .= '            <span class="orange_bottom_1px">חבילת נופש ל' . $pack_loction_name . '</span>';
        $html .= '            </div>';
        $html .= '            <div class="nights">';
        $html .= '            <span class="num_nights"> טיסה ל' . $flight_locations . ' </span>';
        $html .= '           </div>';
        if ($pkgs_fhc->instant_approval == 1) {
            $html .= '<div class="immediate_approval">חבילה באישור מיידי!   </div>';
        }
        $html .= '            <div class="pack-aviable-room">';
        $html .= '            <i class="fa fa-bed" aria-hidden="true"></i> ' . $room_reserved . ' יחידות זמין במלאי </div>';
        $html .= '            <div class="location">';
        $html .= '            </div>';
        $html .= '            </div>';
        $html .= '          </div>';
        $html .= '          <div class="content-box-rate">';
        $html .= '          <div class="rate-sec">';
        $html .= '            <div class="rate-box">';
        $html .= '            <span>החל מ </span>€' . $pkgs_fhc->package_lowest_price . '<span>לאדם</span>';
        $html .= '          <span class="pack-nights">' . $no_of_days . ' לילות </span></div>';
        $html .= '          </div>';
        $html .= '          <div class="content-box-line"></div>';
        $html .= '          </div>';
        $html .= '         </div>';
        $html .= '    </div>';
        return $html;
    }
}
if (!function_exists('rami_vacation_pkg_mobile_html')) {
    function rami_vacation_pkg_mobile_html($pkgs_fhc)
    {
        $hotel_id = $pkgs_fhc->package_hotel;
        $pack_loc_id = $pkgs_fhc->package_flight_location;
        $hotel_details = hotel::find($hotel_id);
        $hotel_types = unserialize($hotel_details->hotel_type);
        $hotel_types = implode('-', $hotel_types);
        $pack_loction = Location::find($pack_loc_id);
        $pack_loction_name = '';
        $hotel_code = '';
        $room_reserved = get_rami_package_room_avalible_total($pkgs_fhc->id);
        $flight_locations = '';
        $filght_sheds = unserialize($pkgs_fhc->package_flight_sche);
        $filght_sheds = flight_schedule::find($filght_sheds[0]);
        if (!empty($filght_sheds)) {
            $flight = flight::find($filght_sheds->flight_up);
            if (!empty($flight->location_desti)) {
                $flight_locations = $flight->location_desti->loc_name;
            }
        }
        $no_of_days = rami_get_no_of_days_diff($pkgs_fhc->package_start_date, $pkgs_fhc->package_end_date);
        $start_date = rami_get_require_date_format($pkgs_fhc->package_start_date, 'd/m');
        $end_date = rami_get_require_date_format($pkgs_fhc->package_end_date, 'd/m');
        if (empty($no_of_days)) {
            $no_of_days = 1;
        }
        if (empty($room_reserved)) {
            $room_reserved = 1;
        }
        if (!empty($hotel_details)) {
            $hotel_code = $hotel_details->hotel_code;
        }
        if (!empty($pack_loction->loc_name)) {
            $pack_loction_name = $pack_loction->loc_name;
        }
        $html = '<div class="rt-packframes filterable"  data-type="' . $hotel_types . '" data-star="' . $hotel_details->hotel_star . '">';
        $html .= '	<div class="frm-left col-6 col-sm-6">';
        $html .= '         <div class="content-image-heading">';
        $html .= '               <h5>חבילת נופש ל' . $pack_loction_name . ' </h5>';
        $html .= '          </div>';
        $html .= '          <div class="nights">';
        $html .= '               <p>טיסה ל' . $flight_locations . '  </p>';
        $html .= '           </div>';
        if ($pkgs_fhc->instant_approval == 1) {
            $html .= '<div class="immediate_approval">חבילה באישור מיידי!   </div>';
        }
        $html .= '           <div class="pack-aviable-room">';
        $html .= '                <p><i class="fa fa-bed" aria-hidden="true"></i> ' . $room_reserved . ' יחידות זמין במלאי </p>';
        $html .= '            </div>';
        $html .= '            <div class="package-date">';
        $html .= '                   <p><i class="fa fa-calendar" aria-hidden="true"></i> ' . $start_date . '-' . $end_date . ' </p>';
        $html .= '            </div>';
        $html .= '             <div class="ref_id_cont">';
        $html .= '                  <p>' . $hotel_code . '</p>';
        $html .= '             </div>';
        $html .= '      </div>';
        $html .= '      <div class="frm-right col-6 col-sm-6">';
        if (!empty($hotel_details->card)) {
            $html .= '                <div class="cards"><img src="' . url('assets/mobile/images/rt-cardmobimg.png') . '" alt="" class="img-fluid"></div>';
        }
        //      if($pkgs_fhc->instant_approval==1){
        //     $html .= '            <div class="inst-approv"><img src="' . url('assets/front/images/approval.png') . '"></div>';
        // }
        $html .= '                <a href="' . url('package/' . $pkgs_fhc->id) . '"> <img src="' . rami_get_hotel_single_image($hotel_id) . '" alt="" class="img-fluid"></a>';
        $html .= '                <div class="rt-price"><span>€' . $pkgs_fhc->package_lowest_price . '</span></div>';
        $html .= '            </div>';
        $html .= '        </div>';
        return $html;
    }
}
if (!function_exists('rami_get_first_package_for_flight')) {
    function rami_get_first_package_for_flight($flight_id)
    {
        $p = package::where('package_status', 1)->where('package_flight_sche', 'like', "%i:$flight_id%")->first();
        return $p ? $p->package_profit_fhc : "";
    }
}
if (!function_exists('rami_fly_drive_pkg_mobile_html')) {
    function rami_fly_drive_pkg_mobile_html($pkgs_fhc)
    {
        $pack_loc_id = $pkgs_fhc->package_flight_location;
        $pack_loction = Location::find($pack_loc_id);
        $pack_loction_name = '';
        $no_of_days = rami_get_no_of_days_diff($pkgs_fhc->package_start_date, $pkgs_fhc->package_end_date);
        $start_date = rami_get_require_date_format($pkgs_fhc->package_start_date, 'd/m');
        $end_date = rami_get_require_date_format($pkgs_fhc->package_end_date, 'd/m');
        if (empty($no_of_days)) {
            $no_of_days = 1;
        }
        if (!empty($pack_loction->loc_name)) {
            $pack_loction_name = $pack_loction->loc_name;
        }
        $flight_locations = '';
        $filght_sheds = unserialize($pkgs_fhc->package_flight_sche);
        $filght_sheds = flight_schedule::find($filght_sheds[0]);
        if (!empty($filght_sheds)) {
            $flight = flight::find($filght_sheds->flight_up);
            if (!empty($flight->location_desti)) {
                $flight_locations = $flight->location_desti->loc_name;
            }
        }
        $html = '';
        $html .= '<div class="rt-packframes filterable">';
        $html .= '     <div class="frm-left col-6 col-sm-6">';
        $html .= '        <div class="fly-head">';
        $html .= '           <h5>חבילת נופש ל' . $pack_loction_name . ' &nbsp;</h5>';
        $html .= '        </div>';
        $html .= '        <div class="nights">';
        $html .= '           <p >טיסה ל' . $flight_locations . ' &nbsp;</p>';
        $html .= '        </div>';
        $html .= '        <div class="package-date">';
        $html .= '           <p><i class="fa fa-calendar" aria-hidden="true"></i> ' . $start_date . '-' . $end_date . '   &nbsp;</p>';
        $html .= '        </div>';
        $html .= '     </div>';
        if ($pkgs_fhc['instant_approval'] == 1) {
            $html .= '     <div class="frm-right col-6 col-sm-6">';
            $html .= '        <div class="inst-approv"><i class="fa fa-credit-card-alt" aria-hidden="true"></i></div>';
        }
        $html .= '        <a href="' . url('fly-travel-package/' . $pkgs_fhc->id) . '"><img src="' . url('assets/mobile/images/driveandfly1.gif') . '" alt="" class="img-fluid"></a>';
        $html .= '        <div class="rt-price"><span>€' . $pkgs_fhc->package_lowest_price . '</span></div>';
        $html .= '     </div>';
        $html .= '  </div>';
        return $html;
    }
}
if (!function_exists('rami_fly_drive_pkg_html')) {
    function rami_fly_drive_pkg_html($pkgs_fhc)
    {
       //dd($pkgs_fhc->package_lowest_price);
        $pack_loc_id = $pkgs_fhc->package_flight_location;
        $pack_loction = Location::find($pack_loc_id);
        $pack_loction_name = '';
        $no_of_days = rami_get_no_of_days_diff($pkgs_fhc->package_start_date, $pkgs_fhc->package_end_date);
        $start_date = rami_get_require_date_format($pkgs_fhc->package_start_date, 'd/m');
        $end_date = rami_get_require_date_format($pkgs_fhc->package_end_date, 'd/m');
        if (empty($no_of_days)) {
            $no_of_days = 1;
        }
        if (!empty($pack_loction->loc_name)) {
            $pack_loction_name = $pack_loction->loc_name;
        }
        $flight_locations = '';
        $filght_sheds = unserialize($pkgs_fhc->package_flight_sche);
        $filght_sheds = flight_schedule::find($filght_sheds[0]);
        if (!empty($filght_sheds)) {
            $flight = flight::find($filght_sheds->flight_up);
            if (!empty($flight->location_desti)) {
                $flight_locations = $flight->location_desti->loc_name;
            }
        }
        $html = '';
        $html .= '	<div class="col-md-3 flightss pkgs filterable">';
        $html .= '        <div class="home-product-box">';
        $html .= '          <div class="content-image clearfix">';
        if ($pkgs_fhc['instant_approval'] == 1) {
            $html .= '            <div class="rt_approval"><img src="' . url('assets/front/images/approval.png') . '"></div>';
        }
        $html .= '           <a href="' . url('fly-travel-package/' . $pkgs_fhc->id) . '"><img width="340" height="214" src="' . url('assets/front/images/driveandfly1.gif') . '" class="img-fluid" alt=""></a>';
        $html .= '           <div class="date_code">';
        $html .= '             <div class="dates">';
        $html .= '              <span class="pack-date">';
        $html .= '              <img src="' . url('assets/front/images/frm-cal.png') . '"> ' . $start_date . '-' . $end_date . '  </span>';
        $html .= '             </div>';
        $html .= '           </div>';
        $html .= '          </div>';
        $html .= '          <div class="pakinner">';
        $html .= '            <div class="home-product-inner-box">';
        $html .= '            <div class="content-image-heading">';
        $html .= '            <span class="orange_bottom_1px">חבילת טוס וסע ' . $pack_loction_name . ' <span>';
        $html .= '            </div>';
        $html .= '            <div class="nights">';
        $html .= '            <span class="num_nights">ט טיסה ל  ' . $flight_locations . ' </span>';
        $html .= '            </div>';
        $html .= '            <div class="immediate_approval">
                חבילה באישור מיידי! </div>';
        $html .= '            </div>';
        $html .= '          </div>';
        $html .= '          <div class="content-box-rate">';
        $html .= '          <div class="rate-sec">';
        $html .= '            <div class="rate-box">';
        $html .= '            <span>החל מ </span>€' . $pkgs_fhc->package_lowest_price . '<span>לאדם</span>';
        $html .= '          <span class="pack-nights">' . $no_of_days . ' לילות  </span>';
        $html .= '          </div>';
        $html .= '          </div>';
        $html .= '          <div class="content-box-line"></div>';
        $html .= '          </div>';
        $html .= '         </div>';
        $html .= '	</div>';
        return $html;
    }
}
if (!function_exists('rami_flight_pkg_html')) {
    function rami_flight_pkg_html($filght_she)
    {
        $airline = airline::find($filght_she->airline_up);
        $airline_logo = url('/assets/front/images/luftansa.jpg');
        if (!empty($airline)) {
            $airline_logo = url('ramtours/' . $airline->airl_logo_img);
        }
        $flight_up = flight::find($filght_she->flight_up);
        $flight_down = flight::find($filght_she->flight_down);
        $flight_up_desti = '';
        if (!empty($flight_up->location_desti)) {
            $flight_up_desti = $flight_up->location_desti->loc_name;
        }

        $flight_down_source = '';
        if (!empty($flight_down->location_source)) {
            $flight_down_source = $flight_down->location_source->loc_name;
        }

        $start_date = rami_get_require_date_time_format($filght_she->up_departure_time, 'd-m-Y');
        $end_date = rami_get_require_date_time_format($filght_she->down_departure_time, 'd-m-Y');
        $html = '';
        $html .= '<div class="col-md-3 flightss rt_flight_view">';
        $html .= '      <div class="home-product-box">';
        $html .= '      <div class="content-image clearfix">';
        $html .= '      <a href="' . url('flight-detail/' . $filght_she->id) . '"><img width="340" height="214" src="' . $airline_logo . '" class="img-fluid" alt=""></a>';
        $html .= '      <div class="date_code">';
        $html .= '
               <div class="dates">';
        $html .= '       <span class="pack-date">';
        $html .= '      <img src="' . url('/assets/front/images/frm-cal.png') . '"> ' . $start_date . '-' . $end_date . '  </span>
                 </div>';
        $html .= '      </div>
              </div>
              <div class="pakinner">';
        $html .= '        <div class="home-product-inner-box">';
        $html .= '          <div class="flight_to">הלוך:טיסה ל ' . $flight_up_desti . '</div>';
        $html .= '          <div class="flight_return">חזור: טיסה מ ' . $flight_down_source . '</div> ';
        $html .= '       </div>
              </div>
              <div class="content-box-rate"> ';
        $html .= '      <div class="rate-sec">
                <div class="rate-box">
                $' . get_rami_flight_price_for_single_flight($filght_she->id) . ' <span>לאדם</span>
              </div>';
        $html .= '     <div class="flt_book"><a href="' . url('flight-detail/' . $filght_she->id) . '" class="flt_book_btn">להזמין עכשיו</a></div>
              </div>';
        $html .= '      <div class="content-box-line"></div>
              </div>
             </div>
        </div>';
        return $html;
    }
}
if (!function_exists('rami_flights_page_html')) {
    function rami_flights_page_html($filght_she)
    {
        $airline = airline::find($filght_she->airline_up);
        $airline_logo = url('assets/front/images') . '/luftansa.jpg';
        if (!empty($airline)) {
            $airline_logo = url('ramtours/' . $airline->airl_logo_img);
        }
        $location_png = url('/assets/front/images') . '/flt-location.png';
        $calender_png = url('/assets/front/images') . '/flt-calnder.png';
        $flight_up = flight::find($filght_she->flight_up);
        $up_airline_name = $filght_she->airline_name->airl_name_eng;
        $up_desti = get_location_name($filght_she->flight_name->flight_desti);
        $up_source = get_location_name($filght_she->flight_name->flight_source);
        $up_depart_full_date = rami_get_require_date_time_format($filght_she->up_departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($filght_she->up_departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($filght_she->up_departure_time, 'Y');
        $up_arrival_time = rami_get_require_date_time_format($filght_she->up_arrival_time, 'H:i');
        $up_arrival_time_in_month_date = rami_get_require_date_time_format($filght_she->up_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($filght_she->up_arrival_time, 'm'));
        $up_departure_time = rami_get_require_date_time_format($filght_she->up_departure_time, 'H:i');
        $up_departure_time_in_month_date = rami_get_require_date_time_format($filght_she->up_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($filght_she->up_departure_time, 'm'));
        $flight_up_desti = $flight_up->location_desti->loc_name;
        $flight_down = flight::find($filght_she->flight_down);
        $flight_down_source = $flight_down->location_source->loc_name;
        $start_date = rami_get_require_date_time_format($filght_she->up_departure_time, 'd-m-Y');
        $end_date = rami_get_require_date_time_format($filght_she->down_departure_time, 'd-m-Y');
        $back_full_date = rami_get_require_date_time_format($filght_she->down_departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($filght_she->down_departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($filght_she->down_departure_time, 'Y');
        $down_airline_name = $filght_she->airline_name_down->airl_name_eng;
        $down_desti = get_location_name($filght_she->flight_name_down->flight_desti);
        $down_source = get_location_name($filght_she->flight_name_down->flight_source);
        $down_departure_time = rami_get_require_date_time_format($filght_she->down_departure_time, 'H:i');
        $down_departure_time_in_month_date = rami_get_require_date_time_format($filght_she->down_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($filght_she->down_departure_time, 'm'));
        $down_arrival_time = rami_get_require_date_time_format($filght_she->down_arrival_time, 'H:i');
        $down_arrival_time_in_month_date = rami_get_require_date_time_format($filght_she->down_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($filght_she->down_arrival_time, 'm'));
        $html = '';
        $html .= '<div class="row flt_header filterable" data-flightType="' . $flight_up->flight_type . '" data-month="' . rami_get_require_date_time_format($filght_she->up_departure_time, "m") . '" data-airline="' . $filght_she->airline_up . '">';
        $html .= '   <div class="col-md-6 fltdlt">';
        $html .= '        <div class="row">';
        $html .= '		            <div class="col-md-12">';
        $html .= '		            <div class="flt-dates">';
        $html .= '		              <ul>';
        $html .= '              <li><img src="' . $location_png . '"> יעד :' . $up_desti . ' </li>';
        $html .= '              <li><img src="' . $calender_png . '">' . $start_date . '-' . $end_date . '</li>';
        $html .= '		              </ul>';
        $html .= '		            </div>';
        $html .= '		            </div>';
        $html .= '		        </div>';

        if ($filght_she->flight_type_up == 2) {
            $flight_conn_up = flight_schedule_connection::where([['type', 1], ['flight_schedule_id', $filght_she->id]])->orderBy('departure_time', 'asc')->get();
            foreach ($flight_conn_up as $flight) {
                $flight_depart_full_date = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                $flight_airline_name = $flight->flight->airline_name->airl_name_eng;
                $flight_airline_logo = $flight->flight->airline_name->airl_logo_img;
                $flight_departure_time = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                $flights_departure_time_in_month_date = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                $flights_arrival_time = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                $flights_arrival_time_in_month_date = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                $flights_desti = $flight->flight->location_desti->loc_name;
                $flights_source = $flight->flight->location_source->loc_name;

                $html .= '        <div class="row fltdtss">';
                $html .= '		            <div class="col-md-12">';
                $html .= '		              <ul>';
                $html .= '		                <li><strong>יציאה  :</strong>' . $flight_depart_full_date . '</li>';
                $html .= '		                <li>' . $flight_airline_name . '</li>';
                $html .= '		              </ul>';
                $html .= '		            </div> ';
                $html .= '		        </div>';
                $html .= '       <div class="row fltinff">  ';
                $html .= '	                <div class="col-md-3 flt-img"><img src="' . url('ramtours/' . $flight_airline_logo) . '" class="img-fluid"></div>';
                $html .= '	                <div class="col-md-3 tf1"> ';
                $html .= '	                ' . $flights_source . '<span class="rt_tmm">' . $flight_departure_time . '</span>' . $flights_departure_time_in_month_date;
                $html .= '	            </div>';
                $html .= '           <div class="col-md-3 flight-take-off ftbord">
							            שעות  <span class="flt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>';
                $html .= '			        </div>';
                $html .= '			        <div class="col-md-3 tf2"> ';
                $html .= '			            ' . $flights_desti . '<span class="rt_tmm">' . $flights_arrival_time . '</span>' . $flights_arrival_time_in_month_date;
                $html .= '			        </div>';
                $html .= '       </div>';
            }

        } else {
            $html .= '        <div class="row fltdtss">';
            $html .= '		            <div class="col-md-12">';
            $html .= '		              <ul>';
            $html .= '		                <li><strong>יציאה  :</strong>' . $up_depart_full_date . '</li>';
            $html .= '		                <li>' . $up_airline_name . '</li>';
            $html .= '		              </ul>';
            $html .= '		            </div> ';
            $html .= '		        </div>';
            $html .= '       <div class="row fltinff">  ';
            $html .= '	                <div class="col-md-3 flt-img"><img src="' . $airline_logo . '" class="img-fluid"></div>';
            $html .= '	                <div class="col-md-3 tf1"> ';
            $html .= '	                ' . $up_source . '<span class="rt_tmm">' . $up_departure_time . '</span>' . $up_departure_time_in_month_date;
            $html .= '	            </div>';
            $html .= '           <div class="col-md-3 flight-take-off ftbord">
							            שעות  <span class="flt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>';
            $html .= '			        </div>';
            $html .= '			        <div class="col-md-3 tf2"> ';
            $html .= '			            ' . $up_desti . '<span class="rt_tmm">' . $up_arrival_time . '</span>' . $up_arrival_time_in_month_date;
            $html .= '			        </div>';
            $html .= '       </div>';

        }
        $html .= '    </div>';
        $html .= '    <div class="col-md-6 fltdlt">';
        $html .= '       <div class="row">';
        $html .= '		            <div class="col-md-12">';
        $html .= '		              <div class="flt-btnn"><a href="' . url('flight-detail/' . $filght_she->id) . '" class="flt-book"> המשך להזמנה   </a> </div>';
        $html .= '		              <div class="flt-price"> $' . get_rami_flight_price_for_single_flight($filght_she->id) . ' <span class="fltunit">לאדם  </span></div>';
        $html .= '		            </div>';
        $html .= '		        </div>';
        if ($filght_she->flight_type_down == 2) {
            $flight_conn_up = flight_schedule_connection::where([['type', 2], ['flight_schedule_id', $filght_she->id]])->orderBy('departure_time', 'asc')->get();
            foreach ($flight_conn_up as $flight) {
                $flight_depart_full_date = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                $flight_airline_name = $flight->flight->airline_name->airl_name_eng;
                $flight_airline_logo = $flight->flight->airline_name->airl_logo_img;
                $flight_departure_time = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                $flights_departure_time_in_month_date = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                $flights_arrival_time = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                $flights_arrival_time_in_month_date = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                $flights_desti = $flight->flight->location_desti->loc_name;
                $flights_source = $flight->flight->location_source->loc_name;
                $html .= '        <div class="row fltdtss">';
                $html .= '		            <div class="col-md-12">';
                $html .= '		              <ul>';
                $html .= '		                <li><strong>יציאה  :</strong>' . $flight_depart_full_date . '</li>';
                $html .= '		                <li>' . $flight_airline_name . '</li>';
                $html .= '		              </ul>';
                $html .= '		            </div> ';
                $html .= '		        </div>';
                $html .= '       <div class="row fltinff">  ';
                $html .= '	                <div class="col-md-3 flt-img"><img src="' . url('ramtours/' . $flight_airline_logo) . '" class="img-fluid"></div>';
                $html .= '	                <div class="col-md-3 tf1"> ';
                $html .= '	                ' . $flights_source . '<span class="rt_tmm">' . $flight_departure_time . '</span>' . $flights_departure_time_in_month_date;
                $html .= '	            </div>';
                $html .= '           <div class="col-md-3 flight-take-off ftbord">
							            שעות  <span class="flt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>';
                $html .= '			        </div>';
                $html .= '			        <div class="col-md-3 tf2"> ';
                $html .= '			            ' . $flights_desti . '<span class="rt_tmm">' . $flights_arrival_time . '</span>' . $flights_arrival_time_in_month_date;
                $html .= '			        </div>';
                $html .= '       </div>';
            }

        } else {
            $html .= '        <div class="row fltdtss">';
            $html .= '		            <div class="col-md-12">';
            $html .= '		              <ul>';
            $html .= '		                <li><strong>חזור  :</strong>' . $back_full_date . '</li>';
            $html .= '		                <li>' . $down_airline_name . '</li>';
            $html .= '		              </ul>';
            $html .= '		            </div>  ';
            $html .= '		        </div>';
            $html .= '        <div class="row fltinff"> ';
            $html .= '		            <div class="col-md-3 flt-img"><img src="' . $airline_logo . '" class="img-fluid">';
            $html .= '		            </div>';
            $html .= '		            <div class="col-md-3 tf1">  ';
            $html .= '		              ' . $down_source . '<span class="rt_tmm"> ' . $down_departure_time . '</span>' . $down_departure_time_in_month_date;
            $html .= '		            </div>';
            $html .= '		            <div class="col-md-3 flight-take-off ftbord">
						            שעות  ';
            $html .= '		              <span class="flt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>';
            $html .= '		            </div>';
            $html .= '		            <div class="col-md-3 tf2">   ';
            $html .= '		              ' . $down_desti . '<span class="rt_tmm"> ' . $down_arrival_time . '</span>' . $down_arrival_time_in_month_date;
            $html .= '		            </div>';
            $html .= '        </div>';

        }
        $html .= '    </div>';
        $html .= '</div>';
        return $html;
    }
}
if (!function_exists('rami_flights_mobile_page_html')) {
    function rami_flights_mobile_page_html($filght_she)
    {
        $airline = airline::find($filght_she->airline_up);
        $airline_logo = url('assets/mobile/images') . '/luftansa.jpg';
        if (!empty($airline)) {
            $airline_logo = url('ramtours/' . $airline->airl_logo_img);
        }
        $flight_up = flight::find($filght_she->flight_up);
        $up_airline_name = $filght_she->airline_name->airl_name_eng;
        $up_desti = get_location_name($filght_she->flight_name->flight_desti);
        $up_source = get_location_name($filght_she->flight_name->flight_source);
        $up_depart_full_date = rami_get_require_date_time_format($filght_she->up_departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($filght_she->up_departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($filght_she->up_departure_time, 'Y');
        $up_arrive_full_date = rami_get_require_date_time_format($filght_she->up_arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($filght_she->up_arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($filght_she->up_arrival_time, 'Y');
        $up_arrival_time = rami_get_require_date_time_format($filght_she->up_arrival_time, 'H:i');
        $up_departure_time = rami_get_require_date_time_format($filght_she->up_departure_time, 'H:i');
        $up_time_taken = rami_get_no_of_hours_min_diff($filght_she->up_departure_time, $filght_she->up_arrival_time);
        $flight_up_desti = $flight_up->location_desti->loc_name;
        $flight_down = flight::find($filght_she->flight_down);
        $flight_down_source = $flight_down->location_source->loc_name;
        $start_date = rami_get_require_date_time_format($filght_she->up_departure_time, 'd-m-Y');
        $end_date = rami_get_require_date_time_format($filght_she->down_departure_time, 'd-m-Y');
        $down_airline_name = $filght_she->airline_name_down->airl_name_eng;
        $down_desti = get_location_name($filght_she->flight_name_down->flight_desti);
        $down_source = get_location_name($filght_she->flight_name_down->flight_source);
        $down_arrive_full_date = rami_get_require_date_time_format($filght_she->down_arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($filght_she->down_arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($filght_she->down_arrival_time, 'Y');
        $down_depart_full_date = rami_get_require_date_time_format($filght_she->down_arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($filght_she->down_arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($filght_she->down_arrival_time, 'Y');
        $down_departure_time = rami_get_require_date_time_format($filght_she->down_departure_time, 'H:i');
        $down_arrival_time = rami_get_require_date_time_format($filght_she->down_arrival_time, 'H:i');
        $down_time_taken = rami_get_no_of_hours_min_diff($filght_she->down_departure_time, $filght_she->down_arrival_time);
        $html = '';
        $html .= '<div class="col-sm-12 flt-inner pkgflt_secc">';
        $html .= '          <div class="flights-details-box-inner flt_header">';
        $html .= '             <div class="flight-payment">';
        $html .= '                <div class="flt-dates">';
        $html .= '                   <ul>';
        $html .= '                      <li><img src="' . url('assets/mobile') . '/images/flt-location.png">יעד :' . $up_desti . '</li>';
        $html .= '                      <li><img src="' . url('assets/mobile') . '/images/flt-calnder.png">' . $start_date . '-' . $end_date . '</li>';
        $html .= '                   </ul>';
        $html .= '                </div>';
        $html .= '                <div class="ftbtnsec">';
        $html .= '                   <div class="flt-price">$' . get_rami_flight_price_for_single_flight($filght_she->id) . '<span class="fltunit">לאדם</span></div>';
        $html .= '                   <div class="flt-btnn"><a href="' . url('flight-detail/' . $filght_she->id) . '" class="flt-book">המשך להזמנה </a> </div>';
        $html .= '                </div>';
        $html .= '             </div>';
        $html .= '             <div class="clear"></div>';
        $html .= '             <div class="flight-tophead">';
        $html .= '                <div class="flight-date">יעד :' . $up_desti . '</div>';
        $html .= '                <div class="flights-headings">' . $up_airline_name . '</div>';
        $html .= '             </div>';
        $html .= '             <div class="clear"></div>';
        if ($filght_she->flight_type_up == 2) {
            $flight_conn_up = flight_schedule_connection::where([['type', 1], ['flight_schedule_id', $filght_she->id]])->orderBy('departure_time', 'asc')->get();
            foreach ($flight_conn_up as $flight) {
                $flight_depart_full_date = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                $flight_airline_name = $flight->flight->airline_name->airl_name_eng;
                $flight_airline_logo = $flight->flight->airline_name->airl_logo_img;
                $flight_departure_time = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                $flights_departure_time_in_month_date = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                $flights_arrival_time = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                $flights_arrival_time_in_month_date = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                $flight_arrival_full_date = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->arrival_time, 'Y');
                $flights_desti = $flight->flight->location_desti->loc_name;
                $flights_source = $flight->flight->location_source->loc_name;
                $time_taken = rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                $html .= '             <div class="flight-secc top">';
                $html .= '                <div class="flights-icon"><img width="262" height="165" src="' . $flight_airline_logo . '" class="img-fluid" alt=""> </div>';
                $html .= '                <div class="flight-text-box tf1">' . $flights_source . '<span class="rt_tmm">' . $flight_departure_time . '</span>';
                $html .= '                   <span class="rt_dts">' . $flight_depart_full_date . '</span>
		                        </div>';
                $html .= '                <div class="flight-take-off ftbord">
		                           שעות ' . $time_taken . '
		                           <span class="rt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>';
                $html .= '                </div>';
                $html .= '                <div class="flight-text-box tf2">' . $flights_desti . '<span class="rt_tmm">' . $flights_arrival_time . '</span><span class="rt_dts">' . $flight_arrival_full_date . '</span>
		                        </div>';
                $html .= '                <div class="clear"></div>';
                $html .= '             </div>';
            }

        } else {
            $html .= '             <div class="flight-secc top">';
            $html .= '                <div class="flights-icon"><img width="262" height="165" src="' . $airline_logo . '" class="img-fluid" alt=""> </div>';
            $html .= '                <div class="flight-text-box tf1">' . $up_source . '<span class="rt_tmm">' . $up_departure_time . '</span>';
            $html .= '                   <span class="rt_dts">' . $up_depart_full_date . '</span>
	                        </div>';
            $html .= '                <div class="flight-take-off ftbord">
	                           שעות ' . $up_time_taken . '
	                           <span class="rt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>';
            $html .= '                </div>';
            $html .= '                <div class="flight-text-box tf2">' . $up_desti . '<span class="rt_tmm">' . $up_arrival_time . '</span><span class="rt_dts">' . $up_arrive_full_date . '</span>
	                        </div>';
            $html .= '                <div class="clear"></div>';
            $html .= '             </div>';

        }
        $html .= '<div class="flight-tophead flts_border"></div>';
        $html .= '             <div class="clear"></div>';
        if ($filght_she->flight_type_down == 2) {
            $flight_conn_up = flight_schedule_connection::where([['type', 2], ['flight_schedule_id', $filght_she->id]])->orderBy('departure_time', 'asc')->get();
            foreach ($flight_conn_up as $flight) {
                $flight_depart_full_date = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                $flight_airline_name = $flight->flight->airline_name->airl_name_eng;
                $flight_airline_logo = $flight->flight->airline_name->airl_logo_img;
                $flight_departure_time = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                $flights_departure_time_in_month_date = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                $flights_arrival_time = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                $flights_arrival_time_in_month_date = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                $flight_arrival_full_date = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->arrival_time, 'Y');
                $flights_desti = $flight->flight->location_desti->loc_name;
                $flights_source = $flight->flight->location_source->loc_name;
                $time_taken = rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                $html .= '             <div class="flight-secc bottom">';
                $html .= '                <div class="flights-icon"><img width="262" height="165" src="' . $flight_airline_logo . '" class="img-fluid" alt=""> </div>';
                $html .= '                <div class="flight-text-box td1">' . $flights_source . '<span class="rt_tmm">' . $flight_departure_time . '</span><span class="rt_dts">' . $flight_depart_full_date . '</span>';
                $html .= '                </div>';
                $html .= '                <div class="flight-take-off ftbord">
		                           שעות  ' . $time_taken . '
		                           <span class="rt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>';
                $html .= '                </div>';
                $html .= '                <div class="flight-text-box td2">' . $flights_desti . '<span class="rt_tmm">' . $flights_arrival_time . '</span><span class="rt_dts">' . $flight_arrival_full_date . '</span>';
                $html .= '                </div>';
                $html .= '                <div class="clear"></div>';
                $html .= '             </div>';
            }
        } else {

            $html .= '             <div class="flight-secc bottom">';
            $html .= '                <div class="flights-icon"><img width="262" height="165" src="' . $airline_logo . '" class="img-fluid" alt=""> </div>';
            $html .= '                <div class="flight-text-box td1">' . $down_source . '<span class="rt_tmm">' . $down_departure_time . '</span><span class="rt_dts">' . $down_depart_full_date . '</span>';
            $html .= '                </div>';
            $html .= '                <div class="flight-take-off ftbord">
	                           שעות  ' . $down_time_taken . '
	                           <span class="rt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>';
            $html .= '                </div>';
            $html .= '                <div class="flight-text-box td2">' . $down_desti . '<span class="rt_tmm">' . $down_arrival_time . '</span><span class="rt_dts">' . $down_arrive_full_date . '</span>';
            $html .= '                </div>';
            $html .= '                <div class="clear"></div>';
            $html .= '             </div>';

        }
        $html .= '          </div>';
        $html .= '       </div>';
        return $html;
    }
}
if (!function_exists('rami_package_hotel_filter_html')) {
    function rami_package_hotel_filter_html($is_mobile = 0)
    {
        if ($is_mobile == 1) {
            $display = 'style="display:none"';
        } else {
            $display = '';
        }
        $hotel_amenities = hotel_amenity::all();
        $features = hotel_feature::all();
        $types = hotel_type::all();
        $html = '<div class="col-md-3">';
        $html .= '<div class="filters_panel">';
        $html .= '	<div class="cap" ' . $display . '>';
        $html .= '		<label>סינון על פי קטגוריות:</label>';
        $html .= '	</div>';

        $html .= '	<div class="filter_group" data-param="type">';
        $html .= '		<label class="type">סוג המלון </label>';
        foreach ($types as $type) {
            $html .= '		<div class="filter_cont custom-control custom-checkbox">';
            $html .= '			<input type="checkbox" class="custom-control-input filter_checkbox" id="h-type-' . $type->id . '" value="' . $type->id . '">';
            $html .= '			<label class="custom-control-label" for="h-type-' . $type->id . '">' . $type->hotel_type . '</label>';
            $html .= '		</div>';
        }
        $html .= '	</div>';

        $html .= '	<div class="filter_group" data-param="star">';
        $html .= '		<label class="type">סכוכב מלון  </label>';
        for ($i = 1; $i < 6; $i++) {
            $html .= '		<div class="filter_cont custom-control custom-checkbox">';
            $html .= '			<input type="checkbox" class="custom-control-input filter_checkbox" id="h-star-' . $i . '" value="' . $i . '">';
            $html .= '			<label class="custom-control-label" for="h-star-' . $i . '">' . $i . '</label>';
            $html .= '		</div>';
        }
        $html .= '	</div>';

        $html .= '</div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div class="package-category-sidebar-banners">';
        $html .= '<a href="javaScript:void(0)"><img src="' . url('/assets/front/images/banner-1.png') . '" alt=""></a>';
        $html .= '<a href="#"><img src="' . url('/assets/front/images/banner-2.png') . '" alt=""></a>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}
if (!function_exists('rami_flight_filter_html')) {
    function rami_flight_filter_html($is_mobile = 0)
    {
        if ($is_mobile == 1) {
            $display = 'style="display:none"';
        } else {
            $display = '';
        }
        $airlines = airline::all();
        $html = '<div class="col-md-3">';
        $html .= '<div class="filters_panel">';
        $html .= '	<div class="cap"' . $display . '>';
        $html .= '		<label>סינון על פי קטגוריות:  ';
        $html .= '	</div>';

        $html .= '	<div class="filter_group" data-param="flightType">';
        $html .= '		<label class="type">סוג הטיסה</label>';

        $html .= '		<div class="filter_cont custom-control custom-checkbox">';
        $html .= '			<input type="checkbox" class="custom-control-input filter_checkbox" id="flightType-1" value="1">';
        $html .= '			<label class="custom-control-label" for="flightType-1">יסה סדירה </label>';
        $html .= '		</div>';
        $html .= '		<div class="filter_cont custom-control custom-checkbox">';
        $html .= '			<input type="checkbox" class="custom-control-input filter_checkbox" id="flightType-2" value="2">';
        $html .= '			<label class="custom-control-label" for="flightType-2">טיסת שכר </label>';
        $html .= '		</div>';

        $html .= '	</div>';

        $html .= '	<div class="filter_group" data-param="month">';
        $html .= '		<label class="type">חודש   </label>';
        for ($i = 1; $i < 13; $i++) {
            if (date('m') > $i) {
                continue;
            }
            $html .= '		<div class="filter_cont custom-control custom-checkbox">';
            $html .= '			<input type="checkbox" class="custom-control-input filter_checkbox" id="month-' . $i . '" value="' . sprintf("%02d", $i) . '">';
            $html .= '			<label class="custom-control-label" for="month-' . $i . '">' . get_month_name_hebrew($i) . '</label>';
            $html .= '		</div>';
        }
        $html .= '	</div>';

        $html .= '	<div class="filter_group" data-param="airline">';
        $html .= '		<label class="type">חברת תעופה  </label>';
        foreach ($airlines as $airline) {
            $html .= '		<div class="filter_cont custom-control custom-checkbox">';
            $html .= '			<input type="checkbox" class="custom-control-input filter_checkbox" id="airline-' . $airline->id . '" value="' . $airline->id . '">';
            $html .= '			<label class="custom-control-label" for="airline-' . $airline->id . '">' . $airline->airl_title . '</label>';
            $html .= '		</div>';
        }
        $html .= '	</div>';

        $html .= '</div>';
        $html .= '<div class="clearfix"></div>';
        $html .= '<div class="package-category-sidebar-banners">';
        $html .= '<a href="javaScript:void(0)"><img src="' . url('/assets/front/images/banner-1.png') . '" alt=""></a>';
        $html .= '<a href="#"><img src="' . url('/assets/front/images/banner-2.png') . '" alt=""></a>';
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }

}
if (!function_exists('get_currency_symbol')) {
    function get_currency_symbol($val)
    {
        if ($val == 1) {
            $val = '&#36;';
        } elseif ($val == 2) {
            $val = '&euro;';
        } elseif ($val == 3) {
            $val = 'SFr';
        } elseif ($val == 4) {
            $val = '&#8362;';
        }
        return $val;
    }
}

if (!function_exists('get_location_name')) {
    function get_location_name($id)
    {
        $loc = Location::find($id);
        if (!empty($loc)) {
            return $loc->loc_name;
        }
        return '';
    }
}

if (!function_exists('get_hotel_amenities')) {
    function get_hotel_amenities($id)
    {
        $hotel_amenity = hotel_amenity::find($id);
        if (empty($hotel_amenity)) {
            return '';
        }
        return $hotel_amenity->hotel_amenities;
    }
}
if (!function_exists('get_hotel_features')) {
    function get_hotel_features($id)
    {
        $hotel_feature = hotel_feature::find($id);
        return $hotel_feature->hotel_feature;
    }
}
if (!function_exists('get_hotel_type')) {
    function get_hotel_type($id)
    {
        $hotel_type = hotel_type::find($id);
        return $hotel_type->hotel_type;
    }
}
if (!function_exists('get_week_name')) {
    function get_week_name($val)
    {
        switch ($val) {
            case 0:
                return "Sunday";
                break;
            case 1:
                return "Monday";
                break;
            case 2:
                return "Tuesday";
                break;
            case 3:
                return "Wednesday";
                break;
            case 4:
                return "Thursday";
                break;
            case 5:
                return "Friday";
                break;
            case 6:
                return "Saturday";
                break;
            default:
                return "something went wrong";
                break;
        }
    }
}
if (!function_exists('get_week_name_hebrew')) {
    function get_week_name_hebrew($val)
    {
        switch ($val) {
            case 0:
                return "יום ראשון";
                break;
            case 1:
                return "יום שני";
                break;
            case 2:
                return "יום שלישי";
                break;
            case 3:
                return "יום רביעי";
                break;
            case 4:
                return "יום חמישי";
                break;
            case 5:
                return "יום שישי";
                break;
            case 6:
                return "יום שבת";
                break;
            default:
                return "something went wrong";
                break;
        }
    }
}

if (!function_exists('get_month_name')) {
    function get_month_name($val)
    {
        switch ($val) {
            case 1:
                return "January";
                break;
            case 2:
                return "February";
                break;
            case 3:
                return "March";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "May";
                break;
            case 6:
                return "June";
                break;
            case 7:
                return "July";
                break;
            case 8:
                return "August";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "October";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "December";
                break;
            default:
                return "something went wrong";
                break;
        }
    }
}
if (!function_exists('get_month_name_hebrew')) {
    function get_month_name_hebrew($val)
    {
        switch ($val) {
            case 1:
                return 'ינואר';
                break;
            case 2:
                return 'פברואר';
                break;
            case 3:
                return 'מרץ';
                break;
            case 4:
                return 'אפריל';
                break;
            case 5:
                return 'מאי';
                break;
            case 6:
                return 'יוני';
                break;
            case 7:
                return 'יולי';
                break;
            case 8:
                return 'אוגוסט';
                break;
            case 9:
                return 'ספטמבר';
                break;
            case 10:
                return 'אוקטובר';
                break;
            case 11:
                return 'נובמבר';
                break;
            case 12:
                return 'דצמבר';
                break;
            default:
                return "something went wrong";
                break;
        }
    }
}
if (!function_exists('get_package_type')) {
    function get_package_type($val)
    {
        if ($val == '1') {
            $val = 'Flight+Hotel+Car';
        } elseif ($val == '2') {
            $val = 'Flight+Hotel';
        } elseif ($val == '3') {
            $val = 'Flight+Car';
        } elseif ($val == '4') {
            $val = 'Flight';
        } elseif ($val == '5') {
            $val = 'Accomodation';
        } else {
            $val = '';
        }
        return $val;
    }
}
if (!function_exists('get_location_fhc')) {
    function get_location_fhc()
    {
        $fhc_locations = Location::where('count_for_fhc', '>', '0')->get();
        return $fhc_locations;
    }
}
if (!function_exists('get_location_fh')) {
    function get_location_fh()
    {
        $fh_locations = Location::where('count_for_fh', '>', '0')->get();
        return $fh_locations;
    }
}
if (!function_exists('get_location_fc')) {
    function get_location_fc()
    {
        $fc_locations = Location::where('count_for_fc', '>', '0')->get();
        return $fc_locations;
    }
}
if (!function_exists('get_location_flight_src')) {
    function get_location_flight_src()
    {
        $flight_locations = Location::where('count_for_flight', '>', '0')->get();
        return $flight_locations;
    }
}
if (!function_exists('get_location_flight_desti')) {
    function get_location_flight_desti()
    {
        $flight_locations = Location::where('count_for_flight_desti', '>', '0')->get();
        return $flight_locations;
    }
}

if (!function_exists('get_location_accomodation')) {
    function get_location_accomodation()
    {
        $accomodation_locations = Location::where('count_for_accomodation', '>', '0')->get();
        return $accomodation_locations;
    }
}
//shekel base unit
if (!function_exists('get_rami_price_conversion_to_shekel')) {
    function get_rami_price_conversion_to_shekel($price, $currency)
    {
        if ($currency == 1) {
            return $price * get_rami_setting('dollar_to_shekel');
        } elseif ($currency == 2) {
            return $price * get_rami_setting('euro_to_shekel');
        } elseif ($currency == 3) {
            return $price * get_rami_setting('swiss_frank_to_shekel');
        } else {
            return $price;
        }
    }
}
if (!function_exists('get_rami_price_conversion_shekel_to_other')) {
    function get_rami_price_conversion_shekel_to_other($price, $currency)
    {
        if ($currency == 1) {
            return $price / get_rami_setting('dollar_to_shekel');
        } elseif ($currency == 2) {
            return $price / get_rami_setting('euro_to_shekel');
        } elseif ($currency == 3) {
            return $price / get_rami_setting('swiss_frank_to_shekel');
        } else {
            return $price;
        }
    }
}
if (!function_exists('get_rami_round_num')) {
    function get_rami_round_num($num)
    {
        if ($num < 0) {
            return (int) $num;
        } elseif ($num > (int) $num) {
            return (int) $num + 1;
        }
        return $num;
    }
}
if (!function_exists('get_rami_pakage_profit')) {
    function get_rami_pakage_profit($id, $total)
    {
        $package = package::find($id);
        if (empty($package)) {
            return 0;
        }
        if ($package->package_type == 1) {
            $profit = $package->package_profit_fhc;
        } elseif ($package->package_type == 2) {
            $profit = $package->package_profit_fh;
        } elseif ($package->package_type == 3) {
            $profit = $package->package_profit_fc;
        } else {
            return 0;
        }
        if ($package->package_profit_type == 2) {
            return $total * $profit / 100;
        } else {
            return get_rami_price_conversion_to_shekel($profit, $package->profit_curr);
        }
    }
}
if (!function_exists('get_rami_room_price')) {
    function get_rami_room_price($room_id, $person = 2, $date)
    {
        $price = room_price::where([['room_id', $room_id], ['price_start_date', '<=', $date], ['price_end_date', '>=', $date]])->first();
        $property = 'price_for_' . $person;
        if (empty($price->{$property})) {
            return 0;
        } else {
            return get_rami_price_conversion_to_shekel($price->{$property}, $price->price_currency);
        }
    }
}
if (!function_exists('get_rami_room_avalible')) {
    function get_rami_room_avalible($room_id, $date)
    {
        $room_stock = room_stock::where([['room_id', $room_id], ['stock_start_date', '<=', $date], ['stock_end_date', '>=', $date]])->first();
        if (empty($room_stock->room_available)) {
            return 0;
        } elseif ($room_stock->room_available < 1) {
            return 0;
        }
        return $room_stock->room_available;
    }
}
if (!function_exists('get_rami_package_room_avalible')) {
    function get_rami_package_room_avalible($package_id, $room_id)
    {
        $room_stock = package_room_stock::where([['room_id', $room_id], ['package_id', $package_id]])->first();
        if (empty($room_stock->room_available)) {
            return 0;
        } elseif ($room_stock->room_available < 1) {
            return 0;
        }
        return $room_stock->room_available;
    }
}
if (!function_exists('get_rami_package_room_avalible_total')) {
    function get_rami_package_room_avalible_total($package_id)
    {
        $room_stock = package_room_stock::where([['package_id', $package_id]])->sum('room_available');
        return $room_stock;
    }
}
if (!function_exists('get_rami_flight_price')) {
    function get_rami_flight_price($filight_shedule_id)
    {
        $flight = flight_schedule::find($filight_shedule_id);
        if (!empty($flight)) {
            $per_seat_available = $flight->num_available_seat / $flight->num_total_seat * 100;
            if (((int) $per_seat_available) < $per_seat_available) {
                $per_seat_available = (int) $per_seat_available + 1;
            }
            if ($per_seat_available > $per_seat_available - $per_seat_available % 10) {
                $per_seat_available = $per_seat_available - $per_seat_available % 10 + 10;
            }
            $property = 'price_incr_' . $per_seat_available;
            $price = $flight->price_per_person;
            if (!empty($flight->{$property})) {
                if ($flight->flight_incr_price_str == 1) {
                    $price = $price + $flight->{$property};
                } elseif ($flight->flight_incr_price_str == 2) {
                    $price = $price * $flight->{$property} / 100 + $price;
                }
            }
            return get_rami_price_conversion_to_shekel($price, $flight->price_curr);
        }
    }
}
if (!function_exists('get_rami_flight_price_for_single_flight')) {
    function get_rami_flight_price_for_single_flight($filight_shedule_id)
    {
        $flight = flight_schedule::find($filight_shedule_id);
        if (!empty($flight)) {
            $price = get_rami_flight_price($flight->id);
            if ($flight->profit_type == 2) {
                $price += $price * $flight->flight_profit / 100;
            } else {
                $price += get_rami_price_conversion_to_shekel($flight->flight_profit, $flight->profit_curr);
            }
            $price = get_rami_price_conversion_shekel_to_other($price, 1);
            return get_rami_round_num($price);
        }
    }
}

if (!function_exists('get_rami_room_price_cheapest')) {
    function get_rami_room_price_cheapest($room_id, $date)
    {
        $room = room::find($room_id);
        if (empty($room)) {
            $low_price['price'] = 0;
            $low_price['per_person_price'] = 0;
            $low_price['person'] = 0;
            return $low_price;
        }
        for ($i = 1; $i <= $room->max_people; $i++) {
            $price = get_rami_room_price($room_id, $i, $date);
            $price_per_person = $price / $i;
            if ($i == 1) {
                $low_price['price'] = $price;
                $low_price['per_person_price'] = $price_per_person;
                $low_price['person'] = $i;
            } elseif ($price_per_person <= $low_price['per_person_price']) {
                $low_price['price'] = $price;
                $low_price['per_person_price'] = $price_per_person;
                $low_price['person'] = $i;
            }
        }
        return $low_price;
    }
}
if (!function_exists('get_rami_car_price')) {
    function get_rami_car_price($car_id, $person = 2, $date)
    {
        $current_car = car::find($car_id);
        if (empty($current_car)) {
            return 0;
        }
        $car_price_profit = 0;
        if (!empty($current_car->car_profit)) {
            $car_price_profit = get_rami_price_conversion_to_shekel($current_car->car_profit, $current_car->profit_currency);
        }
        $price = car_price::where([['car_id', $car_id], ['price_start_date', '<=', $date], ['price_end_date', '>=', $date]])->first();
        $property = 'price_for_' . $person;
        if (empty($price->{$property})) {
            return 0;
        } else {
            return $car_price_profit + get_rami_price_conversion_to_shekel($price->{$property}, $price->price_currency);
        }
    }
}
if (!function_exists('get_rami_room_title_by_id')) {
    function get_rami_room_title_by_id($id, $type = '1')
    {
        $room = room::find($id);
        if (!empty($room)) {
            return $room->room_title;
        } else {
            return '';
        }
    }
}

if (!function_exists('is_black_forest')) {
    function is_black_forest($package) {
        return $package-> package_flight_location == 21 ;
    }
}

if (!function_exists('get_child_location_parent_name_seq')) {
    function get_child_location_parent_name_seq($id, $loc_name = '')
    {
        $loc = Location::find($id);
        if (empty($loc)) {
            return $loc_name;
        }
        if (!empty($loc_name)) {
            $name = $loc->loc_name . ' / ' . $loc_name;
        } else {
            $name = $loc->loc_name;
        }
        return get_child_location_parent_name_seq($loc->loc_par, $name);
    }
}
if (!function_exists('get_location_all_child_location')) {
    function get_location_all_child_location($id, $loc_child = array())
    {
        $locs = Location::where([['loc_par', $id]])->get();
        foreach ($locs as $loc) {
            $loc_child[] = $loc->id;
            $loc_child = get_location_all_child_location($loc->id, $loc_child);
        }
        return $loc_child;
    }
}
if (!function_exists('get_search_adult')) {
    function get_search_adult()
    {
        if (!empty(session()->get('pack_adults'))) {
            $pack_adults = session()->get('pack_adults');
        } else {
            $pack_adults = 1;
        }
        return $pack_adults;

    }
}
if (!function_exists('get_search_child')) {
    function get_search_child()
    {
        if (!empty(session()->get('pack_childs'))) {
            $pack_childs = session()->get('pack_childs');
        } else {
            $pack_childs = 0;
        }
        return $pack_childs;
    }
}
if (!function_exists('get_search_infant')) {
    function get_search_infant()
    {
        if (!empty(session()->get('pack_infants'))) {
            $pack_infants = session()->get('pack_infants');
        } else {
            $pack_infants = 0;
        }
        return $pack_infants;
    }
}
if (!function_exists('last_footer_menu_for_pages')) {
    function last_footer_menu_for_pages()
    {
        $pages = page::where([['show_in_footer_menu', 1], ['page_status', 1]])->orderBy('sequence', 'DESC')->get();
        $html = '';
        if (!empty($pages)) {
            $html = '<li class="btn-group">';
            $html .= '<a data-toggle="dropdown">עמודים נוספים   </a>';
            $html .= '<ul class="dropdown-menu drop-up" role="menu" aria-labelledby="dropdownMenu">';
            foreach ($pages as $page) {
                $html .= '<li><a class="dropdown-item" href="' . url('/' . $page->id) . '">' . $page->menu_title . '</a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
            $html .= '</li>';
        }
        return $html;
    }
}
if (!function_exists('last_header_menu_for_pages')) {
    function last_header_menu_for_pages()
    {
        $pages = page::where([['show_in_header_menu', 1], ['page_status', 1]])->orderBy('sequence', 'DESC')->get();
        $html = '';
        if (!empty($pages)) {
            $html .= '<li class="nav-item dropdown">';
            $html .= '<a href="#" class="nav-link dropdown-toggle' . get_rami_active_menu('additional_pages') . '" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">דפים נוספים </a> ';
            $html .= '<ul class="dropdown-menu" role="menu">';
            foreach ($pages as $page) {
                $html .= '<li class="dropdown-item"><a href="' . url('/' . $page->id) . '">' . $page->menu_title . '</a>';
                $html .= '</li>';
            }
            $html .= '</ul>';
            $html .= '</li>';
        }
        return $html;
    }
}

if (!function_exists('rami_page_loop_setup')) {
    function rami_page_loop_setup($results, $prop, $skip_dates, $total_packs, $prv_count = 0, $current_records = [])
    {
        $total_result = $results->count();
        if ($total_result == 0) {
            return [];
        }
        if (($total_result <= $total_packs) && ($prv_count == 0)) {
            return $results;
        }
        $prv_date = '';
        if ($prv_count == $total_packs) {
            return $current_records;
        }
        foreach ($results as $key => $result) {
            if (empty($result)) {
                unset($results[$key]);
            }
            if (empty($prv_date)) {
                $current_records[] = $result;
                $prv_date = $result->{$prop};
                unset($results[$key]);
            } else {
                if (rami_get_no_of_days_diff($prv_date, $result->{$prop}) >= $skip_dates) {
                    $current_records[] = $result;
                    $prv_date = $result->{$prop};
                    unset($results[$key]);
                } else {
                    if (empty($current_records)) {
                        $current_records[] = $result;
                        $prv_date = $result->{$prop};
                        unset($results[$key]);
                    }
                    continue;
                }
            }
            $prv_count++;
            if ($prv_count == $total_packs) {
                return $current_records;
            }
        }

        return rami_page_loop_setup($results, $prop, $skip_dates, $total_packs, $prv_count, $current_records);
    }
}
if (!function_exists('get_rami_car_price_cheapest')) {
    function get_rami_car_price_cheapest($car_id, $date)
    {
        $car = car::find($car_id);
        if (empty($car)) {
            $low_price['price'] = 0;
            $low_price['per_person_price'] = 0;
            $low_price['person'] = 0;
            return $low_price;
        }
        for ($i = 1; $i <= $car->max_people; $i++) {
            $price = get_rami_car_price($car_id, $i, $date);
            // $price_per_person = $price / $i;
            $price_per_person = $price; // Eli Hayun - Car price is car price and not per person
            if ($i == 1) {
                $low_price['price'] = $price;
                $low_price['per_person_price'] = $price_per_person;
                $low_price['person'] = $i;
            } elseif ($price_per_person <= $low_price['per_person_price']) {
                $low_price['price'] = $price;
                $low_price['per_person_price'] = $price_per_person;
                $low_price['person'] = $i;
            }
        }
        return $low_price;
    }
}

if (!function_exists('get_rami_hotel_reviews')) {
    function get_rami_hotel_reviews($hotel_reviews)
    {
        $html = '';
        if (!empty($hotel_reviews->count() > 0)) {
            $html .= '  <div class="pkg-section" id="reviews-box">';
            $html .= '   <div class="row">';
            $html .= '     <div class="col-md-12 bd-sec">';
            $html .= '      <div class="bd-head"><h3><img src="' . url('/assets/front/images') . '/review-ico.png" alt="" >לקוחות ממליצים</h3></div>';
            $html .= '     </div>';
            $html .= '     <div id="hotel_reviews" class="col-md-12 carousel slide" data-ride="carousel">';
            $html .= '      <div class="carousel-inner">';
            $count = 0;
            foreach ($hotel_reviews as $hotel_review) {
                if ($count == 0) {
                    $class = 'active';
                } else {
                    $class = '';
                }
                $html .= '<div class="carousel-item ' . $class . '" data-interval="3000">';
                $html .= '   <div class="review_box">';
                $html .= '		<div class="hotel-room-rank-box">';
                $html .= '			<div class="hotel-room-rank">';
                $html .= '				<div class="vertical-align">';
                $html .= '					<div class="left-small-text-yellow text-center">ציון כללי</div>';
                $html .= '						<div class="ranking">' . $hotel_review->rating . '</div>';
                $html .= '							<div class="text-center" >';
                for ($i = 1; $i <= $hotel_review->rating; $i++) {
                    $html .= '                            <img class="rating_star" src="' . url('/assets/front/images') . '/yellow-small-star.jpg" alt="" val-attr="' . $i . '">';
                }
                $html .= '   							</div>';
                $html .= '   				</div>';
                $html .= '   			</div>';
                $html .= '   		</div>';
                $html .= ' 	<div class="ranking-discription">';
                $html .= '      <div class="ranking-heading">';
                $html .= '          <div class="room-small-heading">' . $hotel_review->title_review . '</div>';
                $html .= '          <div class="test-date">';
                $html .= '            <img src="http://ramnew.sisfy.com/assets/front/images/calander-icon-recomended.jpg" alt=""> ' . $hotel_review->review_date . '
                				  </div>';
                $html .= '      </div>';
                $html .= '        <div class="review_content partial">' . $hotel_review->review . '
                				</div>';
                $html .= '         <span class="show_more_review">לקריאת ההמלצה המלאה</span>';
                $html .= '         <span class="show_less_review">סגירה</span>';
                $html .= '  </div>';
                $html .= '   </div>';
                $html .= '</div>';
                $count++;
            }
            $html .= '    </div>';
            $html .= '	<ol class="carousel-indicators">';
            $count = 0;
            foreach ($hotel_reviews as $hotel_review) {
                if ($count == 0) {
                    $class = 'active';
                } else {
                    $class = '';
                }
                $html .= '          <li data-target="#hotel_reviews" data-slide-to="' . $count . '" class="' . $class . '"></li>';
                $count++;
            }
            $html .= '    </ol>';
            $html .= '   </div>';
            $html .= ' </div>';
            $html .= '</div>';
        }
        return $html;
    }
}
if (!function_exists('get_rami_active_menu')) {
    function get_rami_active_menu($cur_path = '')
    {
        $path = Request::path();
        $uri = explode("/", $path);
        if ($uri[0] == $cur_path) {
            return "active";
        } else {
            return '';
        }
    }
}
if (!function_exists('car_array_comparision_price')) {
    function car_array_comparision_price($cur, $next)
    {
        if ($cur['car_price'] < $next['car_price']) {
            return false;
        } else {
            return true;
        }

    }
}
if (!function_exists('flight_array_comparision_price')) {
    function flight_array_comparision_price($cur, $next)
    {
        if ($cur['flight_price'] < $next['flight_price']) {
            return true;
        } else {
            return false;
        }

    }
}

function getIp()
{
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
}
