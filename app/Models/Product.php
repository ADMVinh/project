<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class,'brand_id');
    }

    // Thêm vào class Product
        public function reviews()
        {
            return $this->hasMany(Review::class);
        }

        public function approvedReviews()
        {
            return $this->hasMany(Review::class)->approved()->parentReviews()->with('replies', 'user');
        }

        public function averageRating()
        {
            return $this->reviews()->approved()->parentReviews()->avg('rating');
        }

        public function totalReviews()
        {
            return $this->reviews()->approved()->parentReviews()->count();
        }

        public function ratingDistribution()
        {
            return $this->reviews()
                ->approved()
                ->parentReviews()
                ->selectRaw('rating, COUNT(*) as count')
                ->groupBy('rating')
                ->orderBy('rating', 'desc')
                ->pluck('count', 'rating');
        }
}
