<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WhatsAppController extends Controller
{

	public function index(Request $request)
	{
		$cekStatusDevice = json_decode(ApiClient()->request('GET', 'devices/iphone-7', [
			'headers' => ApiHeader()
		])->getBody());

		if ($cekStatusDevice->status == 'disconnected')
		{
			$whatsapp = json_decode(ApiClient()->request('GET', 'qr?device_id=iphone-7', [
				'headers' => ApiHeader()
			])->getBody());

			$status = false;
		}
		else
		{
			$whatsapp = json_decode(ApiClient()->request('GET', 'quotas', [
				'headers' => ApiHeader()
			])->getBody());

			$status = true;
		}

		return view('admin.whatsapp.index', compact('whatsapp','status'));
	}

	public function disconnect()
	{
		$whatsapp = json_decode(ApiClient()->request('GET', 'qr?device_id=iphone-7', [
			'headers' => ApiHeader()
		])->getBody());

		return redirect()->back();
	}

	public function testing(Request $request)
	{
		try {

			$messages = 'Hallo Idam Idzin, terimakasih telah memesan di Toko kami. Pesanan anda sudah kami terima dan akan kami proses (TOKO HARAPAN MULYA KUNINGAN)';
			$reqParams = requestMessageText('messages', '6282129960156', $messages, 'iphone-7');
			$response = apiKirimWaRequest($reqParams);
			
			echo $response['body'];

		} catch (Exception $e) {
			print_r($e);
		}

		return redirect()->back();
	}
}
