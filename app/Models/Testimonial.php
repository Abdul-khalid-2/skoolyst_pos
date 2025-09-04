<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'customer_name',
        'customer_position',
        'company',
        'rating',
        'testimonial',
        'is_active',
        'avatar_path',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_active' => 'boolean',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
    
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar_path) {
            return asset('storage/' . $this->avatar_path);
        }
        
        // Default avatar based on gender or use a generic one
        return asset('backend/assets/images/default_avatar.jpg');
    }
    
    public function getStarsAttribute(): array
    {
        $stars = [];
        for ($i = 1; $i <= 5; $i++) {
            $stars[] = $i <= $this->rating ? 'full' : 'empty';
        }
        return $stars;
    }
}