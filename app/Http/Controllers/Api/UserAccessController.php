<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\License;

class UserAccessController extends Controller
{
    public function authorized($productName)
    {
        $product = \App\Models\Product::whereRaw('LOWER(name) = ?', [strtolower($productName)])->first();


        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        $licenses = License::where('product_id', $product->id)->with('user')->get();

        $users = $licenses->pluck('user')->unique('id')->values();

        return response()->json($users);
    }
}
