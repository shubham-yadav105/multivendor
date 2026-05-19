<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'status'
    ];

    public function vendor()
    {
        return $this->belongsTo(User::class, 'vendor_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function review()
    {
        return $this->hasMany(Review::class)
            ->where('is_approved', true)
            ->latest();
    }

    public function averageRating(): float
    {
        return round($this->review()->avg('rating') ?? 0, 1);
    }

    public function reviewsCount(): int
    {
        return $this->review()->count();
    }

    // Rating breakdown (1-5 stars count)
    public function ratingBreakdown(): array
    {
        $breakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $this->review()->where('rating', $i)->count();
            $total = $this->reviewsCount();
            $breakdown[$i] = [
                'count'      => $count,
                'percentage' => $total > 0 ? round(($count / $total) * 100) : 0,
            ];
        }
        return $breakdown;
    }
}
