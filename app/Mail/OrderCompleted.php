<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $order;
    public function __construct($order)
    {
       //session()->forget('mail_order_id');
       $this->order=$order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd($this->order);
        $data['payee_name']= $this->order['payee_name']; 
        $data['email']=$this->order['payee_email_id'];
        $data['tran1']=$this->order['tran_id'];
        $data['tran2']=$this->order['internal_deal_number'];
        $cart=unserialize($this->order['order_cart']);
        $data['start_date']='';
        if(!empty($cart['start_date'])){
            $data['start_date']=$cart['start_date'];
        }
        $data['end_date']='';
        if(!empty($cart['end_date'])){
            $data['end_date']=$cart['end_date'];
        }
        $data['pakage_components']=$cart['pakage_components'];
        $data['adults']=$cart['adults'];
        $data['childs']=$cart['childs'];
        $data['total_peoples']=$cart['total_peoples'];
        $data['card']=$cart['pack_card_total_price']; 
        $data['total_price_in_skl']=$cart['total_price_in_skl'];
        $data['total_price_in_euro']=$cart['total_price_in_euro'];
        $data['amount_paid_in_skl']=$this->order['amount_paid_in_skl'];
        $data['remaining_amount_in_skl']= $data['total_price_in_skl']-$data['amount_paid_in_skl'];
        return $this->markdown('emails.orders.order_completed', $data)->subject('רמטורס:הזמנה חדשה מהאתר - '.$data['tran1'])->to($this->order['payee_email_id'])->cc(get_rami_setting('notification_email_id'))->attach(base_path().'/storage/app/ramtours_assets/orders/'.$this->order['tran_id'].'.pdf');
    }
}
