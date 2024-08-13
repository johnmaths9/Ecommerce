<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AdminProductController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Product::with('category', 'images', 'reviews')
    ->where('name', 'like', "%{$search}%")
    ->orderBy($sortField, $sortDirection)
    ->withAvg('reviews', 'rating')
    ->paginate($perPage);

    $products = $query->through(function ($product) {
        $product->reviews_avg_rating = $product->reviews_avg_rating ?: 0; // Set 0 if null
        return $product;
    });

        return response()->json($products);
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string|max:255',
        'availability' => 'required|string|max:255',
        'brand' => 'required|string|max:255',
        'price' => 'required|numeric',
        'old_price' => 'nullable|numeric',
        'discount_percentage' => 'nullable|integer',
        'description' => 'nullable|string',
        'details' => 'nullable|string',
        'category_id' => 'required|exists:categories,id',
        'colors' => 'nullable|array',
        'colors.*' => 'string',
        'sizes' => 'nullable|array',
        'sizes.*' => 'string',
        'images' => 'nullable|array',
        'images.*.name' => 'required|string',
        'images.*.type' => 'required|string',
        'images.*.content' => 'required|string',
    ]);

    // Remove empty arrays
    if (empty($data['colors'])) {
        unset($data['colors']);
    }
    if (empty($data['sizes'])) {
        unset($data['sizes']);
    }

    // Remove images from $data as we'll handle them separately
    $images = $data['images'] ?? [];
    unset($data['images']);

    $product = Product::create($data);

    if (!empty($images)) {
        $this->saveImages($images, $product);
    }

    return response()->json($product, 201);
}



    public function show(Product $product)
    {
        $product->load('category', 'images', 'reviews');
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'availability' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'discount_percentage' => 'nullable|integer',
            'description' => 'nullable|string',
            'details' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'colors' => 'nullable|array',
            'sizes' => 'nullable|array',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'numeric',
            'new_images' => 'nullable|array',
            'new_images.*.name' => 'required|string',
            'new_images.*.type' => 'required|string',
            'new_images.*.content' => 'required|string',
        ]);

        $product->update($data);

        $new_images = $data['new_images'] ?? [];
        unset($data['new_images']);

        if (!empty($new_images)) {
            $this->saveImages($new_images, $product);
        }

        if ($request->has('deleted_images')) {
            $this->deleteImages($request->input('deleted_images'), $product);
        }

        if ($request->has('name')) {
            $product->slug = Str::slug($request->input('name'));
        }

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->images()->delete();
        $product->reviews()->delete();
        $product->delete();

        return response()->noContent();
    }

    private function saveImages($images, Product $product) {
        foreach ($images as $image) {
            $imageData = explode(',', $image['content']);
            $decodedImage = base64_decode($imageData[1]);
            $path = 'images/' . Str::random();
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0755, true);
            }
            $name = Str::random() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
            Storage::put('public/' . $path . '/' . $name, $decodedImage);

            $relativePath = $path . '/' . $name;

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $relativePath,
                'url' => Storage::url($relativePath),
                'mime' => $image['type'],
                'size' => strlen($decodedImage),
            ]);
        }
    }

    private function deleteImages($imageIds, Product $product)
    {
        $images = ProductImage::where('product_id', $product->id)
            ->whereIn('id', $imageIds)
            ->get();

        foreach ($images as $image) {
            if ($image->path) {
                Storage::delete('public/' . $image->path);
            }
            $image->delete();
        }
    }
}
