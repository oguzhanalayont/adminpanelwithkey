<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\License;

class ProductPermissionController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::where('is_admin', false)->where('is_manager', false)->get();
        $licenses = auth()->user()->licenses()->with('product')->get();
        return view('manager.permissions', compact('users', 'licenses'));
    }


    public function giveAccess(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'license_id' => 'required|exists:licenses,id',
    ]);

    $targetUser = User::where('email', $request->email)->first();
    $existingLicense = License::findOrFail($request->license_id);

    if ($targetUser) {
        // Yeni bir lisans oluştur ve bu kullanıcıya ata (aynı ürünle)
        License::create([
            'user_id' => $targetUser->id,
            'product_id' => $existingLicense->product_id,
            'start_date' => $existingLicense->start_date,
            'end_date' => $existingLicense->end_date,
            'usage_count' => 0,
            'is_active' => false,
        ]);

        return back()->with('success', 'Kullanıcıya ürün kullanım yetkisi verildi.');
    }

    return back()->with('error', 'Kullanıcı bulunamadı.');
}
}