<?php
include 'views/header.php';

$si_user_email = $si_user_password = $su_user_fullname = $su_user_email = $su_user_password = $su_user_password_again = '';
if (isset($_POST['submit'])) {
	$users = new User();
	switch ($_POST['submit']) {
		case 'sign_in':
			$si_user_email = $_POST['user_email'];
			$si_user_password = $_POST['user_password'];
			$user = $users->login($si_user_email, $si_user_password);
			if ($user) {
				echo '<script>alert("Đăng nhập thành công! Đang chuyển hướng đến trang chủ...");location.replace("./");</script>';
				$users->startSession($user);
				header('Location: ./');
			} else echo '<script>alert("Tài khoản không đúng! Vui lòng thử lại!");</script>';
			break;
		case 'sign_up':
			$su_user_fullname = $_POST['user_fullname'];
			$su_user_email = $_POST['user_email'];
			$su_user_password = $_POST['user_password'];
			$su_user_password_again = $_POST['user_password_again'];
			if (Recaptcha::Verify($_POST['g-recaptcha-response'])) {
				if ($su_user_password == $su_user_password_again)
					if ($users->register($su_user_fullname, $su_user_email, $su_user_password)) {
						echo '<script>alert("Đăng ký thành công! Vui lòng đăng nhập!");</script>';
						$si_user_email = $si_user_password = $su_user_fullname = $su_user_email = $su_user_password = $su_user_password_again = '';
					} else echo '<script>alert("Đăng ký thất bại!");</script>';
				else echo '<script>alert("Mật khẩu nhập lại không trùng khớp!! Vui lòng thử lại!");</script>';
			} else echo '<script>alert("Xác minh không thành công! Vui lòng thử lại!");</script>';
			break;
		default:
			break;
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
						<li>Tài khoản</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!--breadcrumbs area end-->

<!-- customer login start -->
<div class="customer_login mt-60">
	<div class="container">
		<div class="row">
			<!--login area start-->
			<div class="col-lg-6 col-md-6">
				<div class="account_form">
					<h2>Đăng nhập</h2>
					<form method="POST" action="">
						<p>
							<label>Địa chỉ email <span>*</span></label>
							<input name="user_email" type="email" value="<?php echo $si_user_email; ?>" required />
						</p>
						<p>
							<label>Mật khẩu <span>*</span></label>
							<input name="user_password" type="password" minlength="6" required />
						</p>
						<div class="login_submit">
							<a href="#">Quên mật khẩu?</a>
							<label for="remember"><input id="remember" type="checkbox" />Remember me</label>
							<button type="submit" name="submit" value="sign_in">Đăng nhập</button>

						</div>

					</form>
				</div>
			</div>
			<!--login area start-->

			<!--register area start-->
			<div class="col-lg-6 col-md-6">
				<div class="account_form register">
					<h2>Đăng ký</h2>
					<form method="POST" action="">
						<p>
							<label>Họ tên <span>*</span></label>
							<input name="user_fullname" type="text" value="<?php echo $su_user_fullname; ?>" required />
						</p>
						<p>
							<label>Địa chỉ Email <span>*</span></label>
							<input name="user_email" type="email" value="<?php echo $su_user_email; ?>" required />
						</p>
						<p>
							<label>Mật khẩu <span>*</span></label>
							<input name="user_password" type="password" minlength="6" required />
						</p>
						<p>
							<label>Nhập lại mật khẩu <span>*</span></label>
							<input name="user_password_again" type="password" minlength="6" required />
						</p>
						<div class="form-group">
							<div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>"></div>
						</div>
						<div class="login_submit">
							<button type="submit" name="submit" value="sign_up">Đăng ký</button>
						</div>
					</form>
				</div>
			</div>
			<!--register area end-->
		</div>
	</div>
</div>
<!-- customer login end -->
<?php
include 'views/footer.php';
?>