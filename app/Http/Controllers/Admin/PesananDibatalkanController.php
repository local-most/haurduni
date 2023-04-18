<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PesananDibatalkanController extends Controller
{
	public function index(Request $request)
	{
		$status = $request->get('status') ? $request->get('status') : 'dibatalkan';

		$order = Order::query();
		$order_dibatalkan = count(Order::where('status', statusOrder('dibatalkan'))->get());

		$order = $order->where('status', statusOrder('dibatalkan'))->get();

		return view('admin.order_dibatalkan.index', compact('order','status','order_dibatalkan'));
	}

	public function kirim($id)
	{
		$order = Order::where('id', $id)->first();

		$produkList = [];
		foreach ($order->OrderDetail as $row) {
			$produkList[] = $row->Produk->nama;
		}

		$order->status = statusOrder('dikirim');
		$order->update();

		try {

			$messages = 'Hallo '.$order->User->nama.', terimakasih telah memesan di Toko kami. Pesanan '.implode(', ', $produkList).' sedang dalam perjalanan (TOKO HARAPAN MULYA KUNINGAN)';

			$reqParams = requestMessageText('messages', '6282129960156', $messages, 'iphone-7');
			$response = apiKirimWaRequest($reqParams);
			echo $response['body'];

		} catch (Exception $e) {
			print_r($e);
		}

		return response()->json(['status' => true]);
	}

	public function selesai($id)
	{
		$order = Order::where('id', $id)->first();

		$produkList = [];
		foreach ($order->OrderDetail as $row) {
			$produkList[] = $row->Produk->nama;
		}

		$order->status = statusOrder('selesai-order');
		$order->update();

		try {

			$messages = 'Hallo '.$order->User->nama.', terimakasih telah memesan di Toko kami. Pesanan '.implode(', ', $produkList).' telah selesai. Selalu kami tunggu untuk pembelian produk lainnya yaa (TOKO HARAPAN MULYA KUNINGAN)';

			$reqParams = requestMessageText('messages', '6282129960156', $messages, 'iphone-7');
			$response = apiKirimWaRequest($reqParams);
			echo $response['body'];

		} catch (Exception $e) {
			print_r($e);
		}

		return response()->json(['status' => true]);
	}

	public function batalkan($id, $alasan)
	{

		$order = Order::where('id', $id)->first();

		$produkList = [];
		foreach ($order->OrderDetail as $row) {
			$produkList[] = $row->Produk->nama;
		}

		$order->alasan_tolak = $alasan;
		$order->status = statusOrder('dibatalkan');
		$order->update();

		try {

			$messages = 'Hallo '.$order->User->nama.', terimakasih telah memesan di Toko kami. Pesanan '.implode(', ', $produkList).' telah kami batalkan karena '.$alasan.'. (TOKO HARAPAN MULYA KUNINGAN)';

			$reqParams = requestMessageText('messages', '6282129960156', $messages, 'iphone-7');
			$response = apiKirimWaRequest($reqParams);
			echo $response['body'];

		} catch (Exception $e) {
			print_r($e);
		}

		return response()->json(['status' => true]);
	}
}
