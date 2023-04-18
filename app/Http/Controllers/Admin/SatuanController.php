<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Satuan;

class SatuanController extends Controller
{
    public function index()
    {
        $satuan = Satuan::all();
        return view('admin.satuan.index', compact('satuan'));
    }

    public function create()
    {
        return view('admin.satuan.create');
    }

    public function store(Request $request)
    {
        $satuan = Satuan::create([
            'nama' => $request->nama,
            'harga' => $request->harga
        ]);

        if ($satuan) {
            return redirect()->route('admin.satuan')->with('msg',['type'=>'success','text'=> 'Satuan Berhasil disimpan']);
        }
    }

    public function edit($id)
    {
        $satuan = Satuan::findOrFail($id);

        return view('admin.satuan.edit', compact('satuan'));
    }

    public function update(Request $request, $id)
    {
        $satuan = Satuan::findOrFail($id);

        if ($satuan)
        {
            $satuan->nama = $request->nama;
            $satuan->harga = $request->harga;
            $satuan->update();
        }

        return redirect()->route('admin.satuan')->with('msg',['type'=>'success','text'=> 'Satuan Berhasil diperbaharui']);
    }

    public function destroy($id)
    {
        Satuan::where('id', $id)->delete();
        return response()->json(['status' => true]);
    }
}
