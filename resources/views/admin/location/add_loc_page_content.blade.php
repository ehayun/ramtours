@extends('admin.main')
@section('title',$page_title)
@section('title_breadcrumb',$page_title)
@section('admin_head_css')
@parent
<link rel="stylesheet" href="{{ $assets_admin }}/plugins/bootstrap-select/css/bootstrap-select.css" />
@endsection
@section('admin_container')
@php
if(empty($page_content))
$page_content='';
@endphp
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="body">
                    <form action="{{url('/admin/location/'.$loc_id.'/package-setting/'.$pkg_type.'/page_content')}}" method="POST" accept-charset="utf-8" id="add_page_content" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        @section('method_field')
                        @show
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="page_title" value="{!! get_edit_input_pvr_old_value_with_obj('page_title',$page_content,'page_title')!!}">
                                {!! get_form_error_msg($errors, 'page_title') !!}
                                <label class="form-label">Page Title</label>
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label">Page Discription</label>
                                <br><br>
                                <textarea class="ckeditor" name="page_disc">{!! get_edit_input_pvr_old_value_with_obj('page_disc',$page_content,'page_disc')!!}</textarea>
                                {!! get_form_error_msg($errors, 'page_disc') !!}
                            </div>
                        </div>
                        <div class="form-group form-float">
                            <div class="form-line">
                                <label class="form-label">Page Short description</label>
                                <br><br>
                                <textarea class="ckeditor1" name="pck_shot_desc">{!! get_edit_input_pvr_old_value_with_obj('pck_shot_desc',$page,'pck_shot_desc')!!}</textarea>
                                {!! get_form_error_msg($errors, 'pck_shot_desc') !!}
                            </div>
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

    @endsection