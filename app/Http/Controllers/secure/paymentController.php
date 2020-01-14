<?php

namespace App\Http\Controllers\secure;

use App;
use App\Http\Controllers\Controller;
use App\Mail\OrderCompleted;
use App\model\car;
use App\model\flight;
use App\model\flight_schedule;
use App\model\flight_schedule_connection;
use App\model\hotel;
use App\model\Location;
use App\model\order;
use App\model\package;
use App\model\package_room_stock;
use App\model\room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;

/*
Details israeli:
--------------------

API
------------
Gateway :
•    https post :   https://cguat2.creditguard.co.il/xpo/Relay
•    webservice :  https://cguat2.creditguard.co.il/xpo/services/Relay

username : israeli
password : I!fr43s!34
mid: 938

XMC
-----------------
url : https://cguat2.creditguard.co.il:8016/html/login.html

username: israeli
password: B#cde1234
id code: 111111

terminal number:
0962831 cvv=yes / id=no  (Authorization setting from CGGW)
0962832 cvv=no / id=no   (Authorization setting from CGGW)
0962833 cvv=yes / id=yes (Authorization setting from CGGW)
0962835 cvv=no / id=yes  (Authorization setting from CGGW)
0963792 cvv=yes / id=yes (Authorization setting from SHVA)
0963793 cvv=no / id=no   (Authorization setting from SHVA)
 */

class paymentController extends Controller
{
    public function notAllow()
    {
        return "404: Not allow";
    }

    public function payment()
    {
        if (rami_checking_is_mobile()) {
            // return view('mobile.pages.temp_order');
        } else {
            // return view('frontend.pages.temp_order');
        }
        $cart = session()->get('rami_pack_cart');
        $passengers = session()->get('rami_pack_passengers');
        $payee = session()->get('rami_pack_payee');
        if ((empty($cart)) || (empty($passengers)) || (empty($payee))) {
            return redirect('/');
        }
        if (empty($cart['package_id'])) {
            $cart['package_id'] = $cart['flight_sch'];
        }
        $item_name = $cart['package_id'] . '_' . $cart['pakage_components'];
        $billing_amount = get_rami_round_num($cart['total_price_in_skl']);
        $order = new order();
        $order->order_cart = serialize($cart);
        $order->pack_passenger = serialize($passengers);
        $order->payee_details = serialize($payee);
        $order->total_amount_skl = $cart['total_price_in_skl'];
        if ($payee['pay_partical'] == 1) {
            $order->amount_paid_in_skl = 200;
        } else {
            $order->amount_paid_in_skl = $cart['total_price_in_skl'];
        }
        $order->package_components = $cart['pakage_components'];
        $order->package_type = $cart['package_type'];
        $order->package_id = $cart['package_id'];
        $order->payee_name = $payee['name'] . ' ' . $payee['surname'];
        $order->payee_email_id = $payee['payer_email'];
        $order->payment_status = 2;
        $order->item_name = $item_name;
        $order->is_stock_deducted = 0;
        $order->save();
        $tran_id = 'rm-' . $cart['package_id'] . strtotime(date('Y-m-d h:i:s')) . $cart['package_type'] . rand(0, 99) . $order->id;
        $order->tran_id = $tran_id;
        $order->save();
        session()->put('last_order_id', $order->id);
        $url = $this->connect_to_payguard($item_name, $tran_id, $payee['payer_email'], $order->amount_paid_in_skl * 100);

        // return;
        if (empty($url)) {
            $order->payment_status = 3;
            $order->save();
            session()->forget('last_order_id');
            return redirect('payment-fail');
        }
        // dd($url);
        if (rami_checking_is_mobile()) {
            return view('mobile.pages.credit_pay', compact('url'));
        } else {
            return view('frontend.pages.credit_pay', compact('url'));
        }
        // return redirect($url);
    }

    private function connect_to_payguard($item_name, $tran_id, $u_email, $amount)
    {
        $cart = session()->get('rami_pack_cart');
        $passengers = session()->get('rami_pack_passengers');
        $payee = session()->get('rami_pack_payee');
        if ((empty($cart)) || (empty($passengers)) || (empty($payee))) {
            return false;
        }

        $cgConf['cg_gateway_url'] = env("CG_URL", "https://cguat2.creditguard.co.il/xpo/Relay");
        $cgConf['tid'] = env('CG_TERMINAL_ID', '');
        $cgConf['mid'] = env('CG_MID'); // 938;
        $cgConf['amount'] = $amount;
        $cgConf['pay_email'] = $u_email;
        $cgConf['user'] = env('CG_USER'); //'israeli';
        $cgConf['password'] = env('CG_PASSWORD'); // 'I!fr43s!34';

        $cgConf['success_url'] = route('payment_verify');
        $cgConf['fail_url'] = route('payment_notok');
        $cgConf['cancel_url'] = route('payment_cancel');

        // dd($cgConf);

        $poststring = 'user=' . $cgConf['user'];
        $poststring .= '&password=' . $cgConf['password'];

        /*Build Ashrait XML to post*/
        $poststring .= '&int_in=<ashrait>
						   <request>
							<version>1000</version>
							<language>HEB</language>
							<dateTime></dateTime>
							<command>doDeal</command>
							<doDeal>
								 <terminalNumber>' . $cgConf['tid'] . '</terminalNumber>
								 <mainTerminalNumber/>
								 <cardNo>CGMPI</cardNo>
								 <total>' . $cgConf['amount'] . '</total>
								 <transactionType>Debit</transactionType>
								 <creditType>Payments</creditType>
								 <currency>ILS</currency>
								 <transactionCode>Phone</transactionCode>
								 <authNumber/>
								 <numberOfPayments>10</numberOfPayments>
								 <firstPayment/>
								 <periodicalPayment/>
								 <validation>TxnSetup</validation>
								 <dealerNumber/>
								 <user>something</user>
								 <mid>' . $cgConf['mid'] . '</mid>
								 <uniqueid>' . time() . rand(100, 1000) . '</uniqueid>
								 <mpiValidation>autoComm</mpiValidation>
                                 <email>' . $cgConf['pay_email'] . '</email>
                                 <successUrl >' . $cgConf['success_url'] . '</successUrl >
                                 <errorUrl >' . $cgConf['fail_url'] . '</errorUrl >
                                 <cancelUrl >' . $cgConf['cancel_url'] . '</cancelUrl>
								 <clientIP/>
								 <customerData>
								  <userData1>' . $tran_id . '</userData1>
								  <userData2/>
								  <userData3/>
								  <userData4/>
								  <userData5/>
								  <userData6/>
								  <userData7/>
								  <userData8/>
								  <userData9/>
								  <userData10/>
								 </customerData>
							</doDeal>
						   </request>
						  </ashrait>';

        //init curl connection
        if (function_exists("curl_init")) {
            $CR = curl_init();
            curl_setopt($CR, CURLOPT_URL, $cgConf['cg_gateway_url']);
            curl_setopt($CR, CURLOPT_POST, 1);
            curl_setopt($CR, CURLOPT_FAILONERROR, true);
            curl_setopt($CR, CURLOPT_POSTFIELDS, $poststring);
            curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($CR, CURLOPT_FAILONERROR, true);

            //actual curl execution perfom
            $result = curl_exec($CR);
            $error = curl_error($CR);

            // on error - die with error message
            if (!empty($error)) {
                die($error);
            }

            curl_close($CR);
        }


        if (function_exists("simplexml_load_string")) {
            if (strpos(strtoupper($result), 'HEB')) {
                $result = iconv("utf-8", "iso-8859-8", $result);
            }
            $xmlObj = simplexml_load_string($result);
            if (isset($xmlObj->response->doDeal->mpiHostedPageUrl)) {
                // print out the url which we should redirect our customers to
                return $xmlObj->response->doDeal->mpiHostedPageUrl;
                echo '<script>window.location=\'' . $xmlObj->response->doDeal->mpiHostedPageUrl . '\';</script>';
            }
        }
        return "";
    }

    public function connect_to_cardcom($item_name, $tran_id, $amount)
    {
        $cart = session()->get('rami_pack_cart');
        $passengers = session()->get('rami_pack_passengers');
        $payee = session()->get('rami_pack_payee');
        if ((empty($cart)) || (empty($passengers)) || (empty($payee))) {
            return false;
        }
        $email = "eli@eli.com";
        return $this->connect_to_payguard($item_name, $tran_id, $email, $amount * 100);
        // Account vars
        $vars = array();
        $vars['TerminalNumber'] = config('constant.TERMINAL_NUBMER');
        $vars['UserName'] = config('constant.TERMINAL_USERNAME');
        $vars["APILevel"] = "10"; // req
        $vars['codepage'] = '65001'; // unicode
        $vars["Operation"] = 1; # = 1 - Bill Only , 2- Bill And Create Token , 3 - Token Only , 4 - Suspended Deal ( Order).
        $vars["Language"] = 'he'; // page languge he- hebrew , en - english , ru , ar
        $vars["CoinID"] = '1'; // billing coin , 1- NIS , 2- USD other , article :  http://kb.cardcom.co.il/article/AA-00247/0
        $vars["SumToBill"] = $amount; // Sum To Bill
        $vars['ProductName'] = $tran_id; // Product Name , will how if no invoice will be created.
        //$vars['SuccessRedirectUrl'] = "https://secure.cardcom.co.il/DealWasSuccessful.aspx"; // Success Page
        $vars['SuccessRedirectUrl'] = url('payment/verify'); // Success Page
        //$vars['ErrorRedirectUrl'] = "https://secure.cardcom.co.il/DealWasUnSuccessful.aspx?customVar=1234"; // Error Page
        $vars['ErrorRedirectUrl'] = url('payment/verify'); // Success Page"; // Error Page
        $vars['IndicatorUrl'] = url('payment/verify'); // Success Page"; // Error Page
        // Other optinal vars :
        $vars["CancelType"] = "1"; # show Cancel button on start ,
        $vars["CancelUrl"] = url('payment/verify');
        // $vars['IndicatorUrl']  = "http://www.yoursite.com/NotifyURL"; // Indicator Url \ Notify URL
        $vars["ReturnValue"] = $tran_id; // value that will be return and save in CardCom system
        $vars["MaxNumOfPayments"] = "3"; // max num of payments to show  to the user
        //$payee = unserialize( $_SESSION['checkout_data'] );
        // Invoice
        $vars["ShowInvoiceHead"] = "false";
        $vars["InvoiceHeadOperation"] = "1";
        $vars["DocTypeToCreate"] = "101";
        $vars["InvoiceHead.CustName"] = $payee['name'] . ' ' . $payee['surname'];
        $vars["InvoiceHead.SendByEmail"] = "true";
        $vars["InvoiceHead.Language"] = "he";
        $vars["InvoiceHead.Email"] = "contact@ramtours.co.il";
        $vars["InvoiceHead.CustAddresLine1"] = $payee['address'];
        $vars["InvoiceHead.CustCity"] = $payee['city'];
        $vars["InvoiceHead.CustMobilePH"] = $payee['mobile_code'] . ' ' . $payee['mobile_phone'];
        $vars["InvoiceHead.CoinID"] = "1";
        $vars["InvoiceHead.IsAutoCreateUpdateAccount"] = "false";
        $vars["InvoiceHead.SiteUniqueId"] = "RamTours.com";
        $vars["InvoiceLines.Description"] = $item_name;
        $vars["InvoiceLines.Price"] = $amount;
        $vars["InvoiceLines.Quantity"] = "1";
        $vars["InvoiceLines.IsPriceIncludeVAT"] = "true";
        // Send Data To Bill Gold Server
        $r = $this->PostVars($vars, 'https://secure.cardcom.co.il/Interface/LowProfile.aspx');
        parse_str($r, $responseArray);
        if (empty($responseArray['url'])) {
            return false;
        }
        return $responseArray['url'];
    }

    public function PostVars($vars, $PostVarsURL)
    {
        $urlencoded = http_build_query($vars);
        #init curl connection
        if (function_exists("curl_init")) {
            $CR = curl_init();
            curl_setopt($CR, CURLOPT_URL, $PostVarsURL);
            curl_setopt($CR, CURLOPT_POST, 1);
            curl_setopt($CR, CURLOPT_FAILONERROR, true);
            curl_setopt($CR, CURLOPT_POSTFIELDS, $urlencoded);
            curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($CR, CURLOPT_FAILONERROR, true);
            #actual curl execution perfom
            $r = curl_exec($CR);
            $error = curl_error($CR);
            # some error , send email to developer
            if (!empty($error)) {

                echo $error;
                return false;
                //die();
            }
            curl_close($CR);
            return $r;
        } else {
            echo "No curl_init";
            return false;
            //die();
        }
    }

    public function verify_deal($LowProfileCode)
    {
        //this is the token from cardcom, saved earlier when user submitted c card
        $vars = array(
            'TerminalNumber' => config('constant.TERMINAL_NUBMER'), //'30413',//1000
            'LowProfileCode' => $LowProfileCode,
            'UserName' => config('constant.TERMINAL_USERNAME'), //'barak9611' '6JTnl3cdHdfPUe7E8R6T'  //6JTnl3cdHdfPUe7E8R6T
        );

        # encode information
        $urlencoded = http_build_query($vars);

        #init curl connection
        if (function_exists("curl_init")) {
            $CR = curl_init();
            curl_setopt($CR, CURLOPT_URL, 'https://secure.cardcom.co.il/Interface/BillGoldGetLowProfileIndicator.aspx');

            curl_setopt($CR, CURLOPT_POST, 1);
            curl_setopt($CR, CURLOPT_FAILONERROR, true);
            curl_setopt($CR, CURLOPT_POSTFIELDS, $urlencoded);
            curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($CR, CURLOPT_FAILONERROR, true);

            #actual curl execution perfom
            $result = curl_exec($CR);
            $error = curl_error($CR);
            # some error , send email to developer
            if (!empty($error)) {
                //echo 'Error: '. $error ;
                $deal_ok = false;
            }

            curl_close($CR);
        }
        $output = array();
        parse_str($result, $output); # ResponseCode={0}&Description={1}......
        //dd($output);
        if ($output['ResponseCode'] == '0') #  Found the  LowProfile , validate is deal was OK!
        {

            return $output;
        }
        return false;
    }

    public function payment_notOk(Request $request)
    {
        // var_dump("Not ok");
        // dd($request);
        $order = order::find(session()->get('last_order_id'));
        if (!empty($order)) {
            $order->payment_status = 3;
            $order->low_profile_code = $request->get('authNumber');
            $order->save();
            session()->forget('last_order_id');
            return redirect('payment-fail');
        } else {
            return redirect('payment-fail');
        }
    }

    public function payment_verify(Request $request)
    {
        // var_dump("verify");
        // dd($request);
        // $response = $this->verify_deal($request->lowprofilecode);
        session()->forget('rami_pack_cart');
        session()->forget('rami_pack_passengers');
        session()->forget('rami_pack_payee');
        $order = order::where('tran_id', $request->get('userData1'))->get()->first();
        if ($order->total_amount_skl > $order->amout_paid_in_skl) {
            $order->payment_status = 4;
        } else {
            $order->payment_status = 1;
        }
        $order->low_profile_code = $request->get('authNumber');
        $order->internal_deal_number = $request->get('uniqueID');
        if ($order->is_stock_deducted == 0) {
            $this->stock_update($order->id);
            $this->order_pdf_generate($order->id);
            $this->order_mail($order->id);
            $order->is_stock_deducted = 1;
        }
        $order->save();
        //session()->put('mail_order_id', $order->id);

        return redirect('payment-success');
    }
    public function order_pdf_generate($order_id)
    {
        $order = order::find($order_id);
        if (empty($order)) {
            return '';
        }
        $cart = unserialize($order['order_cart']);
        if ($cart['package_type'] == 1) {
            $passengers = $this->gererater_pdf_html_fhc_pack($cart, $order, 1);
            $car_hotel_filigts = $this->gererater_pdf_html_fhc_pack($cart, $order, 2);
            $payee = $this->gererater_pdf_html_fhc_pack($cart, $order, 3);
        } elseif ($cart['package_type'] == 3) {
            $html = '';
        } elseif ($cart['package_type'] == 5) {
            $passengers = $this->gererater_pdf_html_flight_schedule($cart, $order, 1);
            $car_hotel_filigts = $this->gererater_pdf_html_flight_schedule($cart, $order, 2);
            $payee = $this->gererater_pdf_html_flight_schedule($cart, $order, 3);
        } else {
            $html = '';
        }
        $lg = array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'he';
        $l['w_page'] = 'מקור:';
        PDF::SetFont('dejavusans', '', 8);
        PDF::SetCreator(PDF_CREATOR);
        PDF::SetAuthor('Ramtours');
        PDF::SetSubject('Order');
        //PDF::SetKeywords('Ramtours, Package, order,'.$order->package_components);
        PDF::SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
        PDF::setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        PDF::setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        PDF::SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        PDF::SetHeaderMargin(PDF_MARGIN_HEADER);
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);
        // set auto page breaks
        PDF::SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

        // set image scale factor
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);
        PDF::setLanguageArray($lg);
        PDF::SetTitle('Ramtours-orders');
        PDF::AddPage();
        PDF::WriteHTML($passengers, true, 0, true, 0);
        PDF::AddPage();
        PDF::WriteHTML($car_hotel_filigts, true, 0, true, 0);
        PDF::AddPage();
        PDF::WriteHTML($payee, true, 0, true, 0);
        $flile_loction = base_path() . '/storage/app/ramtours_assets/orders/' . $order->tran_id . '.pdf';
        PDF::Output($flile_loction, 'F');
    }

    public function gererater_pdf_html_fhc_pack($cart, $order, $type)
    {
        $pkgs_fhc = package::find($cart['package_id']);
        if (empty($pkgs_fhc)) {
            return '';
        }
        $data['title'] = 'חבילת נופש   ';
        $pack_loction_name = '';
        $no_of_days = rami_get_no_of_days_diff($pkgs_fhc->package_start_date, $pkgs_fhc->package_end_date);
        $start_date = rami_get_require_date_format($pkgs_fhc->package_start_date, 'd/m');
        $end_date = rami_get_require_date_format($pkgs_fhc->package_end_date, 'd/m');
        $pack_loction = Location::find($pkgs_fhc->package_flight_location);
        if (!empty($pack_loction->loc_name)) {
            $pack_loction_name = $pack_loction->loc_name;
        }
        $data['title'] = $pkgs_fhc->id . '-' . $pack_loction_name . ' ' . $data['title'] . $end_date . '-' . $start_date;
        $data['order_date'] = rami_get_require_date_time_format($order->created_at, 'd-m-y h:i');
        $data['order_type'] = '';
        if ($cart['package_type'] == 1) {
            $data['order_type'] = 'חבילה  ';
        } elseif ($cart['package_type'] == 3) {
            $data['order_type'] = 'לטוס  & כונן ';
        }
        $payee = unserialize($order['payee_details']);
        $data['client_name'] = $order['payee_name'];
        $data['client_email'] = $payee['payer_email'];
        $data['client_address'] = $payee['address'];
        $data['client_city'] = $payee['city'];
        $data['client_mobile'] = $payee['mobile_code'] . '-' . $payee['mobile_phone'];
        $data['client_phone'] = $payee['home_code'] . '-' . $payee['home_phone'];
        $data['client_zipcode'] = $payee['payer_zipcode'];
        $data['trxn1'] = $order['tran_id'];
        $data['trxn2'] = $order['internal_deal_number'];
        $data['to_date'] = rami_get_require_date_format($pkgs_fhc->package_start_date, 'd-m-Y');
        $data['from_date'] = rami_get_require_date_format($pkgs_fhc->package_end_date, 'd-m-Y');
        $data['no_of_days'] = $no_of_days;
        $data['adults'] = $cart['adults'];
        $data['kids'] = $cart['childs'];
        if (!empty($cart['infants'])) {
            $data['infants'] = $cart['infants'];
        } else {
            $data['infants'] = 0;
        }
        $data['total_person'] = $cart['total_peoples'];
        $data['pack_passenger'] = unserialize($order['pack_passenger']);
        $data['hotel'] = hotel::find($pkgs_fhc->package_hotel);
        $count = 0;
        foreach ($cart['rooms'] as $room) {
            $data['rooms'][$count] = room::find($room['room_id']);
            $count++;
        }
        $flight_schedule = flight_schedule::find($cart['flight_sch']);
        $up_flights = array();
        $down_flights = array();
        if ($flight_schedule->flight_type_up == 2) {
            $flight_conn_up = flight_schedule_connection::where([['type', 1], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get();
            $total_count = $flight_conn_up->count();
            $int = 1;
            foreach ($flight_conn_up as $flight) {
                if ($int == 1) {
                    $fligts_data['up_source'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['up_depart_full_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                    $fligts_data['up_departure_time'] = $flight->departure_time;
                    $fligts_data['up_flight_no'] = $flight->flight->flight_number;
                }
                $up_flights[$int]['airline_name'] = $flight->flight->airline_name->airl_name_eng;
                $up_flights[$int]['airline_logo'] = $flight->flight->airline_name->airl_logo_img;
                $up_flights[$int]['depart_full_date'] = get_week_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'w')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                $up_flights[$int]['departure_time'] = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                $up_flights[$int]['depart_time_in_month_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                $up_flights[$int]['arrival_time'] = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                $up_flights[$int]['arrival_time_in_month_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                $up_flights[$int]['desti'] = $flight->flight->location_desti->loc_name;
                $up_flights[$int]['source'] = $flight->flight->location_source->loc_name;
                $up_flights[$int]['flight_no'] = $flight->flight->flight_number;
                //$up_flights[$int]['time_taken']=rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                if ($int == $total_count) {
                    $fligts_data['up_desti'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['up_arrival_time'] = $flight->arrival_time;
                    $fligts_data['up_time_taken'] = rami_get_no_of_hours_min_diff($fligts_data['up_departure_time'], $fligts_data['up_arrival_time']);
                }
                $int++;
            }
        } else {
            $fligts_data['up_airline_name'] = $flight_schedule->airline_name->airl_name_eng;
            $fligts_data['up_airline_logo'] = $flight_schedule->airline_name->airl_logo_img;
            $fligts_data['up_depart_full_date'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->up_departure_time, 'Y');
            $fligts_data['up_departure_time'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'H:i');
            $fligts_data['up_arrival_time'] = rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'H:i');
            $fligts_data['up_departure_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_departure_time, 'm'));
            $fligts_data['up_arrival_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'm'));
            $fligts_data['up_desti'] = get_location_name($flight_schedule->flight_name->flight_desti);
            $fligts_data['up_source'] = get_location_name($flight_schedule->flight_name->flight_source);
            $fligts_data['up_flight_no'] = $flight_schedule->flight_name->flight_number;
            $fligts_data['up_time_taken'] = rami_get_no_of_hours_min_diff($flight_schedule->up_departure_time, $flight_schedule->up_arrival_time);
        }
        if ($flight_schedule->flight_type_down == 2) {
            $flight_conn_down = flight_schedule_connection::where([['type', 2], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get();
            $total_count = $flight_conn_down->count();
            $int = 1;
            foreach ($flight_conn_down as $flight) {
                if ($int == 1) {
                    $fligts_data['down_source'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['down_depart_full_date'] = get_week_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'w')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                    $fligts_data['down_departure_time'] = $flight->departure_time;
                    $fligts_data['down_flight_no'] = $flight->flight->flight_number;
                }
                $down_flights[$int]['airline_name'] = $flight->flight->airline_name->airl_name_eng;
                $down_flights[$int]['airline_logo'] = $flight->flight->airline_name->airl_logo_img;
                $down_flights[$int]['depart_full_date'] = get_week_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'w')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                $down_flights[$int]['departure_time'] = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                $down_flights[$int]['depart_time_in_month_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                $down_flights[$int]['arrival_time'] = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                $down_flights[$int]['arrival_time_in_month_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                $down_flights[$int]['desti'] = $flight->flight->location_desti->loc_name;
                $down_flights[$int]['source'] = $flight->flight->location_source->loc_name;
                $down_flights[$int]['flight_no'] = $flight->flight->flight_number;
                //$down_flights[$int]['time_taken']=rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                if ($int == $total_count) {
                    $fligts_data['down_desti'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['down_arrival_time'] = $flight->arrival_time;
                    $fligts_data['down_time_taken'] = rami_get_no_of_hours_min_diff($fligts_data['down_departure_time'], $fligts_data['down_arrival_time']);
                }
                $int++;
            }
        } else {
            $fligts_data['down_airline_name'] = $flight_schedule->airline_name_down->airl_name_eng;
            $fligts_data['down_airline_logo'] = $flight_schedule->airline_name_down->airl_logo_img;
            $fligts_data['down_depart_full_date'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->down_departure_time, 'Y');
            $fligts_data['down_departure_time'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'H:i');
            $fligts_data['down_departure_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_departure_time, 'm'));
            $fligts_data['down_arrival_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'm'));
            $fligts_data['down_arrival_time'] = rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'H:i');
            $fligts_data['down_time_taken'] = rami_get_no_of_hours_min_diff($flight_schedule->down_departure_time, $flight_schedule->down_arrival_time);
            $fligts_data['down_desti'] = get_location_name($flight_schedule->flight_name_down->flight_desti);
            $fligts_data['down_source'] = get_location_name($flight_schedule->flight_name_down->flight_source);
            $fligts_data['down_flight_no'] = $flight_schedule->flight_name_down->flight_number;
        }
        $fligts_data['up_flights'] = $up_flights;
        $fligts_data['down_flights'] = $down_flights;
        $fligts_data['id'] = $flight_schedule->id;
        $fligts_data['title'] = $flight_schedule->flight_sche_title;
        $fligts_data['num_available_seat'] = $flight_schedule->num_available_seat;
        $data['all_flight'] = $fligts_data;
        $count = 0;
        foreach ($cart['cars'] as $car) {
            $data['cars'][$count] = car::find($car['car_id']);
            $count++;
        }
        $data['total_price_in_euro'] = $cart['total_price_in_euro'];
        $data['card'] = $cart['pack_card_total_price'];
        $data['total_price_in_skl'] = $cart['total_price_in_skl'];
        $data['amount_paid_in_skl'] = $order['amount_paid_in_skl'];
        $data['remaining_amount'] = $order['total_amount_skl'] - $order['amount_paid_in_skl'];
        if ($type == 1) {
            return $html = view('pdf.passenger', $data);
        }
        if ($type == 2) {
            return $html = view('pdf.flight_car_room', $data);
        }
        if ($type == 3) {
            return $html = view('pdf.payee', $data);
        }
    }
    public function gererater_pdf_html_flight_schedule($cart, $order, $type)
    {
        $flight = flight_schedule::find($cart['package_id']);
        if (empty($flight)) {
            return '';
        }
        $data['title'] = 'טיסה';
        $pack_loction_name = '';
        $no_of_days = rami_get_no_of_days_diff($flight->up_departure_time, $flight->down_departure_time);
        $start_date = rami_get_require_date_time_format($flight->up_departure_time, 'd/m');
        $end_date = rami_get_require_date_time_format($flight->down_departure_time, 'd/m');
        if (!empty($flight->flight_sche_name)) {
            $pack_loction = Location::find($flight->flight_sche_name->flight_desti);
            if (!empty($pack_loction->loc_name)) {
                $pack_loction_name = $pack_loction->loc_name;
            }
        } else {
            $pack_loction_name = ' ';
        }
        $data['title'] = $flight->id . '-' . $pack_loction_name . $data['title'] . $end_date . '-' . $start_date;
        $data['order_date'] = rami_get_require_date_time_format($order->created_at, 'd-m-y h:i');
        $data['order_type'] = '';
        if ($cart['package_type'] == 1) {
            $data['order_type'] = 'חבילה  ';
        } elseif ($cart['package_type'] == 3) {
            $data['order_type'] = 'לטוס  & כונן ';
        } elseif ($cart['package_type'] == 5) {
            $data['order_type'] = 'טיסה  ';
        }
        $payee = unserialize($order['payee_details']);
        $data['client_name'] = $order['payee_name'];
        $data['client_email'] = $order['payee_name'];
        $data['client_address'] = $payee['address'];
        $data['client_city'] = $payee['city'];
        $data['client_mobile'] = $payee['mobile_code'] . '-' . $payee['mobile_phone'];
        $data['client_phone'] = $payee['home_code'] . '-' . $order['home_phone'];
        $data['client_zipcode'] = $order['payer_zipcode'];
        $data['trxn1'] = $order['tran_id'];
        $data['trxn2'] = $order['internal_deal_number'];
        $data['to_date'] = rami_get_require_date_time_format($flight->up_departure_time, 'd-m-Y');
        $data['from_date'] = rami_get_require_date_time_format($flight->down_departure_time, 'd-m-Y');
        $data['no_of_days'] = $no_of_days;
        $data['adults'] = $cart['adults'];
        $data['kids'] = $cart['childs'];
        if (!empty($cart['infants'])) {
            $data['infants'] = $cart['infants'];
        } else {
            $data['infants'] = 0;
        }
        $data['total_person'] = $cart['total_peoples'];
        $data['pack_passenger'] = unserialize($order['pack_passenger']);
        $data['card']=$cart['pack_card_total_price'];
        $data['hotel'] = array();
        $data['rooms'] = array();
        $flight_schedule = flight_schedule::find($cart['flight_sch']);
        $up_flights = array();
        $down_flights = array();
        if ($flight_schedule->flight_type_up == 2) {
            $flight_conn_up = flight_schedule_connection::where([['type', 1], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get();
            $total_count = $flight_conn_up->count();
            $int = 1;
            foreach ($flight_conn_up as $flight) {
                if ($int == 1) {
                    $fligts_data['up_source'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['up_depart_full_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                    $fligts_data['up_departure_time'] = $flight->departure_time;
                    $fligts_data['up_flight_no'] = $flight->flight->flight_number;
                }
                $up_flights[$int]['airline_name'] = $flight->flight->airline_name->airl_name_eng;
                $up_flights[$int]['airline_logo'] = $flight->flight->airline_name->airl_logo_img;
                $up_flights[$int]['depart_full_date'] = get_week_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'w')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                $up_flights[$int]['departure_time'] = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                $up_flights[$int]['depart_time_in_month_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                $up_flights[$int]['arrival_time'] = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                $up_flights[$int]['arrival_time_in_month_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                $up_flights[$int]['desti'] = $flight->flight->location_desti->loc_name;
                $up_flights[$int]['source'] = $flight->flight->location_source->loc_name;
                $up_flights[$int]['flight_no'] = $flight->flight->flight_number;
                //$up_flights[$int]['time_taken']=rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                if ($int == $total_count) {
                    $fligts_data['up_desti'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['up_arrival_time'] = $flight->arrival_time;
                    $fligts_data['up_time_taken'] = rami_get_no_of_hours_min_diff($fligts_data['up_departure_time'], $fligts_data['up_arrival_time']);
                }
                $int++;
            }
        } else {
            $fligts_data['up_airline_name'] = $flight_schedule->airline_name->airl_name_eng;
            $fligts_data['up_airline_logo'] = $flight_schedule->airline_name->airl_logo_img;
            $fligts_data['up_depart_full_date'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->up_departure_time, 'Y');
            $fligts_data['up_departure_time'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'H:i');
            $fligts_data['up_arrival_time'] = rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'H:i');
            $fligts_data['up_departure_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->up_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_departure_time, 'm'));
            $fligts_data['up_arrival_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->up_arrival_time, 'm'));
            $fligts_data['up_desti'] = get_location_name($flight_schedule->flight_name->flight_desti);
            $fligts_data['up_source'] = get_location_name($flight_schedule->flight_name->flight_source);
            $fligts_data['up_flight_no'] = $flight_schedule->flight_name->flight_number;
            $fligts_data['up_time_taken'] = rami_get_no_of_hours_min_diff($flight_schedule->up_departure_time, $flight_schedule->up_arrival_time);
        }
        if ($flight_schedule->flight_type_down == 2) {
            $flight_conn_down = flight_schedule_connection::where([['type', 2], ['flight_schedule_id', $flight_schedule->id]])->orderBy('departure_time', 'asc')->get();
            $total_count = $flight_conn_down->count();
            $int = 1;
            foreach ($flight_conn_down as $flight) {
                if ($int == 1) {
                    $fligts_data['down_source'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['down_depart_full_date'] = get_week_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'w')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                    $fligts_data['down_departure_time'] = $flight->departure_time;
                    $fligts_data['down_flight_no'] = $flight->flight->flight_number;
                }
                $down_flights[$int]['airline_name'] = $flight->flight->airline_name->airl_name_eng;
                $down_flights[$int]['airline_logo'] = $flight->flight->airline_name->airl_logo_img;
                $down_flights[$int]['depart_full_date'] = get_week_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'w')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight->departure_time, 'Y');
                $down_flights[$int]['departure_time'] = rami_get_require_date_time_format($flight->departure_time, 'H:i');
                $down_flights[$int]['depart_time_in_month_date'] = rami_get_require_date_time_format($flight->departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->departure_time, 'm'));
                $down_flights[$int]['arrival_time'] = rami_get_require_date_time_format($flight->arrival_time, 'H:i');
                $down_flights[$int]['arrival_time_in_month_date'] = rami_get_require_date_time_format($flight->arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight->arrival_time, 'm'));
                $down_flights[$int]['desti'] = $flight->flight->location_desti->loc_name;
                $down_flights[$int]['source'] = $flight->flight->location_source->loc_name;
                $down_flights[$int]['flight_no'] = $flight->flight->flight_number;
                //$down_flights[$int]['time_taken']=rami_get_no_of_hours_min_diff($flight->departure_time, $flight->arrival_time);
                if ($int == $total_count) {
                    $fligts_data['down_desti'] = $flight->flight->location_desti->loc_name;
                    $fligts_data['down_arrival_time'] = $flight->arrival_time;
                    $fligts_data['down_time_taken'] = rami_get_no_of_hours_min_diff($fligts_data['down_departure_time'], $fligts_data['down_arrival_time']);
                }
                $int++;
            }
        } else {
            $fligts_data['down_airline_name'] = $flight_schedule->airline_name_down->airl_name_eng;
            $fligts_data['down_airline_logo'] = $flight_schedule->airline_name_down->airl_logo_img;
            $fligts_data['down_depart_full_date'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'd') . ' ' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_departure_time, 'm')) . ' ,' . rami_get_require_date_time_format($flight_schedule->down_departure_time, 'Y');
            $fligts_data['down_departure_time'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'H:i');
            $fligts_data['down_departure_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->down_departure_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_departure_time, 'm'));
            $fligts_data['down_arrival_time_in_month_date'] = rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'd') . ' ,' . get_month_name_hebrew(rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'm'));
            $fligts_data['down_arrival_time'] = rami_get_require_date_time_format($flight_schedule->down_arrival_time, 'H:i');
            $fligts_data['down_time_taken'] = rami_get_no_of_hours_min_diff($flight_schedule->down_departure_time, $flight_schedule->down_arrival_time);
            $fligts_data['down_desti'] = get_location_name($flight_schedule->flight_name_down->flight_desti);
            $fligts_data['down_source'] = get_location_name($flight_schedule->flight_name_down->flight_source);
            $fligts_data['down_flight_no'] = $flight_schedule->flight_name_down->flight_number;
        }
        $fligts_data['up_flights'] = $up_flights;
        $fligts_data['down_flights'] = $down_flights;
        $fligts_data['id'] = $flight_schedule->id;
        $fligts_data['title'] = $flight_schedule->flight_sche_title;
        $fligts_data['num_available_seat'] = $flight_schedule->num_available_seat;
        $data['all_flight'] = $fligts_data;
        // $data['flight_schedule']=flight_schedule::find($cart['flight_sch']);
        // $data['upflight']=flight::find($data['flight_schedule']->flight_up);
        // $data['downflight']=flight::find($data['flight_schedule']->flight_down);
        $data['cars'] = array();
        $data['total_price_in_euro'] = $cart['total_price_in_euro'];
        $data['card'] = $cart['pack_card_total_price'];
        $data['total_price_in_skl'] = $cart['total_price_in_skl'];
        $data['amount_paid_in_skl'] = $order['amount_paid_in_skl'];
        $data['remaining_amount'] = $order['total_amount_skl'] - $order['amount_paid_in_skl'];
        if ($type == 1) {
            return $html = view('pdf.passenger', $data);
        }
        if ($type == 2) {
            return $html = view('pdf.flight_car_room', $data);
        }
        if ($type == 3) {
            return $html = view('pdf.payee', $data);
        }
    }

    public function order_mail($order_id)
    {
        $order = order::find($order_id);
        // if(session()->get('mail_order_id')==$order_id){
        //     return false;
        // }
        if (!empty($order)) {
            Mail::send(new OrderCompleted($order));
        }
    }
    public function stock()
    {
        $this->updating_package_data();
    }

    public function stock_update($order_id)
    {
        $order = order::find($order_id);
        $cart = unserialize($order['order_cart']);
        if (!empty($cart)) {
            $flight = flight_schedule::find($cart['flight_sch']);
            if ($flight->num_available_seat > 0) {
                $flight->num_available_seat = $flight->num_available_seat - $cart['flight_sch_booked_for'];
            }

            $flight->save();
            if ($cart['package_type'] == 1) {
                foreach ($cart['rooms'] as $room) {
                    $new_room = room::find($room['room_id']);
                    if (!empty($new_room)) {
                        $room_stock = package_room_stock::where([['room_id', $room['room_id']], ['package_id', $cart['package_id']]])->get()->first();
                        if ($room_stock->room_available > 0) {
                            --$room_stock->room_available;
                            if ($room_stock->room_available == 0) {
                                // Remove room from package in case of no room in stock
                                $pr = package::find($cart["package_id"]);
                                $p_rooms = unserialize($pr->package_hotel_room);
                                $p_rooms = array_diff($p_rooms, [$room['room_id']]);
                                $pr->package_hotel_room = serialize($p_rooms);
                                $pr->save();
                            }
                        }

                        $room_stock->save();
                    }
                }
            }
        }
    }
}
