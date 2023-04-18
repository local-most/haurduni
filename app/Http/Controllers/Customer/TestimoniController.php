<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use App\Models\Testimoni;

class TestimoniController extends Controller
{
	public function getOrderDetail(Request $request)
	{
		$order_detail = OrderDetail::where('id', $request->id)->first();

		$records = [
			'id' => $order_detail->id,
			'produk_id' => $order_detail->produk_id,
			'jumlah' => $order_detail->jumlah,
			'produk' => $order_detail->Produk->nama
		];

		echo json_encode($records);
	}

	public function store(Request $request)
	{
		
		$order_detail = OrderDetail::where('id', $request->order_detail_id)->first();

		$testimoni = Testimoni::where('order_detail_id', $order_detail->id)->first();

		$path_gambar = $testimoni ? $testimoni->gambar : NULL;

		if ($request->hasFile('gambar')) {
			$image      = $request->file('gambar');
			$fileName   = 'gambar-'.uniqid().'-'.date('dmY').'-'.date('His').'.' . $image->getClientOriginalExtension();
			$image->move('images/testimoni', $fileName);
			$path_gambar = 'images/testimoni/'. $fileName;
		}

		if ($testimoni) {

			$testimoni->keterangan = $request->keterangan;
			$testimoni->rate = $request->rate;
			$testimoni->gambar = $path_gambar;
			$testimoni->update();

		}else{
			$testimoni = Testimoni::create([
				'order_detail_id' => $order_detail->id,
				'produk_id' => $order_detail->produk_id,
				'user_id' => auth()->user()->id,
				'keterangan' => $request->keterangan,
				'rate' => $request->rate,
				'gambar' => $path_gambar,
			]);
		}


		return redirect()->back()->with('msg', ['type' => 'success', 'text' => 'Penilaian berhasil dikirim, terimakasih sudah berbelanja di Toko kami']);
	}
}
