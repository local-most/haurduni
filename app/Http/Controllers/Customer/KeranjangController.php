<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keranjang;
use App\Models\Produk;
use App\Models\Wilayah;

class KeranjangController extends Controller
{
	public function index(Request $request)
	{
		$keranjang = Keranjang::where('user_id', auth()->user()->id)->get();

		return view('customer.keranjang', compact('keranjang'));
	}

	public function checkout(Request $request)
	{
		$keranjang = Keranjang::where('user_id', auth()->user()->id)->get();
		$user_wilayah = auth()->user()->wilayah_id;
		$user_nohp = auth()->user()->nohp;
		// $user_ktp = auth()->user()->ktp;
		$user_email = auth()->user()->email;
		$user_validate = auth()->user()->validate;

		if(!$user_wilayah){
			return redirect()->back()->with('msg', [
						'type' => 'danger',
						'text' => 'Profile wilayah anda belum lengkap, silahkan untuk melengkapi profile anda ! <a href="'.route('profile').'" target="_blank">Klik disini</a>'
					]);
		}

		if(!$user_nohp){
			return redirect()->back()->with('msg', [
						'type' => 'danger',
						'text' => 'Profile No HP anda belum lengkap, silahkan untuk melengkapi profile anda ! <a href="'.route('profile').'" target="_blank">Klik disini</a>'
					]);
		}

		if(!$user_email){
			return redirect()->back()->with('msg', [
						'type' => 'danger',
						'text' => 'Profile Email anda belum lengkap, silahkan untuk melengkapi profile anda ! <a href="'.route('profile').'" target="_blank">Klik disini</a>'
					]);
		}

		// if(!$user_ktp){
		// 	return redirect()->back()->with('msg', [
		// 				'type' => 'danger',
		// 				'text' => 'Profile KTP anda belum lengkap, silahkan untuk melengkapi profile anda ! <a href="'.route('profile').'" target="_blank">Klik disini</a>'
		// 			]);
		// }

		if($user_validate != 1){
			return redirect()->back()->with('msg', [
						'type' => 'danger',
						'text' => 'Akun anda belum tervalidasi oleh Toko, Silahkan tunggu maksimal 1x24 Jam'
					]);
		}

		return view('customer.checkout', compact('keranjang'));
	}

	public function getKeranjang()
	{
		$keranjang = Keranjang::where('user_id', auth()->user()->id)->get();
		$harga_wilayah = auth()->user()->wilayah_id ? auth()->user()->Wilayah->ongkir : 0;

		$jumlah = [];
		$jumlah_barang = [];
		$records = [];
		$jumlah_list = [];
		$produk_stok_kosong = [];
		$sub_ongkir = [];
		$keranjang_id = [];

		foreach ($keranjang as $row) {

			if ($row->status == 1)
			{
				if(count($row->Produk->Diskon) > 0){
					$jumlah[] = $row->jumlah*($row->Produk->harga-$row->Produk->Diskon[0]->harga);
				} else {
					$jumlah[] = $row->jumlah*$row->Produk->harga;
				}
				$jumlah_barang[] = $row->jumlah;

				if ($row->Produk->stok == 0 || $row->jumlah > $row->Produk->stok) {
					$produk_stok_kosong [] = $row->Produk->id;
				}

				$sub_ongkir[] = $row->Produk->berat*$row->jumlah;

				$keranjang_id[] = $row->id;
			}


			$jumlah_list[] = $row->jumlah;
			$harga_result = $row->Produk->harga;
			if(count($row->Produk->Diskon) > 0){
				$harga_result = $row->Produk->harga - $row->Produk->Diskon[0]->harga;
			}
			$records[] = (object) [
				'id' => $row->id,
				'status' => $row->status,
				'jumlah' => $row->jumlah,
				'harga' => 'Rp'.number_format($harga_result, 0,'.','.'),
			];
		}

		$total_ongkir = array_sum($sub_ongkir)+$harga_wilayah;

		$total = array_sum($jumlah);
		$minimal_belanja = 5000000;

		if ($total > 500000 && $total <= $minimal_belanja) {
			$total_ongkir = 0;
			$isOngkir = false;
			$ongkirnya = 0;
		}
		else if($total >= $minimal_belanja)
		{
			$total_ongkir = $total_ongkir;
			// $isOngkir = false;
			$isOngkir = true;
			$ongkirnya = $total_ongkir;
			// $ongkirnya = 0;
		}
		else{
			// $isOngkir = false;
			$total_ongkir = $total_ongkir;
			$isOngkir = true;
			// $total_ongkir = 0;
			$ongkirnya = $total_ongkir;
			// $ongkirnya = 0;
		}

		echo json_encode([
			'keranjang' => $records,
			'keranjang_id' => $keranjang_id,
			'sub_total_view' => 'Rp'.number_format($total, 0,'.','.'),
			'total_bayar_view' => 'Rp'.number_format($total+$ongkirnya, 0,'.','.'),
			'jumlah_barang' => array_sum($jumlah_barang),
			'keranjang_count' => array_sum($jumlah_list),
			'produk_stok_kosong' => count($produk_stok_kosong),
			'total_harga' => $total,
			'total_ongkir' => $total_ongkir,
			'isOngkir' => $isOngkir,
			'total_harga_' => $total+$total_ongkir,
			'total_ongkir_view' => 'Rp'.number_format($total_ongkir, 0,'.','.'),
		]);
	}

	public function setChecked(Request $request)
	{
		if ($request->status == 'single')
		{
			$keranjang = Keranjang::where('id', $request->keranjang_id)->first();
			$keranjang->status = $keranjang->status == 0 ? 1 : 0;
			$keranjang->update();
		}
		else
		{
			if ($request->is_checked == 0) {
				$keranjang = Keranjang::where('status', 0)->update(['status'=>1]);
			}else{
				$keranjang = Keranjang::where('status', 1)->update(['status'=>0]);
			}
		}

		echo json_encode([
			'status' => true
		]);
	}

	public function store(Request $request)
	{
		$status = $request->status;

		$produk = Produk::where('id', $request->produk_id)->first();

		$warna = $request->warna_id;
		// if ($produk->Kategori->is_color == true) {

		// 	if ($request->has('warna_id')) {
		// 		$warna = $request->warna_id;
	    //     	$warna = implode(',', $warna);
		// 	}
		// }

		if ($status == 'keranjang')
		{
			if($produk->kategori_id == 2){
				$keranjang = Keranjang::where('user_id', auth()->user()->id)->where('produk_id', $request->produk_id)->where('warna_id', $warna)->first();
			}else{
				$keranjang = Keranjang::where('user_id', auth()->user()->id)->where('produk_id', $request->produk_id)->first();
			}

			if ($keranjang) {
				$keranjang->jumlah = $keranjang->jumlah + $request->jumlah;
				$keranjang->status = 1;
				$keranjang->update();
			}else{
				$keranjang = Keranjang::create([
					'user_id' => auth()->user()->id,
					'produk_id' => $request->produk_id,
					'jumlah' => $request->jumlah,
					'warna_id' => $warna,
					'status' => 1,
					'catatan' => $request->catatan
				]);
			}

			return redirect()->route('keranjang')
							->with('msg', [
								'type' => 'success',
								'text' => 'Produk berhasil di tambahkan ke dalam keranjang'
							]);
		}
		else
		{

		}
	}

	public function getHargaTotalKeranjang(Request $request)
	{
		$keranjang = Keranjang::where('id', $request->keranjang_id)->first();

		if ($request->jumlah > $keranjang->Produk->stok)
		{
			$keranjang->jumlah = $keranjang->Produk->stok == 0 ? 1 : $keranjang->Produk->stok;
		}
		else
		{
			if ($request->jumlah < 1) {
				$keranjang->jumlah = 1;
			}else{
				$keranjang->jumlah = $request->jumlah;
			}
		}

		$keranjang->update();

		echo json_encode([
			'status' => true
		]);
	}

	public function delete($id)
	{
		$keranjang = Keranjang::where('id', $id)->forceDelete();

		return redirect()->back()->with('msg', ['type' => 'success', 'text' => 'Keranjang berhasil dihapus !']);
	}
}
