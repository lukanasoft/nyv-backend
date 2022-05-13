<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Get all products api paging sort by importance with photos, brand, category
    // filter by catrgory if exist in url
    // order by importance
    public function getAllProducts(Request $request)
    {
        $products = Product::with('brand', 'category', 'photos')
        ->when($request->categoryId, function ($query) use ($request) {
            return $query->where('category_id', $request->categoryId);
        })
        ->when($request->search, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%');
        })
        ->orderBy('importance', 'desc')
        ->paginate($request->perPage);
        return response()->json($products);
    }

    // Get a single product api
    public function getProduct($id)
    {
        $product = Product::find($id);
        $product->photos;
        $product->brand;
        $product->category;
        // return product with photos, brand, category
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
        // upload photos to s3 and save the url to the database
        $photos = $request->file('photos');
        $urls = [];
        foreach ($photos as $photo) {
            //replace white space with underscore
            $name = str_replace(' ', '_', $request->name);
            $url = Storage::disk('s3')->put('/website/products/'. $name, $photo);
            // get complete url
            $fullPath = Storage::disk('s3')->url($url);
            array_push($urls, [
                'url' => $fullPath,
                'name' => $url
            ]);
        }
        $product = Product::create([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'aplication' => $request->application,
            'importance' => $request->importance,
            'brand_id' => $request->brand,
            'category_id' => $request->category,
            'user_id' => $request->user_id,
        ]);
        $product->photos()->createMany($urls);
        //return product with photos
        return response()->json($product, 201);
    }

    // Update a product
    public function update(Request $request)
    {
        $photos = $request->file('photos');
        $urls = [];
        // if photos exist
        if ($photos) {
            foreach ($photos as $photo) {
                //replace white space with underscore
                $name = str_replace(' ', '_', $request->name);
                $url = Storage::disk('s3')->put('/website/products/'. $name, $photo);
                // get complete url
                $fullPath = Storage::disk('s3')->url($url);
                array_push($urls, [
                    'url' => $fullPath,
                    'name' => $url
                ]);
            }
        }
        //update product
        $product = Product::find($request->id);
        $product->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'aplication' => $request->application,
            'importance' => $request->importance,
            'brand_id' => $request->brand,
            'category_id' => $request->category,
            'user_id' => $request->user_id,
        ]);

        //if urls size is greater than 0
        if (count($urls) > 0) {
            $product->photos()->createMany($urls);
        }
        // return product with photos
        return response()->json([
            "id" => $product->id,
            "name" => $product->name,
            "code" => $product->code,
            "description" => $product->description,
            "aplication" => $product->aplication,
            "importance" => $product->importance,
            "brand_id" => $product->brand_id,
            "brand" => $product->brand,
            "category" => $product->category,
            "photos" => $product->photos,
            "user_id" => $product->user_id,
        ], 201);
    }

    // Delete a product
    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        //clear all photos from s3
        foreach ($product->photos as $photo) {
            Storage::disk('s3')->delete($photo->name);
        }
        $product->delete();
        return response()->json(null, 204);
    }

    public function deletePhoto(Request $request)
    {
        $product = Product::find($request->id);
        $photo = $product->photos()->where('id', $request->photoId)->first();
        Storage::disk('s3')->delete($photo->name);
        $photo->delete();
        return response()->json(null, 204);
    }
}
