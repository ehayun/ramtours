@extends('admin.main')
@section('admin_head_css')
@parent
    <link rel="stylesheet" href="{{ $assets_admin }}/plugins/bootstrap-select/css/bootstrap-select.css" />
    <link href="{{ $assets_admin }}/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

@endsection

@section('title',$page_title)

@section('title_breadcrumb',$page_title)

@section('admin_container')
@php

   if(empty($package))

    $package='';

@endphp

 {!!show_flash_msg()!!}


{{-- empty check for edit purpose and helper use--}}

        <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="body">
                        @section('nav-tabs')
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active"  href="javascript:void(0)" data-toggle="tab">Package Info</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="javascript:void(0)">Meta data</a></li>
                            </ul>
                        @show 
                        <form action="{{url('admin/package')}}@yield('edit_package_id')" id="add_package" method="POST" accept-charset="utf-8" enctype="multipart/form-data">

                            {{ csrf_field() }}
                            @section('method_field')
                            @show

                            <div class="form-group form-float">

                                <div class="form-line">

                                    <input type="text" class="form-control" name="package_title" value="{!! get_edit_input_pvr_old_value_with_obj('package_title',$package, 'package_title')!!}">

                                    {!! get_form_error_msg($errors, 'package_title') !!}

                                    <label class="form-label">Package Title</label>

                                </div>
                               <p class="font col-orange">This is automatically generated by selecting location.</p>

                            </div>
                            <div class="form-group form-float">

                                <label class="profit">Title Display in Package Page: </label>

                                <input type="radio" name="is_display_pkg_title" id="yes" class="with-gap radio-col-amber" value="1" {!!get_edit_select_check_pvr_old_value_with_obj('is_display_pkg_title',$package,'is_display_pkg_title',1, 'chacked')!!}>

                                <label for="yes" class="m-l-10 m-r-10">yes</label>

                                <input type="radio" name="is_display_pkg_title"  id="no" class="with-gap radio-col-amber" value="0" {!!get_edit_select_check_pvr_old_value_with_obj('is_display_pkg_title',$package,'is_display_pkg_title',0, 'chacked')!!}>
                                <label for="no" class="m-l-10 m-r-10">No</label>
                                {!! get_form_error_msg($errors, 'is_display_pkg_title') !!}
                            </div>
                            <div class="form-group form-float">

                                <div class="form-line">

                                    <select class="form-control show-tick rami_package_type" name="package_type" value="">

                                        <option value="">Select One</option>

                                        <option value="1" {{ get_edit_select_check_pvr_old_value_with_obj('package_type', $package,'package_type', '1', 'select')}}>flight+Hotel+car</option>
                                        {{-- <option value="2" {{ get_edit_select_check_pvr_old_value_with_obj('package_type', $package, 'package_type', '2', 'select')}}>flight+Hotel</option> --}}
                                        <option value="3" {{ get_edit_select_check_pvr_old_value_with_obj('package_type', $package, 'package_type', '3', 'select')}}>flight+car</option>
                                       {{--  <option value="4"{{ get_edit_select_check_pvr_old_value_with_obj('package_type', $package, 'package_type', '4', 'select')}}>flight</option>
                                        <option value="5"{{ get_edit_select_check_pvr_old_value_with_obj('package_type', $package, 'package_type', '5', 'select')}}>Accomodation</option> --}}
                                    </select>
                                    <label class="form-label">Package Type</label>
                                </div>
                                {!! get_form_error_msg($errors, 'package_type') !!}
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">Enter Discription</label>
                                    <br><br>
                                    <textarea class="ckeditor" name="package_desc">{!! get_edit_input_pvr_old_value_with_obj('package_desc',$package,'package_desc')!!}</textarea>
                                    {!! get_form_error_msg($errors, 'package_desc') !!}
                                </div>
                            </div>
                                {{-- <pre> {{ print_r($locations) }}</pre> --}}
                             <div class="form-group form-float">
                                <div class="form-line">
                                    <select class="form-control show-tick" name="package_flight_location" id="package_flight_location" data-live-search="true">
                                        <option value="">Select Location</option>
                                         @foreach($locations as $location)
                                            <option value="{{$location->id}}" {{get_edit_select_check_pvr_old_value_with_obj('package_flight_location', $package, 'package_flight_location', $location->id, 'select')}} >{{$location->loc_name}}</option>
                                            {!! get_loctions_child_option($location->id) !!}
                                         @endforeach
                                    </select>
                                    <label class="form-label">Location</label>
                                </div>
                                {!! get_form_error_msg($errors, 'package_flight_location') !!}
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">Package Start Date</label>
                                    <input type="text" class="form-control flight_start_date" name="package_start_date" value="{!! get_edit_input_pvr_old_value_with_obj('package_start_date',$package, 'package_start_date')!!}">
                                    {!! get_form_error_msg($errors, 'package_start_date') !!}
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">Package End Date</label>
                                    <input type="text" class="form-control flight_start_date" name="package_end_date" value="{!! get_edit_input_pvr_old_value_with_obj('package_end_date',$package, 'package_end_date')!!}">
                                    {!! get_form_error_msg($errors, 'package_end_date') !!}
                                </div>
                            </div>
                            <div class="form-group form-float rami_airline_all">
                                <div class="form-line">
                                    <select class="form-control show-tick package_airline" name="package_airline[]" id="airline_id" data-live-search="true" multiple="">
                                        <option value="">Select Airline</option>
                                        @if(!empty($airlines))
                                        @foreach($airlines as $airline)
                                        <option value="{{$airline->id}}" {{ get_edit_select_check_pvr_old_value_with_obj_serlizie('package_airline', $package, 'package_airline', $airline->id ,'select')}}>{{$airline->airl_title}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <label class="form-label">Airline</label>
                                </div>
                                {!! get_form_error_msg($errors, 'package_airline') !!}
                            </div>
                            <div class="form-group form-float rami_airline_all">
                                <div class="form-line">
                                    <select class="form-control show-tick package_flight_sche" name="package_flight_sche[]" id="flight_sche_id" multiple="" data-live-search="true" prv_flight_sche="{{ rami_get_prv_serialize_data('package_flight_sche',$package, 'package_flight_sche') }}">
                                        <option value="">Select Flight Schedule</option>
                                    </select>
                                    <label class="form-label">Flight Schedule</label>
                                </div>
                                {!! get_form_error_msg($errors, 'package_flight_sche') !!}
                            </div>
                            <div class="form-group form-float rami_hotel_all">
                                <div class="form-line">
                                    <select class="form-control show-tick package_hotel" name="package_hotel" id='package_hotel_id' data-live-search="true" prv_hotel="{{get_edit_input_pvr_old_value_with_obj('package_hotel',$package, 'package_hotel')}}">
                                    </select>
                                    <label class="form-label">Hotel</label>
                                </div>
                                {!! get_form_error_msg($errors, 'package_hotel') !!}
                            </div>
                            <div class="form-group form-float rami_hotel_all">

                                <div class="form-line">

                                    <select class="form-control show-tick package_hotel_room" name="package_hotel_room[]" id="hotel_room_id" multiple="" data-live-search="true" prv_rooms="{{ rami_get_prv_serialize_data('package_hotel_room',$package, 'package_hotel_room') }}">
                                        <option value="">Select Room</option>
                                    </select>
                                    <label class="form-label">Room</label>
                                </div>

                                {!! get_form_error_msg($errors, 'package_hotel_room') !!}

                            </div>
                            <label id="room_stock">Room Stock</label>
                            
                            @foreach (rami_get_prv_serialize_data_array('package_hotel_room',$package, 'package_hotel_room') as $room)
                                <input type="hidden" name="room_prv_stock_{{$room}}" value=" {{get_edit_input_pvr_old_value('room_stock_'.$room, get_rami_package_room_avalible($package_id, $room))}}">
                            @endforeach
                            <div class="row" id="package_rooms_stock" style="border: 1px solid #e0e0e0; margin: 0px;">
                            </div>
                            <div class="form-group form-float rami_car_pack">
                                <div class="form-line">
                                    <select class="form-control show-tick package_car" name="package_car[]" id="car_id" multiple="" data-live-search="true" prv_car="{{ rami_get_prv_serialize_data('package_car',$package, 'package_car') }}">
                                        <option value="">Select Car</option>
                                    </select>
                                    <label class="form-label">Cars</label>
                                </div>
                                {!! get_form_error_msg($errors, 'package_car') !!}
                            </div>

                            <div class="form-group form-float">

                                <label class="profit">Profit : </label>

                                <input type="radio" name="package_profit_type" id="flat" class="with-gap radio-col-amber" value="1" {!!get_edit_select_check_pvr_old_value_with_obj('package_profit_type',$package,'package_profit_type',1, 'chacked')!!}>

                                <label for="flat" class="m-l-10 m-r-10">flat</label>

                                <input type="radio" name="package_profit_type"  id="per" class="with-gap radio-col-amber" value="2" {!!get_edit_select_check_pvr_old_value_with_obj('package_profit_type',$package,'package_profit_type',2, 'chacked')!!}>

                                <label for="per" class="m-l-10 m-r-10">percentage</label>

                                {!! get_form_error_msg($errors, 'package_profit_type') !!}
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line"> 
                                    <select class="form-control show-tick profit_currency" name="profit_curr">
                                        <option value="1" {{get_edit_select_check_pvr_old_value_with_obj('profit_curr', $package, 'profit_curr', 1, 'select')}} >USD</option>
                                        <option value="2" {{get_edit_select_check_pvr_old_value_with_obj('profit_curr', $package, 'profit_curr', 2, 'select')}} >Euro </option>
                                        <option value="3" {{get_edit_select_check_pvr_old_value_with_obj('profit_curr', $package, 'profit_curr', 3, 'select')}} >Swiss Franc</option>
                                        <option value="4" {{get_edit_select_check_pvr_old_value_with_obj('profit_curr', $package, 'profit_curr', 4, 'select')}}>Shekel</option>
                                    </select>
                                    <label class="form-label">Profit Currency</label>
                                </div>
                                {!! get_form_error_msg($errors, 'profit_curr') !!}
                            </div>
                            <div class="form-group form-float rami_fhc_pack">
                                <div class="form-line">
                                    <input type="text" class="form-control" name="package_profit_fhc" value="{!! get_edit_input_pvr_old_value_with_obj('package_profit_fhc',$package, 'package_profit_fhc')!!}">
                                    {!! get_form_error_msg($errors, 'package_profit_fhc') !!}
                                    <label class="form-label">Package profit per person for ( F + H + C )</label>
                                </div>
                            </div>
                            {{-- <div class="form-group form-float rami_fh_pack">
                                <div class="form-line">
                                   <input type="text" class="form-control" name="package_profit_fh" value="{!! get_edit_input_pvr_old_value_with_obj('package_profit_fh',$package, 'package_profit_fh')!!}">

                                    {!! get_form_error_msg($errors, 'package_profit_fh') !!}

                                    <label class="form-label">Package profit per person for ( F + H )</label>

                                </div>

                            </div>
 --}}
                            <div class="form-group form-float rami_fc_pack">

                                <div class="form-line">

                                    <input type="text" class="form-control" name="package_profit_fc" value="{!! get_edit_input_pvr_old_value_with_obj('package_profit_fc',$package, 'package_profit_fc')!!}">

                                    {!! get_form_error_msg($errors, 'package_profit_fc') !!}

                                    <label class="form-label">Package profit per person for ( F + C )</label>

                                </div>
                            </div> 
                             <div class="form-group form-float">

                                <label class="profit">Hot Deal : </label>

                                <input type="radio" name="is_hot_deal" id="hot_yes" class="with-gap radio-col-amber" value="1" {!!get_edit_select_check_pvr_old_value_with_obj('is_hot_deal',$package,'is_hot_deal',1, 'chacked')!!}>

                                <label for="hot_yes" class="m-l-10 m-r-10">yes</label>

                                <input type="radio" name="is_hot_deal"  id="hot_no" class="with-gap radio-col-amber" value="0" {!!get_edit_select_check_pvr_old_value_with_obj('is_hot_deal',$package,'is_hot_deal',0, 'chacked')!!}>
                                <label for="hot_no" class="m-l-10 m-r-10">No</label>
                                {!! get_form_error_msg($errors, 'is_hot_deal') !!}
                            </div>                           
                            <div class="form-group form-float">

                                <label class="profit">Instant Approval : </label>

                                <input type="radio" name="instant_approval" id="ins_yes" class="with-gap radio-col-amber" value="1" {!!get_edit_select_check_pvr_old_value_with_obj('instant_approval',$package,'instant_approval',1, 'chacked')!!}>

                                <label for="ins_yes" class="m-l-10 m-r-10">yes</label>

                                <input type="radio" name="instant_approval"  id="ins_no" class="with-gap radio-col-amber" value="0" {!!get_edit_select_check_pvr_old_value_with_obj('instant_approval',$package,'instant_approval',0, 'chacked')!!}>
                                <label for="ins_no" class="m-l-10 m-r-10">No</label>
                                {!! get_form_error_msg($errors, 'instant_approval') !!}
                            </div>
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <label class="form-label">Package Instruction Text</label>
                                    <br><br>
                                    <textarea name="pkg_instruction_text" rows="5" style="width:100%;margin-top: -20px" >{!! get_edit_input_pvr_old_value_with_obj('pkg_instruction_text',$package,'pkg_instruction_text')!!}</textarea>
                                    {!! get_form_error_msg($errors, 'pkg_instruction_text') !!}
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <label class="profit">Package Status : </label>
                                <input type="radio" name="package_status" id="active" class="with-gap radio-col-amber" value="1" {!!get_edit_select_check_pvr_old_value_with_obj('package_status',$package,'package_status',1, 'chacked')!!}>
                                <label for="active" class="m-l-10 m-r-10">Active</label>
                                <input type="radio" name="package_status" id="Inactive" class="with-gap radio-col-amber" value="0" {!!get_edit_select_check_pvr_old_value_with_obj('package_status',$package,'package_status',0, 'chacked')!!}>
                                <label for="Inactive" class="m-l-10 m-r-10">Inactive</label>
                                {!! get_form_error_msg($errors, 'package_status') !!}
                            </div>                            
                            <button type="submit" class="btn btn-success btn-primary waves-effect m-t-20">Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
@section('admin_jscript')
@parent
    <script src="{{ $assets_admin }}/js/pages/forms/editors.js"></script>
    <script src="{{ $assets_admin }}/plugins/ckeditor/ckeditor.js"></script> <!-- Ckeditor -->
    <script src="{{ $assets_admin }}/plugins/momentjs/moment.js"></script>
    <script src="{{ $assets_admin }}/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <script type="text/javascript">
        $('.flight_start_date').bootstrapMaterialDatePicker({
            format: 'YYYY-MM-DD',
            clearButton: true,
            time: false
        });
        $('.profit_currency').selectpicker({
            liveSearchPlaceholder:'Search Profit Currency',
            noneSelectedText:'Please Select Profit Currency',
            title:'Profit Currency',
            liveSearch:"true",
            noneResultsText: 'Profit Currency not found.'
        });
        $("#add_tag").validate({
            rules: {
                title:{
                    required: true,
                    maxlength: 100,
                },
                contact_no:{
                    required: true,
                }
            },
            messages: {
                title: {
                    required: "Please enter Name here.",
                    maxlength:"Sub Category Name contain only 100 Charecters ."
                },
                contact_no:{
                    required:"Please enter cotact number here.",
                }
            }
        });
        $(document).ready(function() {
            $('#add_package').on('change', '#package_hotel_id', function(event) {
                event.preventDefault();
                var hotel_id=$(this).val();
                get_room_via_hotel_id(hotel_id);
                $('#package_rooms_stock').empty();
                 $('#package_rooms_stock').hide();
            });
            if($('#airline_id').val()!==''){
                var airline_id =$('#airline_id').val();
                get_airline_flight_sche_id(airline_id);
            }
            $('#add_package').on('change', '#airline_id', function(event) {
                event.preventDefault();
                var airline_id=$(this).val();
                get_airline_flight_sche_id(airline_id);
            });
            if($('#package_flight_location').val()!==''){
                var loc_id =$('#package_flight_location').val();
                get_hotel_from_loc_id(loc_id);
            }

            $('#add_package').on('change', '#flight_sche_id', function(event) {
                event.preventDefault();
                var flight_sche_ids=$(this).val();
                get_cars_from_flight_sche_ids(flight_sche_ids);
            });
            
            $('#add_package').on('change', '#package_flight_location', function(event) {
                event.preventDefault();
                var loc_id=$(this).val();
                get_hotel_from_loc_id(loc_id);
                set_package_title_here($(this));
            });
            if($('select.rami_package_type').val()!==''){
                if($('select.rami_package_type').val()==1){ //f+h+c
                    $('.rami_hotel_all').show();
                    $('.rami_airline_all').show();
                    $('.rami_car_pack').show();
                    $('.rami_fhc_pack').show();
                    $('.rami_fh_pack').hide();
                    $('.rami_fc_pack').hide();
                }else if($('select.rami_package_type').val()==2){ //f+h
                    $('.rami_hotel_all').show();
                    $('.rami_airline_all').show();
                    $('.rami_fh_pack').show();
                    $('.rami_car_pack').hide();
                    $('.rami_fhc_pack').hide();
                    $('.rami_fc_pack').hide();
                }else if($('select.rami_package_type').val()==3){ //f+c
                    $('.rami_airline_all').show();
                    $('.rami_car_pack').show();
                    $('.rami_fc_pack').show();
                    $('.rami_hotel_all').hide();
                    $('.rami_fhc_pack').hide();
                    $('.rami_fh_pack').hide();
                }
            }
            $('#add_package').on('change', 'select.rami_package_type', function(event) {
                event.preventDefault();
                /* Act on the event */
                if($(this).val()==1){ //f+h+c
                    $('.rami_hotel_all').show();
                    $('.rami_airline_all').show();
                    $('.rami_car_pack').show();
                    $('.rami_fhc_pack').show();
                    $('.rami_fh_pack').hide();
                    $('.rami_fc_pack').hide();
                }else if($(this).val()==2){ //f+h
                    $('.rami_hotel_all').show();
                    $('.rami_airline_all').show();
                    $('.rami_fh_pack').show();
                    $('.rami_car_pack').hide();
                    $('.rami_fhc_pack').hide();
                    $('.rami_fc_pack').hide();
                }else if($(this).val()==3){ //f+c
                    $('.rami_airline_all').show();
                    $('.rami_car_pack').show();
                    $('.rami_fc_pack').show();
                    $('.rami_hotel_all').hide();
                    $('.rami_fhc_pack').hide();
                    $('.rami_fh_pack').hide();
                }
            });
        });
        function get_hotel_from_loc_id(loc_id){
            //alert('ajax working');
            $.ajax({
                url: "{{ url('/get_hotel_from_loc_id') }}",
                type: 'POST',
                data: {_token:'{{csrf_token()}}', loc_id:loc_id},
            })
            .done(function(res) {
                var selected='';
                var option='<option value="">Select Hotel</option>';;
                var prv_hotel=$('#package_hotel_id').attr('prv_hotel');
                if(res.status=='success'){
                    $.each(res.hotel, function(index, el) {
                        el.id=el.id.toString();
                        if(el.id== prv_hotel){
                            selected='selected="true"';
                        }else{
                            selected='';
                        }
                        option+='<option value="'+el.id+'" '+selected+'>' +el.hotel_code+ '</option>';
                    });
                }
                $('#package_hotel_id').html();
                $('#package_hotel_id').html(option);
                $('#package_hotel_id').selectpicker('refresh');
                if($('#package_hotel_id').val()!==''){
                var hotel_id =$('#package_hotel_id').val();
                get_room_via_hotel_id(hotel_id);
                }
            })
            .fail(function() {
               alert('something went wrong.');
            })
        }
        function get_room_via_hotel_id(hotel_id){
            //alert('ajax working');
            $.ajax({
                url: "{{ url('/get_hotel_room') }}",
                type: 'POST',
                data: {_token:'{{csrf_token()}}', hotel_id:hotel_id},
            })
            .done(function(res) {
                 var option='';
                 var prv_rooms=$('#hotel_room_id').attr('prv_rooms');
                 prv_rooms=prv_rooms.split(',');
                 var selected='';
                if(res.status=='success'){
                    $.each(res.room, function(index, el) {
                        el.id=el.id.toString();
                        if($.inArray(el.id,  prv_rooms) != -1){
                            selected='selected="true"';
                        }else{
                            selected='';
                        }
                        option+='<option value="'+el.id+'" '+selected+'>'+el.room_title+'</option>';
                    });
                }
                $('#hotel_room_id').html();
                $('#hotel_room_id').html(option);
                $('#hotel_room_id').selectpicker('refresh');
                if($('#hotel_room_id').val().length > 0){
                    drew_room_hotel_section(prv_rooms);
                    $.each($('#hotel_room_id').val(), function(index, val) {
                        var room_stock= $('input[name=room_prv_stock_'+val+']').val();
                        if(typeof room_stock !== "undefined"){
                            $('input[name=room_stock_'+val+']').val(room_stock);
                        }
                        
                    });
                }
            })
            .fail(function() {
               alert('something went wrong.');
            })
        }
        function get_airline_flight_sche_id(airline_id){
            //alert('ajax working');
            $.ajax({
                url: "{{ url('/get_flight_sche_from_airline') }}",
                type: 'POST',
                data: {_token:'{{csrf_token()}}', airline_id:airline_id},
            })
            .done(function(res) {
                var option='';
                if(res.status=='success'){
                   var prv_flight_sche=$('#flight_sche_id').attr('prv_flight_sche');
                   prv_flight_sche=prv_flight_sche.split(',');
                   var selected='';
                    $.each(res.flight_schedule, function(index, el) {
                        el.id=el.id.toString();
                        console.log(prv_flight_sche);
                        console.log(el.id);
                        if($.inArray(el.id,  prv_flight_sche) != -1){
                            selected='selected="true"';
                        }else{
                            selected='';
                        }
                        option+='<option value="'+el.id+'" '+selected+'>'+el.flight_sche_title+'</option>';
                    });
                }else{
                    option+='<option value="">Please Select flight schedule</option>';
                }
                $('#flight_sche_id').html();
                $('#flight_sche_id').html(option);
                $('#flight_sche_id').selectpicker('refresh');
                if($('#flight_sche_id').val()!==''){
                    var flight_sche_ids =$('#flight_sche_id').val();
                    get_cars_from_flight_sche_ids(flight_sche_ids);
                }
            })
            .fail(function() {
               alert('something went wrong.');
            })
        }
        function get_cars_from_flight_sche_ids(flight_sche_ids){
            $.ajax({
                url: "{{ url('/get_car_from_flight_sche_id') }}",
                type: 'POST',
                data: {_token:'{{csrf_token()}}', flight_sche_ids:flight_sche_ids},
            })
            .done(function(res) {
                var option='';
                if(res.status=='success'){
                   var prv_car=$('#car_id').attr('prv_car');
                   prv_car=prv_car.split(',');
                   var selected='';
                    $.each(res.car, function(index, el) {
                        el.id=el.id.toString();
                        if($.inArray(el.id,  prv_car) != -1){
                            selected='selected="true"';
                        }else{
                            selected='';
                        }
                        option+='<option value="'+el.id+'" '+selected+'>'+el.car_title+'</option>';
                    });
                }else{
                    option+='<option value="">Please Select flight schedule</option>';
                }
                $('#car_id').html();
                $('#car_id').html(option);
                $('#car_id').selectpicker('refresh');
            })
            .fail(function() {
               alert('something went wrong.');
            })
        }
        function  set_package_title_here(ele){
            var text =$(ele).find('option[value='+$(ele).val()+']').html();
            text=text.replace('&nbsp;', '');
            text=text.replace('--------', '');
            text=text.replace('------', '');
            text=text.replace('----', '');
            text=text.replace('--', '');
            text=text.replace('-', '');
            text=$.trim(text);
            text='חבילת נופש ל'+' '+text;
            //$('input[name=package_title]').val(text);
        }
        $('#hotel_room_id').change(function(event) {
          drew_room_hotel_section($(this).val())
        });
        function drew_room_hotel_section($rooms){
           var html=""
           $.each($rooms, function(index, val) {
                html += '<div class="col-md-3" style="padding-top: 25px; font-size: 16px;">';
                html += '<span class="text-center page-header">'+$('#hotel_room_id option[value='+val+']').html()+'</span>';
                html += '</div>';
                html +='<div class="col-md-9">';
                html +='<div class="form-group form-float">';
                html +='<div class="form-line">';
                html +='<label class="form-label">Room Avalible</label>';
                html +='<input type="text" class="form-control" name="room_stock_'+val+'" >';
                html +=' </div>';                               
                html +=' </div>';                           
                html +=' </div>';                  

           });
           $('#package_rooms_stock').empty();
           $('#package_rooms_stock').append(html);
           $('#package_rooms_stock').show();
        }
    </script>
@endsection