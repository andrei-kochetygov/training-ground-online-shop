<?php

namespace App\Http\Requests\Management;

use App\Http\Requests\SecuredFormRequest;
use App\Enums\Category\CategoryAttributeName;

class CategoryUpdateRequest extends SecuredFormRequest
{
    public function rules()
    {
        return [
            CategoryAttributeName::NAME => 'required|string|max:255',
        ];
    }
}
