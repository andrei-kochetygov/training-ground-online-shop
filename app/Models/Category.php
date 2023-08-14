<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Database\TableName;
use App\Enums\Category\CategoryAttributeName;
use App\Enums\Product\ProductAttributeName;
use App\Models\Traits\SimpleJsonPaginateTrait;

class Category extends Model
{
    use HasFactory, SoftDeletes, SimpleJsonPaginateTrait;

    protected $table = TableName::CATEGORIES;

    protected $primaryKey = CategoryAttributeName::ID;

    protected $fillable = [
        CategoryAttributeName::NAME,
    ];

    public function products()
    {
        return $this->hasMany(Product::class, ProductAttributeName::CATEGORY_ID, (new Category)->getKeyName());
    }
}
