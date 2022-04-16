<?php
include 'views/header.php';

$page = $_GET['page'];
if ($page < 1 || $page == '' || !is_numeric($page)) $page = 1;
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
													<!-- <tr>
														<td>Alvin</td>
														<td>Eclair</td>
														<td>$0.87</td>
														<td>qwe</td>
														<td>asd</td>
														<td>zxc</td>
														<td><span class="chip lighten-5 green green-text">PAID</span></td>
														<td>
															<div class="invoice-action">
																<a href="app-invoice-view.html" class="invoice-action-view mr-4">
																	<i class="material-icons">remove_red_eye</i>
																</a>
																<a href="app-invoice-edit.html" class="invoice-action-edit">
																	<i class="material-icons">edit</i>
																</a>
															</div>
														</td>
													</tr> -->
													<?php
													$invoices = new Invoice;
													foreach ($invoices->getInvoices() as $k => $v) {
														echo '<tr>
																<td>INV-' . $v['invoice_id'] . '</td>
																<td>' . $v['invoice_user_fullname'] . '</td>
																<td>' . $v['invoice_user_phone_number'] . '</td>
																<td>' . $v['invoice_user_email'] . '</td>
																<td>' . number_format($v['invoice_subtotal'] + $v['invoice_fee_transport'] + $v['invoice_fee_bond'], 0, ',', '.') . 'đ</td>
																<td>' . date('Y-m-d', $v['invoice_created_at']) . '</td>
																<td>' . ($v['invoice_status'] == 0 ? '<span class="chip lighten-5 red red-text">ĐÃ HUỶ</span>' : ($v['invoice_status'] == 2 ? '<span class="chip lighten-5 green green-text">ĐÃ THANH TOÁN</span>' : '<span class="chip lighten-5 orange orange-text">CHỜ THANH TOÁN</span>')) . '</td>
																<td>
																	<div class="invoice-action">
																		<a href="invoice.html?invoice_id=' . $v['invoice_id'] . '" class="invoice-action-view mr-4"><i class="material-icons">remove_red_eye</i></a>
																		<!--<a href="app-invoice-edit.html" class="invoice-action-edit"><i class="material-icons">edit</i></a>-->
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
									$total = $invoices->getCount();
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