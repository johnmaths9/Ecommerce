<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $wishlistItems = Wishlist::with(['product.images']) // Assuming the images relationship is on the Product model
        ->where('user_id', $user->id)
        ->get();

        // Format the data for the frontend
        $formattedItems = $wishlistItems->map(function ($wishlistItem) {
        return [
        'id' => $wishlistItem->id,
        'name' => $wishlistItem->product->name,
        'price' => $wishlistItem->product->price,
        'slug' => $wishlistItem->product->slug,
        'old_price' => $wishlistItem->product->old_price,
        'image' => $wishlistItem->product->images->first()->url ?? null, // Get the first image's URL or null
        ];
        });

        return response()->json($formattedItems);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // Retrieve the authenticated user
        $user = Auth::user();

        // Check if the product is already in the wishlist
        $existingWishlistItem = Wishlist::where('user_id', $user->id)
                                         ->where('product_id', $request->product_id)
                                         ->first();

        if ($existingWishlistItem) {
            return response()->json(['message' => 'Product is already in your wishlist'], 409);
        }

        // Create a new wishlist item
        $wishlistItem = new Wishlist();
        $wishlistItem->user_id = $user->id;
        $wishlistItem->product_id = $request->product_id;
        $wishlistItem->save();

        // Load the related product for the response
        $wishlistItem->load('product');

        return response()->json($wishlistItem, 201);
    }

    public function destroy($id)
    {
        $wishlistItem = Wishlist::where('user_id', auth()->id())->find($id);

    if (!$wishlistItem) {
        return response()->json(['message' => 'Item not found'], 404);
    }

    $wishlistItem->delete();

    return response()->json(['message' => 'Item removed from wishlist'], 200);
    }
}
