<?php

namespace App\Http\Controllers;

use App\Docs;
use App\Models\Category;
use App\Http\Controllers\Controller;

#[Docs\FeatureTag('Categories')]
class CategoryController extends Controller
{
    #[
        Docs\Http\Methods\Get(
            path: '/api/categories',
        ),
        Docs\Http\Responses\Ok,
    ]
    public function index()
    {
        return Category::all();
    }

    #[
        Docs\Http\Methods\Get(
            path: '/api/categories/{id}/products',
            secured: true,
        ),
        Docs\Http\Requests\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            example: 1,
        ),
        Docs\Http\Responses\Ok,
    ]
    public function showProducts(Category $category)
    {
        return $category->products;
    }
}