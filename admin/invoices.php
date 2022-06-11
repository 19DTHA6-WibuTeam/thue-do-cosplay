<?php
include 'views/header.php';

$page = $_GET['page'];
if ($page < 1 || $page == '' || !is_numeric($page)) $page = 1;

$invoices = new Invoice();
// if (!empty(getGET('keyword'))) {
// 	$listInvoices = $invoices->search(getGET('keyword'),  $page);
// 	$total = $invoices->getCountSearch(getGET('keyword'));
// } else {
if (!empty(getGET('invoice_status_id'))) {
	$listInvoices = $invoices->getInvoicesByInvoiceStatusId(getGET('invoice_status_id'), $page);
	$total = $invoices->getCountInvoicesByInvoiceStatusId(getGET('invoice_status_id'));
} else {
	$listInvoices = $invoices->getInvoices($page);
	$total = $invoices->getCount();
}
// }
?>
<!-- BEGIN: Page Main-->
<div id="main">
	<div class="row">
		<div class="content-wrapper-before gradient-45deg-purple-deep-purple"></div>
		<div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
			<!-- Search for small screen-->
			<div class="container">
				<div class="row">
					<div class="col s10 m6 l6">
						<h5 class="breadcrumbs-title mt-0 mb-0"><span>Danh sách đơn hàng</span></h5>
						<ol class="breadcrumbs mb-0">
							<li class="breadcrumb-item"><a href="index.html">Đơn hàng</a>
							</li>
							<li class="breadcrumb-item active">Danh sách đơn hàng</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="col s12">
			<div class="container">
				<div class="section">
					<div class="row">
						<div class="col s12">
							<div id="input-fields" class="card card-tabs">
								<div class="card-content">
									<div class="card-title">
										<div class="row">
											<div class="col s12 m6 l10">
												<h4 class="card-title">Lọc hoá đơn</h4>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col s12">
											<p>Tìm kiếm nhanh hoá đơn theo trạng thái hoá đơn.</p>
											<br>
											<form class="row" method="get" action="">
												<!-- <div class="col s4">
													<div class="input-field col s12">
														<input placeholder="keyword" id="keyword" type="number" class="validate" name="keyword" />
														<label for="keyword">Mã hoá đơn</label>
													</div>
												</div> -->
												<div class="col s4">
													<div class="input-field col s12">
														<select class="select2 browser-default" name="invoice_status_id" id="invoice_status_id">
															<option value="0" selected>Tất cả</option>
															<?php
															$invoiceStatus = new InvoiceStatus();
															$listInvoiceStatus = '';
															foreach ($invoiceStatus->getInvoiceStatus() as $k => $v) {
																$listInvoiceStatus .= '<option value="' . $v['invoice_status_id'] . '">' . $v['invoice_status_name'] . '</option>';
															}
															echo $listInvoiceStatus;
															?>
														</select>
													</div>
												</div>
												<div class="col s4">
													<div class="col s12">
														<button class="btn cyan waves-effect waves-light right" type="submit" name="action">Tìm kiếm <i class="material-icons right">send</i></button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content-overlay"></div>
		</div>
		<div class="col s12">
			<div class="container">
				<div class="section">
					<div class="row">
						<div class="col s12 m12 l12">
							<div id="highlight-table" class="card card card-default scrollspy">
								<div class="card-content">
									<!-- <h4 class="card-title">Danh sách</h4> -->
									<!-- <p class="mb-2">Add <code class=" language-markup">class="Highlight"</code> to the table tag for a highlight table</p> -->
									<div class="row">
										<div class="col s12">
										</div>
										<div class="col s12">
											<table class="highlight">
												<thead>
													<tr>
														<th>ID đơn</th>
														<th>Tên khách</th>
														<th>Số điện thoại</th>
														<th>Email</th>
														<th>Tổng tiền (gồm các phí)</th>
														<th>Ngày đặt</th>
														<th>Trạng thái</th>
														<th>Hành động</th>
													</tr>
												</thead>
												<tbody>
													<?php
													// $invoices = new Invoice;
													foreach ($listInvoices as $k => $v) {
														$status_name = mb_strtoupper($v['invoice_status_name']);
														echo '<tr>
																<td>INV-' . $v['invoice_id'] . '</td>
																<td>' . $v['invoice_user_fullname'] . '</td>
																<td>' . $v['invoice_user_phone_number'] . '</td>
																<td>' . $v['invoice_user_email'] . '</td>
																<td>' . formatPrice($v['invoice_subtotal'] + $v['invoice_fee_transport'] + $v['invoice_fee_bond']) . 'đ</td>
																<td>' . date('Y-m-d', $v['invoice_created_at']) . '</td>
																<td>' . ($v['invoice_status_id'] == 1 ? '<span class="chip lighten-5 red red-text">' . $status_name . '</span>' : ($v['invoice_status_id'] == 2 ? '<span class="chip lighten-5 orange orange-text">' . $status_name . '</span>' : '<span class="chip lighten-5 green green-text">' . $status_name . '</span>')) . '</td>
																<td>
																	<div class="invoice-action">
																		<a href="user.html?user_id=' . $v['user_id'] . '" class="invoice-action-view mr-4" title="Thông tin khách hàng"><i class="material-icons">perm_identity</i></a>
																		<a href="invoice.html?invoice_id=' . $v['invoice_id'] . '" class="invoice-action-view mr-4" title="Chi tiết đơn hàng"><i class="material-icons">remove_red_eye</i></a>
																	</div>
																</td>
															</tr>';
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<!-- Pagination -->
							<div class="col s12 center">
								<ul class="pagination">
									<?php
									// $total = $invoices->getCount();
									$limit = (($page - 1) * DATA_PER_PAGE) . ',' . DATA_PER_PAGE;
									$end_page =  ceil($total / DATA_PER_PAGE);
									$page_item = [];
									for ($i = 1; $i <= $end_page; $i++) if (abs($page - $i) <= 3 || $i == 1 || $i == $end_page) {
										$page_item[] = $i;
										echo '<li class="' . ($page == $i ? 'active' : 'waves-effect') . '"><a href="?page=' . $i . '">' . $i . '</a></li>';
									}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content-overlay"></div>
		</div>
	</div>
</div>
<!-- END: Page Main-->
<?php
include 'views/footer.php';
?>