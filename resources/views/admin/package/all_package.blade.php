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
                <div class="card package_list">
                    <div class="header">
                        <h4>Packages &nbsp;<span class="badge badge-primary">{{$all_count}}</span></h4>
                        <button type="button" class="btn btn-raised btn-primary waves-effect rami_admin_add_new_btn"><a href="{{url('admin/package/create')}}">Add-Package</a></button>
                        @if(!empty($trash_count))
                        <button type="button" class="btn btn-raised btn-primary waves-effect rami_admin_left_btn rami_admin_btn"><a href="{{url('admin/package/trash')}}">view Trash &nbsp;<span class="badge badge-danger">{{$trash_count}}</span></a></button>
                       @endif
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-hover table-bordered table-striped  pack_table dataTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Package Location</th>
                                    <th>Package Type</th>
                                    <th>Package profit</th>
                                    <th>Hotel</th>
                                    <th>status</th>                                   
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>                               
                                @foreach($packages as $package)
                               {{--  {{ dd($packages[646]) }}
 --}}                                <tr>
                                    <td>{{++$loop->index}}</td>                                    
                                    <td><span class="text-muted">{{$package->package_title}}</span></td>
                                    <td><span class="text-muted">{{$package->package_start_date}}</span></td>
                                    <td><span class="text-muted">{{$package->package_end_date}}</span></td>
                                    <td><span class="text-muted">{{$package->package_flight_location}}</span></td>
                                    
                                    <td><span class="text-muted">{{get_package_type($package->package_type)}}</span></td>
                                    <td><span class="text-muted">{{$package->package_profit_fhc}}</span></td>
                                    <td><span class="text-muted">
                                        @if(!empty($package->hotel->hotel_code))
                                        {{$package->hotel->hotel_code}}
                                        @endif
                                        </span>
                                    </td>
                                    @php
                                        if($package->package_status==1){
                                            $package_status="active";
                                        }elseif($package->package_status==0){
                                            $package_status="In-active";
                                        }else{
                                            $package_status=" ";
                                        }
                                    @endphp
                                    <td><span class="text-muted">{{$package_status}}</span></td>
                                    <td>
                                     <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                                            <a target="_blank" href="{{ url('package/'.$package->id) }}" class="btn btn-default waves-effect waves-float waves-green">
                                                <i class="material-icons" title="view" style="top:0px">pageview</i>
                                            </a>
                                    </div>
                                    <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                                        <a href="{{ url('admin/package/'.$package->id.'/edit') }}" class="btn btn-default waves-effect waves-float waves-green">
                                            <i class="zmdi zmdi-edit" title="Edit"></i>
                                        </a>
                                    </div>
                                    <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                                        <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float waves-red package_del_btn" item_id="{{$package->id}}">
                                            <i class="zmdi zmdi-delete" title="delete"></i>
                                        </a>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach                                
                            </tbody>
                        </table>
                    </div>        
                </div>
                <form id='del_package_form' method="POST" action="{{url('admin/package')}}" style="display: none">
                    {{ csrf_field() }}
                    {{method_field('DELETE')}}
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
        $('.package_list').on('click', '.package_del_btn', function(event) {
            event.preventDefault();           
            var id= $(this).attr('item_id');
            if(confirm('Are You sure to delete this Package.')){   
             var action=$('#del_package_form').attr('action');
             $('#del_package_form').attr('action', action+'/'+id);
             $('#del_package_form').submit();
           }
        });
        $('.pack_table').DataTable();
    </script>
@endsection