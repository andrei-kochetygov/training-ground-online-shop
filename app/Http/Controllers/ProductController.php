<?php

namespace App\Http\Controllers;

use App\Docs;
use App\Models\Product;
use App\Http\Controllers\Controller;

#[Docs\FeatureTag('Products')]
class ProductController extends Controller
{
    #[
        Docs\Http\Methods\Get(
            path: '/api/products',
        ),
        Docs\Http\Responses\Ok,
    ]
    public function index()
    {
        return Product::all();
    }

    #[
        Docs\Http\Methods\Get(
            path: '/api/products/{id}',
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
}
