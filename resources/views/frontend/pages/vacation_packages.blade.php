@extends('frontend.home_main')
@section('rami_front_container')
  <section>
    <div class="container">
     <div class="row">
      <div class="col-md-12">
       <div class="inner-page-breadcrum">
          <strong>::</strong> 
          <a href="{{ url('/')}}">דף הבית </a>
           <img src="{{url('/assets/front/images')}}/bread-crum-arrow.png" alt="">
           חבילות 
           <img src="{{url('/assets/front/images')}}/bread-crum-arrow.png" alt="">
           {{$page_title }}
    </div>
    </div>
  </section>
  <section class="rt_frames">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading">{{ $page_title }} </h2>
        </div>
       <!-- {!!rami_package_hotel_filter_html()!!}-->
        <div class="col-lg-12">
          @foreach($show_settings as $setting)
            @if(!empty($setting['results']))
              @if(!empty($setting['section_title']))
              <div class="row">
                <div class="col-lg-12 text-center">
                  <h2 class="section-heading text-right">{{ $setting['section_title'] }}</h2>
                </div>
              </div>
              @endif
              <div class="row text-center pakage_div">
              @foreach($setting['results'] as $pkgs_fhc)           
                {!!rami_vacation_pkg_html($pkgs_fhc, 3)!!}
              @endforeach
              </div>
            @endif
          @endforeach
          @if(!empty($show_load_more))
           <div class="col-md-12 load_more_packs_div">
            <input type="hidden" name="pack_location" value="{{$loc_id}}">
            <input type="hidden" name="pack_start_date" value="{{$ser_start_date}}">
            <input type="hidden" name="pack_end_date" value="{{$ser_end_date}}">
            <button class="test-btn load_more_packs" type="submit" page_attr="2">ראה עוד</button>
           </div>
        </div>
          @endif
      </div>
    </div>
</section>
@endsection
@section('rami_front_footer_js')
@parent
  <script type="text/javascript">
    $('.load_more_packs_div').on('click', '.load_more_packs', function(event) {
      event.preventDefault();
      var page=$(this).attr('page_attr');
      var pack_location=$('input[name=pack_location]').val();
      var pack_start_date=$('input[name=pack_start_date]').val();
      var pack_end_date=$('input[name=pack_end_date]').val();
      $.ajax({
        url: '/package_load_more',
        type: 'POST',
        data: {_token:'{{csrf_token()}}', page:page,no_of_element:8, pack_location:pack_location, pack_start_date:pack_start_date, pack_end_date:pack_end_date},
      })
      .done(function(res) {        
        if(res.status=='success'){
          $('.pakage_div').append(res.html);
          if(res.is_last_page==1){
             $('.load_more_packs_div').hide();
          }
          page=parseInt(page);
          page++;
          $('.load_more_packs').attr('page_attr',page);
        }else{
          alert(res.msg);
        }
      })
      .fail(function() {
        alert('some thing went wrong.');
      })
            
    });

  </script>
@endsection