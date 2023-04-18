<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wilayah;

class ProfileController extends Controller
{
	public function index(Request $request)
	{
		$user = User::where('id', auth()->user()->id)->first();
		$wilayah = Wilayah::get();

		return view('customer.profile', compact('user','wilayah'));
	}

	public function update(Request $request, $id)
	{
		$user = User::where('id', $id)->first();

		$path_foto = $user->foto;
		$path_ktp = $user->ktp;

		if ($request->hasFile('foto')) {
			$image      = $request->file('foto');
			$fileName   = 'profile-'.uniqid().'.' . $image->getClientOriginalExtension();
			$image->move('images/profile', $fileName);
			$path_foto = 'images/profile/'. $fileName;
		}

		if ($request->hasFile('ktp')) {
			$image      = $request->file('ktp');
			$fileName   = 'ktp-'.uniqid().'.' . $image->getClientOriginalExtension();
			$image->move('images/ktp', $fileName);
			$path_ktp = 'images/ktp/'. $fileName;
		}

		$user->nama = $request->nama_lengkap;
		$user->username = $request->username;
		$user->email = $request->email;
		
		if ($request->has('password')) {
			$user->password = bcrypt($request->password);
		}

		$user->alamat = $request->alamat;
		$user->nohp = $request->nohp;
		$user->wilayah_id = $request->wilayah_id;
		$user->alamat = $request->alamat;
		$user->foto = $path_foto;
		$user->ktp = $path_ktp;
		$user->update();

		return redirect()->back()->with('msg', ['type' => 'success', 'text' => 'Profile berhasil di perbarui']);
	}
}
