<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function items()
    {
        return $this->hasMany(Order_item::class);
    }
    protected $fillable = [
        'id',
        'user_id',
        'address',
        'name',
        'phone',
        'email',
        'order_status',
        'payment_method',
        'payment_status',
        'sub_total',
        'shipping',
        'tracking',
        'amount',
        'note',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderItems()
    {
        return $this->hasMany(Order_item::class);
    }
}
