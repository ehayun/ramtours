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
   @section('rami_mobile_header_css')
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link href="{{url('assets/mobile')}}/css/bootstrap.min.css" rel="stylesheet">
   <link href="{{url('assets/mobile')}}/css/jquery.fancybox.css" rel="stylesheet">
   <link href="{{url('assets/mobile')}}/css/daterangepicker.css" rel="stylesheet">
   <link href="{{url('assets/mobile')}}/css/style.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css?family=Rubik&display=swap" rel="stylesheet">
   <script id="ptoken" src="https://ws.callindex.co.il/campaign/send_analytics.js?ptoken=534"></script>
   @show
   <script src='https://www.google.com/recaptcha/api.js'></script>
   @if (env('APP_ENV') == 'production')
   <!-- Global site tag (gtag.js) - Google Analytics -->
   <meta name="google-site-verification" content="h70ijBBOLp8VIvyioyIFbMLLDQ0DHwg5QkNYskw27tM" />
   @endif
</head>

<body class="home @yield('rami_front_page_class')">