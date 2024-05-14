<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'product_id', 'rating', 'comment'];

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function response_review()
    {
        return $this->hasOne(Response_review::class, 'review_id', 'id');
    }

    public function review_likes()
    {
        return $this->hasMany(Review_like::class,'review_id','id');
    }
}
