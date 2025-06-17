<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductViewController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user->is_manager) {
            abort(403, 'Bu sayfaya erişim izniniz yok.');
        }

        $products = Product::all();
        return view('products.index', compact('products'));
    }
}
