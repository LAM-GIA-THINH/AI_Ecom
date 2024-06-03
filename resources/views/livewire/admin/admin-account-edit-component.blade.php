<div>
    <main class="main">
        <div class="container" style="background-color: #f0f0f0; text-align: center; padding: 20px; margin-bottom: 20px">
            <h2 style="margin: 0; font-size: 24px; font-weight: bold; color: black;">Sửa tài khoản</h2>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        Sửa tài khoản
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('admin.accounts') }}" class="btn btn-success float-end">Tất cả tài khoản</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if (Session::has('message'))
                                    <div class="alert alert-success" role="alert">{{ Session::get('message') }}</div>
                                @endif
                                <form wire:submit.prevent="updateAcc">
                                    <div class="mb-3 mt-3">
                                        <label for="name" class="form-label">Tên tài khoản</label>
                                        <input type="text" name="name" class="form-control" style="background-color:white" placeholder="Nhập họ và tên" wire:model="name" />
                                        @error('name')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" name="email" class="form-control" style="background-color:white" placeholder="Nhập email" wire:model="email" />
                                        @error('email')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="phone" class="form-label">Điện thoại</label>
                                        <input type="text" name="phone" class="form-control" style="background-color:white" placeholder="Nhập số điện thoại" wire:model="phone" />
                                        @error('phone')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="password" class="form-label">Mật khẩu</label>
                                        <input type="password" name="password" class="form-control" style="background-color:white" placeholder="Nhập mật khẩu" wire:model="password" />
                                        @error('password')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label for="utype" class="form-label">Nhân viên</label>
                                        <select class="form-select mb-3" style="background-color:white" name="utype" wire:model="utype">
                                            <option value="">Chọn danh mục</option>
                                            <option value="SHIP">Giao hàng</option>
                                            <option value="GAR">Kho</option>
                                        </select>
                                        @error('utype')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-primary float-end">Cập nhật</button>
                                </form>
                            </div>
                            @livewireScripts
                            <script>
                                Livewire.on('showSuccessMessage', () => {
                                    Swal.fire({
                                        position: 'center',
                                        icon: 'success',
                                        title: 'Đã cập nhật thành công!',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</div>
