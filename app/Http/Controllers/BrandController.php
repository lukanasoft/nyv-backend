<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    // Get all brands api
    public function getAllBrands()
    {
        $brands = Brand::all();
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
        $brand = Brand::create($request->all());
        return response()->json($brand, 201);
    }

    // Update a brand
    public function update(Request $request, Brand $brand)
    {
        $brand->update($request->all());
        return response()->json($brand, 200);
    }

    // Delete a brand
    public function delete(Brand $brand)
    {
        $brand->delete();
        return response()->json(null, 204);
    }
}
