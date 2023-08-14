<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Database\TableName;
use App\Enums\Order\OrderAttributeName;
use App\Enums\Order\OrderProductAttributeName;
use App\Models\Traits\SimpleJsonPaginateTrait;

class Order extends Model
{
    use HasFactory, SoftDeletes, SimpleJsonPaginateTrait;

    protected $table = TableName::ORDERS;

    protected $primaryKey = OrderAttributeName::ID;

    protected $fillable = [
        OrderAttributeName::USER_ID,
        OrderAttributeName::TOTAL_PRICE,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, OrderAttributeName::USER_ID, (new User)->getKeyName());
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, TableName::ORDERS_PRODUCTS, OrderProductAttributeName::ORDER_ID, OrderProductAttributeName::PRODUCT_ID)->withPivot([
            OrderProductAttributeName::QUANTITY,
            OrderProductAttributeName::PRICE,
        ]);
    }
}
