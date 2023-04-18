<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class PesananDiterimaController extends Controller
{
    public function index(Request $request)
	{
		$status = $request->get('status') ? $request->get('status') : 'diproses';

		$order = Order::query();
		$order_diterima = count(Order::where('status', statusOrder('diterima'))->get());
		$order_diproses = count(Order::where('status', statusOrder('diproses'))->get());
		$order_pengiriman = count(Order::where('status', statusOrder('dikirim'))->get());
		$order_sampai = count(Order::where('status', statusOrder('sampai'))->get());

		if ($status == "diproses")
		{
			$order = $order->where('status', statusOrder('diproses'))->get();
		}
		else if ($status == "pengiriman")
		{
			$order = $order->where('status', statusOrder('dikirim'))->get();
		}
		else if ($status == "sampai")
		{
			$order = $order->where('status', statusOrder('sampai'))->get();
		}
		else
		{
			$order = $order->where('status', statusOrder('diproses'))->get();
		}

		return view('admin.order_diterima.index', compact('order','status','order_diterima','order_pengiriman','order_diproses', 'order_sampai'));
	}

	public function proses($id)
	{
		$order = Order::where('id', $id)->first();

		$produkList = [];
		foreach ($order->OrderDetail as $row) {
			$produkList[] = $row->Produk->nama;
		}

		$order->status = statusOrder('diproses');
		$order->update();

		try {

			$messages = 'Hallo '.$order->User->nama.', terimakasih telah memesan di Toko kami. Pesanan '.implode(', ', $produkList).' sedang kami proses (TOKO HARAPAN MULYA KUNINGAN)';

			$reqParams = requestMessageText('messages', '6282129960156', $messages, 'iphone-7');
			$response = apiKirimWaRequest($reqParams);
			echo $response['body'];

		} catch (Exception $e) {
			print_r($e);
		}

		return response()->json(['status' => true]);
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
