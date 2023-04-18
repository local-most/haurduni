<?php

namespace App\Http\Controllers\Customer\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Auth;

class RegisterController extends Controller
{
	public function index()
	{
		return view('auth.daftar');
	}

	public function cekUsername(Request $request)
	{
		$user = User::where('username', $request->username)->where('role', 2)->first();

		if ($user) {
			$status = false;
		}else{
			$status = true;
		}

		echo json_encode([
			'status' => $status
		]);
	}

	public function register(Request $request)
	{
		$user = User::where('email', $request->email)->orWhere('username', $request->username)->first();
		if ($user != null) {
			if ($user->username == $request->username) {
				return back()->with('msg',['type'=>'danger','text'=>'Username sudah terpakai!'])->withInput();
			}
			if ($user->email == $request->email) {
				return back()->with('msg',['type'=>'danger','text'=>'Email sudah pernah terdaftar!'])->withInput();
			}
		}else{

			$token = \Str::random(60);

			$user = User::create([
				'nama' => $request->nama_lengkap,
				'username' => $request->username,
				'email' => $request->email,
				'password' => bcrypt($request->password),
				'role' => 2,
				'alamat' => NULL,
				'nohp' => $request->nohp,
				'foto' => NULL,
				'ktp' => NULL,
				'validate' => 0,
			]);

			return redirect()->route('login.customer')->with('msg',['type'=>'success','text'=>'Anda berhasil membuat akun, Silahkan masuk Untuk melanjutkan'])->withInput();
		}
	}

	public function verifikasi(Request $request)
	{
		$user = User::where('id', $request->id)->first();

		$user->status = 1;
		$user->update();

		return redirect()->route('home')->with('msg',['type'=>'success','text'=>'Verifikasi Email Berhasil!']);
	}

	public function kirimUlang(Request $request)
	{
		$to_name = auth()->user()->nama;
		$to_email = auth()->user()->email;

		$data = array(
			'name'=>$to_name, 
			'id' => auth()->user()->id, 
			'username' => auth()->user()->username,
			'password' => auth()->user()->password_decrypt
		);
		\Mail::send('pages.verifikasi', $data, function($message) use ($to_name, $to_email) {
			$message->to($to_email, $to_name)
			->subject('Toko Intan Store');
			$message->from('20160910116@uniku.ac.id','Intan Store');
		});

		return back()->with('msg',['type'=>'warning','text'=>'Verifikasi dikirim kembali, Silahkan Cek '.$request->email.' untuk verifikasi ! Kirim Ulang <a href="register/kirimulang") }}">Klik Disini </a>']);
	}
}
