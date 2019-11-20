<!DOCTYPE html>
<html lang="en" dir="rtl">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       <style type="text/css">
            @media  print
            {@page
               {margin:0 !important;padding:0;size:1560px 2040px;}
             }
            table{margin:0;padding:0;border-spacing:0;}
            table.order_pdf td h2{font-size:23px!important;margin-top:5px;}
            table.order_pdf td p{font-size:17px;font-weight:normal;}
            table.order_inner td.order_inner_head{font-weight:bold;border-top:1px solid #ccc;border-bottom:1px solid #ccc;}
            table.order_inner{width:100%;padding:5px;}
            table.info_side{width:100%;}
            td.order_heading.side h2{padding:15px;font-size:18px!important;font-weight:bold;}
            td.order_heading.side p{padding:0 15px;}
            table.order_total{width:100%;padding-top:10px;}
            table.order_total td{font-size:13px;font-weight:600;padding:5px 0!important;}
            span.rt_tmm{font-size: 16px!important;color:#000!important;margin-bottom:0;font-weight:600;display:block;}
            table.info_side td.order_inner_head {font-weight: bold;padding: 4px 10px;border-top: 1px solid #ccc!important;border-bottom: 1px solid #ccc!important;}
            table.c_details,table.cust_info{border-top:1px solid #ccc;border-right: 1px solid #ccc;border-bottom: 1px solid #ccc;}
            table.c_details td,table.cust_info td {border-left: 1px solid #ccc;}
            span.fltt-info {font-weight: bold;}
        </style>
   </head>
   <body>
      <table>
        <tbody>
          <tr>
               <td colspan="2" valign="middle">
                  <table style="padding:10px 0 5px 0;">
                   <tr>
                     <td width="40" height="40"><img width="40" height="40" src="<?php echo e(base_path().'/public/assets/pdf/images/flight.png'); ?>" class="img-fluid" alt="">
                    </td>
                    <td align="right" height="40"><h2 style="line-height:30px"> פרטי טיסה  </h2> </td>
                      </tr>
                  </table>
               </td>
            </tr>
            <tr>                           
                           <td style="border: 1px solid #ccc;" colspan="3">
                              <table class="order_inner flight-sec" border="0">
                                 <tbody>
                                  <tr>
                                    <td class="order_inner_head" width="33%">יציאה : <?php echo e($all_flight['up_depart_full_date']); ?>

                                    </td>
                                    <td align="center" class="order_inner_head" width="40%">יעד : <?php echo e($all_flight['up_desti']); ?></td>
                                    <td align="left" class="order_inner_head" width="27%">משך טיסה כולל  <?php echo e($all_flight['up_time_taken']); ?></td>
                                   </tr>
                                   <?php if(empty($all_flight['up_flights'])): ?>
                                    <tr>
                                    <td> <img width="50" src="<?php echo e(base_path().'\\public\\ramtours\\'.$all_flight['up_airline_logo']); ?>" class="img-fluid" alt="">
                                    <span class="fltt_name" ><?php echo e($all_flight['up_airline_name']); ?> </span>
                                    </td>
                                    <td>

                                    <table>
                                        <tbody><tr>
                                            <td align="center"><?php echo e($all_flight['up_source']); ?><br><span class="rt_tmm"><?php echo e($all_flight['up_departure_time']); ?></span> <br> <?php echo e($all_flight['up_departure_time_in_month_date']); ?>   </td>
                                            <td align="center"><img width="18" src="<?php echo e(base_path().'/public/assets/pdf/images/plane_ico.png'); ?>"></td>
                                            <td align="center"> <?php echo e($all_flight['up_desti']); ?><br><span class="rt_tmm"><?php echo e($all_flight['up_arrival_time']); ?></span><br> <?php echo e($all_flight['up_arrival_time_in_month_date']); ?> </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    </td>
                                    <td align="center">  <span class="fltt-info">פרטי הטיסה </span><br>
                                          <span class="fltt-ttltime"> <?php echo e('טיסת '.$all_flight['up_flight_no']); ?> <?php echo e($all_flight['up_source']); ?> ל<?php echo e($all_flight['up_desti']); ?></span>
                                    
                                    </td>
                                 </tr>
                                 <?php else: ?>
                                 <?php $__currentLoopData = $all_flight['up_flights']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <tr>
                                    <td> <img width="50" src="<?php echo e(base_path().'\\public\\ramtours\\'.$flight['airline_logo']); ?>" class="img-fluid" alt="">
                                    <span class="fltt_name" ><?php echo e($flight['airline_name']); ?> </span>
                                    </td>
                                    <td>

                                    <table>
                                        <tbody><tr>
                                            <td align="center"><?php echo e($flight['source']); ?><br><span class="rt_tmm"><?php echo e($flight['departure_time']); ?></span> <br> <?php echo e($flight['depart_time_in_month_date']); ?>   </td>
                                            <td align="center"><img width="18" src="<?php echo e(base_path().'/public/assets/pdf/images/plane_ico.png'); ?>"></td>
                                            <td align="center"> <?php echo e($flight['desti']); ?><br><span class="rt_tmm"><?php echo e($flight['arrival_time']); ?></span><br> <?php echo e($flight['arrival_time_in_month_date']); ?> </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    </td>
                                    <td align="center">  <span class="fltt-info">פרטי הטיסה </span><br>
                                          <span class="fltt-ttltime"> <?php echo e('טיסת '.$flight['flight_no']); ?> <?php echo e($flight['source']); ?> ל<?php echo e($flight['desti']); ?></span>
                                    
                                    </td>
                                 </tr>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
                                  <tr>
                                    <td class="order_inner_head" width="33%">יציאה : <?php echo e($all_flight['down_depart_full_date']); ?>

                                    </td>
                                    <td align="center" class="order_inner_head" width="40%">יעד : <?php echo e($all_flight['down_desti']); ?></td>
                                    <td align="left" class="order_inner_head" width="27%">משך טיסה כולל  <?php echo e($all_flight['down_time_taken']); ?></td>
                                  </tr>
                                  <?php if(empty($all_flight['down_flights'])): ?>
                                    <tr>
                                    <td> <img width="50" src="<?php echo e(base_path().'\\public\\ramtours\\'.$all_flight['down_airline_logo']); ?>" class="img-fluid" alt="">
                                    <span class="fltt_name" ><?php echo e($all_flight['down_airline_name']); ?> </span>
                                    </td>
                                    <td>

                                    <table>
                                        <tbody><tr>
                                            <td align="center"><?php echo e($all_flight['down_source']); ?><br><span class="rt_tmm"><?php echo e($all_flight['down_departure_time']); ?></span> <br> <?php echo e($all_flight['down_departure_time_in_month_date']); ?>   </td>
                                            <td align="center"><img width="18" src="<?php echo e(base_path().'/public/assets/pdf/images/plane_ico.png'); ?>"></td>
                                            <td align="center"> <?php echo e($all_flight['down_desti']); ?><br><span class="rt_tmm"><?php echo e($all_flight['down_arrival_time']); ?></span><br> <?php echo e($all_flight['down_arrival_time_in_month_date']); ?> </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    </td>
                                    <td align="center">  <span class="fltt-info">פרטי הטיסה </span><br>
                                          <span class="fltt-ttltime"> <?php echo e('טיסת '.$all_flight['down_flight_no']); ?> <?php echo e($all_flight['down_source']); ?> ל<?php echo e($all_flight['down_desti']); ?></span>
                                    
                                    </td>
                                 </tr>
                                 <?php else: ?>
                                 <?php $__currentLoopData = $all_flight['down_flights']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $flight): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   <tr>
                                    <td> <img width="50" src="<?php echo e(base_path().'\\public\\ramtours\\'.$flight['airline_logo']); ?>" class="img-fluid" alt="">
                                    <span class="fltt_name" ><?php echo e($flight['airline_name']); ?> </span>
                                    </td>
                                    <td>

                                    <table>
                                        <tbody><tr>
                                            <td align="center"><?php echo e($flight['source']); ?><br><span class="rt_tmm"><?php echo e($flight['departure_time']); ?></span> <br> <?php echo e($flight['depart_time_in_month_date']); ?>   </td>
                                            <td align="center"><img width="18" src="<?php echo e(base_path().'/public/assets/pdf/images/plane_ico.png'); ?>"></td>
                                            <td align="center"> <?php echo e($flight['desti']); ?><br><span class="rt_tmm"><?php echo e($flight['arrival_time']); ?></span><br> <?php echo e($flight['arrival_time_in_month_date']); ?> </td>
                                        </tr>
                                    </tbody>
                                    </table>
                                    </td>
                                    <td align="center">  <span class="fltt-info">פרטי הטיסה </span><br>
                                          <span class="fltt-ttltime"> <?php echo e('טיסת '.$flight['flight_no']); ?> <?php echo e($flight['source']); ?> ל<?php echo e($flight['desti']); ?></span>
                                    
                                    </td>
                                 </tr>
                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 <?php endif; ?>
                                    
                              </tbody>
                            </table>
                           </td>
                           <!--  <td valign="top" class="order_heading side" colspan="2" cellspacing="0" cellpadding="0" bgcolor="#e8e8ea" style="border-width: 1px 0 1px 1px;border-style: solid;border-color:#ccc;">
                             
                           </td> -->
                        </tr>
                        <?php if((!empty($cars))||(!empty($rooms))): ?>
                        <tr>
                           <td colspan="2" width="100%">
                             <table border="0" class="chead">
                                 <tr>
                                     <td valign="middle">
                                          <table style="padding:10px 0 5px 0;">
                                           <tr>
                                             <td width="40" height="40"><img width="40" height="40" src="<?php echo e(base_path().'/public/assets/pdf/images/car.png'); ?>" class="img-fluid" alt="">
                                            </td>
                                            <td align="right" height="40"><h2 style="line-height:30px">  פרטי רכב </h2> </td>
                                              </tr>
                                          </table>
                                       </td>
                                     <td valign="middle">
                                          <table style="padding:10px 0 5px 0;">
                                           <tr>
                                             <td width="40" height="40"><img width="40" height="40" src="<?php echo e(base_path().'/public/assets/pdf/images/hotel.png'); ?>" class="img-fluid" alt="">
                                            </td>
                                            <td align="right" height="40"><h2 style="line-height:30px"> פרטי האירוח  </h2> </td>
                                              </tr>
                                          </table>
                                       </td>
                                 </tr>
                             </table>
                           </td>
                         </tr>
                         <tr>
                          <td colspan="2"  width="50%">
                            <table width="154%" class="order_inner c_details " border="0" style="margin-right: 0px" >
                                 <tbody>
                                    <?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                         <tr class="item">
                                         <td class="name" width="25%"><?php echo e($car->car_title); ?></td>
                                         <td class="quantity" width="40%">
                                             <!-- <strong>כתעופה  :&nbsp;&nbsp;</strong>נמל תעופה יעד  <br/> -->
                                            <!--  <?php if(!empty($car->car_supp_name)): ?>
                                               <strong>סוכנות רכב : &nbsp;&nbsp;</strong><?php echo e($car->car_supp_name->car_suplier_name); ?><br />
                                             <?php endif; ?> -->
                                             <strong>סוכנות רכב : &nbsp;&nbsp;</strong>חברת השכרת רכב בינלאומית מוכרת<br />

                                             <strong>גגיר : &nbsp;&nbsp;</strong>ידני<br/>
                                             <!-- <strong>GPS:&nbsp;&nbsp;</strong>נניתן להזמין gps בתוספת  <br/> -->
                                             <strong>מקס. נוסעים  :&nbsp;&nbsp;</strong><?php echo e($car->max_people); ?><br/>
                                         </td>
                                         </tr>
                                   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                              </tbody></table>
                          </td>
                          <td colspan="2"  width="50%">
                          <table width="154%" class="order_inner c_details " border="0" style="" >
                                 <tbody>
                                       <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <tr class="item">
                                      <td class="name" width="25%"><?php echo e($room->room_title); ?> (<?php echo e($hotel->hotel_code); ?>)</td>
                                      <td class="quantity" width="40%">
                                          <?php if(!empty($hotel->hotel_address)): ?>
                                            <strong>כתובת :&nbsp;&nbsp;</strong><?php echo e($hotel->hotel_address); ?><br/>
                                          <?php endif; ?>
                                          <?php if(!empty($hotel->additional_comment)): ?>
                                            <strong>הערות נוספות  :&nbsp;&nbsp;</strong><?php echo $hotel->additional_comment; ?><br />
                                          <?php endif; ?>
                                          <h4>פרטים על החדר  </h4>
                                          <?php if(!empty($room->room_type_name)): ?>
                                            <strong>סוג החדר  :&nbsp;&nbsp;</strong> <?php echo e($room->room_type_name->room_type); ?><br/>
                                          <?php endif; ?>
                                          <?php if(!empty($room->room_area)): ?>
                                            <strong>גודל החדר  :&nbsp;&nbsp; </strong> <?php echo e($room->room_area); ?> מ"ר <br/>
                                          <?php endif; ?>
                                      </td>
                                      </tr>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </tbody>
                            </table>
                        </td>
                        </tr>  
                        <?php endif; ?>   
     
     
     </tbody>
      </table>
    </body>
  </html>
    
     
     
            <?php /**PATH /home/newssurl/domains/new.s248.upress.link/public_html/resources/views/pdf/flight_car_room.blade.php ENDPATH**/ ?>