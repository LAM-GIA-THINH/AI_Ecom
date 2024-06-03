<main class="main">

    <div>
        <div class="container"
            style="background-color: #f0f0f0; text-align: center; padding: 20px; margin-bottom: 20px">
            <h2 style="margin: 0; font-size: 24px; font-weight: bold; color: black;">Quản lý danh mục</h2>
        </div>


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
                                        <input wire:model="search" type="text" class="form-control"
                                            style="background-color:white" placeholder="Tìm kiếm bằng tên...">
                                        <button wire:click="clearSearch" class="btn btn-secondary btn-sm">Xoá</button>
                                    </div>
                                </div>
                                <div class="col-md-6 mt-3 mt-md-0">
                                        <!-- Added mt-3 mt-md-0 class for spacing on small screens -->
                                        <div class="d-flex justify-content-md-end justify-content-start">
                                            <!-- Adjusted justification -->
                                    <a href="{{ route('admin.category.add') }}" class="btn btn-success float-end">Thêm
                                        danh mục</a>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive"> <!-- Added class for responsiveness -->
                                <table class="table table-striped" style="border: 2px solid #ccc;">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Ảnh</th>
                                            <th>Tên</th>
                                            <th>Slug</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories as $category)
                                            <tr wire:key="category-{{ $category->id }}">
                                                <td>{{$category->id}}</td>
                                                <td><img src="{{ asset('img/products/category/') }}/{{$category->image}}"
                                                        width="80px" height="80px"></td>
                                                <td>{{$category->name}}</td>
                                                <td>{{$category->slug}}</td>
                                                <td>
                                                    <a href="{{route('admin.category.edit', ['category_id' => $category->id])}}"
                                                        class="btn btn-info btn-sm">Chỉnh sửa</a>
                                                    <a href="#" class="btn btn-danger btn-sm ml-2"
                                                        onclick="confirmDeleteCategory('{{ $category->id }}')"
                                                        style="margin-left:20px;">Xoá</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{$categories->links('pagination::bootstrap-4')}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>