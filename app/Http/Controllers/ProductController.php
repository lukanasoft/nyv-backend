<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // Get all products api paging sort by importance with photos, brand, category
    // filter by catrgory if exist in url
    // order by importance
    public function getAllProducts(Request $request)
    {
        $products = Product::with('brand', 'category', 'photos')
        ->when($request->category_id, function ($query) use ($request) {
            return $query->where('category_id', $request->categoryId);
        })
        ->orderBy('importance', 'desc')
        ->paginate($request->perPage);
        return response()->json($products);
    }

    // Get a single product api
    public function getProduct($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    // Store a new product
    public function store(Request $request)
    {
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    //Store a product with photos
    public function storeWithPhotos(Request $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'code' => $request->code,
            'aplication' => $request->aplication,
            'description' => $request->description,
            'importance' => $request->importance,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'user_id' => $request->user_id
        ]);
        $product->photos()->createMany($request->photos);
        //return product with photos
        return response()->json($product->load('photos'), 201);
    }

    // Update a product
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());
        return response()->json($product, 200);
    }

    //Update a product with photos
    public function updateWithPhotos(Request $request, Product $product)
    {
        $product->update($request->all());
        $product->photos()->delete();
        $product->photos()->createMany($request->photos);
        return response()->json($product, 200);
    }

    // Delete a product
    public function delete(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
