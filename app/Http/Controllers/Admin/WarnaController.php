<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Warna;

class WarnaController extends Controller
{
    public function index(Request $request)
	{
		$is_trash = $request->get('status') == 'trash';

		$records = Warna::query();
		$warna_count = $records->count();

		$trashes = Warna::onlyTrashed()->orderBy('deleted_at','desc');
		$trash_count = $trashes->count();
		$records = $is_trash ? $trashes->get() : $records->get();

		return view('admin.warna.index',compact('records','is_trash','warna_count','trash_count'));
	}

	public function create()
	{
		return view('admin.warna.create');
	}

	public function store(Request $request)
	{

		$cek = Warna::where('nama', $request->nama)->first();

		if ($cek != null) {
			return back()->with('msg',['type'=>'danger','text'=>'Warna '.$request->nama.' sudah ada !'])->withInput();
		}

		Warna::create([
			'nama' => $request->nama,
			'value' => $request->value
		]);

		return redirect()->route('admin.warna')->with('msg',['type'=>'success','text'=>'Warna berhasil ditambahkan!']);
	}

	public function edit($id)
	{
		$records = Warna::where('id', $id)->first();
		return view('admin.warna.edit',compact('records'));
	}

	public function update(Request $request, $id)
	{
		$warna = Warna::where('id', $id)->first();
		
		$color = $warna->nama;

		if ($color == $request->nama) {
			$warna->nama = $request->nama;
			$warna->value = $request->value;
			$warna->save();
			return redirect()->route('admin.warna')->with('msg',['type'=>'success','text'=>'Warna berhasil di Update!']);
		}else{
			$cek = Warna::where('nama', $request->nama)->first();

			if ($cek != null) {
				return back()->with('msg',['type'=>'danger','text'=>'Warna '.$request->nama.' sudah ada !'])->withInput();
			}	

			$warna->nama = $request->nama;
			$warna->value = $request->value;
			$warna->save();
			return redirect()->route('admin.warna')->with('msg',['type'=>'success','text'=>'Warna berhasil di Update!']);
		}
	}

	public function delete($id)
	{
		Warna::where('id',$id)->delete();
		return response()->json(['status' => true]);
	}

	public function destroy($id)
	{
		Warna::where('id',$id)->forceDelete();
		return response()->json(['status' => true]);
	}

	public function restore($id)
	{
		Warna::where('id',$id)->restore();
		return response()->json(['status' => true]);
	}
}
