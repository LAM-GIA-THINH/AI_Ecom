
    <main class="main">
    <div class="container" style="background-color: #f0f0f0; text-align: center; padding: 20px; margin-bottom: 20px">
    <h2 style="margin: 0; font-size: 24px; font-weight: bold; color: black;">Quản lý sản phẩm</h2>
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
                                            <input wire:model="search" type="text" class="form-control" style="background-color:white" placeholder="Tìm kiếm bằng tên..." style="border: 1px solid #ccc; border-radius: 4px;">

                                                <select wire:model="filterStockStatus" class="form-select " style="width: 1px; border: 2px solid #ccc; border-radius: 4px;">
                                                    <option value="">Trạng thái</option>
                                                    <option value="in_stock">Còn hàng</option>
                                                    <option value="out_of_stock">Hết hàng</option>
                                                </select>

                                            <button wire:click="clearSearch" class="btn btn-secondary btn-sm">Xoá</button>

                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 mt-md-0">
                                        <!-- Added mt-3 mt-md-0 class for spacing on small screens -->
                                        <div class="d-flex justify-content-md-end justify-content-start">
                                            <!-- Adjusted justification -->
                                        <a href="{{ route('admin.product.add') }}" class="btn btn-success btn-sx">Thêm sản phẩm</a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                                <div class="card-body">
                                <div class="table-responsive"> <!-- Added class for responsiveness -->
                                    <table class="table table-striped" style="border: 2px solid #ccc;">
                                            <thead>
                                                <tr class="text-center">
                                                <th>#</th>
                                                <th>Ảnh</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Tình trạng hàng</th>
                                                <th>Giá</th>
                                                <th>Danh mục</th>
                                                <th>Ngày thêm</th>
                                                <th>Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($products as $product)
                                                    <tr class="text-center">
                                                        <td>{{$product->id}}</td>
                                                        <td>
                                                        @php
                                                            $images = explode(',', $product->image);
                                                            $firstImage = $images[0];
                                                        @endphp
                                                            <img src="{{ asset('img/products/products/' . $firstImage) }}" alt="{{ $product->name }}" width="60" />
                                                        </td>
                                                        <td>{{$product->name}}</td>
                                                        <td> 
                                                            @if( $product->quantity >0)
                                                                Còn hàng
                                                            @else
                                                                Hết hàng
                                                            @endif
                                                        </td>
                                                        <td>{{ number_format($product->regular_price, 0, ',', ',') }} VND</td>
                                                        <td>{{$product->category->name}}</td>
                                                        <td>{{$product->created_at->timezone('Asia/Ho_Chi_Minh')->format('d/m/Y H:i:s')}}</td>
                                                        <td>
                                                        @if($product->deleted_at == '')
                                                            <a href="{{route('admin.product.edit', ['product_id'=>$product->id])}}" class="btn btn-info btn-sm">Cập nhật</a>
                                                            <a href="#" onclick="confirmDeleteProduct('{{ $product->id }}')" class="btn btn-danger btn-sm ml-2" style="margin-left:20px;">Xoá</a>
                                                        @else   
                                                        <a href="#" onclick="" class="btn btn-sm ml-2" style="background-color:gray; color:white">Đã xoá</a>
                                                        @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                </div>
                            <div class="d-flex justify-content-center">
                            {{ $products->links('pagination::bootstrap-4') }}        
                                </div>

                              
                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </main>


