<?php

namespace App\Http\Requests\Management;

use App\Models\Product;
use App\Http\Requests\SecuredFormRequest;
use App\Enums\Order\OrderAttributeName;
use App\Enums\Order\OrderProductAttributeName;
use App\Enums\Product\ProductAttributeName;

class OrderUpdateRequest extends SecuredFormRequest
{
    public function rules()
    {
        return [
            $this->buildItemAttributeName(ProductAttributeName::ID) => 'required|exists:' . (new Product)->getTable() . ',id',
            $this->buildItemAttributeName(OrderProductAttributeName::QUANTITY) => 'required|integer|min:1',
        ];
    }

    public function buildItemAttributeName(string $attributeName)
    {
        return 'items.*.' . $attributeName;
    }
}
