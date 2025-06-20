<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'invoice_number',
        'customer_id',
        'user_id',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'shipping_amount',
        'total_amount',
        'amount_paid',
        'change_amount',
        'payment_status',
        'status',
        'notes',
        'sale_date',
        'walk_in_customer_info',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'change_amount' => 'decimal:2',
        'sale_date' => 'datetime',
        'walk_in_customer_info' => 'array',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function payments()
    {
        return $this->hasMany(SalePayment::class);
    }

    public function returns()
    {
        return $this->hasMany(ReturnProduct::class);
    }


    // In Sale model

    public function getRemainingBalanceAttribute()
    {
        return $this->total_amount - $this->amount_paid;
    }

    public function getPaymentStatusAttribute()
    {
        if ($this->amount_paid >= $this->total_amount) {
            return 'paid';
        } elseif ($this->amount_paid > 0) {
            return 'partial';
        } else {
            return 'unpaid';
        }
    }

    public function scopeUnpaid($query)
    {
        return $query->whereRaw('amount_paid < total_amount');
    }

    public function scopePartiallyPaid($query)
    {
        return $query->whereRaw('amount_paid > 0 AND amount_paid < total_amount');
    }
}
