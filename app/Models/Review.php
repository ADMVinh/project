<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'order_item_id',
        'rating',
        'title',
        'comment',
        'verified_purchase',
        'status',
        'parent_id'
    ];

    protected $casts = [
        'verified_purchase' => 'boolean',
        'rating' => 'integer',
    ];

    // Relationship với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship với OrderItem
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    // Relationship với parent review (cho replies)
    public function parent()
    {
        return $this->belongsTo(Review::class, 'parent_id');
    }

    // Relationship với replies
    public function replies()
    {
        return $this->hasMany(Review::class, 'parent_id')->where('status', 'approved');
    }

    // Scope cho approved reviews
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Scope cho reviews không có parent (không phải reply)
    public function scopeParentReviews($query)
    {
        return $query->whereNull('parent_id');
    }

    // Check if review is a reply
    public function isReply()
    {
        return !is_null($this->parent_id);
    }

    // Check if user can edit this review
    public function canEdit($userId)
    {
        return $this->user_id == $userId && $this->created_at->diffInHours(now()) < 24;
    }
}