<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();


    $cartItems = CartItem::where('user_id', $user->id)->with(['product' => function($query) {
        $query->select('id', 'name', 'price')->with(['images' => function($q) {
            $q->select('product_id', 'url')->take(1); // Get only the first image
        }]);
    }])->get()->map(function($cartItem) {
        return [
            'product_id' => $cartItem->product_id,
            'name' => $cartItem->product->name,
            'price' => $cartItem->product->price,
            'image' => $cartItem->product->images->first()->url ?? null,
            'quantity' => $cartItem->quantity,
        ];
    });

    return response()->json(['items' => $cartItems]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::updateOrCreate(
            ['user_id' => $user->id, 'product_id' => $data['product_id']],
            ['quantity' => $data['quantity']]
        );

        return response()->json(['item' => $cartItem]);
    }

    public function destroy($productId)
    {
        $user = Auth::user();
        CartItem::where('user_id', $user->id)->where('product_id', $productId)->delete();

        return response()->json(['message' => 'Item removed']);
    }

    public function update(Request $request, $productId)
    {
        $data = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $cartItem = CartItem::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $data['quantity']]);
        }

        return response()->json(['item' => $cartItem]);
    }
}
