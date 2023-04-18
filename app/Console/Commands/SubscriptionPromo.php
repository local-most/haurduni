<?php

namespace App\Console\Commands;

use App\Mail\ProductPromo;
use App\Models\EmailSubscriber;
use App\Models\Promo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionPromo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:promo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email promo to subscribers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::info('Cron Job Subscription Promo is working fine!');

        $subscribers = EmailSubscriber::where('is_subscribed', 1)->get();
        $promos = Promo::with('ProductPromos', 'ProductPromos.Produk')
            ->whereDate('published_at', '<=', now()->toDateString())
            ->where('is_published', 0)
            ->whereDate('start', '<=', now()->toDateString())
            ->whereDate('end', '>', now()->toDateString())
            ->get();

        if (!count($subscribers) || !count($promos)) {
            if (!count($subscribers)) {
                $this->info('[info] No Subscribers yet!');
            }

            if (!count($promos)) {
                $this->info('[info] No promo available or all promo is published!');
            }

            $this->info('Subscription:Promo Command Run Successfully!');
            return;
        }
        

        foreach ($promos as $promo) {
            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)
                    ->send(new ProductPromo(
                        $subscriber->remember_token,
                        $promo
                    ));
            }

            $promo->is_published = 1;
            $promo->save();
        }

        $this->info('Subscription:Promo Command Run Successfully!');
    }
}
