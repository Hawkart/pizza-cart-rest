<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function index()
    {
        $items = Category::with(["products"])->get();
        return CategoryResource::collection($items);
    }

    public function show($id)
    {
        $category = Category::findOrFail($id);
        $category->load("products");
        return new CategoryResource($category);
    }
}