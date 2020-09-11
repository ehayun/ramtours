@extends('mobile.home_main')
@section('mobile_container')
<section class="rt-info">
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <div class="rt_info_right">
               <h3 class="rtpkghead">פרטי הנוסעים</h3>
            </div>
            <div class="rt_prev_btn"><a href="{{ URL::previous() }}"><img
                     src="{{url('assets/mobile')}}/images/prev-btn-blk.png"></a></div>
         </div>
      </div>
   </div>
</section>
<section class="steps">
   <div class="container">
      <div class="row">
         <div class="col-sm-12 stepwizard">
            <div class="stepwizard-row setup-panel">
               <div class="stepwizard-step">
                  <a href="#step-1" class="btn">1</a>
                  <p>פרטי המוצר </p>
               </div>
               <div class="stepwizard-step active">
                  <a href="#step-2" class="btn active" disabled="disabled">2</a>
                  <p>פרטי הנוסעים </p>
               </div>
               <div class="stepwizard-step">
                  <a href="#step-3" class="btn" disabled="disabled">3</a>
                  <p>תשלום </p>
               </div>
               <div class="stepwizard-step last">
                  <a href="#step-3" class="btn" disabled="disabled"><img
                        src="{{url('assets/mobile')}}/images/step-check.png" alt=""></a>
                  <p>אישור הזמנה </p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section class="orpassdtl">
   <div class="container">
      <div class="row">
         <form action="{{url('/order-passengers')}}" method="POST" accept-charset="utf-8" class="form_image"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="col-sm-12 orpass-sec">
               <ul>
                  <li>אנא מלאו את פרטי הנוסעים באנגלית בלבד כפי שמופיעים בדרכונים. </li>
                  <li>איות השמות באחריות המזמין/הנוסעים.</li>
                  <li>יש לוודא שהדרכונים בתוקף לפחות 6 חודשים ביום הטיסה.</li>
                  <li>לטסים לגרמניה ושוויץ נדרש תוקף דרכון 3 חודשים מיום הטיסה חזרה לארץ.</li>
                  <span><strong>בטיסות ישראייר בלבד</strong></span>
                  <li>מחיר הטיסה כולל כבודת יד בלבד של 8 עד קילו .</li>
                  <li>יש תוספת למזוודה של 23 קילו לאדם בעלות של 70 דולר.</li>
                  <li>הטיסה מותנית בקבלת אישור מנהל התעופה האזרחית</li>
               </ul>
               @for($a=1; $adults >= $a; $a++)
               <div class="order-heading">מבוגר {{$a}}</div>
               <div class="orderinfo_sec">
                  <input name="traveller_adult_{{$a}}_name" type="text" class="contact-input" placeholder="*שם פרטי "
                     value="{{get_edit_input_pvr_old_value('traveller_adult_'.$a.'_name')}}">
                  {!! get_form_error_msg($errors, 'traveller_adult_'.$a.'_name') !!}
                  <input name="traveller_adult_{{$a}}_family_name" type="text" class="contact-input"
                     placeholder=" שם משפחה   "
                     value="{{get_edit_input_pvr_old_value('traveller_adult_'.$a.'_family_name')}}">
                  {!! get_form_error_msg($errors, 'traveller_adult_'.$a.'_family_name') !!}
                  <div class="rt_droparrow"><select name="traveller_adult_{{$a}}_sex">
                        <option value="male"
                           {{get_edit_select_check_pvr_old_value('traveller_adult_'.$a.'_sex', '', 'male', 'select')}}>
                           זכר</option>
                        <option value="female"
                           {{get_edit_select_check_pvr_old_value('traveller_adult_'.$a.'_sex', '', 'female', 'select')}}>
                           נקבה</option>
                     </select>
                     {!! get_form_error_msg($errors, 'traveller_adult_'.$a.'_sex') !!}
                  </div>

                  <div class="order-label">תאריך לידה</div>
                  <div class="rt_droparrow dob_year"><select name="traveller_adult_{{$a}}_dob_year">
                        <option value="">שנת לידה</option>
                        @for($i=0; $i <= $year_slot_adults; $i++) <option value="{{date('Y')-$i}}"
                           {{get_edit_select_check_pvr_old_value('traveller_adult_'.$a.'_dob_year', '', date('Y')-$i, 'select')}}>
                           {{date('Y')-$i}}</option>
                           @endfor
                     </select>
                     {!! get_form_error_msg($errors, 'traveller_adult_'.$a.'_dob_year') !!}
                  </div>

                  <div class="rt_droparrow dob_month"> <select name="traveller_adult_{{$a}}_dob_month">
                        <option value="">חודש </option>
                        @for($i=1; $i <= 12; $i++) <option value="{{$i}}"
                           {{get_edit_select_check_pvr_old_value('traveller_adult_'.$a.'_dob_month', '', $i, 'select')}}>
                           {{$i}}</option>
                           @endfor
                     </select>
                     {!! get_form_error_msg($errors, 'traveller_adult_'.$a.'_dob_month') !!}
                  </div>

                  <div class="rt_droparrow dob_day"><select name="traveller_adult_{{$a}}_dob_day">
                        <option value="">יום </option>
                        @for($i=1; $i <= 31; $i++) <option value="{{$i}}"
                           {{get_edit_select_check_pvr_old_value('traveller_adult_'.$a.'_dob_day', '', $i, 'select')}}>
                           {{$i}}</option>
                           @endfor
                     </select>
                     {!! get_form_error_msg($errors, 'traveller_adult_'.$a.'_dob_day') !!}
                  </div>

                  <div class="clear"></div>
               </div>
               @endfor
               @for($a=1; $childs >= $a; $a++)
               <div class="order-heading">ילדים {{$a}}</div>
               <div class="orderinfo_sec">
                  <input name="traveller_child_{{$a}}_name" type="text" class="contact-input" placeholder="*שם פרטי "
                     value="{{get_edit_input_pvr_old_value('traveller_child_'.$a.'_name')}}">
                  {!! get_form_error_msg($errors, 'traveller_child_'.$a.'_name') !!}
                  <input name="traveller_child_{{$a}}_family_name" type="text" class="contact-input"
                     placeholder=" שם משפחה   "
                     value="{{get_edit_input_pvr_old_value('traveller_child_'.$a.'_family_name')}}">
                  {!! get_form_error_msg($errors, 'traveller_child_'.$a.'_family_name') !!}
                  <select name="traveller_child_{{$a}}_sex">
                     <option value="male"
                        {{get_edit_select_check_pvr_old_value('traveller_child_'.$a.'_sex', '', 'male', 'select')}}>זכר
                     </option>
                     <option value="female"
                        {{get_edit_select_check_pvr_old_value('traveller_child_'.$a.'_sex', '', 'female', 'select')}}>
                        נקבה</option>
                  </select>
                  {!! get_form_error_msg($errors, 'traveller_child_'.$a.'_sex') !!}
                  <div class="order-label">תאריך לידה</div>
                  <div class="rt_droparrow dob_year">
                     <select name="traveller_child_{{$a}}_dob_year">
                        <option value="">שנת לידה</option>
                        @for($i=0; $i <= $year_slot_childs; $i++) <option value="{{date('Y')-$i}}"
                           {{get_edit_select_check_pvr_old_value('traveller_child_'.$a.'_dob_year', '', date('Y')-$i, 'select')}}>
                           {{date('Y')-$i}}</option>
                           @endfor
                     </select>
                     {!! get_form_error_msg($errors, 'traveller_child_'.$a.'_dob_year') !!}
                  </div>
                  <div class="rt_droparrow dob_month">
                     <select name="traveller_child_{{$a}}_dob_month">
                        <option value="">חודש</option>
                        @for($i=1; $i <= 12; $i++) <option value="{{$i}}"
                           {{get_edit_select_check_pvr_old_value('traveller_child_'.$a.'_dob_month', '', $i, 'select')}}>
                           {{$i}}</option>
                           @endfor
                     </select>
                     {!! get_form_error_msg($errors, 'traveller_child_'.$a.'_dob_month') !!}
                  </div>
                  <div class="rt_droparrow dob_day">
                     <select class="dob_day" name="traveller_child_{{$a}}_dob_day">
                        <option value="">יום</option>
                        @for($i=1; $i <= 31; $i++) <option value="{{$i}}"
                           {{get_edit_select_check_pvr_old_value('traveller_child_'.$a.'_dob_day', '', $i, 'select')}}>
                           {{$i}}</option>
                           @endfor
                     </select>
                     {!! get_form_error_msg($errors, 'traveller_child_'.$a.'_dob_day') !!}
                  </div>

                  <div class="clear"></div>
               </div>
               @endfor
               @for($a=1; $infants >= $a; $a++)
               <div class="order-heading">תינוק {{$a}}</div>
               <div class="orderinfo_sec">
                  <input name="traveller_infant_{{$a}}_name" type="text" class="contact-input" placeholder="*שם פרטי "
                     value="{{get_edit_input_pvr_old_value('traveller_infant_'.$a.'_name')}}">
                  {!! get_form_error_msg($errors, 'traveller_infant_'.$a.'_name') !!}
                  <input name="traveller_infant_{{$a}}_family_name" type="text" class="contact-input"
                     placeholder=" שם משפחה   "
                     value="{{get_edit_input_pvr_old_value('traveller_infant_'.$a.'_family_name')}}">
                  {!! get_form_error_msg($errors, 'traveller_infant_'.$a.'_family_name') !!}
                  <select name="traveller_infant_{{$a}}_sex">
                     <option value="male"
                        {{get_edit_select_check_pvr_old_value('traveller_infant_'.$a.'_sex', '', 'male', 'select')}}>זכר
                     </option>
                     <option value="female"
                        {{get_edit_select_check_pvr_old_value('traveller_infant_'.$a.'_sex', '', 'female', 'select')}}>
                        נקבה</option>
                  </select>
                  {!! get_form_error_msg($errors, 'traveller_infant_'.$a.'_sex') !!}
                  <div class="order-label">תאריך לידה</div>
                  <div class="rt_droparrow dob_year">
                     <select name="traveller_infant_{{$a}}_dob_year">
                        <option value="">שנת לידה</option>
                        @for($i=0; $i <= $year_slot_childs; $i++) <option value="{{date('Y')-$i}}"
                           {{get_edit_select_check_pvr_old_value('traveller_infant_'.$a.'_dob_year', '', date('Y')-$i, 'select')}}>
                           {{date('Y')-$i}}</option>
                           @endfor
                     </select>
                     {!! get_form_error_msg($errors, 'traveller_infant_'.$a.'_dob_year') !!}
                  </div>
                  <div class="rt_droparrow dob_month">
                     <select name="traveller_infant_{{$a}}_dob_month">
                        <option value="">חודש</option>
                        @for($i=1; $i <= 12; $i++) <option value="{{$i}}"
                           {{get_edit_select_check_pvr_old_value('traveller_infant_'.$a.'_dob_month', '', $i, 'select')}}>
                           {{$i}}</option>
                           @endfor
                     </select>
                     {!! get_form_error_msg($errors, 'traveller_infant_'.$a.'_dob_month') !!}
                  </div>
                  <div class="rt_droparrow dob_day">
                     <select class="dob_day" name="traveller_infant_{{$a}}_dob_day">
                        <option value="">יום</option>
                        @for($i=1; $i <= 31; $i++) <option value="{{$i}}"
                           {{get_edit_select_check_pvr_old_value('traveller_infant_'.$a.'_dob_day', '', $i, 'select')}}>
                           {{$i}}</option>
                           @endfor
                     </select>
                     {!! get_form_error_msg($errors, 'traveller_infant_'.$a.'_dob_day') !!}
                  </div>

                  <div class="clear"></div>
               </div>
               @endfor
               <h3 class="pkg_head">פרטי מזמין החבילה.</h3>
               <div class="orderinfo_sec">
                  <div class="rt_flds">
                     <input name="payer_firstname" type="text" class="contact-input" placeholder="*שם פרטי"
                        value="{{get_edit_input_pvr_old_value('payer_firstname')}}">
                     {!! get_form_error_msg($errors, 'payer_firstname') !!}
                  </div>
                  <div class="rt_flds">
                     <input name="payer_surname" type="text" class="contact-input" placeholder="*שם משפחה"
                        value="{{get_edit_input_pvr_old_value('payer_surname')}}">
                     {!! get_form_error_msg($errors, 'payer_surname') !!}
                  </div>
                  <div class="rt_flds">
                     <div class="check-b1 rt_mobileno"><input name="payer_home_phone" type="number"
                           class="contact-input" placeholder="טלפון"
                           value="{{get_edit_input_pvr_old_value('payer_home_phone')}}" maxlength="7">
                        {!! get_form_error_msg($errors, 'payer_home_phone') !!}
                     </div>
                     <div class="rt_droparrow rt_stdcode">
                        <select name="home_code">
                           <option value="">בחר</option>
                           <option value="02" {{get_edit_select_check_pvr_old_value('mobile_code', '', 2, 'select')}}>02
                           </option>
                           <option value="03" {{get_edit_select_check_pvr_old_value('mobile_code', '', 3, 'select')}}>03
                           </option>
                           <option value="04" {{get_edit_select_check_pvr_old_value('mobile_code', '', 3, 'select')}}>04
                           </option>
                           <option value="08" {{get_edit_select_check_pvr_old_value('mobile_code', '', 8, 'select')}}>08
                           </option>
                           <option value="09" {{get_edit_select_check_pvr_old_value('mobile_code', '', 9, 'select')}}>09
                           </option>
                           <option value="072" {{get_edit_select_check_pvr_old_value('mobile_code', '', 72, 'select')}}>
                              072</option>
                           <option value="073" {{get_edit_select_check_pvr_old_value('mobile_code', '', 73, 'select')}}>
                              073</option>
                           <option value="074" {{get_edit_select_check_pvr_old_value('mobile_code', '', 74, 'select')}}>
                              074</option>
                           <option value="075" {{get_edit_select_check_pvr_old_value('mobile_code', '', 75, 'select')}}>
                              075</option>
                           <option value="076" {{get_edit_select_check_pvr_old_value('mobile_code', '', 76, 'select')}}>
                              076</option>
                           <option value="077" {{get_edit_select_check_pvr_old_value('mobile_code', '', 77, 'select')}}>
                              077</option>
                        </select>
                        {!! get_form_error_msg($errors, 'home_code') !!}
                     </div>
                  </div>
                  <div class="rt_flds">
                     <div class="check-b1 rt_mobileno">
                        <input name="payer_mobile_phone" type="number" class="contact-input" placeholder="נייד" value=""
                           maxlength="7" value="{{get_edit_input_pvr_old_value('payer_mobile_phone')}}">
                        {!! get_form_error_msg($errors, 'payer_mobile_phone') !!}
                     </div>
                     <div class="rt_droparrow rt_stdcode">
                        <select name="mobile_code">
                           <option value="">בחר</option>
                           <option value="022" {{get_edit_select_check_pvr_old_value('mobile_code', '', 22, 'select')}}>
                              022</option>
                           <option value="050" {{get_edit_select_check_pvr_old_value('mobile_code', '', 50, 'select')}}>
                              050</option>
                           <option value="052" {{get_edit_select_check_pvr_old_value('mobile_code', '', 52, 'select')}}>
                              052</option>
                           <option value="053" {{get_edit_select_check_pvr_old_value('mobile_code', '', 53, 'select')}}>
                              053</option>
                           <option value="054" {{get_edit_select_check_pvr_old_value('mobile_code', '', 54, 'select')}}>
                              054</option>
                           <option value="055" {{get_edit_select_check_pvr_old_value('mobile_code', '', 55, 'select')}}>
                              055</option>
                           <option value="057" {{get_edit_select_check_pvr_old_value('mobile_code', '', 57, 'select')}}>
                              057</option>
                           <option value="058" {{get_edit_select_check_pvr_old_value('mobile_code', '', 58, 'select')}}>
                              058</option>
                           <option value="066" {{get_edit_select_check_pvr_old_value('mobile_code', '', 66, 'select')}}>
                              066</option>
                           <option value="088" {{get_edit_select_check_pvr_old_value('mobile_code', '', 88, 'select')}}>
                              088</option>
                        </select>
                        {!! get_form_error_msg($errors, 'mobile_code') !!}
                     </div>
                  </div>

                  <input name="payer_email" type="email" class="contact-input" placeholder="*דוא״ל"
                     value="{{get_edit_input_pvr_old_value('payer_email')}}">
                  {!! get_form_error_msg($errors, 'payer_email') !!}
                  <input name="payer_address" type="text" class="contact-input" placeholder="*כתובת"
                     value="{{get_edit_input_pvr_old_value('payer_address')}}">
                  {!! get_form_error_msg($errors, 'payer_address') !!}
                  <input name="payer_city" type="text" class="contact-input" placeholder="*עיר / ישוב" value=""
                     value="{{get_edit_input_pvr_old_value('payer_city')}}">
                  {!! get_form_error_msg($errors, 'payer_city') !!}
                  <input name="payer_zipcode" type="number" class="contact-input" placeholder="מיקוד"
                     value="{{get_edit_input_pvr_old_value('payer_zipcode')}}">
                  {!! get_form_error_msg($errors, 'payer_zipcode') !!}
                  <div class="clear"></div>

                  <div class="pay_now_cont" style="margin-top: 20px;">
                     <p class="order-font12">+ באחריותך לקרוא את תנאי השימוש באתר ואת כל התנאים וההגבלות לגבי הזמנתך<br>
                        + מסמכי הנסיעה יתקבלו בדואר אלקטרוני, במקרה הצורך יתואם איסוף המסמכים מבית ״רם נסיעות ותיירות״
                     </p>
                     <input type="radio" name="pay_partical" value="0" checked="checked">אני רוצה לשלם את מלוא הסכום
                     בכרטיס אשראי כעת <br>
                     <input type="radio" name="pay_partical" value="1">אני רוצה לשלם מקדמה של 200 כרגע ולשמור את ההזמנה
                     , ואת יתרת התשלום להשלים מיידית טלפונית עם נציג רם נסיעות.
                     <p>את היתרה אפשר להשלים טלפונית בכרטיס אשראי עד 3 תשלומים ללא ריבית ,או במזומן במשרדנו או בהעברה
                        לחשבון בנק הפועלים סניף 552 חשבון 27040 .</p>
                  </div>






                  <div class="filter_cont custom-control custom-checkbox">
                     <label class="xcustom-control-label" for="chk-b1">מאשר/ת שקראתי ומסכים לכל תנאי העסקה בהזמנה זו.
                        <input type="checkbox" class="xcustom-control-input" id="chk-b1" name="payer_terms"  style="float: right;" value="1"
                           {{get_edit_select_check_pvr_old_value('payer_terms', '', 1, 'check')}}>

                     </label>
                     {!! get_form_error_msg($errors, 'payer_terms') !!}
                  </div>
                  <div class="filter_cont custom-control custom-checkbox">
                     <label class="xcustom-control-label" for="chk-b2"> הוסף אותי למועדון לקוחות לצורך קבלת מבצעים
                        ופרסומות
                        <input type="checkbox" class="xcustom-control-input" id="chk-b2" name="payer_news_letter" style="float: right;">
                     </label>
                  </div>
                  <div class="order-button">
                     <input name="" type="submit" value="המשך" class="checkout-submit order-submit"></div>

               </div>
            </div>
      </div>
      </form>
   </div>
</section>
@endsection