<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnProduct extends Model
{
    use HasFactory;
    protected $table = 'returns';

    protected $fillable = [
        'tenant_id',
        'sale_id',
        'customer_id',
        'user_id',
        'return_number',
        'total_amount',
        'status',
        'reason',
        'return_date',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'return_date' => 'datetime',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
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
        return $this->hasMany(ReturnItem::class);
    }
}
