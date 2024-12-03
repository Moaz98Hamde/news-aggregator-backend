<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class ListCategoriesController extends Controller
{
    public function __invoke(Request $request)
    {
        $categories = Category::paginate();
        return CategoryResource::collection($categories);
    }
}
