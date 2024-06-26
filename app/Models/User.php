<?php
  
namespace App\Models;
  
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
  
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
     public function wishes()
     {
         return $this->hasMany(Wish::class);
     }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function products()
    {
        return $this->hasMany(product::class);
    }
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        'provider_id',
        'provider',
        'utype',
        'profile_photo_path',
    ]; 
 
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];
  
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
  
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    // protected $appends = [
    //     'profile_photo_url',
    // ];
}