<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Database\TableName;
use App\Enums\Product\ProductAttributeName;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = TableName::PRODUCTS;

    protected $primaryKey = ProductAttributeName::ID;

    protected $fillable = [
        ProductAttributeName::CATEGORY_ID,
        ProductAttributeName::NAME,
        ProductAttributeName::DESCRIPTION,
        ProductAttributeName::PRICE,
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, ProductAttributeName::CATEGORY_ID, (new Category)->getKeyName());
    }
}
