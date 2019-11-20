@extends('admin.main')
@section('title',$page_title)
@section('title_breadcrumb',$page_title)
@section('admin_head_css')
@parent
    <!-- JQuery DataTable Css -->
    <link rel="stylesheet" href="{{ $assets_admin }}/plugins/jquery-datatable/dataTables.bootstrap4.min.css">
@endsection
@section('admin_container')
    <div class="container-fluid">
        {!!show_flash_msg()!!}
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card flight_list">
                    <div class="header">
                        <h4>Trash Flights&nbsp;<span class="badge badge-primary">{{$all_count}}</span></h4>
                        @if(!empty($all_count))
                            <button type="button" class="btn btn-raised btn-primary waves-effect rami_admin_left_btn rami_admin_btn restore_all_btn"><a href="{{url('admin/flight/restore')}}">Restore All</a></button>
                            <button type="button" class="btn btn-raised btn-primary waves-effect rami_admin_right_btn rami_admin_btn force_del_all_btn"><a href="{{url('admin/flight/destroy')}}">Delete All</a></button>
                        @endif
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable pack_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Flight Number</th>
                                    <th>Airline</th>
                                    <th>Source</th>
                                    <th>Destination</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trash_flight as $flight)
                                <tr>
                                    <td>{{++$loop->index}}</td>                                    
                                    <td><span class="text-muted">{{$flight->flight_title}}</span></td>
                                    <td><span class="text-muted">{{$flight->flight_number}}</span></td>
                                    <td>
                                        <span class="text-muted">
                                            @if(!empty($flight->airline_name))    
                                                {{$flight->airline_name->airl_title}}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            @if(!empty($flight->location_source))
                                                {{$flight->location_source->loc_name}}
                                            @endif
                                        </span>
                                    </td>
                                     <td>
                                        <span class="text-muted">
                                            @if(!empty($flight->location_desti))
                                                {{$flight->location_desti->loc_name}}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                    <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float waves-green restore_single_btn" item_id="{{$flight->id}}">
                                            <i class="zmdi zmdi-edit" title="Restore"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float waves-red delete_single_btn" item_id="{{$flight->id}}">
                                            <i class="zmdi zmdi-delete" title="Delete"></i>
                                        </a>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach                                
                            </tbody>
                        </table>
                    </div>        
                </div>
                <form id='del_form' method="POST" action="{{url('admin/flight/destroy')}}" style="display: none">
                    {{ csrf_field() }}
                    {{method_field('DELETE')}}
                </form>
                <form id='res_form' method="POST" action="{{url('admin/flight/restore')}}" style="display: none">
                    {{ csrf_field() }}
                    {{method_field('PATCH')}}
                </form>
            </div>
        </div>
@endsection
@section('admin_jscript')
@parent
     <!-- Jquery DataTable Plugin Js --> 
    <script src="{{ $assets_admin }}/bundles/datatablescripts.bundle.js"></script>
    <script src="{{ $assets_admin }}/plugins/jquery-datatable/buttons/dataTables.buttons.min.js"></script>
    <script src="{{ $assets_admin }}/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js"></script>
    <script src="{{ $assets_admin }}/plugins/jquery-datatable/buttons/buttons.colVis.min.js"></script>
    <script src="{{ $assets_admin }}/plugins/jquery-datatable/buttons/buttons.flash.min.js"></script>
    <script src="{{ $assets_admin }}/plugins/jquery-datatable/buttons/buttons.html5.min.js"></script>
    <script src="{{ $assets_admin }}/plugins/jquery-datatable/buttons/buttons.print.min.js"></script> 
    <script type="text/javascript">
        $('.flight_list').on('click', '.delete_single_btn', function(event) {
            event.preventDefault();           
            var id= $(this).attr('item_id');
            if(confirm('Are you sure to move this filght into trash container.')){   
                var action=$('#del_form').attr('action');
                $('#del_form').attr('action', action+'/'+id);
                $('#del_form').submit();
            }
        });
        $('.flight_list').on('click', '.force_del_all_btn', function(event) {
            event.preventDefault(); 
            if(confirm('Are you sure to delete all Trash flight.')){   
                var action=$('#del_form').attr('action');
                $('#del_form').submit();
            }
        });
        $('.flight_list').on('click', '.restore_all_btn', function(event) {
            event.preventDefault(); 
            if(confirm('Are you sure to restore all Trash flight.')){   
               var action=$('#res_form').attr('action');
               $('#res_form').submit();
            }
        });
        $('.flight_list').on('click', '.restore_single_btn', function(event) {
            event.preventDefault(); 
            var id= $(this).attr('item_id');
            if(confirm('Are you sure to restore this flight.')){   
                var action=$('#res_form').attr('action');
                $('#res_form').attr('action', action+'/'+id);
                $('#res_form').submit();
            }
        });
        $('.pack_table').DataTable();
    </script>
@endsection