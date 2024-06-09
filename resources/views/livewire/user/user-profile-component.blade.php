<div>
<main class="main">

    <section class="pt-4 pb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="dashboard-menu">
                                <ul class="nav nav-tabs justify-content-start border-secondary mb-4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="orders-tab" href="{{route('user.orders')}}"><i
                                                class="fi-rs-shopping-bag mr-10"></i>Đơn hàng</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="{{route('profile.edit')}}">
                                            <i class="fi-rs-user mr-10"></i>Thông tin tài khoản</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @if (session('status'))
                        <div class="col-md-12 mb-3">
                            <div class="alert alert-success mb-3 col-md-12">
                                Cập nhật thành công.
                            </div>
                        </div>
                        @endif
                        @if (session('errorMessage'))
                        <div class="col-md-12 mb-3">
                            <div class="alert alert-danger mb-3 col-md-12">
                                {{session('errorMessage')}}
                            </div>
                        </div>
                        @endif
                        @if ($errors->any())
                        <div class="col-md-12 mb-3">
                            <div class=" alert alert-danger mt-3 mb-3">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    @if($error === 'The email has already been taken.')
                                    <li>Email đã được sử dụng</li>
                                    @elseif($error === 'The password must be at least 8 characters.')
                                    <li>Mật khẩu phải có ít nhất 8 ký tự</li>
                                    @else
                                    <li>{{ $error }}</li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-12">
                            <div class="tab-content dashboard-content">
                                <div class="tab-pane fade active show" id="account-detail" role="tabpanel"
                                    aria-labelledby="account-detail-tab">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5>{{Auth::user()->utype === "ADM" ? 'Thông tin admin' : 'Thông tin tài khoản'}}</h5>
                                        </div>

                                        <div class="card-body">
                                        <div class="row">
                                            <form id="form" wire:submit.prevent="handleSaveAvatar" wire:ignore>
                                                <div class="form-group col-md-12">
                                                    <div class="d-inline-flex flex-column gap-1 justify-content-center">
                                                        <label for="labelAvatar">
                                                            <div id="avatar" class="rounded-circle img-thumbnail m-2"
                                                                style="width: 150px; height: 150px; overflow: hidden; background-size: cover; background-position: center; background-image: url('{{Auth::user()->profile_photo_path ? asset('img/products/avatars/' . Auth::user()->profile_photo_path) : asset('assets/imgs/user.png')}}')">
                                                            </div>
                                                        </label>
                                                        
                                                        <input id="labelAvatar" onchange="displayImage(this)" wire:model="avatar" type="file"
                                                            class="form-control d-none" name="profile_photo" accept="image/jpeg, image/png, image/gif">
                                                            <div class="d-flex justify-content-center">
                                                            <button type="submit" class="btn btn-primary px-3 " style="color:white; width: 100px;"
                                                            name="submit" value="Submit">Lưu ảnh</button>
                                                            </div>

                                                    </div>
                                                </div>
                                            </form>
                                            <form method="post" action="{{route('profile.update')}}">
                                                @csrf
                                                @method('patch')
                                                <?php
                                                    if(isset(Auth::user()->address)) {
                                                        $address = explode(',', Auth::user()->address);
                                                        $length = count($address);
                                                    }
                                                ?>
                                                
                                                    
                                                
                                                    <div class="form-group col-md-12">
                                                        <label>{{Auth::user()->utype === "SELLER" ? 'Tên cửa hàng' : 'Họ tên'}}<span class="required">*</span></label>
                                                        <input required="" class="form-control square" name="name"
                                                            type="text" value="{{Auth::user()->name}}">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Email<span class="required">*</span></label>
                                                        <input required="" class="form-control square"
                                                            name="order_email" type="email"
                                                            value="{{Auth::user()->email}}" disabled>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                    <label>Địa chỉ<span class="required">*</span></label>
                                                    </div>
                                                    @if(Auth::user()->address)
                                                    <div class="form-group col-md-12 d-flex gap-3" style="width: 700px;">
                                                        <select class="form-control form-select form-select-sm"
                                                            name="city" id="city" required aria-label=".form-select-sm">
                                                            <option value="" selected disabled>Chọn tỉnh thành *
                                                            </option>
                                                            <option value="{{
                                                                $address[$length-1]}}" selected>{{
                                                                $address[$length-1]}}
                                                            </option>
                                                        </select>
                                                        <div class="w-200"></div>
                                                        <select class="form-control form-select form-select-sm"
                                                            name="district" id="district" required
                                                            aria-label=".form-select-sm">
                                                            <option value="" disabled>Chọn tỉnh thành *</option>

                                                            <option value="{{
                                                                $address[$length-2]}}" selected>{{
                                                                    $address[$length-2]}}
                                                            </option>
                                                        </select>
                                                        <div class="w-200"></div>
                                                        <select class="form-control form-select form-select-sm"
                                                            name="ward" id="ward" required aria-label=".form-select-sm">
                                                            <option value="" disabled>Chọn tỉnh thành *</option>

                                                            <option value="{{
                                                                $address[$length-3]}}" selected>{{
                                                                    $address[$length-3]}}</option>
                                                        </select>
                                                    </div>
                                                    @else
                                                    <div class="form-group d-flex gap-3">
                                                        <select class="form-control form-select form-select-sm"
                                                            name="city" id="city" required aria-label=".form-select-sm">
                                                            <option value="" selected disabled>Chọn tỉnh
                                                                thành *
                                                            </option>
                                                        </select>

                                                        <select class="form-control form-select form-select-sm"
                                                            name="district" id="district" required
                                                            aria-label=".form-select-sm">
                                                            <option value="" selected disabled>Chọn quận
                                                                huyện *
                                                            </option>
                                                        </select>

                                                        <select class="form-control form-select form-select-sm"
                                                            name="ward" id="ward" required aria-label=".form-select-sm">
                                                            <option value="" selected disabled>Chọn phường xã
                                                                *</option>
                                                        </select>
                                                    </div>
                                                    @endif
                                                    <div class="form-group col-md-12">
                                                    <label>Số nhà <span class="required">*</span></label>
                                                    <input class="form-control square" type="text" name="address" required
                                                            placeholder="Số nhà, tên đường *"
                                                            value="{{implode(',',array_slice(explode(',', Auth::user()->address), 0, -3))}}">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Số điện thoại <span class="required">*</span></label>

                                                        <input class="form-control square" required type="tel" name="phone" pattern="[0-9]{10,11}"
                                                            placeholder="Số điện thoại *"
                                                            value="{{Auth::user()->phone}}">
                                                    </div>
                                                    <div class="col-md-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary px-3" style="color:white;"
                                                            name="submit" value="Submit">Lưu</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @if (Auth::user()->provider_id === NULL)
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>Đổi mật khẩu</h5>
                                        </div>

                                        <div class="card-body">
                                            <form method="post" action="{{route('password.update')}}">
                                                @csrf
                                                @method('put')
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label>Mật khẩu hiện tại <span class="required">*</span></label>
                                                        <input required="" class="form-control square"
                                                            name="current_password" type="password">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Mật khẩu mới <span class="required">*</span></label>
                                                        <input required="" class="form-control square" name="password"
                                                            type="password">
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label>Nhập lại mật khẩu <span class="required">*</span></label>
                                                        <input required="" class="form-control square"
                                                            name="password_confirmation" type="password">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit" class="btn btn-primary px-3"
                                                            name="submit" value="Submit" style="color:white;">Lưu</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script>
    var cities = document.getElementById("city");
    var districts = document.getElementById("district");
    var wards = document.getElementById("ward");
    var Parameter = {
        url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
        method: "GET",
        responseType: "application/json",
    };
    var promise = axios(Parameter);
    promise.then(function (result) {
        renderCity(result.data);

    });

    function renderCity(data) {
        for (const x of data) {
            cities.options[cities.options.length] = new Option(x.Name, x.Name);
        }
        cities.onchange = function () {
            district.length = 1;
            ward.length = 1;
            if (this.value != "") {
                const result = data.filter(n => n.Name === this.value);

                for (const k of result[0].Districts) {
                    district.options[district.options.length] = new Option(k.Name, k.Name);
                }
            }
        };
        district.onchange = function () {
            ward.length = 1;
            const dataCity = data.filter((n) => n.Name === cities.value);
            if (this.value != "") {
                const dataWards = dataCity[0].Districts.filter(n => n.Name === this.value)[0].Wards;

                for (const w of dataWards) {
                    wards.options[wards.options.length] = new Option(w.Name, w.Name);
                }
            }
        };
    }

</script>

<script>
    function displayImage(input) {
        var file = input.files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#avatar').css('background-image', 'url(' + e.target.result + ')');
            };

            reader.readAsDataURL(file);
        }
    }
</script>
</div>