@extends('frontend.home_main')
@section('rami_front_container')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="inner-page-breadcrum">
          <strong>::</strong>
          <a href="{{url('/')}}"> טיסה</a>
          <img src="{{url('/assets/front/images')}}/bread-crum-arrow.png" alt="">
          מינכן <img src="{{url('/assets/front/images')}}/bread-crum-arrow.png" alt="">
          <strong>
            {{$all_flight['up_flight_no']}} מ{{$all_flight['up_source'] }} ל{{$all_flight['up_desti'] }}
          </strong>
        </div>
      </div>
</section>
<section class="rt_flts">
  <div class="container">
    <div class="row flt-inner">
      <div class="col-lg-9 flights-details-box flight_boxx">
        <div class="flights-details-box-inner">
          <div class="flight-conttt">
            <div class="flight-tophead">
              <div class="flights-headings">יציאה : {{$all_flight['up_depart_full_date']}}
              </div>
              <div class="flight-date">יעד : {{$all_flight['up_desti']}}</div>
              <div class="flight-places"></div>
              <div class="flight-duration">משך טיסה כולל {{$all_flight['up_time_taken']}}</div>
            </div>
            @if(empty($all_flight['up_flights']))
            <div class="flight-secc top">
              <div class="flights-icon">
                <img width="262" height="165" src="{{url('ramtours/'.$all_flight['up_airline_logo'])}}"
                  class="img-fluid" alt="">
                <div class="flt_inff"><span class="fltt_name">{{
                                 $all_flight['up_airline_name'] }} </span></div>
              </div>
              <div class="flight-text-box tf1">
                {{$all_flight['up_source']}}
                <span class="rt_tmm">{{$all_flight['up_departure_time']}}
                </span>{{$all_flight['up_departure_time_in_month_date']}}
              </div>
              <div class="flight-take-off ftbord">
                <span class="rt_plane">
                  <i class="fa fa-plane" aria-hidden="true"></i>
                </span>
              </div>
              <div class="flight-text-box tf2">
                {{$all_flight['up_desti']}}
                <span class="rt_tmm">
                  {{$all_flight['up_arrival_time']}}
                </span>{{$all_flight['up_arrival_time_in_month_date']}}
              </div>
              <div class="flight-text-box tf3">
                <span class="fltt-info">
                  פרטי הטיסה
                </span>
                <span class="fltt-ttltime">
                  {{'טיסת '.$all_flight['down_flight_no']}} {{ $all_flight['down_source'] }} ל{{$all_flight['down_desti']}}
                </span>
              </div>
              <div class="flight-text-box tf4"></div>
              <div class="clear"></div>
            </div>

            @endif
            @foreach($all_flight['up_flights'] as $flight)
            <div class="flight-secc top">
              <div class="flights-icon">
                <img width="262" height="165" src="{{url('ramtours/'.$flight['airline_logo'])}}" class="img-fluid"
                  alt="">
                <div class="flt_inff"><span class="fltt_name">{{
                               $flight['airline_name'] }} </span></div>
              </div>
              <div class="flight-text-box tf1">
                {{$flight['source']}}
                <span class="rt_tmm">{{$flight['departure_time']}}
                </span> {{$flight['depart_time_in_month_date']}}
              </div>
              <div class="flight-take-off ftbord">
                <span class="rt_plane">
                  <i class="fa fa-plane" aria-hidden="true"></i>
                </span>
              </div>
              <div class="flight-text-box tf2">
                {{$flight['desti']}}
                <span class="rt_tmm">
                  {{$flight['arrival_time']}}
                </span> {{$flight['arrival_time_in_month_date']}}
              </div>
              <div class="flight-text-box tf3">
                <span class="fltt-info">
                  פרטי הטיסה
                </span>
                <span class="fltt-ttltime">
                  {{'טיסת '.$flight['flight_no']}} {{ $flight['source'] }} ל{{$flight['desti']}}
                </span>
              </div>
              <div class="flight-text-box tf4"></div>
              <div class="clear"></div>
            </div>
            @endforeach

            <div class="flight-tophead">
              <div class="flights-headings">חזור: {{$all_flight['down_depart_full_date']}}</div>
              <div class="flight-date">יעד : {{$all_flight['down_desti'] }} </div>
              <div class="flight-places"></div>
              <div class="flight-duration">משך טיסה כולל {{$all_flight['down_time_taken']}}</div>

            </div>
            @if(empty($all_flight['down_flights']))
            <div class="flight-secc bottom">
              <div class="flights-icon">
                <img width="262" height="165" src="{{url('ramtours/'.$all_flight['down_airline_logo'])}}"
                  class="img-fluid" alt="">
                <div class="flt_inff"><span class="fltt_name">{{
                                   $all_flight['down_airline_name'] }} </span></div>
              </div>
              <div class="flight-text-box tf1">
                {{$all_flight['down_source']}}
                <span class="rt_tmm">{{$all_flight['down_departure_time']}}
                </span>{{$all_flight['down_departure_time_in_month_date']}}
              </div>
              <div class="flight-take-off ftbord">
                <span class="rt_plane">
                  <i class="fa fa-plane" aria-hidden="true"></i>
                </span>
              </div>
              <div class="flight-text-box tf2">
                {{$all_flight['down_desti']}}
                <span class="rt_tmm">
                  {{$all_flight['down_arrival_time']}}
                </span>{{$all_flight['down_arrival_time_in_month_date']}}
              </div>
              <div class="flight-text-box tf3">
                <span class="fltt-info">
                  פרטי הטיסה
                </span>
                <span class="fltt-ttltime">
                  {{'טיסת '.$all_flight['up_flight_no']}} {{ $all_flight['up_source'] }} ל{{$all_flight['up_desti']}}
                </span>
              </div>
              <div class="flight-text-box tf4"></div>
              <div class="clear"></div>
            </div>

            @endif
            @foreach($all_flight['down_flights'] as $flight)
            <div class="flight-secc bottom">
              <div class="flights-icon">
                <img width="262" height="165" src="{{url('ramtours/'.$flight['airline_logo'])}}" class="img-fluid"
                  alt="">
                <div class="flt_inff"><span class="fltt_name">{{
                                 $flight['airline_name'] }} </span></div>
              </div>
              <div class="flight-text-box tf1">
                {{$flight['source']}}
                <span class="rt_tmm">{{$flight['departure_time']}}
                </span> 8 יולי
              </div>
              <div class="flight-take-off ftbord">
                <span class="rt_plane">
                  <i class="fa fa-plane" aria-hidden="true"></i>
                </span>
              </div>
              <div class="flight-text-box tf2">
                {{$flight['desti']}}
                <span class="rt_tmm">
                  {{$flight['arrival_time']}}
                </span> 8 יולי
              </div>
              <div class="flight-text-box tf3">
                <span class="fltt-info">
                  פרטי הטיסה
                </span>
                <span class="fltt-ttltime">
                  {{'טיסת '.$flight['flight_no']}} {{ $flight['source'] }} ל{{$flight['desti']}}
                </span>
              </div>
              <div class="flight-text-box tf4"></div>
              <div class="clear"></div>
            </div>
            @endforeach

          </div>
        </div>
      </div>
      <div class="col-md-3 flight-left-frm">
        <div class="flight-prise-box">
          <div class="flight-prise-inner" data-p_per_person="487">
            <div class="font13">נותרו {{$all_flight['num_available_seat']}} מקומות פנויים</div>
            <div class="car-details-price flight_price">
              ${{get_rami_flight_price_for_single_flight($all_flight['id'])}}<span> לנוסע</span></div>
            <div>
              <label>בחירת מספר נוסעים (עד 5 בסך הכל)</label>
              <div class="pass_select">
                <label class="num_lbl">מספר מבוגרים:</label>
                <input type="number" data-current_val="1" min="1" max="99" class="num_passangers adults"
                  value="{{ get_search_adult() }}" id="rami_pakage_adults">
                <div class="quantity-nav">
                  <div class="quantity-button quantity-up rami_incr_btn">+</div>
                  <div class="quantity-button quantity-down rami_decr_btn">-</div>
                </div>
              </div>
              <div class="pass_select">
                <label class="num_lbl">מספר ילדים (2-16):</label>
                <input type="number" data-current_val="0" min="0" max="99" class="num_passangers kids"
                  value="{{ get_search_child() }}" id="rami_pakage_childs">
                <div class="quantity-nav">
                  <div class="quantity-button quantity-up rami_incr_btn">+</div>
                  <div class="quantity-button quantity-down rami_decr_btn">-</div>
                </div>
              </div>
              <div class="pass_select">
                <label class="num_lbl">מספר תינוקות (0-2):</label>
                <input type="number" data-current_val="0" min="0" max="99" class="num_passangers infants"
                  value="{{ get_search_child() }}" id="rami_pakage_infants">
                <div class="quantity-nav">
                  <div class="quantity-button quantity-up rami_incr_btn">+</div>
                  <div class="quantity-button quantity-down rami_decr_btn">-</div>
                </div>
              </div>
            </div>
            <div class="flight-total">סה״כ: <span
                class="yellow-text">${{get_rami_flight_price_for_single_flight($all_flight['id'])}}</span></div>
            <div class="clear"></div>
            <div class="flights-buttons-box">
              <input name="" type="button" class="flight-for-button slideDiv" value="לפרטים" id="5112">

              <input name="" type="button" class="flight-choose-button add-to-cart_flight checking_cart" value="הזמינו">
              <div class="section" id="pay_remarks">
                <p style="text-align: right; ">למזמינים חבילת נופש, טיסה או טוס וסע ניתן לשלם בכרטיס אשראי עד 4 תשלומים
                  ללא ריבית או יותר בקרדיט. אפשר גם בהעברה לבנק או במשרדנו בגבעת שמואל במזומן.</p>
                <p
                  style="text-align: right; border-top: 1px #ffa800 solid ;padding-top: 3px; margin-top: 5px; margin-bottom: 0px;font-size: 15px;">
                  שריינו את הטיסה שבחרתם בתשלום מקדמה של סה"כ <span style="font-size: 20px;color: #ffa800;">200</span>
                  בלבד להזמנה דרך האתר. נציגנו יצרו עמכם קשר לאישור ההזמנה ויתרת תשלום.</p>
                <p style="text-align: right; padding-top: 0; margin-bottom: 10px;font-size: 15px;display: none;">ההזמנה
                  ניתנת לביטול תוך 14 יום מרגע ההזמנה תמורת 100 שקלים לאדם.</p>
                <p>
                  <img class="optimized_c_cards" src="{{url('/assets/front/images')}}/visa.jpg">
                </p>
                <p>אתר רם נסיעות מאובטח ע"י תקן PCI הבנלאומי ,סטנדרט גבוה מאוד המבטיח רמת אבטחה גבוהה מאוד לרכישות
                  באינטרנט. ניתן לשלם בכרטיסי אשראי הבאים:</p>
              </div>
              <div id="flight_page_contact_pop_cont">
                <div class="contact_popup_basic">
                  <a class="wp-colorbox-inline cboxElement" href="#contact_popup" data-toggle="modal"
                    data-target="#contact_popup">שאלות? הקליקו ליצירת קשר </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
</section>
@include('frontend.pages.contact_us_popup')
@endsection
@section('rami_front_footer_js')
@parent
@include('frontend.pages.singal_js.flight_details_js')
@include('frontend.pages.singal_js.contact_us_popup_js')
@endsection