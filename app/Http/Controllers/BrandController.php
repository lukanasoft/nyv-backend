<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    // Get all brands api
    public function getAllBrands()
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    // Get all brands with images is not null
    public function getAllBrandsWithImages()
    {
        $brands = Brand::where('image', '!=', null)->get();
        return response()->json($brands);
    }

    // Get a single brand api
    public function getBrand($id)
    {
        $brand = Brand::find($id);
        return response()->json($brand);
    }

    // Store a new brand
    public function store(Request $request)
    {
        $brand = Brand::create([
            'name' => $request->name,
        ]);
        if($request->images) {
            //store to s3
            $brands = $request->file('images');
            $name = str_replace(' ', '_', $request->name);
            $url = Storage::disk('s3')->put('/website/brands/'. $name, $brands[0]);
            $fullPath = Storage::disk('s3')->url($url);
            $brand->image = $fullPath;
            $brand->image_path = $url;
            $brand->save();
        }
        return response()->json($brand, 201);
    }

    // Update a brand
    public function update(Request $request)
    {
        $brand = Brand::find($request->id);
        $brand->name = $request->name;
        if($request->images) {
            //store to s3
            $brands = $request->file('images');
            $name = str_replace(' ', '_', $request->name);
            $url = Storage::disk('s3')->put('/website/brands/'. $name, $brands[0]);
            $fullPath = Storage::disk('s3')->url($url);
            $brand->image = $fullPath;
            $brand->image_path = $url;
        }
        $brand->save();
        return response()->json($brand, 200);
    }

    public function deleteImage(Request $request)
    {
        $brand = Brand::find($request->id);
        Storage::disk('s3')->delete($brand->image_path);
        $brand->image = null;
        $brand->image_path = null;
        //delete from s3
        $brand->save();
        return response()->json($brand, 200);
    }

    // Delete a brand
    public function delete(Request $request)
    {
        $brand = Brand::find($request->id);
        if($brand->image) {
            Storage::disk('s3')->delete($brand->image_path);
        }
        $brand->delete();
        return response()->json($brand, 200);
    }
}
