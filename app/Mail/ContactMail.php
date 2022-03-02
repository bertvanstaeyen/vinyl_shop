<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = "";
        $name = "";
        if ($this->request->contact == "info") {
            $email = "info@thevinylshop.com";
            $name = "The Vinyl Shop - Info";
        } else if ($this->request->contact == "billing") {
            $email = "billing@thevinylshop.com";
            $name = "The Vinyl Shop - Billing";
        } if ($this->request->contact == "support") {
            $email = "support@thevinylshop.com";
            $name = "The Vinyl Shop - Support";
        }
        return $this->from($email, $name)
            ->cc($email, $name)
            ->subject('The Vinyl Shop - Contact Form')
            ->markdown('email.contact');
    }
}
