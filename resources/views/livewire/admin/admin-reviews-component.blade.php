<div>
    <style>
th, td {
    white-space: nowrap;
}
    </style>
<div>
    <main class="main">
    <div class="container" style="background-color: #f0f0f0; text-align: center; padding: 20px; margin-bottom: 20px">
    <h2 style="margin: 0; font-size: 24px; font-weight: bold; color: black;">Quản lý đánh giá</h2>
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
                                            <input wire:model="search" class="form-control" type="text" placeholder="Tìm kiếm bằng nội dung..." style="border: 1px solid #ccc; border-radius: 4px;">
                                            <select wire:model="filterNSFW" class="form-select " style="width: 1px; border: 2px solid #ccc; border-radius: 4px;">
                                                    <option value="">Loại</option>
                                                    <option value="0">Đã duyệt</option>
                                                    <option value="1">Không duyệt</option>
                                                </select>                                        
                                            <button wire:click="clearSearch" class="btn btn-secondary btn-sm">Xoá</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 mt-md-0">
                                    </div>
                                </div>
                            </div>
                                <div class="card-body"> 
                                <div class="table-responsive"> <!-- Added class for responsiveness -->
                                    <table class="table table-striped" style="border: 2px solid #ccc;">                                            <thead>
                                                <tr>
                                                    <th>Sản phẩm</th>
                                                    <th>Khách hàng</th>
                                                    <th>SĐT</th> 
                                                    <th>Email</th>                                                     
                                                    <th>Số sao</th>
                                                    <th>Nội dung</th>
                                                    <th>Hành động</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reviews as $review)
                                                    <tr>
                                                        <td >{{$review->product->name}}</td>
                                                        <td >{{$review->user->name}}</td>
                                                        <td >{{$review->user->phone}}</td>
                                                        <td >{{$review->user->email}}</td>
                                                        <td>{{$review->rating}}</td>                                        
                                                        <td>{{ Str::limit($review->comment, 15) }}</td>
                                                        <td>
                                                        <button onclick="showReviewComment('{{ $review->comment }}')" class="btn btn-primary btn-sm ml-2">Xem</button>
                                                        @if($review->status == 0)
                                                            <button class="btn btn-info btn-sm" disabled>Khôi phục</button>
                                                            <button class="btn btn-danger btn-sm ml-2" disabled>Xoá</button>
                                                        @else
                                                            <a href="#" class="btn btn-info btn-sm">Khôi phục</a>
                                                            <a href="#" onclick="confirmDeleteReview('{{ $review->id }}')" class="btn btn-danger btn-sm ml-2">Xoá</a>
                                                        @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                
                                            </tbody>
                                        </table>
                                        
                                </div>
                                {{$reviews->links('pagination::bootstrap-4')}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
    </main>
    
    <script>
    function showReviewComment(comment) {
        Swal.fire({
            title: 'Đánh giá',
            html: `<textarea class="swal2-textarea" readonly style="width: 80%; height: 200px">${comment}</textarea>`,
            icon: 'info',
            confirmButtonText: 'Đóng'
        });
    }
</script>
</div>


