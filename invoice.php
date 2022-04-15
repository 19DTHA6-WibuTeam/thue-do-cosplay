<?php
include 'views/header.php';

$invoices = new Invoice;
$invoice = $invoices->getInvoice($_GET['invoice_id']);
if ($invoice == false)	header('Location: ./');

?>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="breadcrumb_content">
					<ul>
						<li><a href="index.html">Trang chủ</a></li>
						<li>Chi tiết đơn hàng</li>
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
										<th class="product_thumb">Ảnh sản phẩm</th>
										<th class="product_name">Tên sản phẩm</th>
										<th class="product-price">Đơn giá</th>
										<th class="product_quantity">Số lượng</th>
										<th class="product_total">Số tiền</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($invoices->getInvoiceDetails($_GET['invoice_id']) as $k => $v) {
										$product_id = $v['product_id'];
										$product_img = explode('|', $v['product_img'])[0];
										echo '<tr id="product_' . $product_id . '">
												<td class="product_thumb"><a target="_blank" href="product-details.html?product_id=' . $product_id . '"><img src="' . $product_img . '" alt=""></a></td>
												<td class="product_name"><a target="_blank" href="product-details.html?product_id=' . $product_id . '">' . $v['product_name'] . '</a></td>
												<td class="product-price product_price" id="product_price_' . $product_id . '">' . number_format($v['invd_product_rental_price'], 0, ',', '.') . 'đ</td>
												<td class="product_quantity">' . $v['invd_product_quantity'] . '</td>
												<td class="product_total">' . number_format(($v['invd_product_quantity'] * $v['invd_product_rental_price']), 0, ',', '.') . 'đ</td>
											</tr>';
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!--coupon code area start-->
			<div class="coupon_area">
				<div class="row">
					<div class="col-lg-6 col-md-6">
					</div>
					<div class="col-lg-6 col-md-6">
						<div class="coupon_code right">
							<h3>Tổng giỏ hàng</h3>
							<div class="coupon_inner">
								<div class="cart_subtotal">
									<p>Số tiền</p>
									<p class="cart_amount"><?php echo number_format($invoice['invoice_subtotal'], 0, ',', '.'); ?>đ</p>
								</div>
								<div class="cart_subtotal">
									<p>Phí vận chuyển</p>
									<p class="cart_amount"><?php echo number_format($invoice['invoice_fee_transport'], 0, ',', '.'); ?>đ</p>
								</div>
								<div class="cart_subtotal">
									<p>Phí đảm bảo tài sản</p>
									<p class="cart_amount"><?php echo number_format($invoice['invoice_fee_bond'], 0, ',', '.'); ?>đ</p>
								</div>
								<a target="_blank" href="faq.html">Ấn vào đây để xem Câu hỏi thường gặp!</a>
								<div class="cart_subtotal">
									<p>Tổng số tiền</p>
									<p class="cart_amount" id="cart_subtotal"><?php echo number_format(($invoice['invoice_subtotal'] + $invoice['invoice_fee_transport'] + $invoice['invoice_fee_bond']), 0, ',', '.'); ?>đ</p>
								</div>
								<div class="cart_subtotal">
									<p>Trạng thái đơn hàng</p>
									<p class="cart_amount"><?php echo orderStatus($invoice['invoice_status']); ?></p>
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