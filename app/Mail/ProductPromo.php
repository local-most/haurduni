<?php

namespace App\Mail;

use App\Models\Feature;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductPromo extends Mailable
{
    use Queueable, SerializesModels;

    protected $contact;
    protected $products;
    protected $promo;
    protected $rememberToken;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rememberToken, $promo)
    {
        $this->contact = Feature::getByName('contact')->value;
        $this->products = Product::orderBy('view_count', 'desc')
            ->take(3)->get();
        $this->promo = $promo;
        $this->rememberToken = $rememberToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@ngpinterior.com')
            ->subject('Promo di ' . config('app.name', 'NGP - Interior') . '!')
            ->view('emails.product-promo')
            ->text('emails.product-promo_plain')
            ->with([
                'contact' => $this->contact,
                'products' => $this->products,
                'promo' => $this->promo,
                'rememberToken' => $this->rememberToken,
            ]);
    }
}
