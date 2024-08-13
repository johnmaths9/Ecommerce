<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::select('id', 'name', 'price', 'old_price','slug')
            ->with(['images:id,product_id,url'])
            ->withAvg('reviews', 'rating')
            ->get()
            ->map(function ($product) {
                $product->reviews_avg_rating = $product->reviews_avg_rating ?: 0; // Set 0 if null
                return $product;
            });

        return response()->json($products);
    }

    public function show($slug)
    {
        $product = Product::with(['images', 'reviews', 'category'])
            ->withAvg('reviews', 'rating')
            ->where('slug', $slug)
            ->firstOrFail();

        $product->reviews_avg_rating = $product->reviews_avg_rating ?: 0; // Set 0 if null

        return response()->json($product);
    }
}
