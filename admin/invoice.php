<?php
include 'views/header.php';

$invoices = new Invoice;
$invoice = $invoices->getInvoice($_GET['invoice_id']);

if (isset($_POST['submit'])) {
	switch ($_POST['submit']) {
		case 'change_status':
			$invoices->updateStatus($invoice['invoice_id'], ($invoice['invoice_status'] == 1 ? 2 : 1));
			break;
		case 'cancel_invoice':
			$invoices->updateStatus($invoice['invoice_id'], 0);
			break;
	}
	echo '<script>alert("Cập nhật đơn thành công!");</script>';
	$invoice = $invoices->getInvoice($_GET['invoice_id']);
}
?>
<!-- BEGIN: Page Main-->
<div id="main">
	<div class="row">
		<div class="content-wrapper-before gradient-45deg-purple-deep-purple"></div>
		<div class="col s12">
			<div class="container">
				<!-- app invoice View Page -->
				<section class="invoice-view-wrapper section">
					<div class="row">
						<!-- invoice view page -->
						<div class="col xl9 m8 s12">
							<div class="card">
								<div class="card-content invoice-print-area">
									<!-- header section -->
									<div class="row invoice-date-number">
										<div class="col xl4 s12">
											<span class="invoice-number mr-1">Hoá đơn số #</span>
											<span>INV-<?php echo $invoice['invoice_id']; ?></span>
										</div>
										<div class="col xl8 s12">
											<div class="invoice-date display-flex align-items-center flex-wrap">
												<div class="mr-3">
													<small>Ngày đặt hàng:</small>
													<span><?php echo date('d-m-Y', $invoice['invoice_created_at']); ?></span>
												</div>
												<!-- <div>
													<small>Date Due:</small>
													<span>08/10/2019</span>
												</div> -->
											</div>
										</div>
									</div>
									<!-- logo and title -->
									<div class="row mt-3 invoice-logo-title">
										<div class="col m6 s12 display-flex invoice-logo mt-1 push-m6">
											<img src="./app-assets/images/gallery/pixinvent-logo.png" alt="logo" height="46" width="164">
										</div>
										<div class="col m6 s12 pull-m6">
											<h4 class="indigo-text">HOÁ ĐƠN</h4>
											<span>WIBUSHOP</span>
										</div>
									</div>
									<div class="divider mb-3 mt-3"></div>
									<!-- invoice address and contact -->
									<div class="row invoice-info">
										<div class="col m6 s12">
											<h6 class="invoice-from">Từ:</h6>
											<div class="invoice-address">
												<span>Cửa hàng cho thuê đồ cosplay</span>
											</div>
											<div class="invoice-address">
												<span>KCN cao, TP. Thủ Đức trực thuộc TP. HCM</span>
											</div>
											<div class="invoice-address">
												<span>contact@wibuteam.phatdev.xyz</span>
											</div>
											<div class="invoice-address">
												<span>SĐT: 0777xxx449</span>
											</div>
										</div>
										<div class="col m6 s12">
											<div class="divider show-on-small hide-on-med-and-up mb-3"></div>
											<h6 class="invoice-to">Đến:</h6>
											<div class="invoice-address">
												<span><?php echo $invoice['invoice_user_fullname']; ?></span>
											</div>
											<div class="invoice-address">
												<span><?php echo $invoice['invoice_user_address']; ?></span>
											</div>
											<div class="invoice-address">
												<span><?php echo $invoice['invoice_user_email']; ?></span>
											</div>
											<div class="invoice-address">
												<span>SĐT: <?php echo $invoice['invoice_user_phone_number']; ?></span>
											</div>
										</div>
									</div>
									<div class="divider mb-3 mt-3"></div>
									<!-- product details table-->
									<div class="invoice-product-details">
										<table class="striped responsive-table">
											<thead>
												<tr>
													<th>Sản phẩm</th>
													<th>Đơn giá</th>
													<th>SL</th>
													<th class="right-align">Số tiền</th>
												</tr>
											</thead>
											<tbody>
												<!-- <tr>
													<td>Frest Admin</td>
													<td>HTML Admin Template</td>
													<td>28</td>
													<td>1</td>
													<td class="indigo-text right-align">$28.00</td>
												</tr>
												<tr>
													<td>Apex Admin</td>
													<td>Anguler Admin Template</td>
													<td>24</td>
													<td>1</td>
													<td class="indigo-text right-align">$24.00</td>
												</tr>
												<tr>
													<td>Stack Admin</td>
													<td>HTML Admin Template</td>
													<td>24</td>
													<td>1</td>
													<td class="indigo-text right-align">$24.00</td>
												</tr> -->
												<?php
												foreach ($invoices->getInvoiceDetails($invoice['invoice_id']) as $k => $v) {
													echo '<tr>
															<td>' . $v['product_name'] . '</td>
															<td>' . number_format($v['invd_product_rental_price'], 0, ',', '.') . 'đ</td>
															<td>' . $v['invd_product_quantity'] . '</td>
															<td class="indigo-text right-align">' . number_format(($v['invd_product_quantity'] * $v['invd_product_rental_price']), 0, ',', '.') . 'đ</td>
														</tr>';
												}
												?>
											</tbody>
										</table>
									</div>
									<!-- invoice subtotal -->
									<div class="divider mt-3 mb-3"></div>
									<div class="invoice-subtotal">
										<div class="row">
											<div class="col m5 s12">
												<?php
												if (!empty($invoice['invoice_note']))
													echo '<p><b>Ghi chú đơn hàng:</b></p><p>' . $invoice['invoice_note'] . '</p>';
												?>
											</div>
											<div class="col xl4 m7 s12 offset-xl3">
												<ul>
													<li class="display-flex justify-content-between">
														<span class="invoice-subtotal-title">Tạm tính</span>
														<h6 class="invoice-subtotal-value"><?php echo number_format($invoice['invoice_subtotal'], 0, ',', '.'); ?>đ</h6>
													</li>
													<li class="display-flex justify-content-between">
														<span class="invoice-subtotal-title">Phí giao hàng</span>
														<h6 class="invoice-subtotal-value"><?php echo number_format($invoice['invoice_fee_transport'], 0, ',', '.'); ?>đ</h6>
													</li>
													<li class="display-flex justify-content-between">
														<span class="invoice-subtotal-title">Phí đảm bảo tài sản</span>
														<h6 class="invoice-subtotal-value"><?php echo number_format($invoice['invoice_fee_bond'], 0, ',', '.'); ?>đ</h6>
													</li>
													<li class="divider mt-2 mb-2"></li>
													<li class="display-flex justify-content-between">
														<span class="invoice-subtotal-title">Tổng cộng</span>
														<h6 class="invoice-subtotal-value"><?php echo number_format(($invoice['invoice_subtotal'] + $invoice['invoice_fee_transport'] + $invoice['invoice_fee_bond']), 0, ',', '.'); ?>đ</h6>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- invoice action  -->
						<div class="col xl3 m4 s12">
							<div class="card invoice-action-wrapper">
								<div class="card-content">
									<form method="POST" action="">
										<!-- <div class="invoice-action-btn">
										<a href="#" class="btn indigo waves-effect waves-light display-flex align-items-center justify-content-center">
											<i class="material-icons mr-4">check</i>
											<span class="text-nowrap">Send Invoice</span>
										</a>
									</div> -->
										<div class="invoice-action-btn">
											<a href="javascript:void();" class="btn-block btn btn-light-indigo waves-effect waves-light invoice-print">
												<span>In đơn</span>
											</a>
										</div>
										<!-- <div class="invoice-action-btn">
										<a href="app-invoice-edit.html" class="btn-block btn btn-light-indigo waves-effect waves-light">
											<span>Edit Invoice</span>
										</a>
									</div>
									<div class="invoice-action-btn">
										<a href="#" class="btn waves-effect waves-light display-flex align-items-center justify-content-center">
											<i class="material-icons mr-3">attach_money</i>
											<span class="text-nowrap">Add Payment</span>
										</a>
									</div> -->
										<?php
										$invoice_status = $invoice['invoice_status'];
										if ($invoice_status) {
										?>
											<div class="invoice-action-btn">
												<button class="btn waves-effect waves-light display-flex align-items-center justify-content-center" style="width: 100%;" type="submit" name="submit" value="change_status">
													<i class="material-icons mr-3">attach_money</i>
													<span class="text-nowrap">Đánh dấu là <?php echo $invoice_status == 1 ? 'ĐÃ' : 'CHƯA'; ?> thanh toán</span>
												</button>
											</div>
											<div class="invoice-action-btn">
												<button class="btn-block btn btn-light-indigo waves-effect waves-light" style="width: 100%;" type="submit" name="submit" value="cancel_invoice">
													<span>Huỷ đơn hàng</span>
												</button>
											</div>
											<p>Khi chọn Huỷ đơn hàng, sẽ không thể đổi trạng thái đơn hàng được nữa (Chỉnh sửa tại CSDL).</p>
										<?php } ?>
									</form>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="content-overlay"></div>
		</div>
	</div>
</div>
<!-- END: Page Main-->
<?php include 'views/footer.php'; ?>