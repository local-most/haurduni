<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
    	$status = $request->get('status') ? $request->get('status') : 0;

    	$query = User::query();

    	$user = $status == 1 ? User::where('validate', 1)->where('role', 2)->get() : User::where('validate', 0)->where('role', 2)->get();

    	$validate_count = count(User::where('validate', 1)->where('role', 2)->get());
    	$not_validate_count = count(User::where('validate', 0)->where('role', 2)->get());

    	return view('admin.user.index', compact('user', 'validate_count', 'not_validate_count', 'status'));
    }

    public function terima(Request $request, $id)
    {
    	$user = User::where('id', $id)->first();

    	$user->validate = 1;
    	$user->update();

    	return response()->json(['status' => true]);
    }

    public function tolak(Request $request, $id)
    {
    	$user = User::where('id', $id)->first();

    	$user->validate = 0;
    	$user->alasan = $request->alasan;
    	$user->update();

    	return response()->json(['status' => true]);
    }
}
