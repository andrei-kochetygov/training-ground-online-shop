<?php

namespace App\Http\Controllers\Management;

use App\Docs;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\ProductStoreRequest;
use App\Http\Requests\Management\ProductUpdateRequest;

#[Docs\FeatureTag('Products (Management)')]
class ProductController extends Controller
{
    #[
        Docs\Http\Methods\Get(
            path: '/api/manage/products',
            secured: true,
        ),
        Docs\Http\Responses\Ok,
    ]
    public function index()
    {
        return Product::all();
    }

    #[
        Docs\Http\Methods\Post(
            path: '/api/manage/products',
            secured: true,
        ),
        Docs\Http\Requests\Json(
            category_id: 1,
            name: 'Nike Air Max 90',
            description: 'The Nike Air Max 90 stays true to its OG running roots with the iconic Waffle outsole, stitched overlays and classic, colour-accented TPU plates. Retro colours celebrate the first generation while Max Air cushioning adds comfort to your journey.',
            price: 139.99,
            stock: 10,
        ),
        Docs\Http\Responses\Created,
    ]
    public function store(ProductStoreRequest $request)
    {
        $product = new Product();

        $product->fill($request->validated());

        $product->save();

        return $product;
    }

    #[
        Docs\Http\Methods\Get(
            path: '/api/manage/products/{id}',
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
    public function show(Product $product)
    {
        return $product;
    }

    #[
        Docs\Http\Methods\Put(
            path: '/api/manage/products/{id}',
            secured: true,
        ),
        Docs\Http\Requests\Parameter(
            name: 'id',
            in: 'path',
            required: true,
            example: 1,
        ),
        Docs\Http\Requests\Json(
            category_id: 1,
            name: 'Nike Air Max 80',
            description: 'The Nike Air Max 80 stays true to its OG running roots with the iconic Waffle outsole, stitched overlays and classic, colour-accented TPU plates. Retro colours celebrate the first generation while Max Air cushioning adds comfort to your journey.',
            price: 119.99,
        ),
        Docs\Http\Responses\Ok,
    ]
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->fill($request->validated());

        $product->save();

        return $product;
    }
    
    #[
        Docs\Http\Methods\Delete(
            path: '/api/manage/products/{id}',
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
    public function destroy(Product $product)
    {
        $product->delete();

        return $product;
    }
}
