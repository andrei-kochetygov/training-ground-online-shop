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
        Docs\Http\Responses\Ok(
            pagination: [
                'pages' => [
                    'current' => 1,
                    'last' => 5,
                ],
                'items' => [
                    'per_page' => 20,
                    'from' => 1,
                    'to' => 20,
                    'total' => 100,
                ],
            ],
            items: [
                [        
                    'id' => 1,
                    'category_id' => 1,
                    'name' => 'AirPods Pro',
                    'description' => 'AirPods Pro are sweat and water resistant for non-water sports and exercise. AirPods Pro were tested under controlled laboratory conditions, and have a rating of IPX4 under IEC standard 60529. Sweat and water resistance are not permanent conditions and resistance might decrease as a result of normal wear. Do not attempt to charge wet AirPods Pro; refer to https://support.apple.com/kb/HT210711 for cleaning and drying instructions. The charging case is not sweat or water resistant.',
                    'price' => '249.00',
                    'created_at' => '2023-01-01T00:00:00.000000Z',
                    'updated_at' => '2023-01-01T00:00:00.000000Z',
                    'deleted_at' => null,
                ],
                [        
                    'id' => 2,
                    'category_id' => 3,
                    'name' => 'Apple Watch Series 6',
                    'description' => 'Apple Watch Series 6 lets you measure your blood oxygen level with a revolutionary new sensor and app. Take an ECG from your wrist. See your fitness metrics on the enhanced Always-On Retina display, now 2.5x brighter outdoors when your wrist is down. Set a bedtime routine and track your sleep. And reply to calls and messages right from your wrist. It’s the ultimate device for a healthier, more active, more connected life.',
                    'price' => '399.00',
                    'created_at' => '2023-01-01T00:00:00.000000Z',
                    'updated_at' => '2023-01-01T00:00:00.000000Z',
                    'deleted_at' => null,
                ],
            ],
        ),
    ]
    public function index()
    {
        return Product::simpleJsonPaginate(20);
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
        Docs\Http\Responses\Created(
            id: 1,
            category_id: 1,
            name: 'AirPods Pro',
            description: 'AirPods Pro are sweat and water resistant for non-water sports and exercise. AirPods Pro were tested under controlled laboratory conditions, and have a rating of IPX4 under IEC standard 60529. Sweat and water resistance are not permanent conditions and resistance might decrease as a result of normal wear. Do not attempt to charge wet AirPods Pro; refer to https://support.apple.com/kb/HT210711 for cleaning and drying instructions. The charging case is not sweat or water resistant.',
            price: '249.00',
            created_at: '2023-01-01T00:00:00.000000Z',
            updated_at: '2023-01-01T00:00:00.000000Z',
            deleted_at: null,
        ),
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
        Docs\Http\Responses\Ok(
            id: 1,
            category_id: 1,
            name: 'AirPods Pro',
            description: 'AirPods Pro are sweat and water resistant for non-water sports and exercise. AirPods Pro were tested under controlled laboratory conditions, and have a rating of IPX4 under IEC standard 60529. Sweat and water resistance are not permanent conditions and resistance might decrease as a result of normal wear. Do not attempt to charge wet AirPods Pro; refer to https://support.apple.com/kb/HT210711 for cleaning and drying instructions. The charging case is not sweat or water resistant.',
            price: '249.00',
            created_at: '2023-01-01T00:00:00.000000Z',
            updated_at: '2023-01-01T00:00:00.000000Z',
            deleted_at: null,
        ),
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
        Docs\Http\Responses\Ok(
            id: 1,
            category_id: 1,
            name: 'AirPods Pro',
            description: 'AirPods Pro are sweat and water resistant for non-water sports and exercise. AirPods Pro were tested under controlled laboratory conditions, and have a rating of IPX4 under IEC standard 60529. Sweat and water resistance are not permanent conditions and resistance might decrease as a result of normal wear. Do not attempt to charge wet AirPods Pro; refer to https://support.apple.com/kb/HT210711 for cleaning and drying instructions. The charging case is not sweat or water resistant.',
            price: '249.00',
            created_at: '2023-01-01T00:00:00.000000Z',
            updated_at: '2023-01-01T00:00:00.000000Z',
            deleted_at: null,
        ),
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
        Docs\Http\Responses\Ok(
            id: 1,
            category_id: 1,
            name: 'AirPods Pro',
            description: 'AirPods Pro are sweat and water resistant for non-water sports and exercise. AirPods Pro were tested under controlled laboratory conditions, and have a rating of IPX4 under IEC standard 60529. Sweat and water resistance are not permanent conditions and resistance might decrease as a result of normal wear. Do not attempt to charge wet AirPods Pro; refer to https://support.apple.com/kb/HT210711 for cleaning and drying instructions. The charging case is not sweat or water resistant.',
            price: '249.00',
            created_at: '2023-01-01T00:00:00.000000Z',
            updated_at: '2023-01-01T00:00:00.000000Z',
            deleted_at: '2023-01-01T00:00:00.000000Z',
        ),
    ]
    public function destroy(Product $product)
    {
        $product->delete();

        return $product;
    }
}
