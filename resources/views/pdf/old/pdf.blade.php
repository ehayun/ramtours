<table width="100%">
   <tr>
      <td colspan="2"><br />
         <h2>פרטי הזמנה: {{ $title }} </h2>
         <br />
         מסמך זה אינו מהווה אישור סופי להזמנתך, הזמנתך כרוכה באישור סופי מול ספקי התיירות וחברת התעופה, נציגי רם נסיעות
         ותיירות יחזרו אליכם תוך 48 שעות לאישורה הסופי
         <br />
         <hr />
         <br />
      </td>
   </tr>
   <tr>
      <td>
         <h4>פרטים כלליים </h4>
         <strong>תאריך ההזמנה: </strong>
         {{ $order_date }}
         <br />
         <strong>סוג הזמנה: : </strong>
         {{$order_type}}
      </td>
      <td>
         <h4>פרטי הלקוח </h4>
         <strong> שם הלקוח: : </strong>
         {{ $client_name }}<br />
         <strong>דואר אלקטרוני : </strong>
         {{ $client_email}}<br />
         <strong>כתובת הלקוח : </strong>
         {{ $client_address }}<br />
         <strong>עיר : </strong>
         {{ $client_city }}<br />
         <strong>טלפון נייד : </strong>
         {{ $client_mobile}}<br />
         <strong>טלפון לקוח : </strong>
         {{ $client_phone }}<br />
         <strong>קידוד לקוח : </strong>
         {{ $client_zipcode }}<br />
         <strong>שיטת תשלום : </strong>
         עסקת אשראי <br />
         <strong> 1קוד עסקה : </strong>
         {{$trxn1}} <br />
         <strong> 2קוד עסקה : </strong>
         {{$trxn2}}<br />
      </td>
   </tr>
</table>
<br /> <br />
<table>
   <tr>
      <td colspan="2">
         <h2>פרטי ההזמנה </h2>
         <hr />
         <br /> <br />
      </td>
   </tr>
   <tr>
      <td>
         <h4>מועד ההזמנה </h4>
         <br />
         <strong>מתאריך : </strong>
         {{$from_date }}<br />
         <strong>עד תאריך : </strong>
         {{ $to_date }}<br />
         <strong>ימי הטיול :</strong>
         {{$no_of_days}}
      </td>
      <td>
         <h4>פרטים אישיים </h4>
         <br />
         <strong>סך הכל נפשות : </strong>
         {{$total_person }}<br />
         <strong>מבוגרים : </strong>
         {{$adults}}<br />
         <strong>ילדים' : </strong>
         {{$kids}}
      </td>
   </tr>
</table>
<table>
   <tr>
      <br />
      <td colspan="3  ">
         <h2>פרטי הנוסעים </h2>
         <hr /><br /><br />
      </td>
   </tr>

   @foreach($pack_passenger['adults'] as $adult)
   <tr>
      <td colspan="4">
         <h4>מבוגרים {{++$loop->index}}</h4><br />
      </td>
   </tr>
   <tr>
      <td><strong>שם הנוסע </strong><br />{{ $adult['name'] }}
      </td>
      <td><strong>שם משפחה </strong><br /> {{ $adult['family_name'] }}
      </td>
      <td><strong>מין </strong><br />
         @if($adult['sex'] == 'male')
         זכר
         @else
         נקבה
         @endif
      </td>
      <td><strong>תאריך לידה </strong><br />
         {{$adult['dob_day'].'-'.$adult['dob_month'].'-'.$adult['dob_year']}}
      </td>
   </tr>
   @endforeach
   @foreach($pack_passenger['childs'] as $child)
   <tr>
      <td colspan="4">
         <h4>מילדים {{++$loop->index}}</h4><br />
      </td>
   </tr>
   <tr>
      <td><strong>שם הנוסע </strong><br />{{ $child['name'].' '.$child['family_name'] }}</td>
      <td><strong>שם משפחה </strong><br /> {{ $child['family_name'] }}
      </td>
      <td><strong>מין </strong><br />
         @if($child['sex'] == 'male')
         זכר
         @else
         נקבה
         @endif
      </td>
      <td><strong>תאריך לידה </strong><br />
         {{$child['dob_day'].'-'.$child['dob_month'].'-'.$child['dob_year']}}
      </td>
   </tr>
   @endforeach
</table>
<br></br><br></br>
<table cellpadding="0" cellspacing="0">
   <thead>
      <tr>
         <th width="25%" align="right">
            <strong>שם </strong><br /> <br />
         </th>
         <th width="40%" align="right">
            <strong>פרטים </strong><br /> <br />
         </th>

      </tr>
   </thead>
   <tbody id="order_line_items">
      @foreach($rooms as $room)
      <tr class="item">
         <td class="name" width="25%">{{$room->room_title}} ({{$hotel->hotel_code}})</td>
         <td class="quantity" width="40%">
            <h4>רטי האירוח דירת </h4>
            @if(!empty($hotel->hotel_address))
            <strong>כתובת מקום הלינה :&nbsp;&nbsp;</strong>{{$hotel->hotel_address}}<br />
            @endif
            @if(!empty($hotel->additional_comment))
            <strong>הערות נוספות :&nbsp;&nbsp;</strong>{{$hotel->additional_comment}}<br />
            @endif
            <h4>{{++$loop->index}}פפרטים על החדר </h4>
            @if(!empty($room->room_type_name))
            <strong>סוג החדר :&nbsp;&nbsp;</strong> {{$room->room_type_name->room_type }}<br />
            @endif
            @if(!empty($room->room_area))
            <strong>גודל החדר :&nbsp;&nbsp; </strong> {{ $room->room_area}} ft2<br />
            @endif
         </td>
      </tr>
      @endforeach
      @if(!empty($flight_schedule))
      <tr class="item">
         <td class="name" width="25%">{{$upflight->flight_title}}</td>
         <td class="quantity" width="40%">
            <strong>סוג הטיסה :&nbsp;&nbsp;</strong>
            @if($upflight->flight_type==2){
            טיסת שכר
            }
            @else{
            טיסה סדירה
            }
            @endif
            <br />
            <strong>השדה תעופה :&nbsp;&nbsp;</strong>
            @if(!empty($upflight->airport_name))
            {{$upflight->airport_name}}
            @else
            {{$upflight->location_source->loc_name}}
            @endif
            <br />
            <strong>השדה תעופה :&nbsp;&nbsp;</strong>
            @if(!empty($downflight->airport_name))
            {{$downflight->airport_name}}
            @else
            {{$downflight->location_source->loc_name}}
            @endif
            <br />
            @if(!empty($upflight->airline_name))
            <strong>החברת תעופה :&nbsp;&nbsp;</strong>{{$upflight->airline_name->airl_title}} <br />
            @endif
            @if(!empty($upflight->flight_number))
            <strong>מספר טיסה :&nbsp;&nbsp;</strong>{{$upflight->flight_number}} <br />
            @endif
            @if(!empty($flight_schedule->up_departure_time))
            <strong>מאריך המראה - הלוך
               :&nbsp;&nbsp;</strong>{{rami_get_require_date_time_format($flight_schedule->up_departure_time,'Y-m-d h:i')}}
            <br />
            @endif
            @if(!empty($flight_schedule->up_arrival_time))
            <strong>מתאריך נחיתה - הלוך
               :&nbsp;&nbsp;</strong>{{rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'Y-m-d h:i')}}
            <br />
            @endif
            @if(!empty($downflight->flight_number))
            <strong>מספר טיסה :&nbsp;&nbsp;</strong>{{$downflight->flight_number}} <br />
            @endif
            @if(!empty($flight_schedule->down_departure_time))
            <strong>מאריך המראה - הלוך
               :&nbsp;&nbsp;</strong>{{rami_get_require_date_time_format($flight_schedule->down_departure_time, 'Y-m-d h:i')}}
            <br />
            @endif
            @if(!empty($flight_schedule->down_arrival_time))
            <strong>מתאריך נחיתה - הלוך
               :&nbsp;&nbsp;</strong>{{rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'Y-m-d h:i')}}
            <br />
            @endif
         </td>
      </tr>
      @endif
      @foreach($cars as $car)
      <tr class="item">
         <td class="name" width="25%">{{$car->car_title}}</td>
         <td class="quantity" width="40%">
            <strong>כתעופה :&nbsp;&nbsp;</strong>נמל תעופה יעד <br />
            @if(!empty($car->car_supp_name))
            <strong>הסוכנות רכב :&nbsp;&nbsp;</strong>{{$car->car_supp_name->car_suplier_name}}<br />
            @endif
            <strong>GPS:&nbsp;&nbsp;</strong>נניתן להזמין gps בתוספת <br />
            <strong>מקס. נוסעים :&nbsp;&nbsp;</strong>{{$car->max_people}}<br />
         </td>
      </tr>
      @endforeach
      <br />
      <br />
      <tr class="item">
         <td width="25%">
            <h2>עלות </h2>
         </td>
         <td width="40%">&nbsp;</td>
         <td width="15%">&nbsp;</td>
         <td width="15%">
            € {{$total_price_in_euro }}</td>
      </tr>
      <tr class="item">
         <td width="25%">
            <h2>שולמו באתר באשראי </h2>
         </td>
         <td width="40%">&nbsp;</td>
         <td width="15%">&nbsp;</td>
         <td width="15%">
            ש"ח {{$amount_paid_in_skl}}</td>
      </tr>
      <tr class="item">
         <td width="25%">
            <h2>שהכמות הכוללת </h2>
         </td>
         <td width="40%">&nbsp;</td>
         <td width="15%">&nbsp;</td>
         <td width="15%">
            ש"ח {{$total_price_in_skl}}</td>
      </tr>
      <tr class="item">
         <td width="25%">
            <h2>הסכום שנותר </h2>
         </td>
         <td width="40%">&nbsp;</td>
         <td width="15%">&nbsp;</td>
         <td width="15%">
            ש"ח {{$remaining_amount}}</td>
      </tr>
   </tbody>
</table>
