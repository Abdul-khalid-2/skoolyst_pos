<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'customer_id',
        'user_id',
        'order_number',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'status',
        'source',
        'storage_type',
        'walk_in_customer_info',
        'notes',
        'expires_at'
    ];

    protected $casts = [
        'walk_in_customer_info' => 'array',
        'expires_at' => 'datetime'
    ];

    /**
     * Get the tenant that owns the order.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the branch that owns the order.
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Get the customer that owns the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the user who created the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Scope a query to only include draft orders.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope a query to only include confirmed orders.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include completed orders.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled orders.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Scope a query to only include session orders.
     */
    public function scopeSessionOrders($query)
    {
        return $query->where('storage_type', 'session');
    }

    /**
     * Scope a query to only include database orders.
     */
    public function scopeDatabaseOrders($query)
    {
        return $query->where('storage_type', 'database');
    }
}
