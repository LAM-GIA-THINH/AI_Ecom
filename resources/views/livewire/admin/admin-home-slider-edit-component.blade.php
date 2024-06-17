<div>
    <main class="main">
        <div class="container"
            style="background-color: #f0f0f0; text-align: center; padding: 20px; margin-bottom: 20px">
            <h2 style="margin: 0; font-size: 24px; font-weight: bold; color: black;">Cập nhật banner</h2>
        </div>
        <section class="mt-50 mb-50">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-6">
                                        Cập nhật banner
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{route('admin.home.slider')}}" class="btn btn-success float-end">Tất
                                            cả banner</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(Session::has('message'))
                                    <div class="alert alert-success" role="alert">{{Session::get('message')}}</div>
                                @endif
                                <form wire:submit.prevent="updateSlide">
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Tên banner</label>
                                        <input type="text" class="form-control" style="background-color:white"
                                            placeholder="Nhập tên banner" wire:model="title" />
                                        @error('title')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Tiêu đề chính</label>
                                        <input type="text" class="form-control" style="background-color:white"
                                            placeholder="Nhập tiêu đề chính" wire:model="top_title" />
                                        @error('top_title')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Tiêu đề phụ</label>
                                        <input type="text" class="form-control" style="background-color:white"
                                            placeholder="Nhập tiêu đề chính" wire:model="sub_title" />
                                        @error('sub_title')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Khuyến mãi</label>
                                        <input type="text" class="form-control" style="background-color:white"
                                            placeholder="Nhập khuyến mãi" wire:model="offer" />
                                        @error('offer')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Liên kết</label>
                                        <input type="text" class="form-control" style="background-color:white"
                                            placeholder="Nhập liên kết" wire:model="link" />
                                        @error('link')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Loại</label>
                                        <select class="form-select mb-3"
                                            wire:model="type">
                                            <option value="">Chọn loại</option>
                                            <option value="1">Banner lớn</option>
                                            <option value="0">Banner nhỏ</option>
                                        </select>
                                        @error('type')
                                            <p class="text-danger">{{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Ảnh</label>
                                        <input type="file" class="form-control" wire:model="newimage" />
                                        @if($newimage)
                                            <img src="{{$newimage->temporaryUrl()}}" width="100" />
                                        @else
                                            <img src="{{asset('img/products/slider')}}/{{$image}}" width="100" />
                                        @endif
                                        @error('newimage')
                                            <p class="text-danger">{{$message}}</p>
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