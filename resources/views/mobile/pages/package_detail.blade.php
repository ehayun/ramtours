@extends('mobile.home_main')
@section('rami_mobile_slider_imgs')
@foreach($hotel_gallery as $img)
@if($loop->index==1)
<div class="carousel-item active">
   @else
   <div class="carousel-item">
      @endif
      <img class="img-fluid" src="{{url('ramtours/'.$img->image)}}" alt="{{$img->title}}">
   </div>
   @endforeach
   @endsection
   @section('rami_front_page_class', 'rami_pkg_body_cls')
   @section('mobile_container')
   <section class="rt-info">
      <div class="container">
         <div class="row">
            <div class="col-sm-12">
               <div class="rt_info_right">
                  <h3 class="rtpkghead">חבילת נופש ל
                     @if(!empty($package->package_desti)){{$package->package_desti->loc_name}}@endif</h3>
                  <div class="date"><i class="fa fa-calendar"
                        aria-hidden="true"></i>{{ rami_get_require_date_format($package->package_end_date, 'd/m').' - ' .rami_get_require_date_format($package->package_start_date, 'd/m') }}
                  </div>
               </div>
               <div class="rt_btnsec">
                  <div class="rt_prev_btn"><a href="{{ URL::previous() }}"><img
                           src="{{url('assets/mobile/images/prev-btn-blk.png')}}"></a></div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="steps">
      <div class="container">
         <div class="row">
            <div class="col-sm-12 stepwizard">
               <div class="stepwizard-row setup-panel">
                  <div class="stepwizard-step active">
                     <a href="#step-1" class="btn active">1</a>
                     <p>פרטי המוצר </p>
                  </div>
                  <div class="stepwizard-step">
                     <a href="#step-2" class="btn" disabled="disabled">2</a>
                     <p>פרטי הנוסעים </p>
                  </div>
                  <div class="stepwizard-step">
                     <a href="#step-3" class="btn" disabled="disabled">3</a>
                     <p>תשלום </p>
                  </div>
                  <div class="stepwizard-step last">
                     <a href="#step-3" class="btn" disabled="disabled"><img
                           src="{{url('assets/mobile/images/step-check.png')}}" alt=""></a>
                     <p>אישור הזמנה </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="pkg_section">
      <div class="container">
         <div class="row">
            <div class="col-sm-12 rt-inner abtpkg">
               <h3 class="pkg_head"> החבילה כוללת :</h3>
               <!-- <h5>  החבילה כוללת:     </h5>-->
               <p>{!!rami_vacation_pkg_del_top_text($package->package_flight_location)!!}</p>
               <p class="rt_dts" style="display: none">משפחתי סטיישן
                  לילות {{rami_get_no_of_days_diff($package->package_start_date, $package->package_end_date)}} </p>
            </div>
            <div class="col-sm-12 rt-inner listpkg">
               <h3 class="pkg_head">לינה : <span
                     class="rt_headd">{{ get_rami_page_placeholder('help_text_apartment',1) }}</span></h3>
               <div class="rtpkglst">
                  <img src="{{url('assets/mobile/images/rooms.png')}}" alt="">
                  <h4>פרטי מקום הלינה</h4>
                  <div class="pkg_btnn"><a href="JavaScript:Void(0);" id="rt_lodging_btn"><img
                           src="{{url('assets/mobile/images/pkg-arrow-yellow.png')}}" class="inf_arrow"></a></div>
               </div>
               <div class="rtpkglst">
                  <img src="{{url('assets/mobile/images/apartment-ico.png')}}" alt="">
                  <h4>פרטי דירה</h4>
                  <div class="pkg_btnn"><a href="JavaScript:Void(0);" id="rt_rooms_btn">
                        <img src="{{url('assets/mobile/images/pkg-arrow-yellow.png')}}" class="inf_arrow"></a>
                  </div>
               </div>
               <div class="rtpkglst">
                  <img src="{{url('assets/mobile/images/location.png')}}" alt="">
                  <h4>אטרקציות</h4>
                  <div class="pkg_btnn"><a href="JavaScript:Void(0);" id="rt_map_btn">
                        <img src="{{url('assets/mobile/images/pkg-arrow-yellow.png')}}" class="inf_arrow"></a>
                  </div>
               </div>
               @if($hotel_reviews->count()>0)
               <div class="rtpkglst">
                  <img src="{{url('assets/mobile/images/review-ico.png')}}" alt="">
                  <h4>לקוחות ממליצים</h4>
                  <div class="pkg_btnn"><a href="JavaScript:Void(0);" id="rt_review_btn">
                        <img src="{{url('assets/mobile/images/pkg-arrow-yellow.png')}}" class="inf_arrow"></a>
                  </div>
               </div>
               @endif
            </div>

            <div class="col-sm-12 flt-inner pkgflt_secc">
               <h3 class="pkg_head">טיסות : <span
                     class="rt_headd">{{ get_rami_page_placeholder('help_text_flights',1) }}</span></h3>
               @foreach($all_flights as $all_flight)
               <div class="flights-details-box-inner">
                  <!-- <div class="flight-tophead">
                        <div class="flight-date">יעד : {{$all_flight['up_desti']}} </div>
                        <div class="flights-headings"> {{$all_flight['up_flight_no']}}</div>
                     </div> -->
                  @if(!empty($all_flight['up_flights']))
                  @foreach($all_flight['up_flights'] as $flight)
                  <div class="clear"></div>
                  <div class="flight-secc top">
                     <div class="flights-icon"><img width="262" height="165"
                           src="{{url('ramtours/'.$flight['airline_logo'])}}" class="img-fluid" alt=""> </div>
                     <div class="flight-text-box tf1">{{$flight['source']}}<span
                           class="rt_tmm">{{$flight['departure_time']}}</span>
                        <span class="rt_dts">{{$flight['depart_full_date']}}</span>
                     </div>
                     <div class="flight-take-off ftbord">
                        שעות {{$flight['time_taken']}}
                        <span class="rt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>
                     </div>
                     <div class="flight-text-box tf2">{{ $flight['desti']}} <span
                           class="rt_tmm">{{$flight['arrival_time']}}</span><span class="rt_dts">
                           {{$flight['arrival_full_date']}}
                        </span>
                     </div>
                     <div class="clear"></div>
                  </div>
                  @endforeach
                  @else
                  <div class="clear"></div>
                  <div class="flight-secc top">
                     <div class="flights-icon"><img width="262" height="165"
                           src="{{url('ramtours/'.$all_flight['up_airline_logo'])}}" class="img-fluid" alt=""> </div>
                     <div class="flight-text-box tf1">{{$all_flight['up_source']}}<span
                           class="rt_tmm">{{$all_flight['up_departure_time']}}</span>
                        <span class="rt_dts">{{$all_flight['up_depart_full_date']}}</span>
                     </div>
                     <div class="flight-take-off ftbord">
                        שעות {{$all_flight['up_time_taken']}}
                        <span class="rt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>
                     </div>
                     <div class="flight-text-box tf2">{{ $all_flight['up_desti']}} <span
                           class="rt_tmm">{{$all_flight['up_arrival_time']}}</span><span class="rt_dts">
                           {{$all_flight['up_arrival_full_date']}}
                        </span>
                     </div>
                     <div class="clear"></div>
                  </div>
                  @endif
                  <!-- div class="flight-tophead">
                        <div class="flight-date">יעד : {{$all_flight['down_desti']}}  </div>
                        <div class="flights-headings"> {{$all_flight['down_flight_no']}}</div>
                     </div> -->
                  @if(!empty($all_flight['down_flights']))
                  @foreach($all_flight['down_flights'] as $flight)
                  <div class="clear"></div>
                  <div class="flight-secc bottom">
                     <div class="flights-icon"><img width="262" height="165"
                           src="{{url('ramtours/'.$flight['airline_logo'])}}" class="img-fluid" alt=""> </div>
                     <div class="flight-text-box tf1">{{$flight['source']}}<span
                           class="rt_tmm">{{$flight['departure_time']}}</span>
                        <span class="rt_dts">{{$flight['depart_full_date']}}</span>
                     </div>
                     <div class="flight-take-off ftbord">
                        שעות {{$flight['time_taken']}}
                        <span class="rt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>
                     </div>
                     <div class="flight-text-box tf2">{{ $flight['desti']}} <span
                           class="rt_tmm">{{$flight['arrival_time']}}</span><span class="rt_dts">
                           {{$flight['arrival_full_date']}}
                        </span>
                     </div>
                     <div class="clear"></div>
                  </div>
                  @endforeach
                  @else
                  <div class="clear"></div>
                  <div class="flight-secc bottom">
                     <div class="flights-icon"><img width="262" height="165"
                           src="{{url('ramtours/'.$all_flight['down_airline_logo'])}}" class="img-fluid" alt=""> </div>
                     <div class="flight-text-box td1">{{$all_flight['down_source']}} <span
                           class="rt_tmm">{{$all_flight['down_departure_time']}}</span><span
                           class="rt_dts">{{$all_flight['down_depart_full_date']}}</span>
                     </div>
                     <div class="flight-take-off ftbord">
                        שעות {{$all_flight['down_time_taken']}}
                        <span class="rt_plane"><i class="fa fa-plane" aria-hidden="true"></i></span>
                     </div>
                     <div class="flight-text-box td2">{{$all_flight['down_desti']}} <span class="rt_tmm">
                           {{$all_flight['down_arrival_time']}} </span><span class="rt_dts">
                           {{$all_flight['down_arrival_full_date']}}
                        </span>
                     </div>
                     <div class="clear"></div>
                  </div>
                  @endif

               </div>
               @endforeach
            </div>

            <div class="col-sm-12 car-inner">
               <h3 class="pkg_head">רכב <span
                     class="rt_headd">{{ get_rami_page_placeholder('help_text_vehicle',1) }}</span></h3>
               <div class="rt_crt_sec col-sm-12">
                  <img src="{{url('ramtours/'.$all_cars['first_car_img'])}}" class="img-fluid">
                  <h4 class="pkg_subhead">{!!$all_cars['first_car_title']!!} </h4>
                  <p>{!!$all_cars['first_car_des']!!} </p>
                  <div class="rtpkglst">
                     <img src="{{url('assets/mobile/images/pkg-car.png')}}" alt="">
                     <h4>אפשרויות שדרוג רכב </h4>
                     <div class="pkg_btnn">
                        <a href="JavaScript:Void(0);" id="rt_car_btn">
                           <img src="{{url('assets/mobile/images/pkg-arrow-yellow.png')}}" class="inf_arrow">
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="pkg-price">
      <div class="container">
         <div class="row">
            <div class="col-6  col-sm-6 rt-inner">
               <h3><span>החל מ</span>€{{$package->package_lowest_price}}</h3>
            </div>
            <div class="col-6 col-sm-6 rt-inner">
               <button class="btn btn-lg btn-primary btn-block " type="submit" id="pkg_prc_btn">המשיכו להזמנה
               </button></div>
         </div>
      </div>
   </section>
   <div class="rt_popup" id="rt_lodging">
      <div class="popup-header">
         <div class="rt_close"><img src="{{url('assets/mobile/images/rt_navclse.png')}}"></div>
         <h4><img src="{{url('assets/mobile/images/rooms.png')}}" alt="">פרטי מקום הלינה</h4>
      </div>
      <div class="ap-cont">
         <h5> {{$hotel->hotel_display_name}} </h5>
         <p>כתובת: {{ $hotel->hotel_code }} - {{ $hotel->hotel_address }}</p>
         <div class="ap-cont aprt">
            <h3 class="pkg_head">מתקני מקום הלינה :</h3>
            <ul>
               <ul>
                  @foreach($amenities as $amenity)
                  <li>{{ get_hotel_amenities($amenity) }}</li>
                  @endforeach
               </ul>
            </ul>
            <h3 class="pkg_head">פעילויות בקרבת מקום :</h3>
            <ul>
               @foreach($features as $feature)
               <li>{{ get_hotel_features($feature) }}</li>
               @endforeach
            </ul>
         </div>

         @php
         $iix = 0;
         $hotel_gallery_count = sizeof($hotel_gallery)
         @endphp


         <div class="pkg-section" id="gallery">
            <h3 class="pkg_head">גלריה :</h3>
            <div class="col-sm-5 ap-cont">
               <div class="col-sm-12 gallery">
                  @foreach($hotel_gallery as $img)
                  <div class="pics">
                     @if ($iix < 15) <a data-fancybox="gallery" href="{{url('ramtours/'.$img->image)}}">
                        <img class="img-fluid" src="{{url('ramtours/'.$img->image)}}" alt="{{$img->title}}">
                        </a>
                        @endif

                        @php
                        $iix++;
                        @endphp
                  </div>
                  @endforeach
               </div>
            </div>
         </div>

         @if(!empty($hotel_card))
         <div class="ap-cont aprt">
            <h3 class="cont-head rt_cardhead">מידע על כרטיס </h3>
            <img src="{{url('ramtours/'.$hotel_card['card_image'])}}" class="rt_cardimg">
            <p class="rt_cardesc">המתארחים במקום לינה זה זכאים
               <a href=" {{$hotel_card['link']}}" target="_blank">
                  {{$hotel_card['title']}}
               </a>
            </p>
         </div>
         @endif
         <h3 class="pkg_head">מידע כללי :</h3>
         <p>{!! $hotel->hotel_desc !!}
         </p>
         @if(!empty($hotel->hotel_instruction_text))
         <h3 class="pkg_head">אטרקציות:</h3>
         <p class="att-sec">
            {!! $hotel->hotel_instruction_text !!}
         </p>
      </div>
      @endif
   </div>
</div>
@if(!empty($map))
<div class="rt_popup" id="rt_map">
   <div class="popup-header">
      <div class="rt_close"><img src="{{url('assets/mobile/images/rt_navclse.png')}}"></div>
      <h4><img src="{{url('assets/mobile/images/location.png')}}" alt="">אטרקציות באיזור מקום הלינה. </h4>
   </div>
   <div class="map-sec">
      <img src="{{url('ramtours/'.$map)}}" alt="map" class="img-fluid">
      <div class="map_text">
         כל המפות באתר מיועדות להמחשה בלבד, ישנם אי דיוקים במרחקי האטרקציות למקום הלינה, לכן אין להסתמך על נתונים אלה
         לצורך תכנון הטיול.
      </div>
   </div>
   <div class="att-sec">
      <h3 class="pkg_head">אטרקציות באיזור מקום האירוח :</h3>
      <div class="att-inner">
         <h5>מרחקי האטרקציות ממקום הלינה בקילומטרים</h5>
         <ul class="attr-pts">
            @foreach($attractions as $attr)
            <li><span class="num">{{$attr->attraction_sequence}}</span><span
                  class="attr_name">{{$attr->attraction_title}}</span><span
                  class="distance">{{$attr->attraction_distance}} ק"מ</span></li>
            @endforeach
         </ul>
      </div>
   </div>
</div>
@endif
<div class="rt_popup" id="rt_review">
   <div class="popup-header">
      <div class="rt_close"><img src="{{url('assets/mobile/images/rt_navclse.png')}}"></div>
      <h4><img src="{{url('assets/mobile/images/review-ico.png')}}" alt="">לקוחות ממליצים
      </h4>
   </div>

   @if(!empty($hotel_reviews))
   <div class="pkg-section" id="reviews-box">
      <div class="row">
         <div id="hotel_reviews" class="col-md-12">
            {!! get_rami_hotel_reviews($hotel_reviews) !!}
         </div>
      </div>
   </div>
   @endif

</div>
<div class="rt_popup" id="rt_rooms">
   <div class="popup-header">
      <div class="rt_close"><img src="{{url('assets/mobile/images/rt_navclse.png')}}"></div>
      <h4><img src="{{url('assets/mobile/images/apartment-ico.png')}}" alt="">פרטי דירה</h4>
   </div>
   <div class="accordion" id="accordionExample">
      @foreach($hotel_rooms as $room)
      <div class="card">
         <div class="card-header" id="headingOne">
            <h5 class="mb-0">
               <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                  data-target="#collapse{{$loop->index}}" aria-expanded="false" aria-controls="collapseOne">
                  <div class="bd-sec ap_slect">
                     <div class="bd-head">
                        <h3>
                           <span>
                              <img src="{{url('/assets/front/images')}}/ramtours-rooms.png">
                              @if(!empty($room['room_area']))
                              {{$room['room_type']}} - {{$room['room_area']}} מ"ר |
                              @else
                              {{$room['room_type']}} |
                              @endif
                           </span>
                           <span>
                              <img src="{{url('/assets/front/images')}}/mann.png">&nbsp;מתאים להרכב של עד
                              {{$room['max_people']}} נפשות <span dir="ltr">({{$room['room_code']}})</span>|
                           </span>
                           <span>
                              <img src="{{url('/assets/front/images')}}/aproom.png">

                              זמין במלאי {{$room['room_avalible']}} יחידות
                           </span>
                        </h3>
                     </div>
                  </div>
               </button>
            </h5>
         </div>
         <div id="collapse{{$loop->index}}" class="collapse" aria-labelledby="headingOne"
            data-parent="#accordionExample">
            <div class="card-body">
               <div class="col-sm-12 ap-cont">
                  <h3 class="pkg_head">מידע כללי :</h3>
               </div>
               <div class="col-sm-7 ap-cont">
                  <h5>{!!$room['title']!!}</h5>
                  <p>{!!$room['room_desc']!!}</p>
               </div>
               <div class="col-sm-5 ap-cont">
                  <div class="col-sm-12 gallery">
                     @foreach($room['room_images'] as $room_img)
                     <div class="pics">
                        <a data-fancybox="gallery1" href="{{url('ramtours/'.$room_img->image)}}">
                           <img class="img-fluid" src="{{url('ramtours/'.$room_img->image)}}" alt=""></a>
                     </div>
                     @endforeach
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endforeach
   </div>
</div>
<div class="rt_popup" id="rt_car">
   <div class="popup-header">
      <div class="rt_close"><img src="{{url('assets/mobile/images/rt_navclse.png')}}"></div>
      <h4><img src="{{url('assets/mobile/images/pkg-car.png')}}" alt="">אפשרויות שדרוג רכב </h4>
      <div class="rt_crt_sec col-sm-12">
         <h3 class="pkg_head">גולף סטיישן ידני ממוזג :</h3>
         <ul class="crprice">
            @foreach($all_cars as $car)
            @if(empty($car['car_title']))
            @continue
            @endif
            <li><span class="crt-desp">{{$car['car_title']}}</span>
               <!--  <span class="mcrprz">{{$car['car_price']}}</span> -->
            </li>
            @endforeach
         </ul>
      </div>
   </div>
</div>
<div class="rt_popup" id="pkg_prc">
   <div class="popup-header">
      <div class="rt_close"><img src="{{url('assets/mobile/images/rt_navclse.png')}}"></div>
      <h4>בחירת דירה והרכב נוסעים</h4>
   </div>
   <div class="pkg-right">
      <div class="pkg-box">
         <div class="pkg-price">
            <div class="pkg-btns"><button class="btn btn-lg btn-primary btn-block checking_cart" type="submit">המשיכו
                  להזמנה
               </button></div>
            <div class="pkgprc"><span id="pkg-last-price">מחיר סופי</span>€{{$package->package_lowest_price}} </div>
         </div>
         <div class="pkg-frm">
            <div class="pkggs pkg_adults">
               <label>מבוגר </label>
               <div class="pkg-select">
                  <div class="aprt-inner2">
                     <select id="rami_pakage_adults">
                        @for($i=2; $i<=10; $i++) <option value="{{$i}}" @if($i==get_search_adult()) Selected="true"
                           @endif>{{ $i }}</option>
                           @endfor
                     </select>
                     <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </div>
               </div>
            </div>
            @php
            $idx = rami_get_least_package($package->total_persons_combinations)
            @endphp
            <div class="pkggs pkg_kids">
               <label>ילד (2-16) </label>
               <div class="pkg-select">
                  <div class="aprt-inner2">
                     <select id="rami_pakage_childs">
                        @for($i=0; $i<=10; $i++) <option value="{{$i}}" @if ($i==$idx) Selected="true" @endif
                           @if($i==get_search_child()) Selected="true" @endif>{{ $i }}</option>
                           @endfor
                     </select>
                     <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </div>
               </div>
            </div>
            <div class="pkggs pkg_infants">
               <label>תינוק (0-2) </label>
               <div class="pkg-select">
                  <div class="aprt-inner2">
                     <select id="rami_pakage_infants">
                        @for($i=0; $i<=10; $i++) <option value="{{$i}}" @if($i==get_search_child()) Selected="true"
                           @endif>{{ $i }}</option>
                           @endfor
                     </select>
                     <i class="fa fa-angle-down" aria-hidden="true"></i>
                  </div>
               </div>
            </div>
            <label>אנא בחר טיסה</label>
            <div class="pkg-select rami_cart_select_div rami_package_flights">
               <div class="aprt-inner">
                  <select>
                     <option value="0">אנא בחר טיסה</option>
                     @foreach($all_flights as $all_flight)
                     <option value="{{$all_flight['id']}}" selected>{{$all_flight['title']}} </option>
                     @endforeach
                  </select>
               </div>
            </div>
            <label>דירה</label>
            <div class="pkg-select apart rami_cart_select_div rami_package_room">
               <div class="aprt-inner">
                  <select class="rami_pkg_chnage_select chnage_select1" element_no='1' element_name="room">
                     <option value="0">אנא בחר חדר</option>
                     @foreach( $hotel_rooms as $room)
                     <option value="{{$room['id']}}" @if($room['id']==$package->cheapest_room) selected="true" @endif>
                        <span>
                           חדרים -{{$room['room_area']}} מ"ר |
                        </span>
                        <span>
                           &nbsp;מתאים להרכב של עד {{$room['max_people']}} נפשות <span
                              dir="ltr">({{$room['room_code']}})</span>|
                        </span>
                        <span>
                           {{$room['room_type']}}
                        </span>
                     </option>
                     @endforeach
                  </select>
                  <a href="javascript:void(0);" class="add_button" title="Add More room"><i class="fa fa-plus"
                        aria-hidden="true"></i></a>
               </div>

            </div>
            <label>מבחר סוג רכב </label>
            <div class="pkg-select apart rami_cart_select_div rami_package_cars">
               <div class="aprt-inner">
                  <select class="rami_pkg_chnage_select chnage_select1" element_no='1' element_name="car">
                     <option>אנא בחר מכונית</option>
                     @php
                     $idx = 0
                     @endphp
                     @foreach( $all_cars as $car)
                     @if(empty($car['id']))
                     @continue
                     @endif
                     <option value="{{$car['id']}}" @if($car['id']==$package->cheapest_car) selected="true" @endif
                        >{{$car['car_title']}}</option>
                     @php
                     $idx++;
                     @endphp
                     @endforeach
                  </select>
                  <a href="javascript:void(0);" class="add_button" title="Add More room"><i class="fa fa-plus"
                        aria-hidden="true"></i></a>
               </div>
            </div>
            <div class="pkg-trms">
               <!-- @if(!empty($hotel_card))
                   <div id="bf_card_cont" class="custom-control custom-checkbox">
                      <input id="bf_card" class="custom-control-input" type="checkbox">
                      <label class="custom-control-label" for="bf_card">
                        אבקש להוסיף לחבילה <span class="card_title">{{$hotel_card['title']}}</span>עלות של 
                         <span class="card_price">{{$hotel_card['price']}}</span> יורו למשפחה. </label>
                   </div>
                   @endif -->
                   @if (is_black_forest($package))
               <div id="bf_card_cont" class="custom-control custom-checkbox">
                  <input id="bf_card" class="custom-control-input" type="checkbox">
                  <label class="custom-control-label" for="bf_card">
                     אבקש להוסיף לחבילה כרטיס היער השחור משפחתי בעלות של 265 יורו למשפחה.
                  </label>
               </div>
               @endif
               <p class="rt_balinfo">תוספת למבוגר מעל גיל 16 היא 30 יורו ללילה.</p>
               <p class="rt_balinfo">תוספת תינוק (0-2) לחבילה היא בעלות 150 דולר .</p>
               <p class="rt_balinfo">שריינו את החופשה שבחרתם בתשלום מקדמה של סה"כ <span style="color:#ffa800">200</span>
                  ₪ בלבד להזמנה דרך האתר.</p>
               <p class="rt_balinfo">נציגנו יצרו עמכם קשר לאישור ההזמנה ויתרת תשלום.</p>
               <p><a href="JavaScript:Void(0);" class="notes_transaction">הערות לעסקה</a></p>
               <div class="pack_data_section remarks_sect">
                  <div class="pack_data_title">
                     <img src="https://www.ramtours.com/wp-content/themes/ramtours/images/remarks_icon.png" alt="">
                     <div class="cap">הערות</div>
                  </div>
                  <div class="section">
                     @if($hotel_include_taxtes==1)
                     <p>
                        המחיר כולל מיסים מקומיים.
                     </p>
                     @else
                     <p>המחיר אינו כולל מיסים מקומיים
                        יש לשלם במקום הלינה מיסים מקומיים בעלות של:
                     </p>
                     @endif
                  </div>
                  <div class="tax_remarks" style="font-weight: bold; font-size: 18px; ">
                     מס:
                  </div>
                  <div class="pack_remarks">
                     <p>מחיר החבילה המוצעת &nbsp;הינו למשפחה אחת של עד 6 נפשות בלבד.<br>
                        המלאי מוגבל.<strong><br>
                           המחיר בחבילה כולל:</strong><br>
                        טיסה סדירה ליעד המבוקש, אירוח בדירת נופש/מלון ורכב סטיישן משפחתי ל-8 לילות<br>
                        ניתן להזמין חדרי מלון/דירות בגדלים אחרים ויש לפנות למשרדנו לצורך כך.<br>
                        בהרכב של 6 נפשות ייתכן ותידרש הזמנת 2 חדרים , לצורך כך יש לפנות למשרדנו לתמחור.<br>
                        <br>
                        בדירות נופש כולל מצעים ומגבות, נקיון סופי</p>
                     <p>נושא המחזור הינו מנדטורי ביער השחור. על מנת לעמוד &nbsp;בדרישות מקום הלינה וחוקי גרמניה אנא מלאו
                        אחר <a
                           href="https://www.ramtours.com/%D7%94%D7%A0%D7%97%D7%99%D7%95%D7%AA-%D7%9E%D7%97%D7%96%D7%95%D7%A8-%D7%91%D7%99%D7%A2%D7%A8-%D7%94%D7%A9%D7%97%D7%95%D7%A8/"
                           target="_blank" rel="noopener">הנחיות המחזור</a><br>
                        <br>
                        יתכן ומקום הלינה המוצע בחבילה זו אינו זמין יותר בתאריכי החבילה והחברה רשאית להציע מקום לינה דומה
                        באותה רמה ובאותו איזור על פי בחירת הלקוח ובכפוף להסכמתו.</p>
                     <p>ט.ל.ח</p>
                  </div>
                  <div class="pack_remarks"></div>

               </div>
            </div>
            <div class="pkg-btns">
               <button class="btn btn-lg btn-primary btn-block checking_cart" type="submit">המשיכו להזמנה
               </button>
               <button class="btn btn-lg btn-default btn-block" type="submit">שאלות? הקליקו ליצירת קשר &gt;&gt;</button>
            </div>
            <div class="pkg-chk">
               <img src="{{url('assets/mobile/images/checkout-img.jpg')}}" alt="checkout Image">
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('rami_mobile_footer_js')
@parent
@include('mobile.pages.singal_js.package_details_js')
@endsection