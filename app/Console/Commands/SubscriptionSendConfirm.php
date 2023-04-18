<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionConfirmed;
use App\Models\EmailSubscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SubscriptionSendConfirm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:send-confirm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email confirmation to new subscribers';

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
        Log::info('Cron Job Subscription Send Confirmation is working fine!');

        $subscribers = EmailSubscriber::where('has_send_confirmation', 0)->get();

        foreach ($subscribers as $subscriber) {
            EmailSubscriber::where('id', $subscriber->id)->update([
                'has_send_confirmation' => 1
            ]);

            Mail::to($subscriber->email)
                ->send(new SubscriptionConfirmed($subscriber->remember_token));
        }

        $this->info('Subscription:Send-Confirm Command Run Successfully!');
    }
}
