<?php
include 'views/header.php';
?>
<!--slider area start-->
<section class="slider_section slider_s_one mb-40">
	<div class="slider_area owl-carousel">
		<div class="single_slider d-flex align-items-center" data-bgimg="assets/img/slider/slider1.webp">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-md-7">
						<div class="slider_content content_left">
							<h1> WibuShop</h1>
							<h2>Thời trang hàng hiệu</h2>
							<p>Đa dạng sản phẩm, nhiều kiểu dáng...</p>
							<a class="button" href="products.html">shop Now <i class="zmdi zmdi-long-arrow-right"></i></a>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="single_slider d-flex align-items-center" data-bgimg="assets/img/slider/slider2.webp">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 offset-lg-6 col-md-6 offset-md-6">
						<div class="slider_content content_right">
							<h1> WibuShop</h1>
							<h2>Thời trang hàng hiệu</h2>
							<p>Đa dạng sản phẩm, nhiều kiểu dáng...</p>
							<a class="button" href="products.html">shop Now <i class="zmdi zmdi-long-arrow-right"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!--slider area end-->

<!--banner area start-->
<div class="banner_area mb-66">
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-4">
				<figure class="single_banner">
					<div class="banner_thumb">
						<img src="assets/img/bg/banner1.webp" alt="">
						<div class="banner_conent">
							<h3>Đặt hàng Online</h3>
							<h2></h2>
							<p>Tiện lợi & Nhanh chóng</p>
						</div>
					</div>
				</figure>
			</div>
			<div class="col-lg-4 col-md-4">
				<figure class="single_banner">
					<div class="banner_thumb">
						<img src="assets/img/bg/banner2.webp" alt="">
						<div class="banner_conent">
							<h3>model & Trending</h3>
							<h2>2023</h2>
							<p>cosplay</p>
						</div>
					</div>
				</figure>
			</div>
			<div class="col-lg-4 col-md-4">
				<figure class="single_banner">
					<div class="banner_thumb">
						<img src="assets/img/bg/banner3.webp" alt="">
						<div class="banner_conent">
							<h3>đa dạng</h3>
							<h2></h2>
							<p>trang phục, phụ kiện</p>
						</div>
					</div>
				</figure>
			</div>
		</div>
	</div>
</div>
<!--banner area end-->

<!--product area start-->
<div class="product_area mb-65">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section_title">
					<h2>Sản phẩm</h2>
					<!-- <div class="product_tab_btn">
						<ul class="nav" role="tablist">
							<li>
								<a class="active" data-bs-toggle="tab" href="#Men" role="tab" aria-controls="Men" aria-selected="true">Men</a>
							</li>
							<li>
								<a data-bs-toggle="tab" href="#Women" role="tab" aria-controls="Women" aria-selected="false">Women</a>
							</li>
							<li>
								<a data-bs-toggle="tab" href="#Watches" role="tab" aria-controls="Watches" aria-selected="false">Watches</a>
							</li>
						</ul>
					</div> -->
				</div>
			</div>
		</div>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="Men" role="tabpanel">
				<div class="row">
					<div class="product_carousel product_column4 owl-carousel">
						<?php
						$products = new Products();
						// $products->getProducts();
						foreach ($products->getProducts(1, 1, 8) as $k => $v) {
							$product_id = $v['product_id'];
							$product_price = number_format($v['product_price'], 0, ',', '.');
							$product_img = explode('|', $v['product_img'])[0];
							if ($k % 2 == 0)
								echo '<div class="col-lg-3"><div class="product_items">';
							echo '<article class="single_product">
									<figure>
										<div class="product_thumb">
											<a class="primary_img" href="product-details.html?product_id=' . $product_id . '"><img src="' . $product_img . '" alt=""></a>
											<!--<a class="secondary_img" href="product-details.html"><img src="assets/img/product/product8.webp" alt=""></a>-->
											<div class="action_links">
												<ul>
													<li class="add_to_cart"><a href="javascript:" onclick="add_to_cart(' . $product_id . ');" title="Thêm vào giỏ hàng"><i class="zmdi zmdi-shopping-cart"></i></a></li>
													<li class="quick_button"><a href="product-details.html?product_id=' . $product_id . '" title="Xem thông tin"> <i class="zmdi zmdi-eye"></i></a></li>
												</ul>
											</div>
										</div>
										<figcaption class="product_content">
											<h4 class="product_name"><a href="product-details.html?product_id=' . $product_id . '">' . $v['product_name'] . '</a></h4>
											<div class="price_box">
												<!--<span class="old_price">$420.00</span>-->
												<span class="current_price">' . $product_price . 'đ</span>
											</div>
										</figcaption>
									</figure>
								</article>';
							if ($k % 2 == 0)
								echo '</div></div>';
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--product area end-->


<!--newsletter area start-->
<div class="newsletter_area newsletter_s_one mb-68">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="newsletter_container">
					<div class="newsletter_title">
						<h3>WIBUSHOP</h3>
						<p>Săn trang phục, phụ kiện Cosplay...</p>
					</div>
					<!-- <div class="subscribe_form">
						<form id="mc-form" class="mc-form footer-newsletter">
							<input id="mc-email" type="email" autocomplete="off" placeholder="Enter you email address here..." />
							<button id="mc-submit">Subscribe</button>
						</form>
						<div class="mailchimp-alerts text-centre">
							<div class="mailchimp-submitting"></div>
							<div class="mailchimp-success"></div>
							<div class="mailchimp-error"></div>
						</div>
					</div> -->
				</div>
			</div>
		</div>
	</div>
</div>
<!--newsletter area end-->

<?php
include 'views/footer.php';
?>