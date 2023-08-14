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
        Docs\Http\Responses\Ok(
            items: [
                [
                    'id' => 1,
                    'name' => 'Phones',
                    'created_at' => '2023-01-01T00:00:00.000000Z',
                    'updated_at' => '2023-01-01T00:00:00.000000Z',
                    'deleted_at' => null,
                ],
                [
                    'id' => 2,
                    'name' => 'Monitors',
                    'created_at' => '2023-01-01T00:00:00.000000Z',
                    'updated_at' => '2023-01-01T00:00:00.000000Z',
                    'deleted_at' => null,
                ],
            ],
        ),
    ]
    public function index()
    {
        return response()->make([
            'items' => Category::all(),
        ]);
    }

    #[
        Docs\Http\Methods\Post(
            path: '/api/manage/categories',
            secured: true,
        ),
        Docs\Http\Requests\Json(
            name: 'Athletic',
        ),
        Docs\Http\Responses\Created(
            id: 1,
            name: 'Phones',
            created_at: '2023-01-01T00:00:00.000000Z',
            updated_at: '2023-01-01T00:00:00.000000Z',
            deleted_at: null,
        ),
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
        Docs\Http\Responses\Ok(
            id: 1,
            name: 'Phones',
            created_at: '2023-01-01T00:00:00.000000Z',
            updated_at: '2023-01-01T00:00:00.000000Z',
            deleted_at: null,
        ),
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
            name: 'Phones',
        ),
        Docs\Http\Responses\Ok(
            id: 1,
            name: 'Phones',
            created_at: '2023-01-01T00:00:00.000000Z',
            updated_at: '2023-01-01T00:00:00.000000Z',
            deleted_at: null,
        ),
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
        Docs\Http\Responses\Ok(
            id: 1,
            name: 'Phones',
            created_at: '2023-01-01T00:00:00.000000Z',
            updated_at: '2023-01-01T00:00:00.000000Z',
            deleted_at: '2023-01-01T00:00:00.000000Z',
        ),
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
        Docs\Http\Responses\Ok(
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
    public function showProducts(Category $category)
    {
        return response()->make([
            'items' => $category->products,
        ]);
    }
}
