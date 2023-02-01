<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $orderHistory;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderHistory)
    {
        $this->orderHistory = $orderHistory;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if(!empty($this->orderHistory->email)){
            return $this
                        ->to($this->orderHistory->email)
                        ->subject('We Have Received Your Order')
                        ->view('mail.orderReceived');
        }
    }
}
