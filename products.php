<?php
include 'views/header.php';

$page = $_GET['page'];
if ($page < 1 || $page == '' || !is_numeric($page)) $page = 1;

$products = new Products();
if (!empty(getGET('keyword'))) {
	$listProducts = $products->search(getGET('keyword'), getGET('order_by'), $page);
	$total = $products->getCountSearch(getGET('keyword'));
} else {
	if (!empty(getGET('product_type_id'))) {
		$listProducts = $products->getProductsByProductTypeId(getGET('product_type_id'), getGET('order_by'), $page);
		$total = $products->getCountProductsByProductTypeId(getGET('product_type_id'));
	} else {
		$listProducts = $products->getProducts(getGET('order_by'), $page);
		$total = $products->getCount();
	}
}
?>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="breadcrumb_content">
					<ul>
						<li><a href="index.html">Trang chủ</a></li>
						<li>Sản phẩm</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--breadcrumbs area end-->

<!--shop  area start-->
<div class="shop_area shop_fullwidth mt-60 mb-60">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<!--shop wrapper start-->
				<!--shop toolbar start-->
				<div class="shop_toolbar_wrapper">
					<div class="shop_toolbar_btn">
						<button data-role="grid_3" type="button" class=" btn-grid-3" data-bs-toggle="tooltip" title="3"></button>
						<button data-role="grid_4" type="button" class="active btn-grid-4" data-bs-toggle="tooltip" title="4"></button>
					</div>
					<div class=" niceselect_option">
						<form class="select_option" id="select_option" action="#">
							<select class="select2 browser-default" name="order_by" id="order_by">
								<!-- <option selected value="1"></option>
								<option value="2"></option>
								<option value="3"></option> -->
								<?php
								$order_by = array('Xếp theo mới nhất', 'Xếp theo giá: từ thấp đến cao', 'Xếp theo giá: từ cao xuống thấp');
								for ($i = 0; $i < count($order_by); $i++) {
									$od = $order_by[$i];
									echo '<option value="' . ($i + 1) . '"' . ($i + 1 == $_GET['order_by'] ? ' selected' : '') . '>' . $od . '</option>';
								}
								?>
							</select>
						</form>
					</div>
					<div class="page_amount">
						<p>Đang hiển thị 1–24 trong tổng số <?php echo count($listProducts); ?> kết quả</p>
					</div>
				</div>
				<!--shop toolbar end-->
				<div class="row shop_wrapper grid_4">
					<!-- <div class="col-lg-3 col-md-4 col-12 ">
						<article class="single_product">
							<figure>
								<div class="product_thumb">
									<a class="primary_img" href="product-details.html"><img src="assets/img/product/product11.webp" alt=""></a>
									<a class="secondary_img" href="product-details.html"><img src="assets/img/product/product10.webp" alt=""></a>
									<div class="action_links">
										<ul>
											<li class="add_to_cart"><a href="cart.html" title="Add to cart"><i class="zmdi zmdi-shopping-cart"></i></a></li>

											<li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a></li>

											<li class="compare"><a href="#" title="Add to Compare"><i class="zmdi zmdi-shuffle"></i></a></li>

											<li class="quick_button"><a href="#" data-bs-toggle="modal" data-bs-target="#modal_box" title="quick view"> <i class="zmdi zmdi-eye"></i></a></li>

										</ul>
									</div>
								</div>
								<div class="product_content grid_content">
									<h4 class="product_name"><a href="product-details.html">asd</a></h4>

									<div class="product_rating">
										<ul>
											<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
										</ul>
									</div>
									<div class="price_box">
										<span class="old_price">$420.00</span>
										<span class="current_price">$180.00</span>
									</div>
								</div>
								<div class="product_content list_content">
									<h4 class="product_name"><a href="product-details.html">Aliquam Consequat</a></h4>
									<div class="product_rating">
										<ul>
											<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
											<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
										</ul>
									</div>
									<div class="price_box">
										<span class="old_price">$420.00</span>
										<span class="current_price">$180.00</span>
									</div>
									<div class="product_desc">
										<p>Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada tincidunt. Class aptent taciti sociosqu ..</p>
									</div>
								</div>
							</figure>
						</article>
					</div> -->
					<?php
					foreach ($listProducts as $k => $v) {
						$product_id = $v['product_id'];
						$product_img = explode('|', $v['product_img'])[0];
						echo '<div class="col-lg-3 col-md-4 col-12 ">
							<article class="single_product">
								<figure>
									<div class="product_thumb">
										<!--<a class="primary_img" href="product-details.html"><img src="' . $product_img . '" alt=""></a>-->
										<a class="primary_img" href="product-details.html?product_id=' . $product_id . '">
											<div style="width: 100%; background-image: url(\'' . $product_img . '\'); background-size: contain; background-repeat: no-repeat; padding-top: 100%;"></div>
										</a>
										<!--<a class="secondary_img" href="product-details.html"><img src="assets/img/product/product10.webp" alt=""></a>-->
										<div class="action_links">
											<ul>
												<li class="add_to_cart"><a href="javascript:" onclick="add_to_cart(' . $v['product_id'] . ');" title="Thêm vào giỏ hàng"><i class="zmdi zmdi-shopping-cart"></i></a></li>
												<!--<li class="quick_button"><a href="product-details.html?product_id=' . $product_id . '" data-bs-toggle="modal" data-bs-target="#modal_box" title="Xem thông tin"> <i class="zmdi zmdi-eye"></i></a></li>-->
												<li class="quick_button"><a href="product-details.html?product_id=' . $product_id . '" title="Xem thông tin"> <i class="zmdi zmdi-eye"></i></a></li>
											</ul>
										</div>
									</div>
									<div class="product_content grid_content">
										<h4 class="product_name"><a href="product-details.html?product_id=' . $product_id . '" style="display: block; white-space: nowrap; overflow: hidden !important; text-overflow: ellipsis;">' . $v['product_name'] . '</a></h4>
										<div class="price_box">
											<!--<span class="old_price">$420.00</span>-->
											<span class="current_price">' . formatPrice($v['product_rental_price']) . 'đ</span>
										</div>
									</div>
								</figure>
							</article>
						</div>';
					}
					?>
				</div>

				<div class="shop_toolbar t_bottom">
					<div class="pagination">
						<ul>
							<!-- <li class="current">1</li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li class="next"><a href="#">next</a></li>
							<li><a href="#">>></a></li> -->
							<?php
							// $total = $listCount;
							$limit = (($page - 1) * DATA_PER_PAGE) . ',' . DATA_PER_PAGE;
							$end_page =  ceil($total / DATA_PER_PAGE);
							$page_item = [];
							for ($i = 1; $i <= $end_page; $i++) if (abs($page - $i) <= 3 || $i == 1 || $i == $end_page) {
								$page_item[] = $i;
								echo '<li class="' . ($page == $i ? 'current' : '') . '"><a href="javascript:" onclick="pagination(' . $i . ')">' . $i . '</a></li>';
							}
							?>

						</ul>
					</div>
				</div>
				<!--shop toolbar end-->
				<!--shop wrapper end-->
			</div>
		</div>
	</div>
</div>
<!--shop  area end-->
<?php
include 'views/footer.php';
?>