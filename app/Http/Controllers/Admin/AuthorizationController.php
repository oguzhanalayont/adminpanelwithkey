<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function index()
{
    $users = User::where('is_admin', false)->get();
    $managers = User::where('role', 'manager')->get();

    return view('admin.authorization', compact('users', 'managers'));
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
    public function revokeManager($id)
{
    $user = \App\Models\User::findOrFail($id);
    $user->role = 'user'; // veya null, sistemine göre değişebilir
    $user->save();

    return redirect()->back()->with('success', 'Manager yetkisi kaldırıldı.');
}

}

