<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Carbon\Carbon;


class SendEmailAlert extends Mailable
{
    use Queueable, SerializesModels;

    private $flight;
    private $msg;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($flight, $msg)
    {
        $this->flight = $flight;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $c = Carbon::now();
        $today = $c->format('d/m/Y');

        $data = ['flight' => $this->flight, 'message' => $this->msg];
        return $this->markdown('emails.alerts.flight_alert', $data)->subject("התראת טיסה $today")
        ->to(get_rami_setting('notification_email_id'))
        ->cc("rami@ramtours.com")
        ->cc("dana@ramtours.com");

    }
}
