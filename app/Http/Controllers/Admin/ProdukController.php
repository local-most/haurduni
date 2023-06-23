<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Warna;
use App\Models\Satuan;
use App\Models\Diskon;
use App\Mail\ProductNew;
use Illuminate\Support\Facades\Mail;

class ProdukController extends Controller
{
	public function index(Request $request)
	{
		$is_trash = $request->get('status') == 'trash';

		$records = Produk::query();
		$produk_count = $records->count();

		$trashes = Produk::onlyTrashed()->orderBy('deleted_at','desc');
		$trash_count = $trashes->count();
		$records = $is_trash ? $trashes->get() : $records->orderBy('id', 'DESC')->get();

		return view('admin.produk.index', compact('records','is_trash','produk_count','trash_count'));
	}

	public function create()
	{
		$kategori = Kategori::all();
		$warna = Warna::all();
		$satuan = Satuan::all();
		return view('admin.produk.create', compact('kategori','warna', 'satuan'));
	}

	public function store(Request $request)
	{
		$harga = preg_replace('/[Rp.]/', '', $request->harga);

		$path_image5 = null;

		if ($request->hasFile('foto1')) {
			$image      = $request->file('foto1');
			$fileName   = 'foto1-'.uniqid().'.' . $image->getClientOriginalExtension();
			$image->move('images/products', $fileName);
			$path_image5 = 'images/products/'. $fileName;
		}

		// $warna = $request->warna_id;
		// if($warna){
		// 	$warna = implode(',', $warna);
		// }

		$produk = Produk::create([
			'nama' => $request->nama,
			'kategori_id' => $request->kategori_id,
			'satuan_id' => $request->satuan_id,
			'harga' => $harga,
			'berat' => $request->berat,
			'deskripsi' => $request->deskripsi,
			'stok' => $request->stok,
			'foto' => $path_image5,
			// 'warna_id' => $warna,
		]);

		if($request->diskon_persen){
			$diskon = Diskon::where('produk_id', $produk->id)->first();

			if(!$diskon){
				Diskon::create([
					'produk_id' => $produk->id,
					'harga' => $request->diskon_rupiah,
					'status' => true
				]);
			}
		}

		$user = User::where('role', role('pelanggan'))->get();

		// if(count($user) > 0){
		// 	foreach($user as $row){
		// 		if($row->email){
		// 			Mail::to($row->email)
		// 			->send(new ProductNew(
		// 				'123456',
		// 				$produk
		// 			));
		// 		}
		// 	}
		// }

		if ($produk) {
			return redirect()->route('admin.produk')->with('msg',['type'=>'success','text'=> 'Produk Berhasil disimpan']);
		}
	}

	public function edit($id)
	{
		$produk = Produk::findOrFail($id);
		$kategori = Kategori::all();
		$warna = Warna::all();
		$satuan = Satuan::all();
		return view('admin.produk.edit', compact('kategori', 'produk', 'warna', 'satuan'));
	}

	public function update(Request $request, $id)
	{
		$produk = Produk::where('id', $id)->first();

		$harga = preg_replace('/[Rp.]/', '', $request->harga);

		$path_image5 = $produk->foto;

		if ($request->hasFile('foto1')) {
			$image      = $request->file('foto1');
			$fileName   = 'foto1-'.uniqid().'.' . $image->getClientOriginalExtension();
			$image->move('images/products', $fileName);
			$path_image5 = 'images/products/'. $fileName;
		}

		// $warna = $request->warna_id;

		// if($warna){
		// 	$warna = implode(',', $warna);
		// }

		$produk->nama = $request->nama;
		$produk->kategori_id = $request->kategori_id;
		$produk->satuan_id = $request->satuan_id;
		$produk->harga = $harga;
		$produk->berat = $request->berat;
		$produk->deskripsi = $request->deskripsi;
		$produk->stok = $request->stok;
		$produk->foto = $path_image5;
		// $produk->warna_id = $warna;
		$produk->update();

		if($request->diskon_persen){
			$diskon = Diskon::where('produk_id', $produk->id)->first();

			if(!$diskon){
				Diskon::create([
					'produk_id' => $produk->id,
					'harga' => $request->diskon_rupiah,
					'status' => true
				]);
			} else {
				$diskon->harga = $request->diskon_rupiah;
				$diskon->update();
			}
		}

		return redirect()->route('admin.produk')->with('msg',['type'=>'success','text'=> 'Produk Berhasil diperbarui']);
	}

	public function delete($id)
	{
		Produk::where('id',$id)->delete();
		return response()->json(['status' => true]);
	}

	public function destroy($id)
	{
		Produk::where('id',$id)->forceDelete();
		return response()->json(['status' => true]);
	}

	public function restore($id)
	{
		Produk::where('id',$id)->restore();
		return response()->json(['status' => true]);
	}

	public function resendProduk($id)
	{
		$produk = Produk::findOrFail($id);
		$user = User::where('role', role('pelanggan'))->get();

		$email = [];
		if(count($user) > 0){
			foreach($user as $row){
				if($row->email){
					$email[] = $row->email;
					Mail::to($row->email)
					->send(new ProductNew(
						'123456',
						$produk
					));
				}
			}
		}

		return redirect()->route('admin.produk')->with('msg',['type'=>'success','text'=> 'Email Berhasil di kirim ulang!']);
	}
}
