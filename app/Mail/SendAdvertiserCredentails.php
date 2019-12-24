<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendAdvertiserCredentails extends Mailable
{
    use Queueable, SerializesModels;

    public $advertiser;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($advertiser)
    {
        $this->advertiser = $advertiser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.send-advertiser-credentials')->subject('Login Credentials')->with([
            'email' =>  $this->advertiser['email'],
            'password'  =>  $this->advertiser['password'],
            'url'   =>  $this->advertiser['url'],
        ]);
    }
}
