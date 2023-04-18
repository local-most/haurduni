<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NotificationChannels\Telegram\TelegramMessage;
use App\Notifications\TelegramRegister;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Config;
use App\Models\Notice;
use Ramsey\Uuid\Uuid;

class HomeController extends Controller
{
	public function index()
	{
		$notice = new Notice([
			'id' => Uuid::uuid4()->tostring(),
			'notice' => 'New Register',
			'noticedes' => 'idamidzin@gmail.com',
			'noticelink' => 'http://abc.garptech.com',
			'telegramid' => Config::get('services.telegram_id')
		]);


		$notice->save();
		
		echo json_encode($notice);

		$notice->notify(new TelegramRegister());

        return view('home');
	}
}
