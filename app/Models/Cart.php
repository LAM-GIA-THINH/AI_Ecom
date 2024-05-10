<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity'];

    protected $appends = ['seller_id'];

    public function product() {
        return $this->hasOne(Product::class, 'id','product_id');
    }

    public function getSellerIdAttribute()
    {
        if ($this->product) {
            return $this->product->user_id;
        }

        return null;
    }
}
