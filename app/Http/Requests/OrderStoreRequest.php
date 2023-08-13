<?php

namespace App\Http\Requests;

use App\Enums\Order\OrderAttributeName;
use App\Enums\Order\OrderProductAttributeName;
use App\Enums\Product\ProductAttributeName;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'items' => 'required|array|min:1',
            $this->buildItemAttributeName(ProductAttributeName::ID) => 'required|exists:' . (new Product)->getTable() . ',id',
            $this->buildItemAttributeName(OrderProductAttributeName::QUANTITY) => 'required|integer|min:1',
        ];
    }

    public function buildItemAttributeName(string $attributeName)
    {
        return 'items.*.' . $attributeName;
    }
}
