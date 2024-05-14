<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response_review extends Model
{
    use HasFactory;
    protected $fillable = ['review_id', 'comment'];
}
