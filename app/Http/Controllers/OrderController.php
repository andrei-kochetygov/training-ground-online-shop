<?php

namespace App\Http\Controllers;

use App\Docs;
use App\Enums\Order\OrderProductAttributeName;
use App\Enums\Product\ProductAttributeName;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderStoreRequest;
use App\Models\Product;

#[Docs\FeatureTag('Orders')]
class OrderController extends Controller
{
    #[
        Docs\Http\Methods\Post(
            path: '/api/orders',
        ),
        Docs\Http\Requests\Json(
            items: [
                [
                    'id' => 1,
                    'quantity' => 2,
                ],
            ],
        ),
        Docs\Http\Responses\Ok,
    ]
    public function store(OrderStoreRequest $request)
    {
        $order = new Order();

        $order->save();
        
        $items = collect($request->items)->keyBy(ProductAttributeName::ID);

        $productsIds = (clone $items)->pluck(ProductAttributeName::ID)->toArray();

        $products = Product::whereIn('id', $productsIds)->get();

        foreach ($products as $product) {
            $order->products()->attach($product->id, [
                OrderProductAttributeName::QUANTITY => $items[$product->id][OrderProductAttributeName::QUANTITY],
                OrderProductAttributeName::PRICE => $product->price,
            ]);

            $order->total_price += $items[$product->id][OrderProductAttributeName::QUANTITY] * $product->price;
        }

        $order->save();

        return $order;
    }
}
