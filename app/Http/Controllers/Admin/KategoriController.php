<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
	public function index()
	{
		$kategori = Kategori::all();
		return view('admin.kategori.index', compact('kategori'));
	}

	public function create()
	{
		return view('admin.kategori.create');
	}

	public function store(Request $request)
	{
		$harga = preg_replace('/[Rp.]/', '', $request->harga);

		$kategori = Kategori::create([
			'nama' => $request->nama,
			'harga' => 0,
			'is_color' => $request->is_color
		]);

		if ($kategori) {
			return redirect()->route('admin.kategori')->with('msg',['type'=>'success','text'=> 'Kategori Berhasil disimpan']);
		}
	}

	public function edit($id)
	{
		$kategori = Kategori::findOrFail($id);

		return view('admin.kategori.edit', compact('kategori'));
	}

	public function update(Request $request, $id)
	{
		$kategori = Kategori::findOrFail($id);

		$harga = preg_replace('/[Rp.]/', '', $request->harga);

		if ($kategori)
		{
			$kategori->nama = $request->nama;
			$kategori->is_color = $request->is_color;
			$kategori->update();
		}

		return redirect()->route('admin.kategori')->with('msg',['type'=>'success','text'=> 'Kategori Berhasil diperbaharui']);
	}

	public function destroy($id)
	{
		Kategori::where('id', $id)->delete();
		return response()->json(['status' => true]);
	}
}
