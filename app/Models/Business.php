<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'name',
        'tax_number',
        'registration_number',
        'phone',
        'email',
        'address',
        'logo_path',
        'receipt_header',
        'receipt_footer'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function mainBranch()
    {
        return $this->hasOne(Branch::class)->where('is_main', true);
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo_path ? asset('backend/' . $this->logo_path) : null;
    }

    public function getReceiptHeaderUrlAttribute()
    {
        return $this->receipt_header ? asset('backend/' . $this->receipt_header) : null;
    }

    public function getReceiptFooterUrlAttribute()
    {
        return $this->receipt_footer ? asset('backend/' . $this->receipt_footer) : null;
    }
}
