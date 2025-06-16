<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\License;
use App\Models\LicenseUsage;
use Illuminate\Support\Carbon;

class LicenseController extends Controller
{
    public function index()
    {
        $licenses = auth()->user()
            ->licenses()
            ->with(['product', 'usages'])
            ->get();

        return view('licenses.index', compact('licenses'));
    }


    public function start(License $license)
    {
        $license->is_active = true;
        $license->save();

        \App\Models\LicenseUsage::create([
            'license_id' => $license->id,
            'started_at' => now(),
        ]);

        return redirect()->route('licenses.index');
    }

    public function stop(License $license)
    {
        $license->is_active = false;
        $license->save();

        $usage = $license->usages()->whereNull('ended_at')->latest()->first();
        if ($usage) {
            $usage->ended_at = now();
            $usage->save();
        }

        return redirect()->route('licenses.index');
    }

    public function purchase(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'years' => 'required|integer|min:1'
    ]);

    $user = auth()->user();
    $productId = $request->product_id;
    $yearsToAdd = $request->years;

    $license = \App\Models\License::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

        if ($license) {
        $start = $license->end_date ? \Carbon\Carbon::parse($license->end_date) : now();
        $license->end_date = $start->copy()->addYears($yearsToAdd);
        $license->start_date = $license->start_date ?? now();
        $license->save();
    }

    else {
        $license = \App\Models\License::create([
            'user_id' => $user->id,
            'product_id' => $productId,
            'start_date' => now(),
            'end_date' => now()->addYears($yearsToAdd),
            'usage_count' => 0,
        ]);
    }

    return redirect()->route('licenses.index')->with('success', 'Ürün başarıyla satın alındı.');
}


}

