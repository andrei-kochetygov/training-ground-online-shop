<?php

namespace App\Http\Controllers\Management;

use App\Docs;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\CategoryStoreRequest;
use App\Http\Requests\Management\CategoryUpdateRequest;

#[Docs\FeatureTag('Categories (Management)')]
class CategoryController extends Controller
{
    #[
        Docs\Http\Methods\Get(
            path: '/api/manage/categories',
            secured: true,
        ),
        Docs\Http\Responses\Ok,
    ]
    public function index()
    {
        return Category::all();
    }

    #[
        Docs\Http\Methods\Post(
            path: '/api/manage/categories',
            secured: true,
        ),
        Docs\Http\Requests\Json(
            name: 'Athletic',
        ),
        Docs\Http\Responses\Created,
    ]
    public function store(CategoryStoreRequest $request)
    {
        $category = new Category();

        $category->fill($request->validated());

        $category->save();

        return $category;
    }

    #[
        Docs\Http\Methods\Get(
            path: '/api/manage/categories/{id}',
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
    public function show(Category $category)
    {
        return $category;
    }

    #[
        Docs\Http\Methods\Put(
            path: '/api/manage/categories/{id}',
            secured: true,
        ),
        Docs\Http\Requests\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            example: 1,
        ),
        Docs\Http\Requests\Json(
            name: 'Casual',
        ),
        Docs\Http\Responses\Ok,
    ]
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->fill($request->validated());

        $category->save();

        return $category;
    }

    #[
        Docs\Http\Methods\Delete(
            path: '/api/manage/categories/{id}',
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
    public function destroy(Category $category)
    {
        $category->delete();

        return $category;
    }

    #[
        Docs\Http\Methods\Get(
            path: '/api/manage/categories/{id}/products',
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
