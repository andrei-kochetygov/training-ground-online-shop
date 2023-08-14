<?php

namespace App\Http\Controllers;

use App\Docs;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

#[Docs\FeatureTag('Products')]
class ProductController extends Controller
{
    #[
        Docs\Http\Methods\Get(
            path: '/api/products',
        ),
        Docs\Http\Requests\Parameter(
            name: 'page',
            in: 'query',
            example: 1,
        ),
        Docs\Http\Requests\Parameter(
            name: 'per_page',
            in: 'query',
            example: 20,
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
    public function index(Request $request)
    {
        return Product::simpleJsonPaginate($request->get('per_page') ?? 20);
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
}
