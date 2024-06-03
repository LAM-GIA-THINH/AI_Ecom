<div>
    <main class="main">
    <div class="container" style="background-color: #f0f0f0; text-align: center; padding: 20px; margin-bottom: 20px">
    <h2 style="margin: 0; font-size: 24px; font-weight: bold; color: black;">Quản lý thương hiệu</h2>
</div>
            <section class="mt-50 mb-50">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header" style=" border: 2px solid #ccc; border-radius: 4px;"> 
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <input wire:model="search" class="form-control" type="text" placeholder="Tìm kiếm bằng tên..." style="border: 1px solid #ccc; border-radius: 4px;">
                                            <button wire:click="clearSearch" class="btn btn-secondary btn-sm">Xoá</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 mt-md-0">
                                    <div class="d-flex justify-content-md-end justify-content-start">
                                        <a href="{{ route('admin.brand.add') }}" class="btn btn-success btn-sx">Thêm thương hiệu</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                                <div class="card-body"> 
                                <div class="table-responsive"> <!-- Added class for responsiveness -->
                                    <table class="table table-striped" style="border: 2px solid #ccc;">                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Ảnh</th>
                                                    <th>Tên thương hiệu</th>
                                                    <th>Slug</th>
                                                    <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($brands as $brand)
                                                    <tr>
                                                        <td>{{$brand->id}}</td>
                                                        <td><img src="{{ asset('img/products/brand/') }}/{{$brand->image}}" width="180px" height="80px"></td>
                                                        <td>{{$brand->name}}</td>
                                                        <td>{{$brand->slug}}</td>
                                                        <td>
                                                        <a href="{{route('admin.brand.edit', ['brand_id'=>$brand->id])}}" class="btn btn-info btn-sm">Chỉnh sửa</a>
                                                        <a href="#" onclick="confirmDeleteBrand('{{ $brand->id }}')" class="btn btn-danger btn-sm ml-2" style="margin-left:20px;">Xoá</a>   
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                        
                                </div>
                                {{$brands->links('pagination::bootstrap-4')}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </main>



