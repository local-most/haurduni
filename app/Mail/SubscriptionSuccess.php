<?php

namespace App\Mail;

use App\Models\Feature;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionSuccess extends Mailable
{
    use Queueable, SerializesModels;

    protected $rememberToken;
    protected $contact;
    protected $isSubscribed;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rememberToken, $isSubscribed)
    {
        $this->rememberToken = $rememberToken;
        $this->contact = Feature::getByName('contact')->value;
        $this->isSubscribed = $isSubscribed;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@ngpinterior.com')
            ->subject('Pengumuman Berlangganan di ' . config('app.name', 'NGP - Interior') . '!')
            ->view('emails.subscription-success')
            ->text('emails.subscription-success_plain')
            ->with([
                'rememberToken' => $this->rememberToken,
                'email' => $this->contact->email,
                'isSubscribed' => $this->isSubscribed
            ]);
    }
}
