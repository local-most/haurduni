<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class DaftarPesananController extends Controller
{
	public function index(Request $request)
	{
		$bulan = $request->get('bulan') ? $request->get('bulan') : date('m');
		$tahun = $request->get('tahun') ? $request->get('tahun') : date('Y');

		$order = Order::where('status', statusOrder('baru'))->get();

		if ($request->get('bulan') && $request->get('tahun')) {
			$order = Order::where('status', statusOrder('baru'))
							->whereRaw('MONTH(tanggal) = ? and YEAR(tanggal) = ?',[$bulan,$tahun])
							->get();
		}

		return view('admin.daftar_order.index', compact('order','bulan','tahun'));
	}

	public function terima($id)
	{
		$order = Order::where('id', $id)->first();

		$produkList = [];
		foreach ($order->OrderDetail as $row) {
			$produkList[] = $row->Produk->nama;
		}

		$order->status = statusOrder('diproses');
		$order->update();

		try {

			$messages = 'Hallo '.$order->User->nama.', terimakasih telah memesan di Toko kami. Pesanan '.implode(', ', $produkList).' sudah kami terima dan di proses pembayarannya (TOKO HARAPAN MULYA KUNINGAN)';

			$reqParams = requestMessageText('messages', $order->User->nohp, $messages, 'iphone-7');
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
		$order->alasan_tolak = $alasan;
		$order->status = statusOrder('dibatalkan');
		$order->update();

		return response()->json(['status' => true]);
	}
}
