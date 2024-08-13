<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'last_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required',
            'payment_method' => 'required',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'apartment' => $request->apartment,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'subtotal' => 0,
            'shipping' => 17.91,
            'total' => 0,
        ]);

        $subtotal = 0;
        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $orderItem = new OrderItem([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
            $order->orderItems()->save($orderItem);
            $subtotal += $product->price * $item['quantity'];
        }

        $order->subtotal = $subtotal;
        $order->total = $subtotal + $order->shipping;
        $order->save();

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order->load('orderItems.product'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
