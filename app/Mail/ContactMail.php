<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;
    public $settings;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mailData, $settings)
    {
        $this->mailData = $mailData;
        $this->settings = $settings;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->mailData['email'])
            ->markdown('mail.contact-form')
            ->with([
                'name' => $this->mailData['name'],
                'email' => $this->mailData['email'],
                'message' => $this->mailData['message'],
                'logo' => $this->settings->logo,
                'email' => $this->settings->email,
                'address' => $this->settings->address,
                'support_phone' => $this->settings->support_phone
            ]);
    }
}
