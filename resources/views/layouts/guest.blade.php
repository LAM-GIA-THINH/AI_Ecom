<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
	<meta name="author" content="AdminKit">
	<meta name="keywords"
		content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="img/icons/icon-48x48.png" />
	<link href="{{ asset('img/theme/favicon.ico') }}" rel="icon">
	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Trang Quản lý - Think Mart</title>

	<link href="{{ asset('css/app3.css') }}" rel="stylesheet">
	<link href="{{ asset('css/bootstrap.min2.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />


	@stack('styles')
	@livewireStyles
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="/">
					<span class="align-middle">Quản trị viên</span>
				</a>

				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Dữ liệu
					</li>

					<li class="sidebar-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{route('admin.dashboard')}}">
							<i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Thống
								kê</span>
						</a>
					</li>
					@if(Auth::user()->utype === "ADM")
						<li class="sidebar-item {{ Route::is('admin.accounts') ? 'active' : '' }}">
							<a class="sidebar-link" href="{{route('admin.accounts')}}">
								<i class="align-middle" data-feather="user"></i> <span class="align-middle">Nhân viên</span>
							</a>
						</li>
						<li class="sidebar-item {{ Route::is('admin.home.slider') ? 'active' : '' }}">
							<a class="sidebar-link" href="{{route('admin.home.slider')}}">
								<i class="align-middle" data-feather="credit-card"></i> <span
									class="align-middle">Banner</span>
							</a>
						</li>
						<li class="sidebar-item {{ Route::is('admin.reviews') ? 'active' : '' }}">
							<a class="sidebar-link" href="{{route('admin.reviews')}}">
								<i class="align-middle" data-feather="message-square"></i> <span class="align-middle">Đánh
									giá</span>
							</a>
						</li>
					@endif

					<li class="sidebar-header">
						Sản phẩm & Đơn hàng
					</li>
					@if(Auth::user()->utype === "ADM" || Auth::user()->utype === "GAR")
						<li class="sidebar-item {{ Route::is('admin.brands') ? 'active' : '' }}">
							<a class="sidebar-link" href="{{route('admin.brands')}}">
								<i class="align-middle" data-feather="award"></i> <span class="align-middle">Thương
									hiệu</span>
							</a>
						</li>
						<li class="sidebar-item {{ Route::is('admin.categories') ? 'active' : '' }}">
							<a class="sidebar-link" href="{{route('admin.categories')}}">
								<i class="align-middle" data-feather="at-sign"></i> <span class="align-middle">Danh
									mục</span>
							</a>
						</li>

						<li class="sidebar-item {{ Route::is('admin.products') ? 'active' : '' }}">
							<a class="sidebar-link" href="{{route('admin.products')}}">
								<i class="align-middle" data-feather="check-square"></i> <span class="align-middle">Sản
									phẩm</span>
							</a>
						</li>
					@endif
					<li class="sidebar-item {{ Route::is('admin.orders') ? 'active' : '' }}">
						<a class="sidebar-link" href="{{route('admin.orders')}}">
							<i class="align-middle" data-feather="package"></i> <span class="align-middle">Đơn
								hàng</span>
						</a>
					</li>



					<li class="sidebar-header">
						Thao tác
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="/">
							<i class="align-middle" data-feather="home"></i> <span class="align-middle">Trang
								chủ</span>
						</a>
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link text-danger"
							onClick="event.preventDefault(); this.closest('form').submit();">
							<form method="POST" action="{{ route('logout') }}">
								@csrf
								<button class="dropdown-item text-danger text-align-center"
									onClick="event.preventDefault(); this.closest('form').submit();">Đăng xuất</button>
							</form>
						</a>
					</li>
				</ul>
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
					<i class="hamburger align-self-center"></i>
				</a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="alertsDropdown" data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="bell"></i>
									<span class="indicator">1</span>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
								aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 Thông báo
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Thông báo</div>
												<div class="text-muted small mt-1">Nội dung
													update.</div>
												<div class="text-muted small mt-1">từ -- phút trước</div>
											</div>
										</div>
									</a>
									
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Xem tất cả</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown"
								data-bs-toggle="dropdown">
								<div class="position-relative">
									<i class="align-middle" data-feather="message-square"></i>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
								aria-labelledby="messagesDropdown">
								<div class="dropdown-menu-header">
									<div class="position-relative">
										4 Thông báo
									</div>
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="" class="avatar img-fluid rounded-circle"
													alt="Vanessa Tucker">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Thông báo</div>
												<div class="text-muted small mt-1">Nội dung
													tortor.</div>
												<div class="text-muted small mt-1">Từ -- phút trước</div>
											</div>
										</div>
									</a>
									
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Xem tất cả</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<div class="btn-group dropdown d-flex align-items-center">
								<div class="px-1 py-0 d-flex align-items-center" style="background-color: #fff;">
									<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#"
										data-bs-toggle="dropdown">
										<i class="align-middle" data-feather="settings"></i>
									</a>

									<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#"
										data-bs-toggle="dropdown">
										<img src="{{ Auth::user()->profile_photo_path ? asset('img/products/avatars/' . Auth::user()->profile_photo_path) : asset('img/user.png') }}"
											class="avatar img-fluid rounded me-1" alt="{{ Auth::user()->name }}"
											style="width: 30px; height: 30px; object-fit: cover;" />
										<span class="text-dark">
											{{ Auth::user()->name }}
											@if(Auth::user()->utype === "SHIP")
												<span class="badge bg-warning text-dark">Shipper</span>
											@elseif(Auth::user()->utype === "ADM")
												<span class="badge bg-danger text-white">Admin</span>
											@elseif(Auth::user()->utype === "GAR")
												<span class="badge text-white" style="background-color: blue;">QL Kho</span>
											@endif
										</span>
									</a>

									<div class="dropdown-menu dropdown-menu-end">
										<a class="dropdown-item" href="{{ route('profile.edit') }}">
											<i class="align-middle me-1" data-feather="user"></i> Trang cá nhân
										</a>
										@if(Auth::user()->utype === "USR")
											<a class="dropdown-item" href="{{ route('user.orders') }}">
												<i class="align-middle me-1" data-feather="shopping-cart"></i> Đơn hàng
											</a>
										@elseif(Auth::user()->utype === "ADM")
											<a class="dropdown-item" href="{{ route('admin.dashboard') }}">
												<i class="align-middle me-1" data-feather="bar-chart-2"></i> Trang quản lý
											</a>
										@endif
										<div class="dropdown-divider"></div>
										<form method="POST" action="{{ route('logout') }}">
											@csrf
											<button class="dropdown-item text-danger"
												onClick="event.preventDefault(); this.closest('form').submit();">
												<i class="align-middle me-1" data-feather="log-out"></i> Đăng xuất
											</button>
										</form>
									</div>
								</div>
							</div>
						</li>

					</ul>
				</div>
			</nav>

			{{$slot}}

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Think Mart</strong></a> &copy;
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Hỗ trợ</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Tư vấn</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Bảo mật</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Chính sách</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>


	@livewireScripts
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
	<script>
		document.addEventListener('livewire:load', function () {
			window.confirmRestoreAccount = function (accountId) {
				Swal.fire({
					title: 'Mở tài khoản nhân viên?',
					text: "",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Mở!',
					cancelButtonText: 'Huỷ'
				}).then((result) => {
					if (result.isConfirmed) {
						window.livewire.emit('restoreAccount', accountId);
					}
				});
			}
			window.confirmDeleteAccount = function (accountId) {
				Swal.fire({
					title: 'Khoá tài khoản nhân viên?',
					text: "",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Khoá!',
					cancelButtonText: 'Huỷ'
				}).then((result) => {
					if (result.isConfirmed) {
						window.livewire.emit('deleteAccount', accountId);
					}
				});
			}
			window.confirmDeleteSlide = function (sliderId) {
				Swal.fire({
					title: 'Xoá banner?',
					text: "",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Xoá!',
					cancelButtonText: 'Huỷ'
				}).then((result) => {
					if (result.isConfirmed) {
						window.livewire.emit('deleteSlide', sliderId);
					}
				});
			}
			window.confirmDeleteCategory = function (categoryId) {
				Swal.fire({
					title: 'Xoá danh mục?',
					text: "",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Xoá!',
					cancelButtonText: 'Huỷ'
				}).then((result) => {
					if (result.isConfirmed) {
						window.livewire.emit('deleteCategory', categoryId);
					}
				});
			}
			window.confirmDeleteBrand = function (brandId) {
				Swal.fire({
					title: 'Xoá thương hiệu?',
					text: "",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Xoá!',
					cancelButtonText: 'Huỷ'
				}).then((result) => {
					if (result.isConfirmed) {
						window.livewire.emit('deleteBrand', brandId);
					}
				});
			}
			window.confirmDeleteProduct = function (productId) {
				Swal.fire({
					title: 'Xoá sản phẩm?',
					text: "",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Xoá!',
					cancelButtonText: 'Huỷ'
				}).then((result) => {
					if (result.isConfirmed) {
						window.livewire.emit('deleteProduct', productId);
					}
				});
			}
			window.confirmRestoreProduct = function (productId) {
				Swal.fire({
					title: 'Khôi phục sản phẩm?',
					text: "",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Khôi phục!',
					cancelButtonText: 'Huỷ'
				}).then((result) => {
					if (result.isConfirmed) {
						window.livewire.emit('restoreProduct', productId);
					}
				});
			}
			window.confirmDeleteReview = function (reviewId) {
				Swal.fire({
					title: 'Xoá đánh giá?',
					text: "",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Xoá!',
					cancelButtonText: 'Huỷ'
				}).then((result) => {
					if (result.isConfirmed) {
						window.livewire.emit('deleteReview', reviewId);
					}
				});
			}
			window.confirmRestoreReview = function (reviewId) {
				Swal.fire({
					title: 'Khôi phục đánh giá?',
					text: "",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Khôi phục!',
					cancelButtonText: 'Huỷ'
				}).then((result) => {
					if (result.isConfirmed) {
						window.livewire.emit('restoreReview', reviewId);
					}
				});
			}

		});
	</script>

	<script src="{{ asset('js/app3.js') }}"></script>
	<script>
		document.addEventListener('livewire:load', function () {
			initializeSelect2();

		});

		Livewire.hook('message.processed', (message, component) => {
			initializeSelect2();

		});

		function initializeSelect2() {
			$('#categorySelect').select2({
				width: '100%',
			});
			$('#categorySelect').on('change', function (e) {
				var selectedValue = $(this).val();
				Livewire.emit('selectedCategoryChanged', selectedValue);
			});

			$('#brandSelect').select2({
				width: '100%',
			});
			$('#brandSelect').on('change', function (e) {
				var selectedValue = $(this).val();
				Livewire.emit('selectedBrandChanged', selectedValue);
			});
			$('#userSelect').select2();
			$('#userSelect').on('change', function (e) {
				var selectedValue = $(this).val();
				Livewire.emit('selectedUserChanged', selectedValue);
			});
		}

		document.addEventListener('livewire:load', function () {
			ClassicEditor
				.create(document.querySelector('#description'))
				.then(editor => {
					editor.model.document.on('change:data', () => {
						const data = editor.getData();
						window.livewire.emit('inputContentChanged', data);
					});
				})
				.catch(error => {
					console.error(error);
				});
		});
		Livewire.on('showupSuccessMessage', () => {
			Swal.fire({
				position: 'center',
				icon: 'success',
				title: 'Đã cập nhật thành công!',
				showConfirmButton: false,
				timer: 2000
			});
		});
		Livewire.on('showaddSuccessMessage', () => {
			Swal.fire({
				position: 'center',
				icon: 'success',
				title: 'Đã thêm thành công!',
				showConfirmButton: false,
				timer: 2000
			});
		});
		Livewire.on('refreshPage',  ()  => {
			setTimeout(() => {
				location.reload();
			}, 2000);
            });
	</script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
	<script>
    document.addEventListener('DOMContentLoaded', function () {
        initializeSortable();
    });

    Livewire.hook('message.processed', (message, component) => {
        initializeSortable();
    });

    function initializeSortable() {
        var el = document.getElementById('imageList');
        if (el && !el.sortableInitialized) {
            new Sortable(el, {
                animation: 150,
                onEnd: function (evt) {
                    let imageOrder = [];
                    document.querySelectorAll('#imageList .sortable-image').forEach((img) => {
                        imageOrder.push(img.getAttribute('data-image-name'));
                    });
                    Livewire.emit('updateImageOrder', imageOrder);
                }
            });
            el.sortableInitialized = true;
        }
    }
</script>
	@stack('scripts')
</body>

</html>