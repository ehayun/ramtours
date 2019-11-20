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
                <div class="card page_lists">
                    <div class="header">
                       <h4>Pages&nbsp;<span class="badge badge-primary">{{$all_count}}</span></h4>
                       <button type="button" class="btn btn-raised btn-primary waves-effect rami_admin_add_new_btn"><a href="{{url('admin/page/create')}}">Add Page</a></button>
                       {{-- @if(!empty($trash_count))
                        <button type="button" class="btn btn-raised btn-primary waves-effect rami_admin_left_btn rami_admin_btn"><a href="{{url('admin/car/trash')}}">view Trash &nbsp;<span class="badge badge-danger">{{$trash_count}}</span></a></button>
                       @endif --}}
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable pack_table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                     <th>Slug</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pages as $page)        
                                <tr>
                                    <td>{{++$loop->index}}</td>  
                                    <td><span class="text-muted">{{$page->page_title}}</span></td>
                                    <td><span class="text-muted">{{$page->slug}}</span></td>
                                    @php
                                    if ($page->page_status == '1') {
                                        $page_status = 'Active';
                                    } elseif ($page->page_status == '0') {
                                        $page_status = 'Deactive';
                                    }else {
                                        $page_status = '';
                                    }
                                    @endphp
                                    <td><span class="text-muted">{{$page_status}}</span></td>
                                    <td>
                                        @if ($page->page_status == '1') 
                                        <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                                            <a target="_blank" href="{{ url($page->id) }}" class="btn btn-default waves-effect waves-float waves-green">
                                                <i class="material-icons" title="view" style="top:0px">pageview</i>
                                            </a>
                                        </div>
                                        @endif
                                        <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                                            <a href="{{ url('admin/page/'.$page->id.'/edit') }}" class="btn btn-default waves-effect waves-float waves-green">
                                                <i class="zmdi zmdi-edit" title="Edit"></i>
                                            </a>
                                        </div>
                                        <div class="btn-group btn-group-xs" role="group" aria-label="Extra-small button group">
                                            <a href="javascript:void(0);" class="btn btn-default waves-effect waves-float waves-red page_del_btn" item_id="{{$page->id}}">
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
                <form id='del_page_form' method="POST" action="{{url('admin/page')}}" style="display: none">
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
        $('.page_lists').on('click', '.page_del_btn', function(event) {
            event.preventDefault();           
            var id= $(this).attr('item_id');
            if(confirm('Are you sure to delete this page.')){   
             var action=$('#del_page_form').attr('action');
             $('#del_page_form').attr('action', action+'/'+id);
             $('#del_page_form').submit();
           }
        });
        $('.pack_table').DataTable();
    </script>
@endsection