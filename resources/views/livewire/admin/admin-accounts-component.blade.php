<div>
    <main class="main">
        <div class="container"
            style="background-color: #f0f0f0; text-align: center; padding: 20px; margin-bottom: 20px">
            <h2 style="margin: 0; font-size: 24px; font-weight: bold; color: black;">Quản lý nhân viên</h2>
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
                                            <input wire:model="search" type="text" placeholder="Tìm kiếm bằng tên..."
                                                style="border: 1px solid #ccc; border-radius: 4px;">
                                            <button wire:click="clearSearch"
                                                class="btn btn-secondary btn-sm">Xoá</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-3 mt-md-0">
                                        <!-- Added mt-3 mt-md-0 class for spacing on small screens -->
                                        <div class="d-flex justify-content-md-end justify-content-start">
                                            <!-- Adjusted justification -->
                                            <a href="{{route('admin.account.add')}}" class="btn btn-success btn-sm">Thêm
                                                nhân viên</a> <!-- Adjusted button size to btn-sm -->
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
                                                <th>Tên tài khoản</th>
                                                <th>Email</th>
                                                <th>Công việc</th>
                                                <th>Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($accounts as $account)
                                                <tr>
                                                    <td>{{$account->id}}</td>
                                                    <td>{{$account->name}}</td>
                                                    <td>{{$account->email}}</td>
                                                    <td>

                                                        @if($account->utype == 'SHIP')
                                                            Giao hàng
                                                        @elseif($account->utype == 'GAR')
                                                            Nhân viên kho
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{route('admin.account.edit', ['account_id' => $account->id])}}"
                                                            class="btn btn-info btn-sm">Chỉnh sửa</a>
                                                        <a href="#" onclick="confirmDeleteU('{{ $account->id }}')"
                                                            class="btn btn-danger btn-sm ml-2">Khoá</a>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    
                                </div>
                                {{$accounts->links('pagination::bootstrap-4')}}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>