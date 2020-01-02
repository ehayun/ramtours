@extends('frontend.home_main')
@section('rami_front_container')
<section>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="inner-page-breadcrum">
          <strong>::</strong> <a href="{{url('/')}}">דף הבית </a>
          <img src="{{url('/assets/front/images')}}/bread-crum-arrow.png" alt="">
          @if(!empty($package->package_desti))
          {{ $package->package_desti->loc_name }}
          @endif
          <img src="{{url('/assets/front/images')}}/bread-crum-arrow.png" alt="">
          <strong>
            חבילת נופש
            @if(!empty($package->package_desti))
            {{ 'ל'.$package->package_desti->loc_name }}
            @endif
            {{ rami_get_require_date_format($package->package_end_date, 'd/m').'-' .rami_get_require_date_format($package->package_start_date, 'd/m') }}
          </strong>
        </div>
      </div>
</section>
<section class="steps">
  <div class="container">
    <div class="row">
      <div class="stepwizard">
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
            <a href="#step-3" class="btn" disabled="disabled"><img src="{{url('/assets/front/images')}}/step-check.png"
                alt=""></a>
            <p>אישור הזמנה </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="pkg-data">
  <div class="container">
                        {{-- {{ dd($package) }} --}}
    <div class="row">
      <div class="col-md-3 pkgrt-sec">
        <div class="pkg-right" id="pkgrtsec">
          <div class="pkg-box">
            <h3 class="pkgfrm-head">בחירת דירה והרכב נוסעים </h3>
            <div class="pkg-price">
              <div class="pkg-btns"><button class="btn btn-lg btn-primary btn-block checking_cart" type="submit">
                  המשיכו להזמנה
                </button></div>
              <div class="pkgprc"> <span>מחיר סופי </span>€{{$package->package_lowest_price}}</div>
            </div>
            <div class="pkg-frm">

              <div class="input-group spinner spin_right">
                <label>מבוגר </label>
                <!-- <input type="text" id="rami_pakage_adults" class="form-control" min="1" max="99" value="{{ get_search_adult() }}">
              <div class="input-group-btn-vertical">
                <button class="btn btn-default rami_incr_btn" type="button">
                  <i class="fa fa-plus" aria-hidden="true"></i>
                </button>
                <button class="btn btn-default rami_decr_btn" type="button">
                  <i class="fa fa-minus" aria-hidden="true"></i>
                </button>
              </div>-->
                <select id="rami_pakage_adults">
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </div>
              <div class="input-group spinner spin_left">
                <label>תינוק (0-2) </label>
                <!--<input type="text" id="rami_pakage_infants" class="form-control" min="0" max="99" value="{{ get_search_child() }}">
              <div class="input-group-btn-vertical">
                 <button class="btn btn-default rami_incr_btn" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                <button class="btn btn-default rami_decr_btn" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
              </div>-->
                <select id="rami_pakage_infants">
                  <option value="0">0</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                </select>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </div>
              <div class="input-group spinner spin_left">
                <label>ילד (2-16) </label>
                <!--<input type="text" id="rami_pakage_childs" class="form-control" min="0" max="99" value="{{ get_search_infant() }}">
              <div class="input-group-btn-vertical">
                 <button class="btn btn-default rami_incr_btn" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                <button class="btn btn-default rami_decr_btn" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
              </div>-->

                @php
                $idx = rami_get_least_package($package->total_persons_combinations)
                @endphp
                <select id="rami_pakage_childs">
                  <option value="0" {{$idx==0 ? "selected" : ""}}>0</option>
                  <option value="1" {{$idx==1 ? "selected" : ""}}>1</option>
                  <option value="2" {{$idx==2 ? "selected" : ""}}>2</option>
                  <option value="3" {{$idx==3 ? "selected" : ""}}>3</option>
                  <option value="4" {{$idx==4 ? "selected" : ""}}>4</option>
                  <option value="5" {{$idx==5 ? "selected" : ""}}>5</option>
                  <option value="6" {{$idx==6 ? "selected" : ""}}>6</option>
                  <option value="7" {{$idx==7 ? "selected" : ""}}>7</option>
                  <option value="8" {{$idx==8 ? "selected" : ""}}>8</option>
                  <option value="9" {{$idx==9 ? "selected" : ""}}>9</option>
                  <option value="10">10</option>
                </select>
                <i class="fa fa-angle-down" aria-hidden="true"></i>
              </div>
              <div class="pkg-select rami_cart_select_div rami_package_flights">
                <label>בחר טיסה</label>
                <div class="aprt-inner">
                  <select>
                    <option value="0">בחר טיסה</option>
                    @foreach($all_flights as $all_flight)
                    <option loc_id="{{$all_flight['up_desti_id']}}" value="{{$all_flight['id']}}" @if($all_flight['id']==$package->cheapest_flight_sche)
                      selected="true" @endif >{{$all_flight['title']}}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="pkg-select apart rami_cart_select_div rami_package_room">
                <label>דירה   ({{$hotel->hotel_code}})<!-- {{$hotel->hotel_code.'('.$hotel_dates.')'}} --></label>
                <div class="aprt-inner">
                  <select class="rami_pkg_chnage_select chnage_select1" element_no='1' element_name="room">
                    <option value="0">בחר חדר </option>
                    @foreach( $hotel_rooms as $room)
                    <option value="{{$room['id']}}" @if($room['id']==$package->cheapest_room) selected="true" @endif >
                      <span>
                        <img src="{{url('/assets/front/images')}}/ramtours-rooms.png">
                        @if(!empty($room['room_area']))
                        {{$room['room_type']}} - {{$room['room_area']}} מ"ר |
                        @else
                        {{$room['room_type']}} |
                        @endif
                      </span>
                      <span>
                        &nbsp;מתאים להרכב של עד {{$room['max_people']}} נפשות <span
                          dir="ltr">({{$room['room_code']}})</span>|
                      </span>
                      <span>
                        זמין במלאי {{$room['room_avalible']}} יחידות
                      </span>
                    </option>
                    @endforeach
                  </select>
                  <a href="javascript:void(0);" class="add_button" title="Add More room"><i class="fa fa-plus"
                      aria-hidden="true"></i></a>
                </div>
              </div>
              @if((!empty($package->having_extra_hotel_1==1)) && (!empty($hotel_extra1_rooms)))
              <div class="pkg-select apart rami_cart_select_div rami_package_hotel_extra1_room">
                <label>מלון נוסף  1 {{$hotel_extra1->hotel_code.'('.$hotel_extra1_dates.')'}}</label>
                <div class="aprt-inner">
                  <select class="rami_pkg_chnage_select chnage_select1" element_no='1' element_name="hotel_extra1_room">
                    <option value="0">בחר חדר </option>
                    @foreach( $hotel_extra1_rooms as $room)
                    <option value="{{$room['id']}}" @if($room['id']==$package->cheapest_room) selected="true" @endif >
                      <span>
                        <img src="{{url('/assets/front/images')}}/ramtours-rooms.png">
                        @if(!empty($room['room_area']))
                        {{$room['room_type']}} - {{$room['room_area']}} מ"ר |
                        @else
                        {{$room['room_type']}} |
                        @endif

                      </span>
                      <span>
                        &nbsp;מתאים להרכב של עד {{$room['max_people']}} נפשות <span
                          dir="ltr">({{$room['room_code']}})</span>|
                      </span>
                      <span>
                        זמין במלאי {{$room['room_avalible']}} יחידות

                      </span>
                    </option>
                    @endforeach
                  </select>
                  <a href="javascript:void(0);" class="add_button" title="Add More room"><i class="fa fa-plus"
                      aria-hidden="true"></i></a>
                </div>
              </div>
              @endif
              @if((!empty($package->having_extra_hotel_2==1)) && (!empty($hotel_extra2_rooms)))
              <div class="pkg-select apart rami_cart_select_div rami_package_hotel_extra2_room">
                <label>מלון נוסף  2 {{$hotel_extra2->hotel_code.'('.$hotel_extra2_dates.')'}}</label>
                <div class="aprt-inner">
                  <select class="rami_pkg_chnage_select chnage_select1" element_no='1' element_name="hotel_extra2_room">
                    <option value="0">בחר חדר </option>
                    @foreach( $hotel_extra2_rooms as $room)
                    <option value="{{$room['id']}}" @if($room['id']==$package->cheapest_room) selected="true" @endif >
                      <span>
                        <img src="{{url('/assets/front/images')}}/ramtours-rooms.png">
                        @if(!empty($room['room_area']))
                        {{$room['room_type']}} - {{$room['room_area']}} מ"ר |
                        @else
                        {{$room['room_type']}} |
                        @endif

                      </span>
                      <span>
                        &nbsp;מתאים להרכב של עד {{$room['max_people']}} נפשות <span
                          dir="ltr">({{$room['room_code']}})</span>|
                      </span>
                      <span>
                        זמין במלאי {{$room['room_avalible']}} יחידות

                      </span>
                    </option>
                    @endforeach
                  </select>
                  <a href="javascript:void(0);" class="add_button" title="Add More room"><i class="fa fa-plus"
                      aria-hidden="true"></i></a>
                </div>
              </div>
               @endif
              <div class="pkg-select apart rami_cart_select_div rami_package_cars">
                <label>מבחר סוג רכב </label>
                <div class="aprt-inner">
                  <select class="rami_pkg_chnage_select chnage_select1" element_no='1' element_name="car">
                    <option value="0">בחר מכונית</option>
                    @foreach( $all_cars as $car)
                    @if(empty($car['id']))
                    @continue
                    @endif
                    <option loc_id="{{$car['loc_id']}}" value="{{$car['id']}}" @if($car['id']==$package->cheapest_car) selected="true" @endif
                      >{{$car['car_title']}}</option>
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
                <p class="rt_balinfo">שריינו את החופשה שבחרתם בתשלום מקדמה של סה"כ <span
                    style="color:#ffa800">200</span> ₪ בלבד להזמנה דרך האתר.</p>
                <p class="rt_balinfo">נציגנו יצרו עמכם קשר לאישור ההזמנה ויתרת תשלום.</p>
                <p><a href="" class="notes_transaction" onclick="return false">הערות לעסקה</a></p>
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
                      בהרכב של 6 נפשות ייתכן ותידרש הזמנת 2 חדרים במלון , לצורך כך יש לפנות למשרדנו לתמחור.<br>
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
              </div>
              <div class="contact_popup_basic">
                <a class="wp-colorbox-inline cboxElement" href="#contact_popup" data-toggle="modal"
                  data-target="#contact_popup">שאלות? הקליקו ליצירת קשר </a>
              </div>
              <div class="pkg-inf">
                <p>אתר רם נסיעות מאובטח ע"י תקן PCI הבנלאומי ,סטנדרט גבוה מאוד המבטיח רמת אבטחה </p>
                <p>גבוהה מאוד לרכישות באינטרנט. ניתן לשלם בכרטיסי אשראי הבאים:</p>
              </div>
              <div class="pkg-chk">
                <img src="{{url('/assets/front/images')}}/checkout-img.jpg" alt="checkout Image">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-9 pkg-left">
        <div class="pkg-inner">
          <div class="pkg-header">
            <h3>
              @if($package->is_display_pkg_title==1)
              {{ $package->package_title }}
              @else
              חבילת נופש
              @if(!empty($package->package_desti))
              {{ 'ל'.$package->package_desti->loc_name }}
              @endif
              {{ rami_get_require_date_format($package->package_end_date, 'd/m').'-' .rami_get_require_date_format($package->package_start_date, 'd/m') }}
              @endif
            </h3>
          </div>
          <nav class="navbar navbar-expand-lg navbar-dark" id="rt_affix">
            <ul class="navbar-nav text-uppercase ml-auto rt_tabs">
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger active"
                  href="#basic-details">{{get_rami_page_placeholder('basic_details', 1)}}</a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#aprment">{{get_rami_page_placeholder('apartment', 1)}}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#gallery">{{get_rami_page_placeholder('gallery', 1)}}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger"
                  href="#choose-apartments">{{get_rami_page_placeholder('choice_of_apartments', 1)}}</a>
              </li>
              @if($hotel_reviews->count()>0)
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger"
                  href="#reviews-box">{{get_rami_page_placeholder('hotel_review', 1)}}</a>
              </li>
              @endif
              @if(!empty($map))
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#map">{{get_rami_page_placeholder('map', 1)}}
                </a>
              </li>
              @endif
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#flights">{{get_rami_page_placeholder('flights', 1)}}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#car">{{get_rami_page_placeholder('vehicle', 1)}} </a>
              </li>

            </ul>
          </nav>
          <div class="pkg-section" id="basic-details">
            <div class="row">
              <div class="col-md-5 bd-sec">
                <div class="bd-head">
                  <h3> יעד החופשה:
                    @if(!empty($package->package_desti))
                    {{ $package->package_desti->loc_name }}
                    @endif
                    <img src="{{url('/assets/front/images')}}/location.png"></h3>
                </div>
                @if(!empty($package->pkg_instruction_text))
                <p>{!! $package->pkg_instruction_text !!}</p>
                @else
                <p>{!!rami_vacation_pkg_del_top_text($package->package_flight_location)!!}</p>
                @endif
              </div>
              <div class="col-md-4 bd-sec">
                <div class="bd-head">
                  <h3>תאריכים<img src="{{url('/assets/front/images')}}/date-ico.png"></h3>
                </div>
                <p>{{ $package->package_end_date }} - {{ $package->package_start_date }}</p>
                <p> {{rami_get_no_of_days_diff($package->package_start_date, $package->package_end_date)}} לילות
                </p>
              </div>
              <div class="col-md-3 bd-sec">
                <div class="bd-head">
                  <h3>מקום אירוח<img src="{{url('/assets/front/images')}}/apartment-ico.png"></h3>
                </div>
                @if(!empty($hotel_instructions))
                <p>{!! $hotel_instructions !!}</p>
                @else
                <p>דירת נופש</p>
                <p>ללא ארוחות</p>
                @endif
              </div>
            </div>
          </div>
            <div class="pkg-section" id="aprment">
            <div class="row">
              <div class="col-md-12 bd-sec">
                <div class="bd-head">
                  <h3>לינה <span class="rt_headd"> {{ get_rami_page_placeholder('help_text_apartment',1) }}</span><img
                      src="{{url('/assets/front/images')}}/rooms.png"></h3>
                </div>
              </div>
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">{{$hotel->hotel_display_name }}</h6>
                <p>כתובת: {{ $hotel->hotel_code }} - {{ $hotel->hotel_address }} </p>
              </div>
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">מידע כללי</h6>
                <p>{!! $hotel->hotel_desc !!} </p>
              </div>
              @if(!empty($hotel->hotel_instruction_text))
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">אטרקציות</h6>
                <p>
                  {!! $hotel->hotel_instruction_text !!}
                </p>
              </div>
              @endif
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">פעילויות בקרבת מקום</h6>
                <ul>
                  @foreach($amenities as $amenity)
                  <li>{{ get_hotel_amenities($amenity) }}</li>
                  @endforeach
                </ul>
              </div>
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">מתקני מקום הלינה </h6>
                <ul>
                  @foreach($features as $feature)
                  <li>{{ get_hotel_features($feature) }}</li>
                  @endforeach
                </ul>
              </div>
              @if(!empty($hotel_card))
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head rt_cardhead">מידע על כרטיס </h6>
                <img src="{{url('ramtours/'.$hotel_card['card_image'])}}" class="rt_cardimg">
                <p class="rt_cardesc">המתארחים במקום לינה זה זכאים
                  <a href=" {{$hotel_card['link']}}" target="_blank">
                    {{$hotel_card['title']}}
                  </a>
                </p>
              </div>
              @endif
            </div>
          </div>
          <div class="pkg-section" id="gallery">
            <div class="row">
              <div class="col-md-12 bd-sec">
                <div class="bd-head">
                  <h3>גלריה <span class="rt_headd"> {{ get_rami_page_placeholder('help_text_gallery',1) }}</span><img
                      src="{{url('/assets/front/images')}}/gallery.png"></h3>
                </div>
              </div>
              <div class="col-md-12 gallery">
                @foreach($hotel_gallery as $img)
                <div class="pics">
                  <a data-fancybox="gallery" href="{{url('ramtours/'.$img->image)}}">
                    <img class="img-fluid" src="{{url('ramtours/'.$img->image)}}" alt="{{$img->title}}">
                  </a>
                  @if(($loop->index==5)&&($hotel_gallery_count >0))
                  <div class="more_img">
                    +{{$hotel_gallery_count }}
                  </div>
                  @endif
                </div>
                @endforeach
              </div>
            </div>
          </div>
          <div class="pkg-section pack_room" id="hotel_rooms">
            <div class="row">
              <div class="col-md-12 bd-sec">
                <div class="bd-head">
                  <h3><img src="{{url('/assets/front/images')}}/apartment-ico.png"> מידע על מקום הלינה <span class="rt_headd"> {{ get_rami_page_placeholder('help_text_apartment_info',1) }}</span></h3>
                </div>
              </div>
              @foreach($hotel_rooms as $room)
              <div class="col-md-12 ap-cont">
                <h3 class="cont-head">
                  <span>
                    <img src="{{url('/assets/front/images')}}/ramtours-rooms.png">
                    @if(!empty($room['room_area']))
                    {{$room['room_type']}} - {{$room['room_area']}} מ"ר |
                    @else
                    {{$room['room_type']}} |
                    @endif
                  </span>
                  <span>
                    <img src="{{url('/assets/front/images')}}/mann.png">&nbsp;מתאים להרכב של עד {{$room['max_people']}}
                    נפשות <span dir="ltr">({{$room['room_code']}})</span>|
                  </span>
                  <span>
                    <img src="{{url('/assets/front/images')}}/aproom.png">
                    זמין במלאי {{$room['room_avalible']}} יחידות
                  </span>
                </h3>
              </div>
              <div class="col-md-7 ap-cont">
                <p> {!! $room['room_desc'] !!}<p>
                    <p>מתאים להרכב של עד {{$room['max_people']}} נפשות</p>
              </div>
              <div class="col-md-5 ap-cont">
                <div class="col-md-12 gallery">
                  @foreach($room['room_images'] as $room_img)
                  <div class="pics">
                    <a data-fancybox="gallery1" href="{{url('ramtours/'.$room_img->image)}}">
                      <img class="img-fluid" src="{{url('ramtours/'.$room_img->image)}}" alt=""></a>
                  </div>
                  @endforeach
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @if((!empty($package->having_extra_hotel_1==1)) && (!empty($hotel_extra1)))
           <div class="pkg-section" id="extra1_aprment">
            <div class="row">
              <div class="col-md-12 bd-sec">
                <div class="bd-head">
                  <h3>מלון נוסף  1 {{$hotel_extra1->hotel_code.'('.$hotel_extra1_dates.')'}}<span class="rt_headd"> </span><img
                      src="{{url('/assets/front/images')}}/rooms.png"></h3>
                </div>
              </div>
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">{{$hotel_extra1->hotel_display_name }}</h6>
                <p>כתובת: {{ $hotel_extra1->hotel_code }} - {{ $hotel_extra1->hotel_address }} </p>
              </div>
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">מידע כללי</h6>
                <p>{!! $hotel_extra1->hotel_desc !!} </p>
              </div>
              @if(!empty($hotel_extra1->hotel_instruction_text))
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">אטרקציות</h6>
                <p>
                  {!! $hotel_extra1->hotel_instruction_text !!}
                </p>
              </div>
              @endif
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">פעילויות בקרבת מקום</h6>
                <ul>
                  @foreach($hotel_extra1_amenities as $amenity)
                  <li>{{ get_hotel_amenities($amenity) }}</li>
                  @endforeach
                </ul>
              </div>
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">מתקני מקום הלינה </h6>
                <ul>
                  @foreach($hotel_extra1_features as $feature)
                  <li>{{ get_hotel_features($feature) }}</li>
                  @endforeach
                </ul>
              </div>
              <!-- @if(!empty($hotel_extra1_card))
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head rt_cardhead">מידע על כרטיס </h6>
                <img src="{{url('ramtours/'.$hotel_extra1_card['card_image'])}}" class="rt_cardimg">
                <p class="rt_cardesc">המתארחים במקום לינה זה זכאים
                  <a href=" {{$hotel_extra1_card['link']}}" target="_blank">
                    {{$hotel_extra1_card['title']}}
                  </a>
                </p>
              </div>
              @endif -->
            </div>
          </div>
          @endif
          @if((!empty($package->having_extra_hotel_1==1)) && (!empty($hotel_extra1_gallery)))
          <div class="pkg-section" id="gallery_hotel_extra1">
            <div class="row">
              <div class="col-md-12 bd-sec">
                <div class="bd-head">
                  <h3>גלריה <span class="rt_headd"></span><img
                      src="{{url('/assets/front/images')}}/gallery.png"></h3>
                </div>
              </div>
              <div class="col-md-12 gallery">
                @foreach($hotel_extra1_gallery as $img)
                <div class="pics">
                  <a data-fancybox="gallery" href="{{url('ramtours/'.$img->image)}}">
                    <img class="img-fluid" src="{{url('ramtours/'.$img->image)}}" alt="{{$img->title}}">
                  </a>
                  @if(($loop->index==5)&&($hotel_extra1_gallery_count >0))
                  <div class="more_img">
                    +{{$hotel_extra1_gallery_count }}
                  </div>
                  @endif
                </div>
                @endforeach
              </div>
            </div>
          </div>
          @endif
          @if((!empty($package->having_extra_hotel_1==1)) && (!empty($hotel_extra1_rooms)))
          <div class="pkg-section pack_room" id="hotel_rooms">
            <div class="row">
              <div class="col-md-12 bd-sec">
                <div class="bd-head">
                  <h3><img src="{{url('/assets/front/images')}}/apartment-ico.png"> מידע על מקום הלינה <span
                      class="rt_headd"> {{ get_rami_page_placeholder('help_text_apartment_info',1) }}</span></h3>
                </div>
              </div>
              @foreach($hotel_extra1_rooms as $room)
              <div class="col-md-12 ap-cont">
                <h3 class="cont-head">
                  <span>
                    <img src="{{url('/assets/front/images')}}/ramtours-rooms.png">
                    @if(!empty($room['room_area']))
                    {{$room['room_type']}} - {{$room['room_area']}} מ"ר |
                    @else
                    {{$room['room_type']}} |
                    @endif
                  </span>
                  <span>
                    <img src="{{url('/assets/front/images')}}/mann.png">&nbsp;מתאים להרכב של עד {{$room['max_people']}}
                    נפשות <span dir="ltr">({{$room['room_code']}})</span>|
                  </span>
                  <span>
                    <img src="{{url('/assets/front/images')}}/aproom.png">
                    זמין במלאי {{$room['room_avalible']}} יחידות
                  </span>
                </h3>
              </div>
              <div class="col-md-7 ap-cont">
                <p> {!! $room['room_desc'] !!}<p>
                    <p>מתאים להרכב של עד {{$room['max_people']}} נפשות</p>
              </div>
              <div class="col-md-5 ap-cont">
                <div class="col-md-12 gallery">
                  @foreach($room['room_images'] as $room_img)
                  <div class="pics">
                    <a data-fancybox="gallery1" href="{{url('ramtours/'.$room_img->image)}}">
                      <img class="img-fluid" src="{{url('ramtours/'.$room_img->image)}}" alt=""></a>
                  </div>
                  @endforeach
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endif
          @if((!empty($package->having_extra_hotel_2==1)) && (!empty($hotel_extra2)))
           <div class="pkg-section" id="extra1_aprment">
            <div class="row">
              <div class="col-md-12 bd-sec">
                <div class="bd-head">
                  <h3>לון נוסף  2 {{$hotel_extra2->hotel_code.'('.$hotel_extra2_dates.')'}} <span class="rt_headd"> </span><img
                      src="{{url('/assets/front/images')}}/rooms.png"></h3>
                </div>
              </div>
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">{{$hotel_extra2->hotel_display_name }}</h6>
                <p>כתובת: {{ $hotel_extra2->hotel_code }} - {{ $hotel_extra2->hotel_address }} </p>
              </div>
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">מידע כללי</h6>
                <p>{!! $hotel_extra2->hotel_desc !!} </p>
              </div>
              @if(!empty($hotel_extra2->hotel_instruction_text))
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">אטרקציות</h6>
                <p>
                  {!! $hotel_extra2->hotel_instruction_text !!}
                </p>
              </div>
              @endif
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">פעילויות בקרבת מקום</h6>
                <ul>
                  @foreach($hotel_extra2_amenities as $amenity)
                  <li>{{ get_hotel_amenities($amenity) }}</li>
                  @endforeach
                </ul>
              </div>
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head">מתקני מקום הלינה </h6>
                <ul>
                  @foreach($hotel_extra2_features as $feature)
                  <li>{{ get_hotel_features($feature) }}</li>
                  @endforeach
                </ul>
              </div>
              <!-- @if(!empty($hotel_extra2_card))
              <div class="col-md-12 ap-cont">
                <h6 class="cont-head rt_cardhead">מידע על כרטיס </h6>
                <img src="{{url('ramtours/'.$hotel_extra2_card['card_image'])}}" class="rt_cardimg">
                <p class="rt_cardesc">המתארחים במקום לינה זה זכאים
                  <a href=" {{$hotel_extra2_card['link']}}" target="_blank">
                    {{$hotel_extra2_card['title']}}
                  </a>
                </p>
              </div>
              @endif -->
            </div>
          </div>
          @endif
          @if((!empty($package->having_extra_hotel_2==1)) && (!empty($hotel_extra2_gallery)))
          <div class="pkg-section" id="gallery_hotel_extra1">
            <div class="row">
              <div class="col-md-12 bd-sec">
                <div class="bd-head">
                  <h3>גלריה <span class="rt_headd"></span><img
                      src="{{url('/assets/front/images')}}/gallery.png"></h3>
                </div>
              </div>
              <div class="col-md-12 gallery">
                @foreach($hotel_extra2_gallery as $img)
                <div class="pics">
                  <a data-fancybox="gallery" href="{{url('ramtours/'.$img->image)}}">
                    <img class="img-fluid" src="{{url('ramtours/'.$img->image)}}" alt="{{$img->title}}">
                  </a>
                  @if(($loop->index==5)&&($hotel_extra2_gallery_count >0))
                  <div class="more_img">
                    +{{$hotel_extra2_gallery_count }}
                  </div>
                  @endif
                </div>
                @endforeach
              </div>
            </div>
          </div>
          @endif
          @if((!empty($package->having_extra_hotel_2==1)) && (!empty($hotel_extra2_rooms)))
          <div class="pkg-section pack_room" id="hotel_extra2_rooms">
            <div class="row">
              <div class="col-md-12 bd-sec">
                <div class="bd-head">
                  <h3><img src="{{url('/assets/front/images')}}/apartment-ico.png"> מידע על מקום הלינה <span
                      class="rt_headd"> {{ get_rami_page_placeholder('help_text_apartment_info',1) }}</span></h3>
                </div>
              </div>
              @foreach($hotel_extra2_rooms as $room)
              <div class="col-md-12 ap-cont">
                <h3 class="cont-head">
                  <span>
                    <img src="{{url('/assets/front/images')}}/ramtours-rooms.png">
                    @if(!empty($room['room_area']))
                    {{$room['room_type']}} - {{$room['room_area']}} מ"ר |
                    @else
                    {{$room['room_type']}} |
                    @endif
                  </span>
                  <span>
                    <img src="{{url('/assets/front/images')}}/mann.png">&nbsp;מתאים להרכב של עד {{$room['max_people']}}
                    נפשות <span dir="ltr">({{$room['room_code']}})</span>|
                  </span>
                  <span>
                    <img src="{{url('/assets/front/images')}}/aproom.png">
                    זמין במלאי {{$room['room_avalible']}} יחידות
                  </span>
                </h3>
              </div>
              <div class="col-md-7 ap-cont">
                <p> {!! $room['room_desc'] !!}<p>
                    <p>מתאים להרכב של עד {{$room['max_people']}} נפשות</p>
              </div>
              <div class="col-md-5 ap-cont">
                <div class="col-md-12 gallery">
                  @foreach($room['room_images'] as $room_img)
                  <div class="pics">
                    <a data-fancybox="gallery1" href="{{url('ramtours/'.$room_img->image)}}">
                      <img class="img-fluid" src="{{url('ramtours/'.$room_img->image)}}" alt=""></a>
                  </div>
                  @endforeach
                </div>
              </div>
              @endforeach
            </div>
          </div>
          @endif
          @if(!empty($map))
          <div class="pkg-section" id="map">
            <div class="row">
              <div class="col-md-12 bd-sec">
                <div class="bd-head">
                  <h3>אטרקציות באיזור מקום האירוח <span class="rt_headd">
                      {{ get_rami_page_placeholder('help_text_attraction',1) }}</span><img
                      src="{{url('/assets/front/images')}}/location.png"></h3>
                </div>
              </div>
              <div class="col-md-4 att-sec">
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
              <div class="col-md-8 map-sec">
                <img src="{{url('ramtours/'.$map)}}" alt="map" class="img-fluid">
                <div class="map-text">
                  כל המפות באתר מיועדות להמחשה בלבד, ישנם אי דיוקים במרחקי האטרקציות למקום הלינה, לכן אין להסתמך על
                  נתונים אלה לצורך תכנון הטיול.
                </div>
              </div>
            </div>
          </div>
          @endif
          {{-- hotel reviews --}}
          {!! get_rami_hotel_reviews($hotel_reviews) !!}
          <div class="pkg-section" id="flights">
            <div class="row flt-inner">
              <div class="col-md-12 bd-sec">
                <div class="bd-head">
                  <h3>טיסה <span class="rt_headd"> {{ get_rami_page_placeholder('help_text_flights',1) }}</span><img
                      src="{{url('/assets/front/images')}}/flight-ico.png"></h3>
                </div>
              </div>
              <div class="col-md-12 rt_flts">
                <div class="flights-details-box-inner">
                  @foreach($all_flights as $all_flight)
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
                          {{'טיסת '.$all_flight['up_flight_no']}} {{ $all_flight['up_source'] }}
                          ל{{$all_flight['up_desti']}}
                        </span>
                      </div>
                      <div class="flight-text-box tf4"></div>
                      <div class="clear"></div>
                    </div>
                    @endif
                    @foreach($all_flight['up_flights'] as $flight)
                    <div class="flight-secc top">
                      <div class="flights-icon">
                        <img width="262" height="165" src="{{url('ramtours/'.$flight['airline_logo'])}}"
                          class="img-fluid" alt="">
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



                    <!-- 

                      array:1 [▼
  2 => array:22 [▼
    "up_airline_name" => "Lufthansa"
    "up_airline_logo" => "airline/39_airline_15615359147.jpeg"
    "up_depart_full_date" => "יום ראשון ,08 ,אפריל ,2020"
    "up_departure_time" => "08:00"
    "up_arrival_time" => "11:30"
    "up_departure_time_in_month_date" => "08 ,אפריל"
    "up_arrival_time_in_month_date" => "08 ,אפריל"
    "up_desti" => "פרנקפורט"
    "up_source" => "תל-אביב"
    "up_flight_no" => "695"
    "up_time_taken" => "3:29"
    "down_airline_name" => "Lufthansa"
    "down_airline_logo" => "airline/39_airline_15615359147.jpeg"
    "down_depart_full_date" => "יום ראשון ,14 ,אפריל ,2020"
    "down_departure_time" => "22:55"
    "down_departure_time_in_month_date" => "14 ,אפריל"
    "down_arrival_time_in_month_date" => "15 ,אפריל"
    "down_arrival_time" => "03:35"
    "down_time_taken" => "4:39"
    "down_desti" => "מינכן"
    "down_source" => "תל-אביב"
    "down_flight_no" => "681"
  ]
]

                    up_airline_name ==>
                    string(9) "Lufthansa"
                                          up_airline_logo ==>
                    string(35) "airline/39_airline_15615359147.jpeg"
                                          up_depart_full_date ==>
                    string(39) "יום ראשון ,08 ,אפריל ,2020"
                                          up_departure_time ==>
                    string(5) "08:00"
                                          up_arrival_time ==>
                    string(5) "11:30"
                                          up_departure_time_in_month_date ==>
                    string(14) "08 ,אפריל"
                                          up_arrival_time_in_month_date ==>
                    string(14) "08 ,אפריל"
                                          up_desti ==>
                    string(16) "פרנקפורט"
                                          up_source ==>
                    string(13) "תל-אביב"
                                          up_flight_no ==>
                    string(3) "695"
                                          up_time_taken ==>
                    string(4) "3:29"
                                          down_airline_name ==>
                    string(9) "Lufthansa"
                                          down_airline_logo ==>
                    string(35) "airline/39_airline_15615359147.jpeg"
                                          down_depart_full_date ==>
                    string(39) "יום ראשון ,14 ,אפריל ,2020"
                                          down_departure_time ==>
                    string(5) "22:55"
                                          down_departure_time_in_month_date ==>
                    string(14) "14 ,אפריל"
                                          down_arrival_time_in_month_date ==>
                    string(14) "15 ,אפריל"
                                          down_arrival_time ==>
                    string(5) "03:35"
                                          down_time_taken ==>
                    string(4) "4:39"
                                          down_desti ==>
                    string(10) "מינכן"
                                          down_source ==>
                    string(13) "תל-אביב"
                                          down_flight_no ==>
                    string(3) "681"
                                          up_flights ==>
                    array(0) {
}
                                          down_flights ==>
                    array(0) {
}
                                          id ==>
                    int(131)
                                          title ==>
                    string(73) "טיסת לופטהנזה 695 מישראל לפרנקפורט 08/04-14/04"
                     -->


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
                          {{'טיסת '.$all_flight['down_flight_no']}} {{ $all_flight['down_source'] }}
                          ל{{$all_flight['down_desti']}}
                        </span>
                      </div>
                      <div class="flight-text-box tf4"></div>
                      <div class="clear"></div>
                    </div>

                    @endif
                    @foreach($all_flight['down_flights'] as $flight)
                    <div class="flight-secc bottom">
                      <div class="flights-icon">
                        <img width="262" height="165" src="{{url('ramtours/'.$flight['airline_logo'])}}"
                          class="img-fluid" alt="">
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
                          {{' 4טיסת '.$flight['flight_no']}} {{ $flight['source'] }} ל{{$flight['desti']}}
                        </span>
                      </div>
                      <div class="flight-text-box tf4"></div>
                      <div class="clear"></div>
                    </div>
                    @endforeach
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
            <div class="pkg-section" id="car">
              <div class="row">
                <div class="col-md-12 bd-sec">
                  <div class="bd-head">
                    <h3>רכב <span class="rt_headd"> {{ get_rami_page_placeholder('help_text_vehicle',1) }}</span><img
                        src="{{url('/assets/front/images')}}/pkg-car.png"></h3>
                  </div>
                </div>
                <div class="col-md-8">
                <small><b>איסוף והחזרה של רכב בתחנות שונות מחייב דמי החזר לחברת ההשכרה של כ-40 יורו</b></small>
                </div>
                <div class="col-md-8">
                  <h5>{{$all_cars['first_car_title']}}</h5>
                  <p>{!!$all_cars['first_car_des']!!}</p>
                  <!-- <h6 class="cont-head">אפשרויות שדרוג רכב בתשלום (מחיר ליום) </h6> -->
                  <h6 class="cont-head">אפשרויות לשדרוג הרכב בחבילה </h6>
                  <ul class="crprice">
                    @foreach($all_cars as $car)
                    @if(empty($car['car_title']))
                    @continue
                    @endif
                    @if($car['id']==$package['cheapest_car'])
                    @continue
                    @endif
                    <li loc_id="{{$car['loc_id']}}">{{$car['car_title']}}
                      <!-- <span class="mcrprz">{{'€'.$car['car_price']}}</span> -->
                    </li>
                    @endforeach
                  </ul>
                </div>
                <div class="col-md-4 ap-cont">
                  <img src="{{url('ramtours/'.$all_cars['first_car_img'])}}" class="img-fluid">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</section>
@include('frontend.pages.contact_us_popup')
@endsection
@section('rami_front_footer_js')
@parent
@include('frontend.pages.singal_js.package_details_js')
@include('frontend.pages.singal_js.contact_us_popup_js')
@endsection