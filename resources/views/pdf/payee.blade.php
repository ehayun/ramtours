<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <style type="text/css">
      @media print {
         @page {
            margin: 0 !important;
            padding: 0;
            size: 1560px 2040px;
         }
      }

      table {
         margin: 0;
         padding: 0;
         border-spacing: 0;
      }

      table.order_pdf td h2 {
         font-size: 23px !important;
         margin-top: 5px;
      }

      table.order_pdf td p {
         font-size: 17px;
         font-weight: normal;
      }

      table.order_inner td.order_inner_head {
         font-weight: bold;
         border-top: 1px solid #ccc;
         border-bottom: 1px solid #ccc;
      }

      table.order_inner {
         width: 100%;
         padding: 5px;
      }

      table.info_side {
         width: 100%;
      }

      td.order_heading.side h2 {
         padding: 15px;
         font-size: 18px !important;
         font-weight: bold;
      }

      td.order_heading.side p {
         padding: 0 15px;
      }

      table.order_total {
         width: 100%;
         padding-top: 10px;
      }

      table.order_total td {
         font-size: 13px;
         font-weight: 600;
         padding: 5px 0 !important;
      }

      span.rt_tmm {
         font-size: 16px !important;
         color: #000 !important;
         margin-bottom: 0;
         font-weight: 600;
         display: block;
      }

      table.info_side td.order_inner_head {
         font-weight: bold;
         padding: 4px 10px;
         border-top: 1px solid #ccc !important;
         border-bottom: 1px solid #ccc !important;
      }

      table.c_details,
      table.cust_info {
         border-top: 1px solid #ccc;
         border-right: 1px solid #ccc;
         border-bottom: 1px solid #ccc;
      }

      table.c_details td,
      table.cust_info td {
         border-left: 1px solid #ccc;
      }

      span.fltt-info {
         font-weight: bold;
      }
   </style>
</head>

<body>
   <table>
      <tbody>
         <tr>
            <td colspan="4" valign="middle">
               <table style="padding:10px 0 5px 0;">
                  <tr>
                     <td width="40" align="right">
                        <img width="40" height="40" src="{{base_path().'/public/assets/pdf/images/customer.png'}}"
                           class="img-fluid" alt="" style="line-height:0px">
                     </td>
                     <td align="right" height="40">
                        <h2 style="line-height:12px"> פרטי לקוח משלם </h2>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr>
            <td colspan="4">
               <table class="order_inner cust_info">
                  <tbody>
                     <tr>
                        <td width="50%"><strong>שם הלקוח : </strong>{{$client_name}}</td>
                        <td width="50%"><strong>תאריך ההזמנה : </strong>{{$order_date}}</td>
                     </tr>
                     <tr>
                        <td><strong>דואר אלקטרוני : </strong>{{$client_email}}</td>
                        <td><strong>סוג הזמנה : </strong>{{$order_type}} </td>
                     </tr>
                     <tr>
                        <td><strong>כתובת הלקוח : </strong> {{$client_address}}</td>
                        <td></td>
                     </tr>
                     <tr>
                        <td><strong>עיר : </strong>{{$client_city}}</td>
                        <td></td>
                     </tr>
                     <tr>
                        <td><strong>טלפון נייד : </strong> {{$client_mobile}}</td>
                        <td></td>
                     </tr>
                     <tr>
                        <td><strong> טלפון נייח: : </strong> {{$client_phone}}</td>
                        <td></td>
                     </tr>
                     <!--  <tr>
                                    <td><strong> במיקוד  : </strong> {{$client_zipcode}}</td>
                                    <td></td>
                                 </tr> -->
                     <tr>
                        <td><strong>שיטת תשלום : </strong> עסקת אשראי</td>
                        <td></td>
                     </tr>
                     <tr>
                        <td><strong>קוד עסקה : </strong></td>
                        <td></td>
                     </tr>

                  </tbody>
               </table>
            </td>
         </tr>
         <tr>
            <td colspan="4">
               <table class="order_total">
                  <tbody>
                     <tr>
                        <td width="33%">
                           <strong> סך עלות העסקה ביורו: </strong>
                        </td>
                        <td width="67%">{{$total_price_in_euro}} €</td>
                     </tr>
                     <tr>
                        <td width="33%">
                           <strong> סך עלות העסקה בשקלים: </strong>
                        </td>
                        <td width="67%">{{$total_price_in_skl}} ₪ </td>
                     </tr>
                     @if ($card > 0)
                     <tr>
                        <td width="33%">
                           <strong> כרטיס ליער השחור: </strong>
                        </td>
                        <td width="67%">{{$card}} ₪ </td>
                     </tr>
                     @endif



                     <tr>
                        <td width="33%">
                           <strong> הסכום ששולם באתר:</strong>
                        </td>
                        <td width="67%"> {{$amount_paid_in_skl}} ₪ </td>
                     </tr>
                     <tr>
                        <td width="33%">
                           <strong> הסכום שנותר לתשלום:</strong>
                        </td>
                        <td width="67%"> {{$remaining_amount}} ₪ </td>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
      </tbody>
   </table>
</body>

</html>