<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = ['quantity_sold'];
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function wishes()
    {
        return $this->hasMany(Wish::class, 'product_id', 'id');
    }

    public function getQuantitySoldAttribute()
    {
        $orders = Order::where(['order_status' => '3'])->get();
        if ($orders) {
            $quantitySold = $orders->sum(function($order) {
                return $order->orderItems->sum(function($orderItem) {
                    if($orderItem->product->user_id === $this->user_id && $orderItem->product_id === $this->id) {
                        return $orderItem->quantity;
                    }
                    return 0;
                });
            });

            if ($quantitySold) {
                return  $quantitySold;
            }
        }

        return 0;
    }
}
