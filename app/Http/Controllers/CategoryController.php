<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Get all categories api
    public function getAllCategories(Request $request)
    {
        // get all parents categories and their children
        $categories = Category::with('children')
        ->where('category_id', null)
        ->when($request->search, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%');
        })
        ->get();
        return response()->json($categories);
    }

    // Get a single category api
    public function getCategory($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    // Store a new category
    public function store(Request $request)
    {
        $category = Category::create(['name' => $request->name]);
        // if has children add them
        if ($request->has('children')) {
            $category->children()->createMany($request->children);
        }
        return response()->json([
            "name" => $category->name,
            "id" => $category->id,
            "created_at" => $category->created_at,
            "updated_at" => $category->updated_at,
            "children" => $category->children()->get()
        ], 201);
    }

    // Update a category
    public function update(Request $request)
    {
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->save();
        // update children
        if ($request->has('children')) {
            $category->children()->delete();
            $category->children()->createMany($request->children);
        }
        return response()->json([
            "name" => $category->name,
            "id" => $category->id,
            "created_at" => $category->created_at,
            "updated_at" => $category->updated_at,
            "children" => $category->children()->get()
        ], 200);
    }

    // Delete a category
    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        $category->delete();
        return response()->json(null, 204);
    }
}
