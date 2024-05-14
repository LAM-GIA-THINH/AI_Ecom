<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review_like extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "review_id",
    ];
}
