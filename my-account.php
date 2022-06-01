<?php
include 'views/header.php';

$user_phone_number = $user_address = '';
$users = new User();
if (isset($_POST['submit'])) {
	switch ($_POST['submit']) {
		case 'update_info':
			$users->updateUser($_SESSION['user_id'], $_POST['user_fullname'], $_POST['user_email'], $_POST['user_phone_number'], $_POST['user_address'], $_POST['user_bank_account_number'], $_POST['user_bank_name']);
			break;
		case 'change_pass':
			if ($_POST['user_password'] == $_POST['user_password_again']) $users->changePassword($_SESSION['user_id'], $_POST['user_password']);
			else echo "<script>alert('Mật khẩu nhập lại không trùng khớp!');</script>";
			break;
		default:
			break;
	}
}
$user = $users->getUser($_SESSION['user_id']);
$users->updateSession($user['user_fullname'], $user['user_email']);
$user_phone_number = $user['user_phone_number'];
$user_address = $user['user_address'];
$user_bank_account_number = $user['user_bank_account_number'];
$user_bank_name = $user['user_bank_name'];
?>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="breadcrumb_content">
					<ul>
						<li><a href="index.html">Trang chủ</a></li>
						<li>Tài khoản</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--breadcrumbs area end-->

<!-- my account start  -->
<section class="main_content_area">
	<div class="container">
		<div class="account_dashboard">
			<div class="row">
				<div class="col-sm-12 col-md-3 col-lg-3">
					<!-- Nav tabs -->
					<div class="dashboard_tab_button">
						<ul role="tablist" class="nav flex-column dashboard-list">
							<li><a href="#dashboard" data-bs-toggle="tab" class="nav-link active">Tổng quan</a></li>
							<li> <a href="#orders" data-bs-toggle="tab" class="nav-link">Đơn hàng</a></li>
							<!-- <li><a href="#downloads" data-bs-toggle="tab" class="nav-link">Downloads</a></li> -->
							<!-- <li><a href="#address" data-bs-toggle="tab" class="nav-link">Địa chỉ</a></li> -->
							<li><a href="#account-details" data-bs-toggle="tab" class="nav-link">Chi tiết tài khoản</a></li>
							<!-- <li><a href="logout.html" class="nav-link">Đăng xuất</a></li> -->
						</ul>
					</div>
				</div>
				<div class="col-sm-12 col-md-9 col-lg-9">
					<!-- Tab panes -->
					<div class="tab-content dashboard_content">
						<div class="tab-pane fade show active" id="dashboard">
							<h3>Thông tin </h3>
							<p>Tại đây, bạn có thể kiểm tra lịch sử mua hàng & chỉnh sửa thông tin tài khoản.</a></p>
						</div>
						<div class="tab-pane fade" id="orders">
							<h3>Đơn hàng</h3>
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
											<th>Đơn hàng</th>
											<th>Ngày</th>
											<th>Trạng thái</th>
											<th>Tổng số tiền</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<!-- <tr>
											<td>1</td>
											<td>May 10, 2018</td>
											<td><span class="success">Completed</span></td>
											<td>$25.00 for 1 item </td>
											<td><a href="cart.html" class="view">view</a></td>
										</tr>
										<tr>
											<td>2</td>
											<td>May 10, 2018</td>
											<td>Processing</td>
											<td>$17.00 for 1 item </td>
											<td><a href="cart.html" class="view">view</a></td>
										</tr> -->
										<?php
										$invoices = new Invoice;
										foreach ($invoices->getInvoicesByUserId($_SESSION['user_id'], 0, 0) as $k => $v) {
											echo '<tr>
													<td>' . $v['invoice_id'] . '</td>
													<td>' . date("Y-m-d", $v['invoice_created_at']) . '</td>
													<td>' . $v['invoice_status_name'] . '</td>
													<td>' . formatPrice($v['invoice_subtotal'] + $v['invoice_fee_transport'] + $v['invoice_fee_bond']) . 'đ</td>
													<td><a href="invoice.html?invoice_id=' . $v['invoice_id'] . '" class="view">Xem chi tiết</a></td>
												</tr>';
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
						<div class="tab-pane fade" id="account-details">
							<h3>Chi tiết tài khoản</h3>
							<div class="login">
								<div class="login_form_container">
									<div class="account_login_form">
										<form method="POST" action="">
											<!-- <p>Already have an account? <a href="#">Log in instead!</a></p> -->
											<!-- <div class="input-radio">
                                                <span class="custom-radio"><input type="radio" value="1" name="id_gender"> Mr.</span>
                                                <span class="custom-radio"><input type="radio" value="1" name="id_gender"> Mrs.</span>
                                            </div> <br /> -->
											<label>Họ tên *</label>
											<input type="text" name="user_fullname" id="user_fullname" value="<?PHP echo $_SESSION['user_fullname']; ?>" required />
											<label>Địa chỉ Email *</label>
											<input type="email" name="user_email" id="user_email" value="<?PHP echo $_SESSION['user_email']; ?>" required />
											<label>Số điện thoại *</label>
											<input type="text" name="user_phone_number" id="user_phone_number" value="<?PHP echo $user_phone_number; ?>" pattern="(84|0[3|5|7|8|9])+([0-9]{8})" required />
											<label>Địa chỉ giao hàng mặc định *</label>
											<input type="text" name="user_address" id="user_address" value="<?PHP echo $user_address; ?>" required />
											<p>Thông tin ngân hàng được dùng để HOÀN LẠI phí đảm bảo tài sản:</p>
											<label>Số tài khoản ngân hàng *</label>
											<input type="text" name="user_bank_account_number" id="user_bank_account_number" value="<?PHP echo $user_bank_account_number; ?>" pattern="[0-9]+" required />
											<label>Tên ngân hàng *</label>
											<input type="text" name="user_bank_name" id="user_bank_name" value="<?PHP echo $user_bank_name; ?>" required />
											<!-- <br />
                                            <span class="custom_checkbox">
                                                <input type="checkbox" value="1" name="optin">
                                                <label>Receive offers from our partners</label>
                                            </span>
                                            <br />
                                            <span class="custom_checkbox">
                                                <input type="checkbox" value="1" name="newsletter">
                                                <label>Sign up for our newsletter<br><em>You may unsubscribe at any moment. For that purpose, please find our contact info in the legal notice.</em></label>
                                            </span> -->
											<div class="save_button primary_btn default_button">
												<button type="submit" name="submit" value="update_info">Lưu</button>
											</div>
										</form>
									</div>
									<hr style="background: #180000;" />
									<div class="account_login_form">
										<form method="POST" action="">
											<!-- <label>Mật khẩu cũ</label>
											<input type="password" name="user_password_old" minlength="6" required /> -->
											<label>Mật khẩu mới</label>
											<input type="password" name="user_password" minlength="6" required />
											<label>Nhập lại mật khẩu mới</label>
											<input type="password" name="user_password_again" minlength="6" required />
											<div class="save_button primary_btn default_button">
												<button type="submit" name="submit" value="change_pass">Đổi mật khẩu</button>
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
	</div>
</section>
<!-- my account end   -->
<?php
include 'views/footer.php';
?>