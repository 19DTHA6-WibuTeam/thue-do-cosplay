<?php
include 'views/header.php';
?>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="breadcrumb_content">
					<ul>
						<li><a href="index.html">Trang chủ</a></li>
						<li>Giỏ hàng</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--breadcrumbs area end-->

<!--shopping cart area start -->
<div class="shopping_cart_area mt-60">
	<div class="container">
		<form action="#">
			<div class="row">
				<div class="col-12">
					<div class="table_desc">
						<div class="cart_page table-responsive">
							<table>
								<thead>
									<tr>
										<th class="product_remove">Xoá</th>
										<th class="product_thumb">Ảnh sản phẩm</th>
										<th class="product_name">Tên sản phẩm</th>
										<th class="product-price">Đơn giá</th>
										<th class="product_quantity">Số lượng</th>
										<th class="product_total">Số tiền</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$carts = new Cart;
									$cart_subtotal = 0;
									// $cart_weight = 0;
									foreach ($carts->getCart($_SESSION['user_id']) as $k => $v) {
										$product_id = $v['product_id'];
										$product_img = explode('|', $v['product_img'])[0];
										if ($v['cart_product_quantity'] > $v['product_quantity']) {
											$cart_product_quantity = $v['product_quantity'];
											$carts->updateCart($_SESSION['user_id'], $product_id, $cart_product_quantity);
										} else $cart_product_quantity = $v['cart_product_quantity'];
										$product_price_total = $cart_product_quantity * $v['product_rental_price'];
										echo '<tr id="product_' . $product_id . '">
												<td class="product_remove"><a href="javascript:" onclick="delete_from_cart(' . $product_id . ')"><i class="fa fa-trash-o"></i></a></td>
												<td class="product_thumb"><a target="_blank" href="product-details.html?product_id=' . $product_id . '"><img src="' . $product_img . '" alt=""></a></td>
												<td class="product_name"><a target="_blank" href="product-details.html?product_id=' . $product_id . '">' . $v['product_name'] . '</a></td>
												<td class="product-price product_price" id="product_price_' . $product_id . '" data-price="' . $v['product_rental_price'] . '">' . number_format($v['product_rental_price'], 0, ',', '.') . 'đ</td>
												<td class="product_quantity"><input id="product_quantity_' . $product_id . '" min="1" max="' . $v['product_quantity'] . '" onchange="update_cart(' . $product_id . ', this.value);" value="' . $cart_product_quantity . '" type="number" />&nbsp;&nbsp;<i>/ ' . $v['product_quantity'] . '</i></td>
												<td class="product_total" id="product_subtotal_' . $product_id . '">' . number_format($product_price_total, 0, ',', '.') . 'đ</td>
											</tr>';
										$cart_subtotal += $product_price_total;
										// $cart_weight += $cart_product_quantity * $v['product_weight'];
									}
									// $fee = new Fee;
									// $fee_transport = $fee->transport($cart_weight);
									// $fee_bond = $fee->bond($cart_subtotal);
									?>
								</tbody>
							</table>
						</div>
						<!-- <div class="cart_submit">
							<button type="submit">update cart</button>
						</div> -->
					</div>
				</div>
			</div>
			<!--coupon code area start-->
			<div class="coupon_area">
				<div class="row">
					<div class="col-lg-6 col-md-6">
						<!-- <div class="coupon_code left">
							<h3>Coupon</h3>
							<div class="coupon_inner">
								<p>Enter your coupon code if you have one.</p>
								<input placeholder="Coupon code" type="text">
								<button type="submit">Apply coupon</button>
							</div>
						</div> -->
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="coupon_code right">
							<h3>Tổng giỏ hàng</h3>
							<div class="coupon_inner">
								<!-- <div class="cart_subtotal">
									<p>Số tiền</p>
									<p class="cart_amount"><?php //echo number_format($cart_subtotal, 0, ',', '.'); 
															?>đ</p>
								</div>
								<div class="cart_subtotal">
									<p>Phí vận chuyển</p>
									<p class="cart_amount"><?php //echo number_format($fee_transport, 0, ',', '.'); 
															?>đ</p>
								</div>
								<div class="cart_subtotal">
									<p>Phí đảm bảo tài sản</p>
									<p class="cart_amount"><?php //echo number_format($fee_bond, 0, ',', '.'); 
															?>đ</p>
								</div>
								<a target="_blank" href="faq.html">Ấn vào đây để xem Câu hỏi thường gặp!</a> -->
								<div class="cart_subtotal">
									<p>Tạm tính</p>
									<p class="cart_amount" id="cart_subtotal"><?php echo number_format($cart_subtotal, 0, ',', '.'); ?>đ</p>
								</div>
								<div class="checkout_btn">
									<a href="checkout.html">Thanh toán</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--coupon code area end-->
		</form>
	</div>
</div>
<!--shopping cart area end -->
<?php
include 'views/footer.php';
?>