
<x-app-layout>
<main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container" style="font-family: Arial, sans-serif; ">
                <div class="breadcrumb">
                    <a href="/" rel="nofollow" style="font-style: bold; font-weight: bold;">Trang chủ&nbsp;</a>                  
                    <a > / Đăng nhập</a>
                </div>
            </div>
        </div>
        <section class="pt-150 pb-150" >
            <div class="container" style="font-family: Arial, sans-serif;">
                <div class="row">
                    <div class="col-lg-10 m-auto" >
                        <div class="row" >
                            <div class="col-lg-5">
                                <div class="login_wrap widget-taber-content p-30 background-white border-radius-10 mb-md-5 mb-lg-0 mb-sm-5">
                                    <div class="padding_eight_all bg-white">
                                        <div class="heading_s1">
                                            <h3 class="mb-30" style="margin-top: 30px; font-style:bold; font-weight:bold; margin-bottom: 30px;">Đăng nhập</h3>
                                        </div>
                                        @if(session('error')) 
                                            <div class="alert alert-danger mt-3 mb-3">
                                                {{session('error')}}
                                            </div>
                                        @endif
                                        @if ($errors->any())
                                            <div class="alert alert-danger mt-3 mb-3">
                                                Email hoặc mật khẩu sai vui lòng thử lại.
                                            </div>
                                        @endif
                                        @if(session('success'))
                                            <div class="alert alert-success mt-3 mb-3">
                                                {{session('success')}}
                                            </div>
                                        @endif
                                        @if(session('warning'))
                                            <div class="alert alert-warning mt-3 mb-3">
                                                {{session('warning')}}
                                            </div>
                                        @endif
                                        <form method="post" action="{{ route('login') }}">
                                            @csrf
                                            <div>
                                                <x-label for="email" value="{{ __('Email') }}" />
                                                <x-input id="email" class="form-control mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                            </div>

                                            <div class="mt-4">
                                                <x-label for="password" value="{{ __('Mật khẩu') }}" />
                                                <x-input id="password" class="form-control mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                                            </div>

                                            <!-- <div class="block mt-4">
                                                <label for="remember_me" class="flex items-center">
                                                    <x-checkbox id="remember_me" name="remember" style="width: 20px; height: 15px; margin-top: 2px;" />
                                                    <span class="ml-2 text-sm text-gray-600">{{ __('Ghi nhớ') }}</span>
                                                </label>
                                            </div> -->




                                            <div class="row align-items-center justify-end mt-4" >
                                                @if (Route::has('password.request'))
                                                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" style="color: brown;margin-left: 20px; font-weight: bold"href="{{ route('password.request') }}">
                                                        {{ __('Quên mật khẩu?') }}
                                                    </a>
                                                @endif

                                                <x-button class="ml-110"  style="background-color: brown; border-radius: 20px;margin-left: auto; margin-right: 15px;">
                                                    {{ __('Đăng nhập') }}
                                                </x-button>
                                            </div>
                                            <div class="row flex items-center justify-end mt-4">
                                                <div class="logo-container" style="display: flex; justify-content: space-between;">
                                                    <a class="btn btn-primary logo-btn" href="{{ url('auth/facebook') }}" id="btn-fblogin" style="margin-left: 20px;background: white; color: #ffffff; padding: 5px; border-radius: 7px; border: none; margin-top: 0 !important;">
                                                        <img src="{{ asset('img/logo/facebook_icon.png') }}" alt="Facebook Icon" class="logo-img" style="width: 50px; height: 50px;" />
                                                    </a>
                                                    <a class="btn btn-primary logo-btn" href="{{ url('auth/google') }}" id="btn-googlelogin" style="margin-left: 50px; background: white; color: #ffffff; padding: 5px; border-radius: 7px; border: none; margin-top: 0 !important;">
                                                        <img src="{{ asset('img/logo/google_login.png') }}" alt="Google Icon" class="logo-img" style="width: 50px; height: 50px;" /> 
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1"></div>
                            <div class="col-lg-6" style="margin-left:-90px; padding-left:20px;">
                               <img src="img/login.jpg" style="weight: 200px; height: 400px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-app-layout>
