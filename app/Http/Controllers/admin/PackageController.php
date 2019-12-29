<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\model\airline;
use App\model\car;
use App\model\flight_schedule;
use App\model\Location;
use App\model\package;
use App\model\hotel;
use App\model\package_room_stock;
use App\model\page_palcehloder;
use App\model\room;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct()
    {
        rami_setup_backend_language();
        $this->middleware('CheckRole');
    }
    public function index()
    {
        $data['packages'] = package::all();
        $data['all_count'] = package::all()->count();
        $data['trash_count'] = package::onlyTrashed()->count();
        $data['page_title'] = 'All Package';
        $data['assets_admin'] = url('assets/admin');
        return view('admin.package.all_package', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Add Package';
        $data['airlines'] = airline::all();
        $data['locations'] = Location::all();
        $data['all_hotels'] = hotel::all();
        $data['package_id'] = 0;
        $data['assets_admin'] = url('assets/admin');
        return view('admin.package.add_package', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $package = new package;
        $messages = [
        ];
        //dd($request);
        if (!empty($request->package_hotel_room)) {
            foreach ($request->package_hotel_room as $room) {
                $messages['room_stock_' . $room . '.required'] = 'Please enter valid room avalible field';
                $messages['room_stock_' . $room . '.max'] = 'Please enter valid room avalible field(max 99)';
                $messages['room_stock_' . $room . '.min'] = 'Please enter valid room avalible field(min 1)';
                $messages['room_stock_' . $room . '.numeric'] = 'Please enter valid room avalible field';
            }
        }
        if (!empty($request->extra_hotel_1_rooms)) {
            foreach ($request->extra_hotel_1_rooms as $room) {
                $messages['room_stock_' . $room . '.required'] = 'Please enter valid room avalible field';
                $messages['room_stock_' . $room . '.max'] = 'Please enter valid room avalible field(max 99)';
                $messages['room_stock_' . $room . '.min'] = 'Please enter valid room avalible field(min 1)';
                $messages['room_stock_' . $room . '.numeric'] = 'Please enter valid room avalible field';
            }
        }
        if (!empty($request->extra_hotel_2_rooms)) {
            foreach ($request->extra_hotel_2_rooms as $room) {
                $messages['room_stock_' . $room . '.required'] = 'Please enter valid room avalible field';
                $messages['room_stock_' . $room . '.max'] = 'Please enter valid room avalible field(max 99)';
                $messages['room_stock_' . $room . '.min'] = 'Please enter valid room avalible field(min 1)';
                $messages['room_stock_' . $room . '.numeric'] = 'Please enter valid room avalible field';
            }
        }
        $valid_array = array(
            'package_title' => 'required',
            'package_type' => 'required',
            'package_start_date' => 'required|date|date_format:Y-m-d|before:package_end_date',
            'package_end_date' => 'required|date|date_format:Y-m-d|after:package_start_date',
            'package_airline' => 'required',
            'package_flight_sche' => 'required',
            'package_flight_location' => 'required',
            'package_profit_type' => 'required',
            'instant_approval' => 'required',
            'package_status' => 'required',
        );
        if(($request->package_type == 1)&&($request->having_extra_hotel_1 == 1)){
            $valid_array['extra_hotel_1'] = 'required|different:package_hotel';
            $valid_array['extra_hotel_1_start_date'] = 'required|date|date_format:Y-m-d|after_or_equal:package_start_date|before:extra_hotel_1_end_date';
            $valid_array['extra_hotel_1_end_date'] = 'required|date|date_format:Y-m-d|before_or_equal:package_end_date|after:extra_hotel_1_start_date';
            $valid_array['extra_hotel_1_rooms'] = 'required';
            if (!empty($request->extra_hotel_1_rooms)) {
                foreach ($request->extra_hotel_1_rooms as $room) {
                    $valid_array['room_stock_' . $room] = 'required|numeric|min:0|max:999';

                }
            }
            if($request->having_extra_hotel_2 == 1){
                $valid_array['extra_hotel_2'] = 'required|not_in:extra_hotel_1|different:package_hotel';
                $valid_array['extra_hotel_2_start_date'] = 'required|date|date_format:Y-m-d|after_or_equal:extra_hotel_1_end_date|before:extra_hotel_2_end_date';
                $valid_array['extra_hotel_2_end_date'] = 'required|date|date_format:Y-m-d|before_or_equal:package_end_date|after:extra_hotel_1_start_date';
                $valid_array['extra_hotel_2_rooms'] = 'required';
                if (!empty($request->extra_hotel_2_rooms)) {
                foreach ($request->extra_hotel_2_rooms as $room) {
                    $valid_array['room_stock_' . $room] = 'required|numeric|min:0|max:999';

                }
            }
            }
        }
        if (!empty($request->package_hotel_room)) {
            foreach ($request->package_hotel_room as $room) {
                $valid_array['room_stock_' . $room] = 'required|numeric|min:0|max:999';

            }
        }
        if ($request->package_profit_type == 1) {
            $valid_array['profit_curr'] = 'required';
        }
        if ($request->package_type == 1) {
            $valid_array['package_hotel'] = 'required';
            $valid_array['package_hotel_room'] = 'required';
            $valid_array['package_car'] = 'required';
            $valid_array['package_profit_fhc'] = 'required';
        } elseif ($request->package_type == 2) {
            $valid_array['package_hotel'] = 'required';
            $valid_array['package_hotel_room'] = 'required';
            $valid_array['package_profit_fh'] = 'required';
        } elseif ($request->package_type == 3) {
            $valid_array['package_car'] = 'required';
            $valid_array['package_profit_fc'] = 'required';
        }
        $this->validate($request, $valid_array, $messages);
        $package->package_title = $request->package_title;
        $package->is_display_pkg_title = $request->is_display_pkg_title;
        $package->is_fix_profit = $request->is_fix_profit;
        $package->package_desc = $request->package_desc;
        $package->package_type = $request->package_type;
        $package->package_start_date = $request->package_start_date;
        $package->package_end_date = $request->package_end_date;
        $package->package_hotel = $request->package_hotel;
        $package->package_hotel_room = serialize($request->package_hotel_room);
        $package->package_airline = serialize($request->package_airline);
        $package->package_flight_sche = serialize($request->package_flight_sche);
        $package->package_flight_location = $request->package_flight_location;
        $package->package_car = serialize($request->package_car);
        $package->package_profit_type = $request->package_profit_type;
        $package->profit_curr = $request->profit_curr;
        $package->package_profit_fhc = $request->package_profit_fhc;
        $package->package_profit_fh = $request->package_profit_fh;
        $package->package_profit_fc = $request->package_profit_fc;
        $package->instant_approval = $request->instant_approval;
        $package->package_status = $request->package_status;
        $package->is_hot_deal = $request->is_hot_deal;
        $package->pkg_instruction_text = $request->pkg_instruction_text;
        if($request->having_extra_hotel_1 == 1){
            $package->having_extra_hotel_1 = $request->having_extra_hotel_1;
            $package->extra_hotel_1_start_date = $request->extra_hotel_1_start_date;
            $package->extra_hotel_1_end_date = $request->extra_hotel_1_end_date;
            $package->extra_hotel_1 = $request->extra_hotel_1;
            $package->extra_hotel_1_rooms =serialize($request->extra_hotel_1_rooms);
            if($request->having_extra_hotel_2 == 1){
                $package->having_extra_hotel_2 = $request->having_extra_hotel_2;
                $package->extra_hotel_2_start_date = $request->extra_hotel_2_start_date;
                $package->extra_hotel_2_end_date = $request->extra_hotel_2_end_date;
                $package->extra_hotel_2 = $request->extra_hotel_2;
                $package->extra_hotel_2_rooms =serialize($request->extra_hotel_2_rooms);
                
            }
        }
        $package->save();
        $package_room_stocks = package_room_stock::where([['package_id', $package->id]]);
        $package_room_stocks->delete();
        if (!empty($request->package_hotel_room)) {
            foreach ($request->package_hotel_room as $room) {
                $package_room_stocks = new package_room_stock;
                $package_room_stocks->room_id = $room;
                $package_room_stocks->package_id = $package->id;
                $package_room_stocks->room_available = $request->{'room_stock_' . $room};
                $package_room_stocks->save();
            }
        }
        if (!empty($request->extra_hotel_1_rooms)) {
                foreach ($request->extra_hotel_1_rooms as $room) {
                    $package_room_stocks = new package_room_stock;
                    $package_room_stocks->room_id = $room;
                    $package_room_stocks->package_id = $package->id;
                    $package_room_stocks->room_available = $request->{'room_stock_' . $room};
                    $package_room_stocks->save();

                }
        }
         if (!empty($request->extra_hotel_2_rooms)) {
                foreach ($request->extra_hotel_2_rooms as $room) {
                    $package_room_stocks = new package_room_stock;
                    $package_room_stocks->room_id = $room;
                    $package_room_stocks->package_id = $package->id;
                    $package_room_stocks->room_available = $request->{'room_stock_' . $room};
                    $package_room_stocks->save();

                }
        }
        $this->setup_low_cost_for_package($package->id);
        set_flash_msg('flash_success', 'Package Inserted Successsfully.');
        return redirect('admin/package');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['package'] = package::find($id);
        $data['airlines'] = airline::all();
        $data['locations'] = Location::all();
        $data['all_hotels'] = hotel::all();
        $data['package_id'] = $data['package']->id;
        $data['page_title'] = 'Edit Package';
        $data['assets_admin'] = url('assets/admin');
        return view('admin.package.edit_package', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $package = package::find($id);
        $messages = [
        ];
        if (!empty($request->package_hotel_room)) {
            foreach ($request->package_hotel_room as $room) {
                $messages['room_stock_' . $room . '.required'] = 'Please enter valid room avalible field';
                $messages['room_stock_' . $room . '.max'] = 'Please enter valid room avalible field';
                $messages['room_stock_' . $room . '.min'] = 'Please enter valid room avalible field';
                $messages['room_stock_' . $room . '.numeric'] = 'Please enter valid room avalible field';
            }
        }
         if (!empty($request->extra_hotel_1_rooms)) {
            foreach ($request->extra_hotel_1_rooms as $room) {
                $messages['room_stock_' . $room . '.required'] = 'Please enter valid room avalible field';
                $messages['room_stock_' . $room . '.max'] = 'Please enter valid room avalible field(max 99)';
                $messages['room_stock_' . $room . '.min'] = 'Please enter valid room avalible field(min 1)';
                $messages['room_stock_' . $room . '.numeric'] = 'Please enter valid room avalible field';
            }
        }
        if (!empty($request->extra_hotel_2_rooms)) {
            foreach ($request->extra_hotel_2_rooms as $room) {
                $messages['room_stock_' . $room . '.required'] = 'Please enter valid room avalible field';
                $messages['room_stock_' . $room . '.max'] = 'Please enter valid room avalible field(max 99)';
                $messages['room_stock_' . $room . '.min'] = 'Please enter valid room avalible field(min 1)';
                $messages['room_stock_' . $room . '.numeric'] = 'Please enter valid room avalible field';
            }
        }
        $valid_array = array(
            'package_title' => 'required',
            'package_start_date' => 'required|date|date_format:Y-m-d|before:package_end_date',
            'package_end_date' => 'required|date|date_format:Y-m-d|after:package_start_date',
            'package_airline' => 'required',
            'package_flight_sche' => 'required',
            'package_flight_location' => 'required',
            'instant_approval' => 'required',
            'package_status' => 'required',
        );
        if(($request->package_type == 1)&&($request->having_extra_hotel_1 == 1)){
            $valid_array['extra_hotel_1'] = 'required|different:package_hotel';
            $valid_array['extra_hotel_1_start_date'] = 'required|date|date_format:Y-m-d|after_or_equal:package_start_date|before:extra_hotel_1_end_date';
            $valid_array['extra_hotel_1_end_date'] = 'required|date|date_format:Y-m-d|before_or_equal:package_end_date|after:extra_hotel_1_start_date';
            $valid_array['extra_hotel_1_rooms'] = 'required';
            if (!empty($request->extra_hotel_1_rooms)) {
                foreach ($request->extra_hotel_1_rooms as $room) {
                    $valid_array['room_stock_' . $room] = 'required|numeric|min:0|max:999';

                }
            }
            if($request->having_extra_hotel_2 == 1){
                $valid_array['extra_hotel_2'] = 'required|not_in:extra_hotel_1|different:package_hotel';
                $valid_array['extra_hotel_2_start_date'] = 'required|date|date_format:Y-m-d|after_or_equal:extra_hotel_1_end_date|before:extra_hotel_2_end_date';
                $valid_array['extra_hotel_2_end_date'] = 'required|date|date_format:Y-m-d|before_or_equal:package_end_date|after:extra_hotel_1_start_date';
                $valid_array['extra_hotel_2_rooms'] = 'required';
                if (!empty($request->extra_hotel_2_rooms)) {
                foreach ($request->extra_hotel_2_rooms as $room) {
                    $valid_array['room_stock_' . $room] = 'required|numeric|min:0|max:999';

                }
            }
            }
        }

        if (!empty($request->package_hotel_room)) {
            foreach ($request->package_hotel_room as $room) {
                $valid_array['room_stock_' . $room] = 'required|numeric|min:0|max:999';
            }
        }
        if ($request->package_profit_type == 1) {
            $valid_array['profit_curr'] = 'required';
        }
        if ($request->package_type == 1) {
            $valid_array['package_hotel'] = 'required';
            $valid_array['package_hotel_room'] = 'required';
            $valid_array['package_car'] = 'required';
            $valid_array['package_profit_fhc'] = 'required';
        } elseif ($request->package_type == 2) {
            $valid_array['package_hotel'] = 'required';
            $valid_array['package_hotel_room'] = 'required';
            $valid_array['package_profit_fh'] = 'required';
        } elseif ($request->package_type == 3) {
            $valid_array['package_car'] = 'required';
            $valid_array['package_profit_fc'] = 'required';
        }
        $this->validate($request, $valid_array, $messages);
        $package->package_title = $request->package_title;
        $package->is_display_pkg_title = $request->is_display_pkg_title;
        $package->is_fix_profit = $request->is_fix_profit;
        $package->package_desc = $request->package_desc;
        $package->package_type = $request->package_type;
        $package->package_start_date = $request->package_start_date;
        $package->package_end_date = $request->package_end_date;
        $package->package_hotel = $request->package_hotel;
        $package->package_hotel_room = serialize($request->package_hotel_room);
        $package->package_airline = serialize($request->package_airline);
        $package->package_flight_sche = serialize($request->package_flight_sche);
        $package->package_flight_location = $request->package_flight_location;
        $package->package_car = serialize($request->package_car);
        $package->package_profit_type = $request->package_profit_type;
        $package->profit_curr = $request->profit_curr;
        $package->package_profit_fhc = $request->package_profit_fhc;
        $package->package_profit_fh = $request->package_profit_fh;
        $package->package_profit_fc = $request->package_profit_fc;
        $package->instant_approval = $request->instant_approval;
        $package->package_status = $request->package_status;
        $package->is_hot_deal = $request->is_hot_deal;
        $package->pkg_instruction_text = $request->pkg_instruction_text;
        //dd($package);
       if($request->having_extra_hotel_1 == 1){
            $package->having_extra_hotel_1 = $request->having_extra_hotel_1;
            $package->extra_hotel_1_start_date = $request->extra_hotel_1_start_date;
            $package->extra_hotel_1_end_date = $request->extra_hotel_1_end_date;
            $package->extra_hotel_1 = $request->extra_hotel_1;
            $package->extra_hotel_1_rooms =serialize($request->extra_hotel_1_rooms);
            if($request->having_extra_hotel_2 == 1){
                $package->having_extra_hotel_2 = $request->having_extra_hotel_2;
                $package->extra_hotel_2_start_date = $request->extra_hotel_2_start_date;
                $package->extra_hotel_2_end_date = $request->extra_hotel_2_end_date;
                $package->extra_hotel_2 = $request->extra_hotel_2;
                $package->extra_hotel_2_rooms =serialize($request->extra_hotel_2_rooms);
                
            }
        }
        $package->save();
        $package_room_stocks = package_room_stock::where([['package_id', $package->id]]);
        $package_room_stocks->delete();
        if (!empty($request->package_hotel_room)) {
            foreach ($request->package_hotel_room as $room) {
                $package_room_stocks = package_room_stock::where([['package_id', $package->id], ['room_id', $room]]);
                $package_room_stocks->delete();
                $package_room_stocks = new package_room_stock;
                $package_room_stocks->room_id = $room;
                $package_room_stocks->package_id = $package->id;
                $package_room_stocks->room_available = $request->{'room_stock_' . $room};
                $package_room_stocks->save();
            }
        }
        if (!empty($request->extra_hotel_1_rooms)) {
                foreach ($request->extra_hotel_1_rooms as $room) {
                    $package_room_stocks = new package_room_stock;
                    $package_room_stocks->room_id = $room;
                    $package_room_stocks->package_id = $package->id;
                    $package_room_stocks->room_available = $request->{'room_stock_' . $room};
                    $package_room_stocks->save();

                }
        }
         if (!empty($request->extra_hotel_2_rooms)) {
                foreach ($request->extra_hotel_2_rooms as $room) {
                    $package_room_stocks = new package_room_stock;
                    $package_room_stocks->room_id = $room;
                    $package_room_stocks->package_id = $package->id;
                    $package_room_stocks->room_available = $request->{'room_stock_' . $room};
                    $package_room_stocks->save();

                }
        }
        $this->setup_low_cost_for_package($package->id);
        set_flash_msg('flash_success', 'Package Updated Successsfully.');
        return redirect('admin/package/' . $id . '/edit');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $package = package::find($id);
        $package->delete();
        set_flash_msg('flash_success', 'Package Deleted Successsfully.');
        return redirect('admin/package');
    }
    public function trash_package()
    {
        $data['page_title'] = 'All Trash Package';
        $data['trash_package'] = package::onlyTrashed()->get();
        $data['all_count'] = package::onlyTrashed()->count();
        $data['assets_admin'] = url('assets/admin');
        return view('admin.package.all_trashed_package', $data);
    }
    public function restore_trash_package()
    {
        $package = package::onlyTrashed()->restore();
        if (!empty($package)) {
            set_flash_msg('flash_success', 'Trash package Restore Successsfully.');
            return redirect('admin/package');
        } else {
            set_flash_msg('flash_error', 'Trash package not Found for Restore.');
            return redirect('admin/package/trash');
        }
    }
    public function restore_single_package($id)
    {
        $package = package::onlyTrashed()->where(['id' => $id])->restore();
        if (!empty($package)) {
            set_flash_msg('flash_success', 'Trash package Restore Successsfully.');
            return redirect('admin/package');
        } else {
            set_flash_msg('flash_error', 'Trash package not Found for Restore.');
            return redirect('admin/package/trash');
        }
    }
    public function force_delete_package($id)
    {
        $package = package::onlyTrashed()->where(['id' => $id]);
        $package->forceDelete();
        set_flash_msg('flash_success', 'Package deleted Successfully.');
        return redirect('admin/package/trash');
    }
    public function force_delete_all()
    {
        package::onlyTrashed()->forceDelete();
        set_flash_msg('flash_success', 'All package deleted successfully');
        return redirect('admin/package/trash');
    }
    public function add_pkg_meta_data($id)
    {
        $data['package'] = package::find($id);
        if (empty($data['package'])) {
            set_flash_msg('flash_error', 'Package not found.');
            return redirect('admin/package');
        }
        $data['page_title'] = 'Add Package meta data';
        $data['assets_admin'] = url('assets/admin');
        return view('admin.package.add_pkg_meta_data', $data);
    }
    public function save_pkg_meta_data(Request $request, $id)
    {
        $package = package::find($id);
        $package->header_custom_code = $request->header_custom_code;
        $package->footer_custom_code = $request->footer_custom_code;
        $package->pkg_title_text = $request->pkg_title_text;
        $package->slug = $request->slug;
        $package->save();
        set_flash_msg('flash_success', 'Package Meta data updated successfully');
        return redirect('admin/package-meta/' . $id);
    }
    public function package_page_placeholders()
    {
        $data['page_title'] = 'Package Page Placeholders';
        $data['assets_admin'] = url('assets/admin');
        return view('admin.package.package_page_placeholder', $data);
    }
    public function save_package_page_placeholders(Request $request)
    {
        if (!empty($request->basic_details)) {
            page_palcehloder::save_page_placeholder('basic_details', $request->basic_details, 1);
        } else {
            page_palcehloder::delete_page_placeholder('basic_details', 1);
        }
        if (!empty($request->apartment)) {
            page_palcehloder::save_page_placeholder('apartment', $request->apartment, 1);
        } else {
            page_palcehloder::delete_page_placeholder('apartment', 1);
        }
        if (!empty($request->gallery)) {
            page_palcehloder::save_page_placeholder('gallery', $request->gallery, 1);
        } else {
            page_palcehloder::delete_page_placeholder('gallery', 1);
        }
        if (!empty($request->choice_of_apartments)) {
            page_palcehloder::save_page_placeholder('choice_of_apartments', $request->choice_of_apartments, 1);
        } else {
            page_palcehloder::delete_page_placeholder('choice_of_apartments', 1);
        }
        if (!empty($request->hotel_review)) {
            page_palcehloder::save_page_placeholder('hotel_review', $request->hotel_review, 1);
        } else {
            page_palcehloder::delete_page_placeholder('hotel_review', 1);
        }
        if (!empty($request->map)) {
            page_palcehloder::save_page_placeholder('map', $request->map, 1);
        } else {
            page_palcehloder::delete_page_placeholder('map', 1);
        }
        if (!empty($request->flights)) {
            page_palcehloder::save_page_placeholder('flights', $request->flights, 1);
        } else {
            page_palcehloder::delete_page_placeholder('flights', 1);
        }
        if (!empty($request->vehicle)) {
            page_palcehloder::save_page_placeholder('vehicle', $request->vehicle, 1);
        } else {
            page_palcehloder::delete_page_placeholder('vehicle', 1);
        }
        if (!empty($request->help_text_apartment)) {
            page_palcehloder::save_page_placeholder('help_text_apartment', $request->help_text_apartment, 1);
        } else {
            page_palcehloder::delete_page_placeholder('help_text_apartment', 1);
        }
        if (!empty($request->help_text_gallery)) {
            page_palcehloder::save_page_placeholder('help_text_gallery', $request->help_text_gallery, 1);
        } else {
            page_palcehloder::delete_page_placeholder('help_text_gallery', 1);
        }
        if (!empty($request->help_text_apartment_info)) {
            page_palcehloder::save_page_placeholder('help_text_apartment_info', $request->help_text_apartment_info, 1);
        } else {
            page_palcehloder::delete_page_placeholder('help_text_apartment_info', 1);
        }
        if (!empty($request->help_text_attraction)) {
            page_palcehloder::save_page_placeholder('help_text_attraction', $request->help_text_attraction, 1);
        } else {
            page_palcehloder::delete_page_placeholder('help_text_attraction', 1);
        }
        if (!empty($request->help_text_flights)) {
            page_palcehloder::save_page_placeholder('help_text_flights', $request->help_text_flights, 1);
        } else {
            page_palcehloder::delete_page_placeholder('help_text_flights', 1);
        }
        if (!empty($request->help_text_vehicle)) {
            page_palcehloder::save_page_placeholder('help_text_vehicle', $request->help_text_vehicle, 1);
        } else {
            page_palcehloder::delete_page_placeholder('help_text_vehicle', 1);
        }
        set_flash_msg('flash_success', 'Page Placeholders Saved Successsfully');
        return redirect('admin/package/package-page-placeholders');
    }
    public function setup_low_cost_for_package($id)
    {
        $curr_pack = package::find($id);
        if (!empty($curr_pack)) {
            $start_date = $curr_pack->package_start_date;
            $end_date = $curr_pack->package_end_date;
            if (($curr_pack->package_type == 1) || ($curr_pack->package_type == 2)) {
                $rooms = unserialize($curr_pack->package_hotel_room);
                if (empty($rooms)) {
                    $curr_pack->package_status = 0;
                    $curr_pack->save();
                }
                $new_room = array();
                $room_id = null;
                $count = 1;
                foreach ($rooms as $room) {
                    $curr_room = room::find($room);
                    if (empty($curr_room) || (empty(get_rami_package_room_avalible($id, $room)))) {
                        continue;
                    }
                    $room_price = get_rami_room_price_cheapest($room, $start_date);
                    if ($count == 1) {
                        $room_id = $room;
                        $old_price = $room_price['per_person_price'];
                    } elseif (($old_price >= $room_price['per_person_price']) && ($room_price['per_person_price'] > 0)) {
                        $room_id = $room;
                        $old_price = $room_price['per_person_price'];
                    }
                    if (($old_price != 0)) {
                        $new_room[] = $room;
                    }
                    $count++;
                }
                if (empty($new_room)) {
                    $curr_pack->package_hotel_room = serialize($new_room);
                    $curr_pack->package_status = 0;
                    $curr_pack->save();
                } else {
                    $curr_pack->package_hotel_room = serialize($new_room);
                    $curr_pack->cheapest_room = $room_id;
                    $curr_pack->save();
                }
            } else {
                $curr_pack->package_hotel_room = serialize(array());
                $curr_pack->cheapest_room = null;
                $curr_pack->save();
            }
            if (($curr_pack->package_type == 1) || ($curr_pack->package_type == 3)) {
                $cars = unserialize($curr_pack->package_car);
                if (empty($cars)) {
                    $curr_pack->package_status = 0;
                    $curr_pack->save();
                }
                $new_car = array();
                $count = 1;
                $car_id = null;
                foreach ($cars as $car) {
                    $curr_car = car::find($car);
                    if (empty($curr_car)) {
                        continue;
                    }
                    $car_price = get_rami_car_price_cheapest($car, $start_date);
                    if ($count == 1) {
                        $car_id = $car;
                        $old_price = $car_price['per_person_price'];
                    } elseif (($old_price >= $car_price['per_person_price']) && ($car_price['per_person_price'] > 0)) {
                        $car_id = $car;
                        $old_price = $car_price['per_person_price'];
                    }
                    if (($old_price != 0)) {
                        $new_car[] = $car;
                    }
                    $count++;
                }
                if (empty($new_car)) {
                    $curr_pack->package_car = serialize($new_car);
                    $curr_pack->package_status = 0;
                    $curr_pack->save();
                } else {
                    $curr_pack->package_car = serialize($new_car);
                    $curr_pack->cheapest_car = $car_id;
                    $curr_pack->save();
                }
            } else {
                $curr_pack->package_car = serialize(array());
                $curr_pack->cheapest_car = null;
                $curr_pack->save();
            }

            $flights = unserialize($curr_pack->package_flight_sche);
            if (empty($flights)) {
                $curr_pack->package_status = 0;
                $curr_pack->save();
            }
            $new_flight_sch = array();
            $count = 1;
            $flight_id = null;
            foreach ($flights as $flight) {
                $curr_flight = flight_schedule::find($flight);
                if (empty($curr_flight)) {
                    continue;
                }
                $flight_price = get_rami_flight_price($flight);
                if ($count == 1) {
                    $flight_id = $flight;
                    $old_price = $flight_price;
                } elseif (($old_price >= $flight_price) && ($flight_price > 0)) {
                    $flight_id = $flight;
                    $old_price = $flight_price;
                }
                if (($flight_price != 0)) {
                    $new_flight_sch[] = $curr_flight->id;
                }
                $count++;
            }
            if (empty($new_flight_sch)) {
                $curr_pack->package_flight_sche = serialize($new_flight_sch);
                $curr_pack->package_status = 0;
                $curr_pack->save();
            } else {
                $curr_pack->package_flight_sche = serialize($new_flight_sch);
                $curr_pack->cheapest_flight_sche = $flight_id;
                $curr_pack->save();
            }
            $no_of_days = rami_get_no_of_days_diff($start_date, $end_date);
            $car_price = get_rami_car_price_cheapest($curr_pack->cheapest_car, $start_date);
            $room_price = get_rami_room_price_cheapest($curr_pack->cheapest_room, $start_date);
            $flight_price = get_rami_flight_price($curr_pack->cheapest_flight_sche);
            if (($car_price['person'] != $room_price['person']) && ($room_price['person'] != 0) && ($car_price['person'] != 0)) {
                $room_price_new = get_rami_room_price($curr_pack->cheapest_room, $car_price['person'], $start_date);
                $car_price_new = get_rami_car_price($curr_pack->cheapest_car, $room_price['person'], $start_date);
                if (($room_price_new == 0) || ($car_price_new == 0)) {
                    if ($car_price['person'] > $room_price['person']) {
                        $persons = $room_price['person'];
                    } else {
                        $persons = $car_price['person'];
                    }
                } else {
                    $persons = $room_price['person'];
                    $persons1 = $car_price['person'];
                }
            } elseif ($room_price['person'] > 0) {
                $persons = $room_price['person'];
            } else {
                $persons = $car_price['person'];
            }
            if (!empty($persons1)) {
                if ($car_price['person'] == $persons1) {
                    // get_rami_car_price($curr_pack->cheapest_car, $no_of_days ,$start_date);
                    $car_total_price = $car_price['price'] * ($no_of_days + 1);
                } else {
                    $car_total_price = $car_price_new * ($no_of_days + 1);
                }
                if ($room_price['person'] == $persons1) {
                    $room_total_price = $room_price['price'] * $no_of_days;
                } else {
                    $room_total_price = $room_price_new * $no_of_days;
                }
                $flight_total_price = $flight_price * $persons1;
                $total = $flight_total_price + $room_total_price + $car_total_price;
                //$adults = $persons1 > 2 ? 2 : $persons1;
                //$per_adults_extra_charge=get_rami_price_conversion_to_shekel(30,2);
                // $adults_total_extra_charge=$per_adults_extra_charge* $adults*$no_of_days;
                // $total+= $adults_total_extra_charge;
                $profit = get_rami_pakage_profit($curr_pack->id, $total) * $persons1;
                $total += $profit;
                $total_euro = get_rami_price_conversion_shekel_to_other($total, 2);
                $per_peson1 = get_rami_round_num($total_euro / $persons1);
            }
            if (($car_price['person'] == $persons) || ($car_price['person'] == 0)) {
                $car_total_price = $car_price['price'] * ($no_of_days + 1);
            } else {
                $car_total_price = $car_price_new * ($no_of_days + 1);
            }
            if (($room_price['person'] == $persons) || ($room_price['person'] == 0)) {
                $room_total_price = $room_price['price'] * $no_of_days;
            } else {
                $room_total_price = $room_price_new * $no_of_days;
            }
            $flight_total_price = $flight_price * $persons;
            $total = $flight_total_price + $room_total_price + $car_total_price;
            //$adults = $persons > 2 ? 2 : $persons;
            //$per_adults_extra_charge=get_rami_price_conversion_to_shekel(30,2);
            //$adults_total_extra_charge=$per_adults_extra_charge* $adults;
            //$total+= $adults_total_extra_charge;
            $profit = get_rami_pakage_profit($curr_pack->id, $total) * $persons;
            $total += $profit;
            $total_euro = get_rami_price_conversion_shekel_to_other($total, 2);
            if ($persons == 0) {
                $curr_pack->package_lowest_price = 0;
                $curr_pack->total_persons = 0;
                $curr_pack->total_persons_combinations = 0;
                $curr_pack->total_price_in_euro = 0;
                $curr_pack->package_status = 0;
                $curr_pack->save();
            } else {
                $per_peson = get_rami_round_num($total_euro / $persons);
                if ((!empty($per_peson1)) && ($per_peson1 < $per_peson)) {
                    $curr_pack->package_lowest_price = $per_peson1;
                    $curr_pack->total_persons_combinations = '2' . '&' . "$persons1-2";
                    $curr_pack->total_persons = $persons1;
                    $curr_pack->total_price_in_euro = $total_euro;
                    $curr_pack->save();
                } else {
                    $curr_pack->package_lowest_price = $per_peson;
                    $curr_pack->total_persons_combinations = '2' . '&' . "$persons-2";
                    $curr_pack->total_persons = $persons;
                    $curr_pack->total_price_in_euro = $total_euro;
                    $curr_pack->save();
                }
            }
        }
    }
}