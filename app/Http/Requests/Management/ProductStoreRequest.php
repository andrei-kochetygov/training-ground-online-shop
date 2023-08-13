<?php

namespace App\Http\Requests\Management;

use App\Models\Category;
use App\Http\Requests\SecuredFormRequest;
use App\Enums\Product\ProductAttributeName;

class ProductStoreRequest extends SecuredFormRequest
{

    public function rules()
    {
        return [
            ProductAttributeName::CATEGORY_ID => 'required|exists:' . (new Category)->getTable() . ',id',
            ProductAttributeName::NAME => 'required|string|max:255',
            ProductAttributeName::DESCRIPTION => 'required|string|max:65535',
            ProductAttributeName::PRICE => 'required|numeric|min:0',
        ];
    }
}
