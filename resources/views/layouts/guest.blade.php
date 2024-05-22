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

	<link rel="canonical" href="https://demo-basic.adminkit.io/" />

	<title>Trang Quản lý - AI Ecom</title>

	<link href="{{ asset('css/app2.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<link href="{{ asset('lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	@stack('styles')
	@livewireStyles
</head>

<body>
	<div class="wrapper">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="index.html">
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
								<i class="align-middle" data-feather="book"></i> <span class="align-middle">Banner</span>
							</a>
						</li>
					@endif

					<li class="sidebar-header">
						Sản phẩm & Đơn hàng
					</li>
					@if(Auth::user()->utype === "ADM" || Auth::user()->utype === "GAR")
						<li class="sidebar-item {{ Route::is('admin.brands') ? 'active' : '' }}">
							<a class="sidebar-link" href="{{route('admin.brands')}}">
								<i class="align-middle" data-feather="align-left"></i> <span class="align-middle">Thương
									hiệu</span>
							</a>
						</li>
						<li class="sidebar-item {{ Route::is('admin.categories') ? 'active' : '' }}">
							<a class="sidebar-link" href="{{route('admin.categories')}}">
								<i class="align-middle" data-feather="square"></i> <span class="align-middle">Danh
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
							<i class="align-middle" data-feather="grid"></i> <span class="align-middle">Đơn hàng</span>
						</a>
					</li>



					<li class="sidebar-header">
						Thao tác
					</li>

					<li class="sidebar-item">
						<a class="sidebar-link" href="/">
							<i class="align-middle" data-feather="bar-chart-2"></i> <span class="align-middle">Trang
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
									<span class="indicator">4</span>
								</div>
							</a>
							<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0"
								aria-labelledby="alertsDropdown">
								<div class="dropdown-menu-header">
									4 New Notifications
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-danger" data-feather="alert-circle"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Update completed</div>
												<div class="text-muted small mt-1">Restart server 12 to complete the
													update.</div>
												<div class="text-muted small mt-1">30m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-warning" data-feather="bell"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Lorem ipsum</div>
												<div class="text-muted small mt-1">Aliquam ex eros, imperdiet vulputate
													hendrerit et.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-primary" data-feather="home"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">Login from 192.186.1.8</div>
												<div class="text-muted small mt-1">5h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<i class="text-success" data-feather="user-plus"></i>
											</div>
											<div class="col-10">
												<div class="text-dark">New connection</div>
												<div class="text-muted small mt-1">Christina accepted your request.
												</div>
												<div class="text-muted small mt-1">14h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all notifications</a>
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
										4 New Messages
									</div>
								</div>
								<div class="list-group">
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-5.jpg"
													class="avatar img-fluid rounded-circle" alt="Vanessa Tucker">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Vanessa Tucker</div>
												<div class="text-muted small mt-1">Nam pretium turpis et arcu. Duis arcu
													tortor.</div>
												<div class="text-muted small mt-1">15m ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-2.jpg"
													class="avatar img-fluid rounded-circle" alt="William Harris">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">William Harris</div>
												<div class="text-muted small mt-1">Curabitur ligula sapien euismod
													vitae.</div>
												<div class="text-muted small mt-1">2h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-4.jpg"
													class="avatar img-fluid rounded-circle" alt="Christina Mason">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Christina Mason</div>
												<div class="text-muted small mt-1">Pellentesque auctor neque nec urna.
												</div>
												<div class="text-muted small mt-1">4h ago</div>
											</div>
										</div>
									</a>
									<a href="#" class="list-group-item">
										<div class="row g-0 align-items-center">
											<div class="col-2">
												<img src="img/avatars/avatar-3.jpg"
													class="avatar img-fluid rounded-circle" alt="Sharon Lessman">
											</div>
											<div class="col-10 ps-2">
												<div class="text-dark">Sharon Lessman</div>
												<div class="text-muted small mt-1">Aenean tellus metus, bibendum sed,
													posuere ac, mattis non.</div>
												<div class="text-muted small mt-1">5h ago</div>
											</div>
										</div>
									</a>
								</div>
								<div class="dropdown-menu-footer">
									<a href="#" class="text-muted">Show all messages</a>
								</div>
							</div>
						</li>
						<li class="nav-item dropdown">
							<div class="btn-group dropdown d-flex align-items-center">
								<div class=" px-1 py-0 d-flex align-items-center" style="background-color: #fff;">
									<a class="nav-link" data-toggle="collapse" href="#navbar-vertical1"
										style="display: flex;">
										<div class="rounded-circle img-thumbnail mr-2"
											style="width: 30px; height: 30px; overflow: hidden; background-size: cover; background-position: center; background-image: url('{{Auth::user()->profile_photo_path ? asset('img/products/avatars/' . Auth::user()->profile_photo_path) : asset('img/user.png')}}')">
										</div>
										<div style="margin-top:3px;">
											{{ Auth::user()->name }}
											@if(Auth::user()->utype === "SHIP")
												<span class="badge bg-warning text-dark">Shipper</span>
											@elseif(Auth::user()->utype === "ADM")
												<span class="badge bg-danger text-white">Admin</span>
											@endif
										</div>
										<i class="fi-rs-angle-down ml-1"></i>
									</a>
									<nav class="collapse navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0 position-absolute"
										style="top: 100%; left: 0; z-index: 100;" id="navbar-vertical1">
										<div class="navbar-nav w-100 overflow-hidden"
											style="max-height: 410px;;background-color:white">
											<a class="dropdown-item" href="{{route('profile.edit')}}">Trang cá nhân</a>
											@if(Auth::user()->utype === "USR")
												<a class="dropdown-item" href="{{route('user.orders')}}">Đơn hàng</a>
											@elseif(Auth::user()->utype === "ADM")
												<a class="dropdown-item" href="{{route('admin.dashboard')}}">Trang quản
													lý</a>
											@endif
											<div>
												<form method="POST" action="{{ route('logout') }}">
													@csrf
													<button class="dropdown-item text-danger text-align-center"
														onClick="event.preventDefault(); this.closest('form').submit();">Đăng
														xuất</button>
												</form>
											</div>
										</div>
									</nav>
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
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AI
										Ecom</strong></a> &copy;
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
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="https://cdn.ckeditor.com/4.9.2/standard/ckeditor.js"></script>

	<script src="{{ asset('js/app2.js') }}"></script>
	<script>
		document.addEventListener('livewire:load', function () {
			initializeSelect2();

		});

		Livewire.hook('message.processed', (message, component) => {
			initializeSelect2();

		});

		function initializeSelect2() {
			$('#categorySelect').select2();
			$('#categorySelect').on('change', function (e) {
				var selectedValue = $(this).val();
				Livewire.emit('selectedCategoryChanged', selectedValue);
			});

			$('#brandSelect').select2();
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
			const editor = CKEDITOR.replace('description');
			editor.on('change', function () {
				window.livewire.emit('inputContentChanged', editor.getData());
			});
		});
		function confirmDeleteC(category_id) {
			if (confirm('Bạn có chắc muốn xoá ?')) {
				Livewire.emit('deleteCategory', category_id);
			}

		}
		function confirmDeleteB(brand_id) {
			if (confirm('Bạn có chắc muốn xoá ?')) {
				Livewire.emit('deleteBrand', brand_id);
			}

		}
		function confirmDeleteP(product_id) {
			if (confirm('Bạn có chắc muốn xoá ?')) {
				Livewire.emit('deleteProduct', product_id);
			}

		}
		function confirmDeleteU(account_id) {
			if (confirm('Bạn có chắc muốn khoá ?')) {
				Livewire.emit('deleteAccount', account_id);
			}

		}
		function confirmDeleteS(slider_id) {
			if (confirm('Bạn có chắc muốn khoá ?')) {
				Livewire.emit('deleteSlide', slider_id);
			}

		}
	</script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	@stack('scripts')
</body>

</html>