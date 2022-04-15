<?php
include 'views/header.php';

$products = new Products();
$product = $products->getProductById($_GET['product_id']);
if ($product == false) echo '<script>location.replace("products.html");</script>';
$product_price = number_format($product['product_price'], 0, ',', '.');
$product_imgs = explode('|', $product['product_img']);
// var_dump($product_imgs);
// $product_img = $product_imgs[0];
?>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="breadcrumb_content">
					<ul>
						<li><a href="index.html">Trang chủ</a></li>
						<li>Chi tiết sản phẩm</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--breadcrumbs area end-->

<!--product details start-->
<div class="product_details mt-60 mb-60">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-6">
				<div class="product-details-tab">
					<div id="img-1" class="zoomWrapper single-zoom">
						<a href="#">
							<img id="zoom1" src="<?php echo $product_imgs[0]; ?>" data-zoom-image="<?php echo $product_imgs[0]; ?>" alt="big-1">
						</a>
					</div>
					<div class="single-zoom-thumb">
						<ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
							<!-- <li>
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="assets/img/product/productbig4.webp" data-zoom-image="assets/img/product/productbig4.webp">
                                    <img src="assets/img/product/productbig4.webp" alt="zo-th-1" />
                                </a>
                            </li>
                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="assets/img/product/productbig1.webp" data-zoom-image="assets/img/product/productbig1.webp">
                                    <img src="assets/img/product/productbig1.webp" alt="zo-th-1" />
                                </a>
                            </li>
                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="assets/img/product/productbig2.webp" data-zoom-image="assets/img/product/productbig2.webp">
                                    <img src="assets/img/product/productbig2.webp" alt="zo-th-1" />
                                </a>
                            </li>
                            <li>
                                <a href="#" class="elevatezoom-gallery active" data-update="" data-image="assets/img/product/productbig3.webp" data-zoom-image="assets/img/product/productbig3.webp">
                                    <img src="assets/img/product/productbig3.webp" alt="zo-th-1" />
                                </a>
                            </li> -->
							<?php
							foreach ($product_imgs as $k => $v) {
								echo '<li><a href="javascript:void();" class="elevatezoom-gallery active" data-update="" data-image="' . $v . '" data-zoom-image="' . $v . '">
										<img src="' . $v . '" alt="zo-th-1" />
									</a></li>';
							}
							?>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="product_d_right">
					<form>
						<h1><?php echo $product['product_name']; ?></h1>
						<!-- <div class="product_nav">
                            <ul>
                                <li class="prev"><a href="product-details.html"><i class="fa fa-angle-left"></i></a></li>
                                <li class="next"><a href="variable-product.html"><i class="fa fa-angle-right"></i></a></li>
                            </ul>
                        </div> -->
						<!-- <div class=" product_ratting">
                            <ul>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li><a href="#"><i class="fa fa-star"></i></a></li>
                                <li class="review"><a href="#"> (customer review ) </a></li>
                            </ul>
                        </div> -->
						<div class="price_box">
							<span class="current_price"><?php echo $product_price; ?>đ</span>
							<!-- <span class="old_price">$80.00</span> -->
						</div>
						<!-- <div class="product_desc">
                            <p style="font-size: 15px;">qweqwe</p>
                        </div> -->
						<!-- <div class="product_variant color">
                            <h3>Available Options</h3>
                            <label>color</label>
                            <ul>
                                <li class="color1"><a href="#"></a></li>
                                <li class="color2"><a href="#"></a></li>
                                <li class="color3"><a href="#"></a></li>
                                <li class="color4"><a href="#"></a></li>
                            </ul>
                        </div> -->
						<div class="product_variant quantity">
							<?php if ($product['product_quantity'] > 0) { ?>
								<label>Số lượng</label>
								<input min="1" max="100" value="1" type="number" /><br />
								<button class="button" onclick="add_to_cart(<?php echo $product['product_id']; ?>);">Thêm vào giỏ hàng</button>
							<?php } else echo '<button class="button" disabled>Hết hàng</button>'; ?>
						</div>
						<div class=" product_d_action">
							<p><?php echo $product['product_quantity']; ?> sản phẩm có sẵn</p>
							<!-- <ul>
                                <li><a href="#" title="Add to wishlist">+ Add to Wishlist</a></li>
                                <li><a href="#" title="Add to wishlist">+ Compare</a></li>
                            </ul> -->
						</div>
						<!-- <div class="product_meta">
                            <span>Loại sản phẩm: <a href="javascript:void();">asdasd</a></span>
                        </div> -->
					</form>
					<!-- <div class="priduct_social">
                        <ul>
                            <li><a class="facebook" href="#" title="facebook"><i class="fa fa-facebook"></i> Like</a></li>
                            <li><a class="twitter" href="#" title="twitter"><i class="fa fa-twitter"></i> tweet</a></li>
                            <li><a class="pinterest" href="#" title="pinterest"><i class="fa fa-pinterest"></i> save</a></li>
                            <li><a class="google-plus" href="#" title="google +"><i class="fa fa-google-plus"></i> share</a></li>
                            <li><a class="linkedin" href="#" title="linkedin"><i class="fa fa-linkedin"></i> linked</a></li>
                        </ul>
                    </div> -->
				</div>
			</div>
		</div>
	</div>
</div>
<!--product details end-->

<!--product info start-->
<div class="product_d_info mb-58">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="product_d_inner">
					<div class="product_info_button">
						<ul class="nav" role="tablist">
							<li><a class="active" data-bs-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">MÔ TẢ</a></li>
							<li><a data-bs-toggle="tab" href="#sheet" role="tab" aria-controls="sheet" aria-selected="false">CHI TIẾT</a></li>
							<!-- <li><a data-bs-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Reviews (1)</a></li> -->
						</ul>
					</div>
					<div class="tab-content">
						<div class="tab-pane fade show active" id="info" role="tabpanel">
							<div class="product_info_content">
								<p><?php echo $product['product_description']; ?></p>
							</div>
						</div>
						<div class="tab-pane fade" id="sheet" role="tabpanel">
							<div class="product_d_table">
								<form action="#">
									<table>
										<tbody>
											<tr>
												<td class="first_child">Loại sản phẩm</td>
												<td><?php echo $product['product_type_name']; ?></td>
											</tr>
											<tr>
												<td class="first_child">Kho hàng</td>
												<td><?php echo $product['product_quantity']; ?></td>
											</tr>
											<tr>
												<td class="first_child">Gửi từ</td>
												<td>TP. Hồ Chí Minh</td>
											</tr>
										</tbody>
									</table>
								</form>
							</div>
							<!-- <div class="product_info_content">
                                <p>Fashion has been creating well-designed collections since 2010. The brand offers feminine designs delivering stylish separates and statement dresses which have since evolved into a full ready-to-wear collection in which every item is a vital part of a woman's wardrobe. The result? Cool, easy, chic looks with youthful elegance and unmistakable signature style. All the beautiful pieces are made in Italy and manufactured with the greatest attention. Now Fashion extends to a range of accessories including shoes, hats, belts and more!</p>
                            </div> -->
						</div>
						<!-- <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="reviews_wrapper">
                                <h2>1 review for Donec eu furniture</h2>
                                <div class="reviews_comment_box">
                                    <div class="comment_thmb">
                                        <img src="assets/img/blog/comment2.webp" alt="">
                                    </div>
                                    <div class="comment_text">
                                        <div class="reviews_meta">
                                            <div class="star_rating">
                                                <ul>
                                                    <li><a href="#"><i class="ion-ios-star"></i></a></li>
                                                    <li><a href="#"><i class="ion-ios-star"></i></a></li>
                                                    <li><a href="#"><i class="ion-ios-star"></i></a></li>
                                                    <li><a href="#"><i class="ion-ios-star"></i></a></li>
                                                    <li><a href="#"><i class="ion-ios-star"></i></a></li>
                                                </ul>
                                            </div>
                                            <p><strong>admin </strong>- September 12, 2018</p>
                                            <span>roadthemes</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment_title">
                                    <h2>Add a review </h2>
                                    <p>Your email address will not be published. Required fields are marked </p>
                                </div>
                                <div class="product_ratting mb-10">
                                    <h3>Your rating</h3>
                                    <ul>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                        <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    </ul>
                                </div>
                                <div class="product_review_form">
                                    <form action="#">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="review_comment">Your review </label>
                                                <textarea name="comment" id="review_comment"></textarea>
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <label for="author">Name</label>
                                                <input id="author" type="text">
                                            </div>
                                            <div class="col-lg-6 col-md-6">
                                                <label for="email">Email </label>
                                                <input id="email" type="text">
                                            </div>
                                        </div>
                                        <button type="submit">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--product info end-->

<!--product area start-->
<section class="product_area related_products">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section_title">
					<h2>Sản phẩm liên quan</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="product_carousel product_column4 owl-carousel">
				<!-- <div class="col-lg-3">
					<article class="single_product">
						<figure>
							<div class="product_thumb">
								<a class="primary_img" href="product-details.html"><img src="assets/img/product/product1.webp" alt=""></a>
								<a class="secondary_img" href="product-details.html"><img src="assets/img/product/product2.webp" alt=""></a>
								<div class="action_links">
									<ul>
										<li class="add_to_cart"><a href="cart.html" title="Add to cart"><i class="zmdi zmdi-shopping-cart"></i></a></li>

										<li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a></li>

										<li class="compare"><a href="#" title="Add to Compare"><i class="zmdi zmdi-shuffle"></i></a></li>

										<li class="quick_button"><a href="#" data-bs-toggle="modal" data-bs-target="#modal_box" title="quick view"> <i class="zmdi zmdi-eye"></i></a></li>

									</ul>
								</div>
							</div>
							<figcaption class="product_content">
								<h4 class="product_name"><a href="product-details.html">Donec Ac Tempus</a></h4>
								<div class="price_box">
									<span class="old_price">$420.00</span>
									<span class="current_price">$180.00</span>
								</div>
								<div class="product_rating">
									<ul>
										<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
										<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
										<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
										<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
										<li><a href="#"><i class="fa fa-star" aria-hidden="true"></i></a></li>
									</ul>
								</div>
							</figcaption>
						</figure>
					</article>
				</div> -->
				<?php
				$products = new Products();
				// $products->getProducts();
				foreach ($products->getProductsByProductTypeId($product['product_type_id'], 1, 8) as $k => $v) {
					$product_price = number_format($v['product_price'], 0, ',', '.');
					$product_img = explode('|', $v['product_img'])[0];
					echo '<div class="col-lg-3">
							<article class="single_product">
								<figure>
									<div class="product_thumb">
										<a class="primary_img" href="product-details.html"><img src="' . $product_img . '" alt=""></a>
										<div class="action_links">
											<ul>
												<li class="add_to_cart"><a href="cart.html" title="Thêm vào giỏ hàng"><i class="zmdi zmdi-shopping-cart"></i></a></li>
												<!--<li class="wishlist"><a href="wishlist.html" title="Add to Wishlist"><i class="zmdi zmdi-favorite-outline"></i></a></li>
												<li class="compare"><a href="#" title="Add to Compare"><i class="zmdi zmdi-shuffle"></i></a></li>-->
												<li class="quick_button"><a href="#" data-bs-toggle="modal" data-bs-target="#modal_box" title="Xem thông tin"> <i class="zmdi zmdi-eye"></i></a></li>
											</ul>
										</div>
									</div>
									<figcaption class="product_content">
										<h4 class="product_name"><a href="product-details.html">' . $v['product_name'] . '</a></h4>
										<div class="price_box">
											<span class="current_price">' . $product_price . 'đ</span>
										</div>
										<div class="product_rating">
											<ul>
												<li><a href="javascript:void();"><i class="fa fa-star" aria-hidden="true"></i></a></li>
												<li><a href="javascript:void();"><i class="fa fa-star" aria-hidden="true"></i></a></li>
												<li><a href="javascript:void();"><i class="fa fa-star" aria-hidden="true"></i></a></li>
												<li><a href="javascript:void();"><i class="fa fa-star" aria-hidden="true"></i></a></li>
												<li><a href="javascript:void();"><i class="fa fa-star" aria-hidden="true"></i></a></li>
											</ul>
										</div>
									</figcaption>
								</figure>
							</article>
						</div>';
				}
				?>
			</div>
		</div>
	</div>
</section>
<!--product area end-->
<?php
include 'views/footer.php';
?>