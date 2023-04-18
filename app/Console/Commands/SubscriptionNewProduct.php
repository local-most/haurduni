<?php

namespace App\Console\Commands;

use App\Mail\ProductNew;
use App\Models\EmailSubscriber;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionNewProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:new-product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email new product to subscribers';

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
        Log::info('Cron Job Subscription New Product is working fine!');

        $subscribers = EmailSubscriber::where('is_subscribed', 1)->get();
        $product = Product::whereDate('published_at', '<=', now()->toDateString())
            ->where('is_published', 0)
            ->latest()
            ->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)
                ->send(new ProductNew(
                    $subscriber->remember_token,
                    $product
                ));
        }

        // update is published on products to true
        Product::whereDate('published_at', '<=', now()->toDateString())
            ->where('is_published', 0)
            ->update([
                'is_published' => 1
            ]);

        $this->info('Subscription:New-Product Command Run Successfully!');
    }
}
