<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @if(!empty($site_title))
  <title>{{ $site_title }}</title>
  @else
  <title>Ramtours</title>
  @endif
  @if(!empty($header_custom_code))
  {!! $header_custom_code !!}
  @endif
  @section('rami_front_head_css')
  <link rel="icon" type="image/x-icon" href="{{url('/assets/front/images')}}/favicon.ico">
  <link href="{{url('assets/front/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="{{url('assets/front/css/jquery-ui.min.css')}}" rel="stylesheet">
  <link href="{{url('assets/front/css/style.css')}}" rel="stylesheet">
  <link href="{{url('assets/front/css/jquery.fancybox.css')}}" rel="stylesheet">
  <link href="{{url('assets/front/css/daterangepicker.css')}}" rel="stylesheet">  
  @show
</head>