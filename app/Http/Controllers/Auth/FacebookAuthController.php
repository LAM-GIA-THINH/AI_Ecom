<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FacebookAuthController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
        
            $facebookUser = Socialite::driver('facebook')->user();
         
            $user = User::where('provider_id', $facebookUser->getId())->first();
         
            if($user){
         
                Auth::login($user);
       
                return redirect()->intended('');
         
            }else{
                $newUser = User::updateOrCreate(['email' => $facebookUser->getEmail()],[
                        'name' => $facebookUser->getName(),
                        'email' => $facebookUser->getEmail(),
                        'provider_id'=> $facebookUser->getId(),
                        'provider' => 'facebook',
                        'password' => bcrypt(Str::random(8)),
                        'profile_photo_path' => $facebookUser->getAvatar()
                    ]);

                Auth::login($newUser);
        
                return redirect()->intended('');
            }
       
        } catch (\Throwable $th) {
            return redirect(route('login'))->with('error', 'Đã xảy ra lỗi khi thực hiên đăng nhập bằng facebook. Vui lòng thử lại sau');
        }
    }

    
}
