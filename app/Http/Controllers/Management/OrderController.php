<?php

namespace App\Http\Controllers\Management;

use App\Docs;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\Management\OrderUpdateRequest;

#[Docs\FeatureTag('Orders (Management)')]
class OrderController extends Controller
{
    #[
        Docs\Http\Methods\Get(
            path: '/api/manage/orders',
            secured: true,
        ),
        Docs\Http\Responses\Ok,
    ]
    public function index()
    {
        return Order::paginate(20);
    }

    #[
        Docs\Http\Methods\Get(
            path: '/api/manage/orders/{id}',
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
    public function show(Order $order)
    {
        return $order;
    }
    
    #[
        Docs\Http\Methods\Get(
            path: '/api/manage/orders/{id}/products',
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
    public function showProducts(Order $order)
    {
        return $order->products;
    }
}
