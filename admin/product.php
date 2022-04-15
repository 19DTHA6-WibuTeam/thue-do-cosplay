<?php
include 'views/header.php';

$products = new Products();
if (isset($_POST['submit'])) {
	$product_id = is_int($_POST['product_id']) ? $_POST['product_id'] : '';
	$product_name = $_POST['product_name'];
	$product_type_id = $_POST['product_type_id'];
	$product_price = $_POST['product_price'];
	$product_rental_price = $_POST['product_rental_price'];
	$product_img = $_POST['product_img'];
	$product_quantity = $_POST['product_quantity'];
	$product_sizes = $_POST['product_sizes'];
	$product_weight = $_POST['product_weight'];
	if ($product_sizes == NULL) $product_sizes = array();
	$product_description = $_POST['product_description'];
	if ($_GET['act'] == 'add') {
		// echo '<script>alert("Test!");</script>';
		// var_dump($_POST);
		$res =	$products->postProduct($product_name, $product_type_id, $product_price, $product_rental_price, $product_img, $product_quantity, implode('|', $product_sizes), $product_weight, $product_description);
		if ($res) {
			echo '<script>alert("Thêm thành công!");</script>';
			$product_id = $product_name = $product_type_id = $product_price = $product_rental_price = $product_img = $product_quantity = $product_weight = $product_description = '';
			$product_sizes = array();
			$_POST = array();
		} else echo '<script>alert("Thêm thất bại!");</script>';
	} else if ($_GET['act'] == 'edit') {
		$res =	$products->updateProduct($_GET['product_id'], $product_name, $product_type_id, $product_price, $product_rental_price, $product_img, $product_quantity, implode('|', $product_sizes), $product_weight, $product_description);
		if ($res) echo '<script>alert("Chỉnh sửa thành công!");</script>';
		else echo '<script>alert("Chỉnh sửa thất bại!");</script>';
	}
} else {
	if ($_GET['act'] == 'edit') {
		$product = $products->getProductById($_GET['product_id']);
		if ($product != false) {
			$product_id = $product['product_id'];
			$product_name = $product['product_name'];
			$product_type_id = $product['product_type_id'];
			$product_price = $product['product_price'];
			$product_rental_price = $product['product_rental_price'];
			$product_img = $product['product_img'];
			$product_quantity = $product['product_quantity'];
			$product_sizes = $product['product_sizes'];
			if ($product_sizes == NULL) $product_sizes = '';
			$product_sizes = explode('|', $product_sizes);
			$product_weight = $product['product_weight'];
			$product_description = $product['product_description'];
		}
	} else {
		$product_id = $product_name = $product_type_id = $product_price = $product_rental_price = $product_img = $product_quantity = $product_weight = $product_description = '';
		$product_sizes = array();
	}
}
$_SESSION['captcha-product'] = generateRandomString();
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
						<h5 class="breadcrumbs-title mt-0 mb-0"><span>Sản phẩm</span></h5>
						<ol class="breadcrumbs mb-0">
							<li class="breadcrumb-item"><a href="index.html">Trang chủ</a>
							</li>
							<li class="breadcrumb-item active"><?php echo $product_id == '' ? 'Thêm' : 'Sửa'; ?> sản phẩm</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="col s12">
			<div class="container">
				<div class="card">
					<div class="card-content">
						<p class="caption mb-0"><?php if ($product_id) echo 'Mã sản phẩm: #PROD' . $product_id; ?></p>
					</div>
				</div>
				<!-- Input Fields -->
				<div class="row">
					<div class="col s12">
						<div id="input-fields" class="card card-tabs">
							<div class="card-content">
								<div class="card-title">
									<div class="row">
										<div class="col s12 m6 l10">
											<h4 class="card-title">Nhập thông tin</h4>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col s12">
										<p>Bla bla...</p>
										<br>
										<form class="row" method="POST" action="">
											<div class="col s12">
												<div class="input-field col s12">
													<input id="product_name" name="product_name" type="text" value="<?php echo $product_name; ?>" class="validate" required />
													<label for="product_name">Tên sản phẩm *</label>
												</div>
											</div>
											<div class="col s6">
												<div class="input-field col s3">
													<select id="product_type_id" name="product_type_id" required>
														<!-- <option value="0" selected>---</option> -->
														<?php
														$productTypes = new ProductTypes();
														foreach ($productTypes->getProductTypes() as $k => $v) {
															echo '<option value="' . $v['product_type_id'] . '"' . ($product_type_id == $v['product_type_id'] ? ' selected' : '') . '>' . $v['product_type_name'] . '</option>';
														}
														?>
													</select>
													<label>Phân loại *</label>
												</div>
												<div class="input-field col s3">
													<input id="product_price" name="product_price" type="number" value="<?php echo $product_price; ?>" min="0" class="validate" required />
													<label for="product_price">Giá mua gốc *</label>
												</div>
												<div class="input-field col s3">
													<input id="product_rental_price" name="product_rental_price" type="number" value="<?php echo $product_rental_price; ?>" min="0" class="validate" required />
													<label for="product_rental_price">Giá thuê *</label>
												</div>
												<div class="input-field col s3">
													<input id="product_quantity" name="product_quantity" type="number" value="<?php echo $product_quantity; ?>" min="0" class="validate" required />
													<label for="product_quantity">Số lượng</label>
												</div>
											</div>
											<div class="col s3">
												<div class="input-field">
													<h6>Kích cỡ</h6>
													<select class="select2-size-sm browser-default" multiple="multiple" id="default-select-multi" name="product_sizes[]">
														<?php
														$product_size = array('S', 'M', 'L', 'XL');
														for ($i = 0; $i < count($product_size); $i++) {
															$size = $product_size[$i];
															$flag = false;
															foreach ($product_sizes as $v)
																if ($size == $v) {
																	$flag = true;
																	break;
																}
															echo '<option value="' . $size . '"' . ($flag == true ? ' selected' : '') . '>' . $size . '</option>';
														}
														?>
														<!-- <option value="S">S</option>
														<option value="M">M</option>
														<option value="L">L</option>
														<option value="XL">XL</option> -->
													</select>
												</div>
											</div>
											<div class="col s3">
												<div class="input-field col s12">
													<input id="product_weight" name="product_weight" type="number" value="<?php echo $product_weight; ?>" min="0" class="validate" required />
													<label for="product_weight">Khối lượng / Cân nặng (đơn vị: gram) *</label>
												</div>
											</div>
											<div class="col s12">
												<div class="input-field col s12">
													<input id="product_img" name="product_img" type="text" value="<?php echo $product_img; ?>" class="validate" required />
													<label for="product_img">Link ảnh (mỗi link cách nhau bởi dấu gạch đứng | ) *</label>
												</div>
											</div>
											<div class="col s12">
												<!-- <div id="snow-wrapper">
													<div id="snow-container">
														<div class="quill-toolbar">
															<span class="ql-formats">
																<button class="ql-bold"></button>
																<button class="ql-italic"></button>
																<button class="ql-underline"></button>
															</span>
															<span class="ql-formats">
																<button class="ql-list" value="ordered"></button>
																<button class="ql-list" value="bullet"></button>
																<select class="ql-align">
																	<option label="left" selected></option>
																	<option label="center" value="center"></option>
																	<option label="right" value="right"></option>
																	<option label="justify" value="justify"></option>
																</select>
															</span>
															<span class="ql-formats">
																<button class="ql-link"></button>
																<button class="ql-image"></button>
																<button class="ql-video"></button>
															</span>
															<span class="ql-formats">
																<button class="ql-clean"></button>
															</span>
														</div>
														<div class="editor"></div>
													</div>
												</div> -->
												<div class="input-field col s12">
													<textarea id="product_description" name="product_description" class="materialize-textarea"><?php echo $product_description; ?></textarea>
													<label for="product_description">Nội dung / Mô tả (có thể Enter xuống hàng)</label>
												</div>
											</div>
											<div class="col s12">
												<div class="input-field col s12">
													<input id="captcha-add-product" name="captcha-add-product" type="hidden" value="<?php echo $_SESSION['captcha-product']; ?>" />
													<button class="btn cyan waves-effect waves-light right" type="submit" name="submit">Thực hiện<i class="material-icons right">send</i></button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div style="bottom: 50px; right: 19px;" class="fixed-action-btn direction-top"><a class="btn-floating btn-large gradient-45deg-light-blue-cyan gradient-shadow"><i class="material-icons">add</i></a>
					<ul>
						<li><a href="#" class="btn-floating blue"><i class="material-icons">help_outline</i></a></li>
						<li><a href="#" class="btn-floating green"><i class="material-icons">widgets</i></a></li>
						<li><a href="#" class="btn-floating amber"><i class="material-icons">today</i></a></li>
						<li><a href="#" class="btn-floating red"><i class="material-icons">mail_outline</i></a></li>
					</ul>
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