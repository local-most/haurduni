<?php

namespace App\Mail;

use App\Models\Feature;
use App\Models\Produk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductNew extends Mailable
{
    use Queueable, SerializesModels;

    protected $product;
    protected $products;
    protected $rememberToken;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($rememberToken, $product)
    {
        $this->product = $product;
        $this->products = Produk::take(3)->get();
        $this->rememberToken = $rememberToken;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('artostechnopay@gmail.com')
            ->subject('Produk Baru di Toko Harapan Mulya !')
            ->view('emails.product-new')
            ->with([
                'produk' => $this->product,
                'url' => route('show.produk.single', $this->product->id),
                'produks' => $this->products,
                'rememberToken' => $this->rememberToken,
            ]);
    }
}
