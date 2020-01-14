@component('mail::message')


@component('mail::panel',['payee_name'=>$payee_name, 'email'=>$email])

@endcomponent

@component('mail::promotion', ['payee_name'=>$payee_name, 'email'=>$email, 'tran1'=>$tran1,'tran2'=>$tran2,'start_date'=>$start_date, 'end_date'=>$end_date,'pakage_components'=>$pakage_components,'adults'=>$adults,'childs'=>$childs, 'total_peoples'=>$total_peoples, 'total_price_in_skl'=>$total_price_in_skl, 'total_price_in_euro'=>$total_price_in_euro, 'amount_paid_in_skl'=>$amount_paid_in_skl, 'remaining_amount_in_skl'=>$remaining_amount_in_skl, 'card'=>$card])
@endcomponent


@component('mail::subcopy')

@endcomponent
@endcomponent


