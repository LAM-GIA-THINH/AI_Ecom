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
                                <div class="col-md-6 d-flex justify-content-end">
                                    <a href="{{ route('admin.category.add') }}" class="btn btn-success float-end">Thêm
                                        danh mục</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" style="border: 2px solid #ccc;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Slug</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                        <tr>
                                            <td>{{$category->id}}</td>
                                            <td>{{$category->name}}</td>
                                            <td>{{$category->slug}}</td>
                                            <td>
                                                <a href="{{route('admin.category.edit', ['category_id' => $category->id])}}"
                                                    class="text-info">Chỉnh sửa</a>
                                                <a href="#" class="text-danger" onclick="confirmDelete('{{ $category->id }}')"
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
    </section>
</main>

@livewireScripts


<script>
    function confirmDelete(categoryId) {
        if (confirm('Bạn có chắc muốn xoá danh mục này?')) {
            Livewire.emit('deleteCategory', categoryId);
        }
    }
</script>
