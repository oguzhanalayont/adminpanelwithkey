<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function index()
    {
        return view('admin.authorization');
    }

    public function assignManager(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if ($user) {
            $user->is_manager = true;
            $user->role = 'manager';
            $user->save();
            return back()->with('success', 'Kullanıcıya manager yetkisi verildi.');
        }

        return back()->with('error', 'Kullanıcı bulunamadı.');
    }
}

