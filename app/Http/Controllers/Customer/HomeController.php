<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Keranjang;

class HomeController extends Controller
{
	public function index()
	{
		$produk = Produk::limit(7)->orderBy('id', 'DESC')->get();
		$produk_terbaru = Produk::orderBy('id', 'DESC')->first();

		$social = \App\Models\Feature::getByName('social-media');
		$about = \App\Models\Feature::getByName('about-us');

		return view('customer.home', compact('produk','produk_terbaru','social','about'));
	}

	public function showProduk($id)
	{
		$kategori = Kategori::where('id', $id)->first();
		
		if ($kategori)
		{
			$status = 'single-kategori';
			$produk = $kategori->Produk;
		}else{
			$kategori = Kategori::get();
			$status = 'multiple-kategori';
			$produk = [];
		}

		return view('customer.produk', compact('produk','kategori','status'));
	}

	public function showProdukSingle($id)
	{
		$produk = Produk::findOrFail($id);

		$records = [];

		foreach ($produk->OrderDetail as $row) {
			if ($row->Order->status == statusOrder('selesai-order')) {
				$records[] = $row->jumlah;
			}
		}
		
		$terjual = array_sum($records);

		return view('customer.produk_single', compact('produk','terjual'));
	}

	public function getHargaTotal(Request $request)
	{
		$produk = Produk::where('id', $request->produk_id)->first();

		$total = 'Rp. '.number_format($produk->harga*$request->jumlah, 0,'.','.');

		if(count($produk->Diskon) > 0){
			$total = 'Rp. '.number_format(($produk->harga-$produk->Diskon[0]->harga)*$request->jumlah, 0,'.','.');
		}

		$jumlah = $produk->stok;
		$req_jumlah = $request->jumlah;
		
		echo json_encode([
			'total' => $total,
			'total_original' => 'Rp. '.number_format($produk->harga*$request->jumlah, 0,'.','.'),
			'stok' => $jumlah,
			'jumlah' => $req_jumlah
		]);
	}

	public function setKeranjang(Request $request)
	{
		$keranjang = Keranjang::create([
			'produk_id' => $request->produk_id,
			'jumlah' => $request->jumlah,
		]);
	}
}
