<?php

namespace App\Mail;

use App\Models\Feature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    protected $rememberToken;
    protected $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rememberToken)
    {
        $this->rememberToken = $rememberToken;
        $this->contact = Feature::getByName('contact')->value;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@ngpinterior.com')
            ->subject('Konfirmasi Berlangganan di ' . config('app.name', 'NGP - Interior') . '!')
            ->view('emails.subscription-confirm')
            ->text('emails.subscription-confirm_plain')
            ->with([
                'rememberToken' => $this->rememberToken,
                'email' => $this->contact->email
            ]);
    }
}
