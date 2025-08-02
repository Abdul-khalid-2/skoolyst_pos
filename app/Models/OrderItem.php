<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'tenant_id',
        'order_id',
        'product_id',
        'variant_id',
        'quantity',
        'unit_price',
        'cost_price',
        'total_price'
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product that owns the order item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant that owns the order item.
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
