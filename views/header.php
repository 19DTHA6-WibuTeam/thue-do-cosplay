<?php
include 'config.php';

if (strpos(strtolower($_SERVER['REQUEST_URI']), 'login.') !== false && isset($_SESSION['user_id']))
	header('Location: ./');
else if (strposa(strtolower($_SERVER['REQUEST_URI']), ['my-account.', 'cart.', 'checkout.']) && !isset($_SESSION['user_id']))
	header('Location: ./login.html');
// else if (strpos(strtolower($_SERVER['REQUEST_URI']), 'my-account.') !== false && !isset($_SESSION['user_id']))
// 	header('Location: ./login.html');
if (strpos(strtolower($_SERVER['REQUEST_URI']), 'checkout.')) {
	$test_cart = new Cart;
	if ($test_cart->getCount($_SESSION['user_id']) == 0)
		header('Location: ./');
}
?>
<!doctype html>
<html class="no-js" lang="vi">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Cho thuê đồ Cosplay | WibuShop</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

	<!-- CSS 
========================= -->

	<!-- Plugins CSS -->
	<link rel="stylesheet" href="assets/css/plugins.css">

	<!-- Main Style CSS -->
	<link rel="stylesheet" href="assets/css/style.css">

	<link rel="stylesheet" href="admin/app-assets/vendors/select2/select2.min.css" type="text/css">
	<link rel="stylesheet" href="admin/app-assets/vendors/select2/select2-materialize.css" type="text/css">
	<script src="https://kit.fontawesome.com/c7d93c2203.js" crossorigin="anonymous"></script>
</head>

<body>

	<!--header area start-->

	<!--Offcanvas menu area start-->
	<div class="off_canvars_overlay">

	</div>
	<div class="Offcanvas_menu">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="canvas_open">
						<a href="javascript:void(0)"><i class="ion-navicon"></i></a>
					</div>
					<div class="Offcanvas_menu_wrapper">
						<div class="canvas_close">
							<a href="javascript:void(0)"><i class="ion-android-close"></i></a>
						</div>
						<div class="header_account">
						</div>
						<div class="header_right_info">
							<ul>
								<li class="search_box"><a href="javascript:void(0)"><i class="zmdi zmdi-search zmdi-hc-fw"></i></a>
									<div class="search_widget">
										<form action="#">
											<input placeholder="Tìm kiếm sản phẩm (từ khoá tối thiểu 3 kí tự)" type="text" />
											<button type="submit"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
										</form>
									</div>
								</li>
								<!-- <li class="header-wishlist"><a href="wishlist.html"><i class="zmdi zmdi-favorite-outline"></i> <span class="item_count">3</span></a></li> -->
								<li class="mini_cart_wrapper"><a href="cart.html"><i class="zmdi zmdi-shopping-cart zmdi-hc-fw"></i></a>
									<!--mini cart-->
									<div class="mini_cart">
										<div class="mini_cart_footer">
											<div class="cart_button">
												<a href="cart.html">Xem giỏ hàng</a>
											</div>
											<div class="cart_button">
												<a href="checkout.html">Thanh toán</a>
											</div>

										</div>
									</div>
									<!--mini cart end-->
								</li>
							</ul>
						</div>

						<div id="menu" class="text-left ">
							<ul class="offcanvas_main_menu">
								<li class="menu-item-has-children active">
									<a href="./">Trang chủ</a>
								</li>
								<li class="menu-item-has-children">
									<a href="javascript:void();">Sản phẩm</a>
									<ul class="sub-menu">
										<?php
										$productTypes = new ProductTypes();
										$listProductTypes = '';
										foreach ($productTypes->getProductTypes() as $k => $v) {
											$listProductTypes .= '<li><a href="products.html?product_type_id=' . $v['product_type_id'] . '">' . $v['product_type_name'] . '</a></li>';
										}
										echo $listProductTypes;
										?>
									</ul>
								</li>
								<li class="menu-item-has-children">
									<a href="javascript:void();">Tài khoản</a>
									<ul class="sub-menu">
										<!-- <li><a href="login">Đăng nhập / Đăng ký</a></li> -->
										<?php
										if ($_SESSION['user_id']) echo '<li><a href="my-account.html">Thông tin tài khoản</a></li><li><a href="logout.html">Đăng xuất</a></li>';
										else echo '<li><a href="login.html">Đăng nhập / đăng ký</a></li>';
										?>
									</ul>
								</li>
								<li class="menu-item-has-children">
									<a href="about.html">Giới thiệu</a>
								</li>
								<li class="menu-item-has-children">
									<a href="faq.html">FAQ</a>
								</li>
							</ul>
						</div>

						<div class="Offcanvas_footer">
							<span><a href="javascript:void();"><i class="fa fa-envelope-o"></i> admin@wibuteam.phatdev.xyz</a></span>
							<ul>
								<li class="facebook"><a href="javascript:void();"><i class="fa fa-facebook"></i></a></li>
								<li class="twitter"><a href="javascript:void();"><i class="fa fa-twitter"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--Offcanvas menu area end-->

	<header>
		<div class="main_header header-mobile-m">
			<div class="header_top">
				<div class="container-fluid">
					<div class="row align-items-center">
						<div class="col-lg-6 col-md-6">
							<div class="header_account">
								<ul>
									<li class="language"><a href="javascript:void();"><img src="assets/img/icon/vietnam.png" alt=""> VI <i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
										<ul class="dropdown_language">
											<li><a href="javascript:void();">Vietnamese</a></li>
											<!-- <li><a href="javascript:void();">English</a></li> -->
										</ul>
									</li>
									<!-- <li class="currency"><a href="javascript:void();"> VND <i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
										<ul class="dropdown_currency">
											<li><a href="javascript:void();">EUR – Euro</a></li>
											<li><a href="javascript:void();">GBP – British Pound</a></li>
										</ul>
									</li>
									<li class="top_links"><a href="javascript:void();"> My Account <i class="zmdi zmdi-chevron-down zmdi-hc-fw"></i></a>
										<ul class="dropdown_links">
											<li><a href="checkout.html">Checkout </a></li>
											<li><a href="my-account.html">My Account </a></li>
											<li><a href="cart.html">Shopping Cart</a></li>
											<li><a href="wishlist.html">Wishlist</a></li>
										</ul>
									</li> -->
									<?php if ($_SESSION['user_id']) echo '<li class="currency"><a href="javascript:void();">Xin chào ' . $_SESSION['user_fullname'] . '!</a></li>'; ?>
								</ul>
							</div>
						</div>
						<div class="col-lg-6 col-md-6">
							<div class="header_social text-right">
								<ul>
									<li><a href="javascript:void();"><i class="fa fa-facebook-f"></i></a></li>
								</ul>
							</div>
						</div>
					</div>

				</div>
			</div>
			<div class="header_container sticky-header">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-lg-3">
							<div class="logo">
								<a href="./"><img src="assets/img/logo/logo.webp" alt=""></a>
							</div>
						</div>
						<div class="col-lg-9">
							<div class="header_container_right">
								<!--main menu start-->
								<div class="main_menu menu_position">
									<nav>
										<ul>
											<li><a class="active" href="./">Trang chủ</a></li>
											<li><a href="products.html">Sản phẩm <i class="fa fa-angle-down"></i></a>
												<ul class="sub_menu pages">
													<!-- <li><a href="login.html">Đăng nhập / đăng ký</a></li> -->
													<?php echo $listProductTypes; ?>
												</ul>
											</li>
											<li><a href="javascript:void();">Tài khoản <i class="fa fa-angle-down"></i></a>
												<ul class="sub_menu pages">
													<?php
													if ($_SESSION['user_id']) echo '<li><a href="my-account.html">Thông tin tài khoản</a></li><li><a href="logout.html">Đăng xuất</a></li>';
													else echo '<li><a href="login.html">Đăng nhập / đăng ký</a></li>';
													?>
												</ul>
											</li>
											<li><a href="about.html">Giới thiệu</a></li>
											<li><a href="faq.html">FAQ</a></li>
										</ul>
									</nav>
								</div>
								<!--main menu end-->
								<div class="header_right_info">
									<ul>
										<li class="search_box"><a href="javascript:void(0)"><i class="zmdi zmdi-search zmdi-hc-fw"></i></a>
											<div class="search_widget">
												<form action="products.html" method="GET">
													<input placeholder="Tìm kiếm sản phẩm (từ khoá tối thiểu 3 kí tự)" type="text" name="keyword" />
													<button type="submit"><i class="zmdi zmdi-search zmdi-hc-fw"></i></button>
												</form>
											</div>
										</li>
										<!-- <li class="header-wishlist"><a href="wishlist.html"><i class="zmdi zmdi-favorite-outline"></i> <span class="item_count">3</span></a></li> -->
										<li class="mini_cart_wrapper"><a href="cart.html"><i class="zmdi zmdi-shopping-cart zmdi-hc-fw"></i></a>
											<!--mini cart-->
											<div class="mini_cart">
												<!-- <div class="cart_gallery">
													<div class="cart_item">
														<div class="cart_img">
															<a href="javascript:void();"><img src="assets/img/s-product/product.webp" alt=""></a>
														</div>
														<div class="cart_info">
															<a href="javascript:void();">Quisque In Arcu</a>
															<p><span> $65.00 </span> X 1</p>
														</div>
														<div class="cart_remove">
															<a href="javascript:void();"><i class="ion-android-close"></i></a>
														</div>
													</div>
													<div class="cart_item">
														<div class="cart_img">
															<a href="javascript:void();"><img src="assets/img/s-product/product2.webp" alt=""></a>
														</div>
														<div class="cart_info">
															<a href="javascript:void();">Donec Ac Tempus</a>
															<p><span> $60.00 </span> X 1</p>
														</div>
														<div class="cart_remove">
															<a href="javascript:void();"><i class="ion-android-close"></i></a>
														</div>
													</div>
												</div>
												<div class="mini_cart_table">
													<div class="cart_table_border">
														<div class="cart_total">
															<span>Sub total:</span>
															<span class="price">$125.00</span>
														</div>
														<div class="cart_total mt-10">
															<span>total:</span>
															<span class="price">$125.00</span>
														</div>
													</div>
												</div> -->
												<div class="mini_cart_footer">
													<div class="cart_button">
														<a href="cart.html">Xem giỏ hàng</a>
													</div>
													<div class="cart_button">
														<a href="checkout.html">Thanh toán</a>
													</div>

												</div>
											</div>
											<!--mini cart end-->
										</li>
									</ul>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!--header area end-->