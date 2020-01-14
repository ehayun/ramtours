<?php

namespace App\Http\Controllers\secure;

use App\Http\Controllers\Controller;
use App\Rules\no_of_year;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        rami_checking_mobile_destop_redirection();

    }
    public function order_passengers()
    {
        $rami_pack_cart = session()->get('rami_pack_cart');
        if (empty($rami_pack_cart)) {
            return redirect('/');
        }
        $data['childs'] = $rami_pack_cart['childs'];
        $data['adults'] = $rami_pack_cart['adults'];
        $data['infants'] = $rami_pack_cart['infants'];
        $data['year_slot_adults'] = 130;
        $data['year_slot_childs'] = 17;
        $data['year_slot_infants'] = 3;
        $data['total_amount'] = $rami_pack_cart['total_price_in_skl'];
        if (rami_checking_is_mobile()) {
            // return view('mobile.pages.temp_order', $data);
            return view('mobile.pages.order_passangers', $data);
        }
        // return view('frontend.pages.temp_order', $data);
        return view('frontend.pages.order_passangers', $data);
    }

    public function save_order_passengers(Request $request)
    {
        $rami_pack_cart = session()->get('rami_pack_cart');
        $childs = $rami_pack_cart['childs'];
        $adults = $rami_pack_cart['adults'];
        $infants = $rami_pack_cart['infants'];
        if (empty($rami_pack_cart)) {
            return redirect('/');
        }
        $messages = [
            'payer_firstname.required' => 'שדה חובה.',
            'payer_surname.required' => 'שדה חובה.',
            'payer_home_phone.required' => 'שדה חובה.',
            'home_code.required' => 'שדה חובה.',
            'payer_mobile_phone.required' => 'שדה חובה.',
            'mobile_code.required' => 'שדה חובה.',
            'payer_email.required' => 'שדה חובה.',
            'payer_address.required' => 'שדה חובה.',
            'payer_city.required' => 'שדה חובה.',
            'payer_zipcode.required' => 'שדה חובה.',
            'payer_terms.required' => 'שדה חובה.',
            'payer_mobile_phone.min' => 'המספר צריך להיות בן 7 ספרות.',
            'payer_mobile_phone.max' => 'המספר צריך להיות בן 7 ספרות.',
            'payer_home_phone.min' => 'המספר צריך להיות בן 7 ספרות.',
            'payer_home_phone.max' => 'המספר צריך להיות בן 7 ספרות.',
        ];
        for ($a = 1; $a <= $adults; $a++) {
            $messages['traveller_adult_' . $a . '_name.required'] = 'שדה חובה.';
            $messages['traveller_adult_' . $a . '_family_name.required'] = 'שדה חובה.';
            $messages['traveller_adult_' . $a . '_sex.required'] = 'שדה חובה.';
            $messages['traveller_adult_' . $a . '_dob_year.required'] = 'שדה חובה.';
            $messages['traveller_adult_' . $a . '_dob_month.required'] = 'שדה חובה.';
            $messages['traveller_adult_' . $a . '_dob_day.required'] = 'שדה חובה.';
        }
        for ($a = 1; $a <= $childs; $a++) {
            $messages['traveller_child_' . $a . '_name.required'] = 'שדה חובה.';
            $messages['traveller_child_' . $a . '_family_name.required'] = 'שדה חובה.';
            $messages['traveller_child_' . $a . '_sex.required'] = 'שדה חובה.';
            $messages['traveller_child_' . $a . '_dob_year.required'] = 'שדה חובה.';
            $messages['traveller_child_' . $a . '_dob_month.required'] = 'שדה חובה.';
            $messages['traveller_child_' . $a . '_dob_day.required'] = 'שדה חובה.';
        }
        for ($a = 1; $a <= $infants; $a++) {
            $messages['traveller_infant_' . $a . '_name.required'] = 'שדה חובה.';
            $messages['traveller_infant_' . $a . '_family_name.required'] = 'שדה חובה.';
            $messages['traveller_infant_' . $a . '_sex.required'] = 'שדה חובה.';
            $messages['traveller_infant_' . $a . '_dob_year.required'] = 'שדה חובה.';
            $messages['traveller_infant_' . $a . '_dob_month.required'] = 'שדה חובה.';
            $messages['traveller_infant_' . $a . '_dob_day.required'] = 'שדה חובה.';
        }
        $vaild = [
            'payer_firstname' => 'required',
            'payer_surname' => 'required',
            //'payer_home_phone' => 'min:7|max:7',
            // 'home_code' => 'required',
            'payer_mobile_phone' => 'required|min:7|max:7',
            'mobile_code' => 'required',
            'payer_email' => 'required',
            'payer_address' => 'required',
            'payer_city' => 'required',
            // 'payer_zipcode' => 'required',
            'payer_terms' => 'required',
        ];
        for ($a = 1; $a <= $adults; $a++) {
            $vaild['traveller_adult_' . $a . '_name'] = 'required';
            $vaild['traveller_adult_' . $a . '_family_name'] = 'required';
            $vaild['traveller_adult_' . $a . '_sex'] = 'required';
            $vaild['traveller_adult_' . $a . '_dob_month'] = 'required';
            $vaild['traveller_adult_' . $a . '_dob_day'] = 'required';
            $vaild['traveller_adult_' . $a . '_dob_year'] = 'required';
        }
        for ($a = 1; $a <= $childs; $a++) {
            $vaild['traveller_child_' . $a . '_name'] = 'required';
            $vaild['traveller_child_' . $a . '_family_name'] = 'required';
            $vaild['traveller_child_' . $a . '_sex'] = 'required';
            $vaild['traveller_child_' . $a . '_dob_month'] = 'required';
            $vaild['traveller_child_' . $a . '_dob_day'] = 'required';
            $vaild['traveller_child_' . $a . '_dob_year'] = ['required', new no_of_year($request->{'traveller_child_' . $a . '_dob_month'}, $request->{'traveller_child_' . $a . '_dob_day'}, 16)];
        }
        for ($a = 1; $a <= $infants; $a++) {
            $vaild['traveller_infant_' . $a . '_name'] = 'required';
            $vaild['traveller_infant_' . $a . '_family_name'] = 'required';
            $vaild['traveller_infant_' . $a . '_sex'] = 'required';
            $vaild['traveller_infant_' . $a . '_dob_month'] = 'required';
            $vaild['traveller_infant_' . $a . '_dob_day'] = 'required';
            $vaild['traveller_infant_' . $a . '_dob_year'] = ['required', new no_of_year($request->{'traveller_infant_' . $a . '_dob_month'}, $request->{'traveller_infant_' . $a . '_dob_day'}, 2)];
        }
        $this->validate($request, $vaild, $messages);
        $adult_passengers = array();
        for ($a = 1; $a <= $adults; $a++) {
            $adult_passengers[$a]['name'] = $request->{'traveller_adult_' . $a . '_name'};
            $adult_passengers[$a]['family_name'] = $request->{'traveller_adult_' . $a . '_family_name'};
            $adult_passengers[$a]['sex'] = $request->{'traveller_adult_' . $a . '_sex'};
            $adult_passengers[$a]['dob_year'] = $request->{'traveller_adult_' . $a . '_dob_year'};
            $adult_passengers[$a]['dob_month'] = $request->{'traveller_adult_' . $a . '_dob_month'};
            $adult_passengers[$a]['dob_day'] = $request->{'traveller_adult_' . $a . '_dob_day'};
        }
        $child_passengers = array();
        for ($a = 1; $a <= $childs; $a++) {
            $child_passengers[$a]['name'] = $request->{'traveller_child_' . $a . '_name'};
            $child_passengers[$a]['family_name'] = $request->{'traveller_child_' . $a . '_family_name'};
            $child_passengers[$a]['sex'] = $request->{'traveller_child_' . $a . '_sex'};
            $child_passengers[$a]['dob_year'] = $request->{'traveller_child_' . $a . '_dob_year'};
            $child_passengers[$a]['dob_month'] = $request->{'traveller_child_' . $a . '_dob_month'};
            $child_passengers[$a]['dob_day'] = $request->{'traveller_child_' . $a . '_dob_day'};
        }
        $infant_passengers = array();
        for ($a = 1; $a <= $infants; $a++) {
            $infant_passengers[$a]['name'] = $request->{'traveller_infant_' . $a . '_name'};
            $infant_passengers[$a]['family_name'] = $request->{'traveller_infant_' . $a . '_family_name'};
            $infant_passengers[$a]['sex'] = $request->{'traveller_infant_' . $a . '_sex'};
            $infant_passengers[$a]['dob_year'] = $request->{'traveller_infant_' . $a . '_dob_year'};
            $infant_passengers[$a]['dob_month'] = $request->{'traveller_infant_' . $a . '_dob_month'};
            $infant_passengers[$a]['dob_day'] = $request->{'traveller_infant_' . $a . '_dob_day'};
        }
        $passengers['childs'] = $child_passengers;
        $passengers['adults'] = $adult_passengers;
        $passengers['infants'] = $infant_passengers;
        $payee['card'] = "12345";
        $payee['name'] = $request->payer_firstname;
        $payee['surname'] = $request->payer_surname;
        $payee['home_phone'] = $request->payer_home_phone;
        $payee['home_code'] = $request->home_code;
        $payee['mobile_phone'] = $request->payer_mobile_phone;
        $payee['mobile_code'] = $request->mobile_code;
        $payee['payer_email'] = $request->payer_email;
        $payee['address'] = $request->payer_address;
        $payee['city'] = $request->payer_city;
        $payee['payer_zipcode'] = $request->payer_zipcode;
        if ($request->pay_partical == 1) {
            $payee['pay_partical'] = 1;
        } else {
            $payee['pay_partical'] = 0;
        }
        session()->put('rami_pack_passengers', $passengers);
        session()->put('rami_pack_payee', $payee);
        return redirect('payment/process');

    }
    public function updating_package_data()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, url('auto/setup_all_package_cost'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function payment_success(Request $request)
    {
        // $rami_pack_cart = session()->get('rami_pack_passengers');
        //if (empty($rami_pack_cart)) {
        // return redirect('/about');
        //}
        //dd($rami_pack_cart);
        if (!empty(rami_checking_is_mobile())) {
            return view('mobile.pages.payment_success');
        }
        return view('frontend.pages.payment_success');
    }
    public function payment_fail(Request $request)
    {
        if (!empty(rami_checking_is_mobile())) {
            return view('mobile.pages.payment_fail');
        }
        return view('frontend.pages.payment_fail');
    }
}
