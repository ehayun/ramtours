<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\model\airline;
use App\model\flight_schedule;
use App\model\flight_schedule_connection;
use Illuminate\Http\Request;

class Flight_ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        rami_setup_backend_language();
        $this->middleware('CheckRole');
    }
    public function index()
    {
        $data['flight_schedules'] = flight_schedule::all();
        $data['all_count'] = flight_schedule::all()->count();
        $data['trash_count'] = flight_schedule::onlyTrashed()->count();
        $data['page_title'] = 'All Flights Schedule';
        $data['assets_admin'] = url('assets/admin');
        return view('admin.flight_schedule.all_flight_schedule', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Add Flight Schedule';
        $data['airlines'] = airline::all();
        $data['assets_admin'] = url('assets/admin');
        $data['flight_connections_up'] = array();
        $data['flight_connections_down'] = array();
        return view('admin.flight_schedule.add_flight_schedule', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $flight_schedule = new flight_schedule;
        $messages = [];
        if (!empty($request->flight_up) && ($request->flight_type_up == 2)) {
            foreach ($request->flight_up as $flight) {
                $messages['up_departure_' . $flight . '.required'] = 'Please enter valid Departure Time';
                $messages['up_departure_' . $flight . '.date_format'] = 'Please enter valid Departure Time';
                $messages['up_departure_' . $flight . '.date'] = 'Please enter valid Departure Time';
                $messages['up_departure_' . $flight . '.after'] = 'Please enter valid Departure Time';
                $messages['up_departure_' . $flight . '.before'] = 'Please enter valid Departure Time';

                $messages['up_arrival_' . $flight . '.required'] = 'Please enter valid Arrival Time';
                $messages['up_arrival_' . $flight . '.date_format'] = 'Please enter valid Arrival Time';
                $messages['up_arrival_' . $flight . '.date'] = 'Please enter valid Arrival Time';
                $messages['up_arrival_' . $flight . '.after'] = 'Please enter valid Arrival Time';
                $messages['up_arrival_' . $flight . '.before'] = 'Please enter valid Arrival Time';
            }
        }
        if (!empty($request->flight_down) && ($request->flight_type_down == 2)) {
            foreach ($request->flight_down as $flight) {
                $messages['down_departure_' . $flight . '.required'] = 'Please enter valid Departure Time';
                $messages['down_departure_' . $flight . '.date_format'] = 'Please enter valid Departure Time';
                $messages['down_departure_' . $flight . '.date'] = 'Please enter valid Departure Time';
                $messages['down_departure_' . $flight . '.after'] = 'Please enter valid Departure Time';
                $messages['down_departure_' . $flight . '.before'] = 'Please enter valid Departure Time';

                $messages['down_arrival_' . $flight . '.required'] = 'Please enter valid Arrival Time';
                $messages['down_arrival_' . $flight . '.date_format'] = 'Please enter valid Arrival Time';
                $messages['down_arrival_' . $flight . '.date'] = 'Please enter valid Arrival Time';
                $messages['down_arrival_' . $flight . '.after'] = 'Please enter valid Arrival Time';
                $messages['down_arrival_' . $flight . '.before'] = 'Please enter valid Arrival Time';
            }
        }
        $valid_array = array(
            'flight_sche_title' => 'required|unique:flight_schedules',
            'airline_up' => 'required',
            'flight_up' => 'required',
            'flight_profit' => 'required|numeric',
            'price_per_person' => 'required|numeric',
            'flight_profit' => 'required|numeric',
            'profit_curr' => 'required|numeric|digits_between:1,4',
            'flight_type_up' => 'required|numeric|digits_between:1,2',
            'flight_type_down' => 'required|numeric|digits_between:1,2',
        );
        if ($request->flight_type_up == 1) {
            $valid_array['up_departure_time'] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|before:up_arrival_time';
            $valid_array['up_arrival_time'] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|after:up_departure_time';
        }
        if ($request->flight_type_down == 1) {
            $valid_array['down_departure_time'] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|before:down_arrival_time';
            $valid_array['down_arrival_time'] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|after:down_departure_time';
        }
        if (($request->flight_type_up == 2) && (!empty($request->flight_up))) {
            foreach ($request->flight_up as $flight) {
                $valid_array['up_departure_' . $flight] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|before:up_arrival_' . $flight;
                $valid_array['up_arrival_' . $flight] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|after:up_departure_' . $flight;
            }
        }
        if (($request->flight_type_down == 2) && (!empty($request->flight_down))) {
            foreach ($request->flight_down as $flight) {
                $valid_array['down_departure_' . $flight] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|before:down_arrival_' . $flight;
                $valid_array['down_arrival_' . $flight] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|after:down_departure_' . $flight;
            }
        }
        $this->validate($request, $valid_array, $messages);
        $flight_schedule->flight_sche_title = $request->flight_sche_title;
        $flight_schedule->price_per_person = $request->price_per_person;
        $flight_schedule->price_curr = $request->price_curr;
        $flight_schedule->profit_type = $request->profit_type;
        $flight_schedule->flight_profit = $request->flight_profit;
        $flight_schedule->package_profit = $request->package_profit;
        $flight_schedule->profit_curr = $request->profit_curr;
        $flight_schedule->flight_pnr_no = $request->flight_pnr_no;
        $flight_schedule->flight_type_up = $request->flight_type_up;
        $flight_schedule->flight_type_down = $request->flight_type_down;
        $flight_schedule->num_available_seat = $request->num_available_seat;
        $flight_schedule->num_total_seat = $request->num_total_seat;
        $flight_schedule->flight_incr_price_str = $request->flight_incr_price_str;
        $flight_schedule->price_incr_90 = $request->price_incr_90;
        $flight_schedule->price_incr_80 = $request->price_incr_80;
        $flight_schedule->price_incr_70 = $request->price_incr_70;
        $flight_schedule->price_incr_60 = $request->price_incr_60;
        $flight_schedule->price_incr_50 = $request->price_incr_50;
        $flight_schedule->price_incr_40 = $request->price_incr_40;
        $flight_schedule->price_incr_30 = $request->price_incr_30;
        $flight_schedule->price_incr_20 = $request->price_incr_20;
        $flight_schedule->price_incr_10 = $request->price_incr_10;
        $flight_schedule->flight_sche_desc = $request->flight_sche_desc;
        $flight_schedule->flight_sche_status = $request->flight_sche_status;
        if ($request->flight_type_up == 1) {
            $flight_schedule->airline_up = $request->airline_up;
            $flight_schedule->flight_up = $request->flight_up;
            $flight_schedule->up_departure_time = $request->up_departure_time;
            $flight_schedule->up_arrival_time = $request->up_arrival_time;
        }
        if ($request->flight_type_down == 1) {
            $flight_schedule->airline_down = $request->airline_down;
            $flight_schedule->flight_down = $request->flight_down;
            $flight_schedule->down_departure_time = $request->down_departure_time;
            $flight_schedule->down_arrival_time = $request->down_arrival_time;

        }
        $flight_schedule->save();

        // Update the relevants packages
        // ===============================
        $this->updatePackagesProfit($flight_schedule);
        //================================
        if ($request->flight_type_up == 2) {
            $flight_schedule->multi_airline_up = serialize($request->airline_up);
            $flight_schedule->multi_flight_up = serialize($request->flight_up);
            foreach ($request->flight_up as $flight) {
                $new_conn = new flight_schedule_connection;
                $new_conn->flight_id = $flight;
                $new_conn->flight_schedule_id = $flight_schedule->id;
                $new_conn->departure_time = $request->{'up_departure_' . $flight};
                $new_conn->arrival_time = $request->{'up_arrival_' . $flight};
                $new_conn->type = 1;
                $new_conn->save();
            }
            $departure_flight = flight_schedule_connection::where([['type', 1], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get()->first();
            $arrival_flight = flight_schedule_connection::where([['type', 1], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'desc')->get()->first();
            $flight_schedule->up_departure_time = $departure_flight->departure_time;
            $flight_schedule->up_arrival_time = $arrival_flight->arrival_time;
            $flight_schedule->airline_up = $departure_flight->flight->flight_airline;
            $flight_schedule->flight_up = $departure_flight->flight_id;
        }
        if ($request->flight_type_down == 2) {
            $flight_schedule->multi_airline_down = serialize($request->airline_down);
            $flight_schedule->multi_flight_down = serialize($request->flight_down);
            foreach ($request->flight_down as $flight) {
                $new_conn = new flight_schedule_connection;
                $new_conn->flight_id = $flight;
                $new_conn->flight_schedule_id = $flight_schedule->id;
                $new_conn->departure_time = $request->{'down_departure_' . $flight};
                $new_conn->arrival_time = $request->{'down_arrival_' . $flight};
                $new_conn->type = 2;
                $new_conn->save();
            }
            $departure_flight_down = flight_schedule_connection::where([['type', 2], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get()->first();
            $arrival_flight_down = flight_schedule_connection::where([['type', 2], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'desc')->get()->first();
            $flight_schedule->down_departure_time = $departure_flight_down->departure_time;
            $flight_schedule->down_arrival_time = $arrival_flight_down->arrival_time;
            $flight_schedule->airline_down = $arrival_flight_down->flight->flight_airline;
            $flight_schedule->flight_down = $arrival_flight_down->flight_id;
        }
        $flight_schedule->save();
        set_flash_msg('flash_success', 'Flight Schedule Inserted Successsfully.');
        return redirect('admin/flight-schedule');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['flight_schedule'] = flight_schedule::find($id);
        if (empty($data['flight_schedule'])) {
            return redirect('admin/flight-schedule');
        }
        $data['page_title'] = 'Edit Flight Schedule';
        $data['airlines'] = airline::all();
        if ($data['flight_schedule']->flight_type_up == 2) {
            $flight_connections = flight_schedule_connection::where([['flight_schedule_id', $data['flight_schedule']->id], ['type', 1]])->orderBy('departure_time')->get();
            foreach ($flight_connections as $flight_connection) {
                $data['flight_connections_up'][$flight_connection->flight_id] = $flight_connection;
            }
        }
        if ($data['flight_schedule']->flight_type_down == 2) {
            $flight_connections = flight_schedule_connection::where([['flight_schedule_id', $data['flight_schedule']->id], ['type', 2]])->orderBy('departure_time')->get();
            foreach ($flight_connections as $flight_connection) {
                $data['flight_connections_down'][$flight_connection->flight_id] = $flight_connection;
            }
        }
        $data['assets_admin'] = url('assets/admin');
        return view('admin.flight_schedule.edit_flight_schedule', $data);
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
        $flight_schedule = flight_schedule::find($id);
        $messages = [];
        if (!empty($request->flight_up) && ($request->flight_type_up == 2)) {
            foreach ($request->flight_up as $flight) {
                $messages['up_departure_' . $flight . '.required'] = 'Please enter valid Departure Time';
                $messages['up_departure_' . $flight . '.date_format'] = 'Please enter valid Departure Time';
                $messages['up_departure_' . $flight . '.date'] = 'Please enter valid Departure Time';
                $messages['up_departure_' . $flight . '.after'] = 'Please enter valid Departure Time';
                $messages['up_departure_' . $flight . '.before'] = 'Please enter valid Departure Time';

                $messages['up_arrival_' . $flight . '.required'] = 'Please enter valid Arrival Time';
                $messages['up_arrival_' . $flight . '.date_format'] = 'Please enter valid Arrival Time';
                $messages['up_arrival_' . $flight . '.date'] = 'Please enter valid Arrival Time';
                $messages['up_arrival_' . $flight . '.after'] = 'Please enter valid Arrival Time';
                $messages['up_arrival_' . $flight . '.before'] = 'Please enter valid Arrival Time';
            }
        }
        if (!empty($request->flight_down) && ($request->flight_type_down == 2)) {
            foreach ($request->flight_down as $flight) {
                $messages['down_departure_' . $flight . '.required'] = 'Please enter valid Departure Time';
                $messages['down_departure_' . $flight . '.date_format'] = 'Please enter valid Departure Time';
                $messages['down_departure_' . $flight . '.date'] = 'Please enter valid Departure Time';
                $messages['down_departure_' . $flight . '.after'] = 'Please enter valid Departure Time';
                $messages['down_departure_' . $flight . '.before'] = 'Please enter valid Departure Time';

                $messages['down_arrival_' . $flight . '.required'] = 'Please enter valid Arrival Time';
                $messages['down_arrival_' . $flight . '.date_format'] = 'Please enter valid Arrival Time';
                $messages['down_arrival_' . $flight . '.date'] = 'Please enter valid Arrival Time';
                $messages['down_arrival_' . $flight . '.after'] = 'Please enter valid Arrival Time';
                $messages['down_arrival_' . $flight . '.before'] = 'Please enter valid Arrival Time';
            }
        }
        $valid_array = array(
            'flight_sche_title' => 'required',
            'airline_up' => 'required',
            'flight_up' => 'required',
            'flight_profit' => 'required|numeric',
            'price_per_person' => 'required|numeric',
            'flight_profit' => 'required|numeric',
            'profit_curr' => 'required|numeric|digits_between:1,4',
            'flight_type_up' => 'required|numeric|digits_between:1,2',
            'flight_type_down' => 'required|numeric|digits_between:1,2',
        );
        if ($request->flight_type_up == 1) {
            $valid_array['up_departure_time'] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|before:up_arrival_time';
            $valid_array['up_arrival_time'] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|after:up_departure_time';
        }
        if ($request->flight_type_down == 1) {
            $valid_array['down_departure_time'] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|before:down_arrival_time';
            $valid_array['down_arrival_time'] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|after:down_departure_time';
        }
        if (($request->flight_type_up == 2) && (!empty($request->flight_up))) {
            foreach ($request->flight_up as $flight) {
                $valid_array['up_departure_' . $flight] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|before:up_arrival_' . $flight;
                $valid_array['up_arrival_' . $flight] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|after:up_departure_' . $flight;
            }
        }
        if (($request->flight_type_down == 2) && (!empty($request->flight_down))) {
            foreach ($request->flight_down as $flight) {
                $valid_array['down_departure_' . $flight] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|before:down_arrival_' . $flight;
                $valid_array['down_arrival_' . $flight] = 'required|date|date_format:Y-m-d H:i:s|after:yesterday|after:down_departure_' . $flight;
            }
        }
        $this->validate($request, $valid_array, $messages);
        $flight_schedule->flight_sche_title = $request->flight_sche_title;
        $flight_schedule->price_per_person = $request->price_per_person;
        $flight_schedule->price_curr = $request->price_curr;
        $flight_schedule->profit_type = $request->profit_type;
        $flight_schedule->flight_profit = $request->flight_profit;
        $flight_schedule->package_profit = $request->package_profit;
        $flight_schedule->profit_curr = $request->profit_curr;
        $flight_schedule->flight_pnr_no = $request->flight_pnr_no;
        $flight_schedule->flight_type_up = $request->flight_type_up;
        $flight_schedule->flight_type_down = $request->flight_type_down;
        $flight_schedule->num_available_seat = $request->num_available_seat;
        $flight_schedule->num_total_seat = $request->num_total_seat;
        $flight_schedule->flight_incr_price_str = $request->flight_incr_price_str;
        $flight_schedule->price_incr_90 = $request->price_incr_90;
        $flight_schedule->price_incr_80 = $request->price_incr_80;
        $flight_schedule->price_incr_70 = $request->price_incr_70;
        $flight_schedule->price_incr_60 = $request->price_incr_60;
        $flight_schedule->price_incr_50 = $request->price_incr_50;
        $flight_schedule->price_incr_40 = $request->price_incr_40;
        $flight_schedule->price_incr_30 = $request->price_incr_30;
        $flight_schedule->price_incr_20 = $request->price_incr_20;
        $flight_schedule->price_incr_10 = $request->price_incr_10;
        $flight_schedule->flight_sche_desc = $request->flight_sche_desc;
        $flight_schedule->flight_sche_status = $request->flight_sche_status;
        if ($request->flight_type_up == 1) {
            $flight_schedule->airline_up = $request->airline_up;
            $flight_schedule->flight_up = $request->flight_up;
            $flight_schedule->up_departure_time = $request->up_departure_time;
            $flight_schedule->up_arrival_time = $request->up_arrival_time;
        }
        if ($request->flight_type_down == 1) {
            $flight_schedule->airline_down = $request->airline_down;
            $flight_schedule->flight_down = $request->flight_down;
            $flight_schedule->down_departure_time = $request->down_departure_time;
            $flight_schedule->down_arrival_time = $request->down_arrival_time;

        }
        $flight_schedule->save();
        // Update the relevants packages
        // ===============================
        $this->updatePackagesProfit($flight_schedule);
        //================================
        if (($request->flight_type_up == 2) || ($request->flight_type_down == 2)) {
            $new_conn = flight_schedule_connection::where([['flight_schedule_id', $flight_schedule->id]]);
            $new_conn->delete();
        }
        if ($request->flight_type_up == 2) {
            $flight_schedule->multi_airline_up = serialize($request->airline_up);
            $flight_schedule->multi_flight_up = serialize($request->flight_up);
            foreach ($request->flight_up as $flight) {
                $new_conn = new flight_schedule_connection;
                $new_conn->flight_id = $flight;
                $new_conn->flight_schedule_id = $flight_schedule->id;
                $new_conn->departure_time = $request->{'up_departure_' . $flight};
                $new_conn->arrival_time = $request->{'up_arrival_' . $flight};
                $new_conn->type = 1;
                $new_conn->save();
            }
            $departure_flight = flight_schedule_connection::where([['type', 1], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get()->first();
            $arrival_flight = flight_schedule_connection::where([['type', 1], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'desc')->get()->first();
            $flight_schedule->up_departure_time = $departure_flight->departure_time;
            $flight_schedule->up_arrival_time = $arrival_flight->arrival_time;
            $flight_schedule->airline_up = $departure_flight->flight->flight_airline;
            $flight_schedule->flight_up = $departure_flight->flight_id;
        }
        if ($request->flight_type_down == 2) {
            $flight_schedule->multi_airline_down = serialize($request->airline_down);
            $flight_schedule->multi_flight_down = serialize($request->flight_down);
            foreach ($request->flight_down as $flight) {
                $new_conn = new flight_schedule_connection;
                $new_conn->flight_id = $flight;
                $new_conn->flight_schedule_id = $flight_schedule->id;
                $new_conn->departure_time = $request->{'down_departure_' . $flight};
                $new_conn->arrival_time = $request->{'down_arrival_' . $flight};
                $new_conn->type = 2;
                $new_conn->save();
            }
            $departure_flight = flight_schedule_connection::where([['type', 2], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get()->first();
            $arrival_flight = flight_schedule_connection::where([['type', 2], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'desc')->get()->first();
            $flight_schedule->down_departure_time = $departure_flight->departure_time;
            $flight_schedule->down_arrival_time = $arrival_flight->arrival_time;
            $flight_schedule->airline_down = $departure_flight->flight->flight_airline;
            $flight_schedule->flight_down = $arrival_flight->flight_id;
        }
        $flight_schedule->save();
        set_flash_msg('flash_success', 'Flight Schedule Updated Successsfully.');
        return redirect('admin/flight-schedule');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $flight_schedule = flight_schedule::find($id);
        $flight_schedule->delete();
        set_flash_msg('flash_success', 'Flight Schedule Deleted Successsfully.');
        return redirect('admin/flight-schedule');
    }
    public function trash_flight_sche()
    {
        $data['page_title'] = 'All Trash flight';
        $data['trash_flight'] = flight_schedule::onlyTrashed()->get();
        $data['all_count'] = flight_schedule::onlyTrashed()->count();
        $data['assets_admin'] = url('assets/admin');
        return view('admin.flight_schedule.all_trashed_flight_schedule', $data);
    }
    public function restore_trash_flight_sche()
    {
        $flight = flight_schedule::onlyTrashed()->restore();
        if (!empty($flight)) {
            set_flash_msg('flash_success', 'Trash flight Restore Successsfully.');
            return redirect('admin/flight-schedule');
        } else {
            set_flash_msg('flash_error', 'Trash flight not Found for Restore.');
            return redirect('admin/flight-schedule/trash');
        }
    }
    public function restore_single_flight_sche($id)
    {
        $flight = flight_schedule::onlyTrashed()->where(['id' => $id])->restore();
        if (!empty($flight)) {
            set_flash_msg('flash_success', 'Trash flight Restore Successsfully.');
            return redirect('admin/flight-schedule');
        } else {
            set_flash_msg('flash_error', 'Trash flight not found for Restore.');
            return redirect('admin/flight-schedule/trash');
        }
    }
    public function force_delete_flight_sche($id)
    {
        $flight = flight_schedule::onlyTrashed()->where(['id' => $id]);
        flight_schedule_connection::where([['flight_schedule_id', $id]])->delete();
        $flight->forceDelete();
        set_flash_msg('flash_success', 'Flight schedule deleted successfully.');
        return redirect('admin/flight-schedule/trash');
    }
    public function force_delete_all_sche()
    {
        $flight_schedule = flight_schedule::onlyTrashed();
        $flight_schedules = $flight_schedule->get();
        foreach ($flight_schedules as $id) {
            flight_schedule_connection::where([['flight_schedule_id', $id]])->delete();
        }
        $flight_schedule->forceDelete();
        set_flash_msg('flash_success', 'All flight schedule deleted successfully.');
        return redirect('admin/flight-schedule/trash');
    }
    public function add_flight_sche_meta_data($id)
    {
        $data['flight_schedule'] = flight_schedule::find($id);
        if (empty($data['flight_schedule'])) {
            set_flash_msg('flash_error', 'flight schedule not found.');
            return redirect('admin/flight-schedule');
        }
        $data['page_title'] = 'Add flight schedule meta data';
        $data['assets_admin'] = url('assets/admin');
        return view('admin.flight_schedule.add_flight_sche_meta_data', $data);
    }
    public function save_flight_sche_meta_data(Request $request, $id)
    {
        $flight_schedule = flight_schedule::find($id);
        $flight_schedule->slug = $request->slug;
        $flight_schedule->flight_sche_title_text = $request->flight_sche_title_text;
        $flight_schedule->flight_sche_header_custom_code = $request->flight_sche_header_custom_code;
        $flight_schedule->flight_sche_footer_custom_code = $request->flight_sche_footer_custom_code;
        $flight_schedule->save();
        set_flash_msg('flash_success', 'flight schedule meta data updated successfully');
        return redirect('admin/flight-schedule-meta/' . $id);
    }
    public function flight_schedule_alert($id)
    {
        $data['flight_schedule'] = flight_schedule::find($id);
        if (empty($data['flight_schedule'])) {
            set_flash_msg('flash_error', 'flight schedule not found.');
            return redirect('admin/flight-schedule');
        }
        $data['assets_admin'] = url('assets/admin');
        $data['page_title'] = 'flight schedule alerts';
        return view('admin/flight_schedule/flight_sche_alert', $data);
    }
    public function store_flight_schedule_alert(Request $request, $id)
    {
        $flight_schedule = flight_schedule::find($id);
        $messages = [
        ];
        $this->validate($request, [
            // 'booking_date' => 'required',
            // 'alert_date_1' => 'required',
            // 'alert_date_2' => 'required',
            // 'alert_date_3' => 'required',
            // 'alert_date_4' => 'required',
            // 'alert_date_5' => 'required',
        ], $messages);
        $flight_schedule->booking_date = $request->booking_date;
        $flight_schedule->alert_date_1 = $request->alert_date_1;
        $flight_schedule->alert_msg_1 = $request->alert_msg_1;
        $flight_schedule->alert_date_2 = $request->alert_date_2;
        $flight_schedule->alert_msg_2 = $request->alert_msg_2;
        $flight_schedule->alert_date_3 = $request->alert_date_3;
        $flight_schedule->alert_msg_3 = $request->alert_msg_3;
        $flight_schedule->alert_date_4 = $request->alert_date_4;
        $flight_schedule->alert_msg_4 = $request->alert_msg_4;
        $flight_schedule->alert_date_5 = $request->alert_date_5;
        $flight_schedule->alert_msg_5 = $request->alert_msg_5;
        $flight_schedule->save();
        set_flash_msg('flash_success', 'flight schedule Alert Inserted Successsfully.');
        return redirect('admin/flight-schedule-alert/' . $id);
    }

    private function updatePackagesProfit($sc)
    {

    }
}