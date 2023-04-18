<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Produk;
use App\Models\Warna;

class PembelianController extends Controller
{
	public function index(Request $request)
	{
		$order_id = base64_decode($request->get('order'));

		$msg = null;

		if ($request->get('order'))
		{
			$order = Order::where('user_id', auth()->user()->id)->where('id', $order_id)->orderBy('id', 'DESC')->first();
		}
		else
		{
			$order = Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
			$msg = "Bukti pembayaran berhasil dikirim, silahkan untuk menunggu konfirmasi selanjutnya";
		}

		return view('customer.form_pembayaran', compact('order','msg'));
	}

	public function store(Request $request)
	{
		$cek_keranjang = Keranjang::whereIn('id', $request->keranjang_id)->get();
		
		if (count($cek_keranjang) > 0)
		{
			$order_list = [
				'user_id' => auth()->user()->id,
				'total_harga' => $request->sub_total,
				'tanggal' => \Carbon\Carbon::now(),
				'total_tagihan' => $request->total_bayar,
				'total_ongkir' => $request->total_ongkir,
				'status' => 1,
				'bukti_pembayaran' => NULL,
				'is_delivered' => $request->sub_total >=  150000 ? 1 : 1,
				'wilayah_id' => auth()->user()->wilayah_id,
			];

			$order = Order::create($order_list);

			$order_detail_list = [];
			$keranjang_id = [];

			foreach (explode(',', $request->keranjang_id[0]) as $id)
			{
				$keranjang = Keranjang::where('id', $id)->first();

				$keranjang_id[] = $keranjang->id;

				$order_detail_list[] = [
					'order_id' => $order->id,
					'produk_id' => $keranjang->produk_id,
					'jumlah' => $keranjang->jumlah,
					'harga' => $keranjang->Produk->harga,
					'warna_id' => $keranjang->warna_id,
					'keterangan' => $keranjang->catatan
				];

				$produk = Produk::where('id', $keranjang->produk_id)->first();

				$produk->stok = $produk->stok - $keranjang->jumlah;
				$produk->update();

			}
			
			$order_detail = OrderDetail::insert($order_detail_list);

			$keranjang_delete = Keranjang::whereIn('id', $keranjang_id)->delete();
		}else{
			$order = Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->first();
		}

		$msg = null;

		return view('customer.form_pembayaran', compact('order','msg'));
	}

	public function uploadPembayaran(Request $request, $id)
	{
		$order = Order::where('id', $id)->first();

		$path_bukti = $order->bukti_pembayaran;

		if ($request->hasFile('bukti_pembayaran')) {
			$image      = $request->file('bukti_pembayaran');
			$fileName   = 'bukti-'.uniqid().'-'.date('dmY').'-'.date('His').'.' . $image->getClientOriginalExtension();
			$image->move('images/bukti', $fileName);
			$path_bukti = 'images/bukti/'. $fileName;
		}

		$order->bukti_pembayaran = $path_bukti;
		$order->update();

		return redirect()->route('pembelian.index')->with('msg', ['type' => 'success', 'text' => 'Bukti pembayaran berhasil dikirim, silahkan untuk menunggu konfirmasi selanjutnya']);
	}

	public function riwayat(Request $request)
	{
		$status = $request->get('status');

		$query = Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC');

		$all = $query->get();

		$menunggu = Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')
							->where('status', statusOrder('baru'))
							->whereNull('bukti_pembayaran')
							->get();

		$menunggu_konfirmasi = Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')
								->where('status', statusOrder('baru'))
								->whereNotNull('bukti_pembayaran')
								->get();

		$diproses = Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')
							->where('status', statusOrder('diproses'))
							->get();

		$dikirim = Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')
							->where('status', statusOrder('dikirim'))
							->get();
							
		$sampai = Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')
							->where('status', statusOrder('sampai'))
							->get();

		$selesai_order = Order::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')
							->where('status', statusOrder('selesai-order'))
							->get();

		$semua_count = count($all);
		$menunggu_count = count($menunggu);
		$menunggu_konfirmasi_count = count($menunggu_konfirmasi);
		$diproses_count = count($diproses);
		$dikirim_count = count($dikirim);
		$sampai_count = count($sampai);
		$selesai_order_count = count($selesai_order);

		if ($status == 'menunggu') {
			$records = $menunggu;
		}
		else if ($status == 'menunggu-konfirmasi') {
			$records = $menunggu_konfirmasi;
		}
		else if ($status == 'diproses') {
			$records = $diproses;
		}
		else if ($status == 'dikirim') {
			$records = $dikirim;
		}
		else if ($status == 'sampai') {
			$records = $sampai;
		}
		else if ($status == 'selesai-order') {
			$records = $selesai_order;
		}
		else if ($status == 'all') {
			$records = $all;
		}

		$transaksi = [];
		foreach ($selesai_order as $row) {
			$transaksi[] = $row->total_tagihan;
		}

		$total_transaksi = array_sum($transaksi);

		return view('customer.riwayat', compact(
			'records',
			'status',
			'total_transaksi',
			'semua_count',
			'menunggu_count',
			'menunggu_konfirmasi_count',
			'diproses_count',
			'dikirim_count',
			'sampai_count',
			'selesai_order_count',
		));
	}

	public function sampai(Request $request)
	{
		$order = Order::where('id', $request->id)->first();

		$order->status = statusOrder('sampai');
		$order->update();

		return response()->json(['status' => true]);
	}

	public function getWarna(Request $request)
	{
		$warna = Warna::where('id', $request->warna_id)->first();

		return response()->json($warna);
	}
}
