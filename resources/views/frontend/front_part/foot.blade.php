@section('rami_front_footer_js')
<script src="{{url('assets/front/js/jquery.min.js')}}"></script>
<script src="{{url('assets/front/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{url('assets/front/js/jquery.easing.min.js')}}"></script>
<script src="{{url('assets/front/js/jquery.fancybox.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/front/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/front/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{url('assets/front/js/daterangepicker.js')}}"></script>
<script src="{{url('assets/front/js/filters.min.js')}}"></script>
<script src="{{url('assets/front/js/custom.js')}}"></script>
@show
@if(!empty($footer_custom_code))
{!! $footer_custom_code !!}
@endif
<script>

$( document ).ready(function() {
  $( ".contact-submit" ).click(function() {
    $( ".contact-submit" ).hide()
});
});

  $('img').bind('touchend', function (e) {
    e.preventDefault();
    // Add your code here. 
    $(this).click();
    // This line still calls the standard click event, in case the user needs to interact with the element that is being clicked on, but still avoids zooming in cases of double clicking.
  })
  $("img").mousedown(function () {
    // console.log("Mouse down over p1!");
  });
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
@if (env('APP_ENV') == 'production')
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-38205015-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() { dataLayer.push(arguments); }
  gtag('js', new Date());

  gtag('config', 'UA-38205015-1');

  document.addEventListener('contextmenu', event => event.preventDefault());
</script>
@endif

</body>

</html>