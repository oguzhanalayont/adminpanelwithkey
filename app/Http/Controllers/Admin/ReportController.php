<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductUsage;
use App\Models\License;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Lisansa bağlı usage kayıtları
        $licenseUsages = [];

        $licenses = License::with(['user', 'product', 'usages'])->get();
        foreach ($licenses as $license) {
            foreach ($license->usages as $usage) {
                $licenseUsages[] = (object)[
                    'user' => $license->user->email ?? '—',
                    'product' => $license->product->name ?? '—',
                    'validity' => ($license->start_date && $license->end_date)
    ? $license->start_date->format('Y-m-d') . ' - ' . $license->end_date->format('Y-m-d')
    : '—',

                    'started_at' => $usage->started_at,
                    'ended_at' => $usage->ended_at,
                ];
            }
        }

        // 2. Notepad gibi bağımsız kullanım kayıtları
        $notepadUsages = ProductUsage::with('user')
            ->orderBy('started_at', 'desc')
            ->get()
            ->map(function ($usage) {
                return (object)[
                    'user' => $usage->user->email ?? '—',
                    'product' => $usage->product,
                    'validity' => '—',
                    'started_at' => $usage->started_at,
                    'ended_at' => $usage->ended_at,
                ];
            });

        // 3. Her iki kaynağı birleştir
        $usages = collect($licenseUsages)->merge($notepadUsages)->sortByDesc('started_at');

        return view('admin.reports.index', compact('usages'));
    }
}
