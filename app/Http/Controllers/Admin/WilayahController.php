<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wilayah;

class WilayahController extends Controller
{
	public function index()
	{
		$wilayah = Wilayah::all();
		return view('admin.wilayah.index', compact('wilayah'));
	}

	public function create()
	{
		return view('admin.wilayah.create');
	}

	public function store(Request $request)
	{
		$wilayah = Wilayah::create([
			'nama' => $request->nama,
			'ongkir' => $request->ongkir
		]);

		if ($wilayah) {
			return redirect()->route('admin.wilayah')->with('msg',['type'=>'success','text'=> 'Wilayah Berhasil disimpan']);
		}
	}

	public function edit($id)
	{
		$wilayah = Wilayah::findOrFail($id);

		return view('admin.wilayah.edit', compact('wilayah'));
	}

	public function update(Request $request, $id)
	{
		$wilayah = Wilayah::findOrFail($id);

		if ($wilayah)
		{
			$wilayah->nama = $request->nama;
			$wilayah->ongkir = $request->ongkir;
			$wilayah->update();
		}

		return redirect()->route('admin.wilayah')->with('msg',['type'=>'success','text'=> 'Wilayah Berhasil diperbaharui']);
	}

	public function destroy($id)
	{
		Wilayah::where('id', $id)->delete();
		return response()->json(['status' => true]);
	}
}
