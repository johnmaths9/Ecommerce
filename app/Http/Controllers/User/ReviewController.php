<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index($id)
    {
        $product = Product::findOrFail($id);
        $reviews = $product->reviews()
            ->with('user:id,name')
            ->latest()
            ->get();

        return response()->json($reviews);
    }

    public function store(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = new Review([
            'user_id' => Auth::id(), // Assuming the user is authenticated
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $product->reviews()->save($review);

        return response()->json($review->load('user:id,name'), 201);
    }

}
