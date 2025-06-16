<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'sale_id',
        'product_id',
        'variant_id',
        'quantity',
        'unit_price',
        'cost_price',
        'tax_rate',
        'tax_amount',
        'discount_rate',
        'discount_amount',
        'total_price',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_rate' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
    
    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function returnItems()
    {
        return $this->hasMany(ReturnItem::class);
    }
}
