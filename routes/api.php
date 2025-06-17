<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Api\UserAccessController;

/*
|--------------------------------------------------------------------------
| Kullanıcı Giriş Doğrulama
|--------------------------------------------------------------------------
*/
Route::post('/authenticate', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Geçersiz kullanıcı bilgileri.'
        ], 401);
    }

    if (!$user->can_use_notepad) {
        return response()->json([
            'message' => 'Bu kullanıcı not defteri uygulamasını kullanamaz.'
        ], 403);
    }

    return response()->json([
        'message' => 'Giriş başarılı.',
        'user' => [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
        ]
    ]);
});

/*
|--------------------------------------------------------------------------
| Belirli Ürün İçin Yetkili Kullanıcılar (product_id bazlı)
|--------------------------------------------------------------------------
| Örn: /api/authorized-users/notepad
*/
Route::get('/authorized-users/{productName}', [UserAccessController::class, 'authorized']);
