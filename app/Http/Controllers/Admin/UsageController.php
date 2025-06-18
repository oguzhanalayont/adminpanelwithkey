<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductUsage;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UsageController extends Controller
{
    public function start(Request $request)
    {
        Log::info('START:', $request->all());
        Log::info('Kullanıcı giriş yapıyor: ' . $request->email);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::warning("Kullanıcı bulunamadı (START): " . $request->email);
            return response()->json(['status' => 'user not found'], 404);
        }

        $existing = ProductUsage::where('user_id', $user->id)
            ->where('product', $request->product)
            ->whereNull('ended_at')
            ->first();

        if ($existing) {
            Log::info('Zaten açık bir kullanım var: ID=' . $existing->id . ', started_at=' . $existing->started_at);
        } else {
            $now = now();
            $new = ProductUsage::create([
                'user_id' => $user->id,
                'product' => $request->product,
                'started_at' => $now,
            ]);

            Log::info('Yeni ProductUsage kaydedildi: ID=' . $new->id . ', started_at=' . $new->started_at);
        }

        return response()->json(['status' => 'started']);
    }

    public function stop(Request $request)
    {
        Log::info('STOP:', $request->all());

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            Log::warning("Kullanıcı bulunamadı (STOP): " . $request->email);
            return response()->json(['status' => 'user not found'], 404);
        }

        $usage = ProductUsage::where('user_id', $user->id)
            ->where('product', $request->product)
            ->whereNull('ended_at')
            ->latest('started_at')
            ->first();

        if ($usage) {
            Log::info('Kapanacak kullanım kaydı bulundu: ID=' . $usage->id . ', started_at=' . $usage->started_at . ', mevcut ended_at=' . $usage->ended_at);

            $usage->ended_at = now();
            $usage->save();

            Log::info('ProductUsage durduruldu: ' . $user->email . ' | ID: ' . $usage->id . ' | ended_at=' . $usage->ended_at);
            return response()->json(['status' => 'stopped']);
        } else {
            Log::warning('Aktif kullanım kaydı bulunamadı, durdurma atlandı.');
            return response()->json(['status' => 'no active usage found'], 404);
        }
    }
}
