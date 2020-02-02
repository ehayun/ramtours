@section('rami_mobile_footer_js')
<script src="{{url('assets/mobile')}}/js/jquery.min.js"></script>
<script src="{{url('assets/mobile')}}/js/bootstrap.bundle.min.js"></script>
<script src="{{url('assets/mobile')}}/js/jquery.easing.min.js"></script>
<script src="{{url('assets/mobile')}}/js/jquery.fancybox.min.js"></script>
<script src="{{url('assets/mobile')}}/js/jquery.touchSwipe.min.js"></script>
<script src="{{url('assets/mobile')}}/js/moment.min.js"></script>
<script src="{{url('assets/mobile')}}/js/daterangepicker.js"></script>
<script src="{{url('assets/mobile')}}/js/filters.min.js"></script>
<script src="{{url('assets/mobile')}}/js/custom.js"></script>
@show
@if(!empty($footer_custom_code))
{!! $footer_custom_code !!}
@endif
@if (env('APP_ENV') == 'production')
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-38205015-1"></script>
<script>
      $( document ).ready(function() {
            $( ".contact-submit" ).click(function() {
                  $( ".contact-submit" ).hide()
             });
      });
      window.dataLayer = window.dataLayer || [];
      function gtag() { dataLayer.push(arguments); }
      gtag('js', new Date());

      gtag('config', 'UA-38205015-1');

      $("img").on({
            "contextmenu": function (e) {
                  // console.log("ctx menu button:", e.which);

                  // Stop the context menu
                  e.preventDefault();
            },
            "mousedown": function (e) {
                  // console.log("normal mouse down:", e.which);
            },
            "mouseup": function (e) {
                  // console.log("normal mouse up:", e.which);
            }
      });
</script>
@endif
</body>

</html>