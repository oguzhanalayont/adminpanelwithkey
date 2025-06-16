<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LicenseUsage;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $usages = LicenseUsage::with(['license.user', 'license.product'])->latest()->get();
        return view('admin.reports.index', compact('usages'));
    }
}
