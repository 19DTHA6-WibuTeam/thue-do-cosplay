<?php
include 'views/header.php';

$page = $_GET['page'];
if ($page < 1 || $page == '' || !is_numeric($page)) $page = 1;

$products = new Products();
if (!empty(getGET('keyword'))) {
	$listProducts = $products->search(getGET('keyword'), 1, $page);
	$total = $products->getCountSearch(getGET('keyword'));
} else {
	if (!empty(getGET('product_type_id'))) {
		$listProducts = $products->getProductsByProductTypeId(getGET('product_type_id'), 1, $page);
		$total = $products->getCountProductsByProductTypeId(getGET('product_type_id'));
	} else {
		$listProducts = $products->getProducts(1, $page);
		$total = $products->getCount();
	}
}
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
						<h5 class="breadcrumbs-title mt-0 mb-0"><span>Danh sách sản phẩm</span></h5>
						<ol class="breadcrumbs mb-0">
							<li class="breadcrumb-item"><a href="index.html">Sản phẩm</a>
							</li>
							<li class="breadcrumb-item active">Danh sách sản phẩm</li>
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
												<h4 class="card-title">Lọc sản phẩm</h4>
											</div>
											<!-- <div class="col s12 m6 l2">
												<ul class="tabs">
													<li class="tab col s6 p-0"><a class="active p-0" href="#view-input-fields">View</a></li>
													<li class="tab col s6 p-0"><a class="p-0" href="#html-input-fields">Html</a></li>
												</ul>
											</div> -->
										</div>
									</div>
									<div class="row">
										<div class="col s12">
											<p>Tìm kiếm nhanh sản phẩm theo tên hoặc loại sản phẩm.</p>
											<br>
											<form class="row" method="get" action="">
												<div class="col s4">
													<div class="input-field col s12">
														<input placeholder="keyword" id="keyword" type="text" class="validate" name="keyword" />
														<label for="keyword">Tên sản phẩm</label>
													</div>
												</div>
												<div class="col s4">
													<div class="input-field col s12">
														<select class="select2 browser-default" name="product_type_id" id="product_type_id">
															<option value="0" selected>Tất cả</option>
															<?php
															$productTypes = new ProductTypes();
															$listProductTypes = '';
															foreach ($productTypes->getProductTypes() as $k => $v) {
																$listProductTypes .= '<option value="' . $v['product_type_id'] . '">' . $v['product_type_name'] . '</option>';
															}
															echo $listProductTypes;
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
					<div class="row" id="ecommerce-products">
						<div class="col s12 m12 l12 pr-0">
							<?php
							// $products = new Products();
							foreach ($listProducts as $k => $v) {
								$product_price = number_format($v['product_price'], 0, ',', '.');
								$product_rental_price = number_format($v['product_rental_price'], 0, ',', '.');
								$product_img = explode('|', $v['product_img'])[0];
								echo '<div class="col s12 m3 l3">
										<div class="card animate fadeUp">
											<div class="card-content">
												<p>' . $v['product_type_name'] . '</p>
												<span class="card-title text-ellipsis">' . $v['product_name'] . '</span>
												<!--<img src="' . $product_img . '" class="responsive-img" alt="" />-->
												<div style="width: 100%; background-image: url(\'' . $product_img . '\'); background-size: contain; background-repeat: no-repeat; padding-top: 100%;"></div>
												<div class="display-flex flex-wrap justify-content-center">
													<h6 class="mt-3">' . $product_rental_price . 'đ</h6>
													<a class="mt-2 waves-effect waves-light gradient-45deg-deep-purple-blue btn btn-block modal-trigger z-depth-4" href="#modal' . $k . '">Xem thông tin</a>
												</div>
											</div>
										</div>
										<!-- Modal Structure -->
										<div id="modal' . $k . '" class="modal">
											<div class="modal-content">
												<a class="modal-close right"><i class="material-icons">close</i></a>
												<div class="row" id="product-two">
													<div class="col m6 s12">
														<img src="' . $product_img . '" class="responsive-img" alt="" />
													</div>
													<div class="col m6 s12">
														<p>' . $v['product_type_name'] . '</p>
														<h5>' . $v['product_name'] . '</h5>
														<!--<span class="new badge left ml-0 mr-2" data-badge-caption="">4.2 Star</span>-->
														<p>Tình trạng: <span class="red-text">' . ($v['product_quantity'] > 0 ? 'Còn ' . $v['product_quantity'] . ' sản phẩm' : 'Hết hàng') . '</span></p>
														<hr class="mb-5">
														<!--<span class="vertical-align-top mr-4"><i class="material-icons mr-3">favorite_border</i>Wishlist</span>-->
														<!--<ul class="list-bullet">
															<li class="list-item-bullet">Fine-tuned acoustics for clarity</li>
															<li class="list-item-bullet">Streamlined design for a custom-fit</li>
															<li class="list-item-bullet">Durable and foldable so you can take them on-the-go</li>
															<li class="list-item-bullet">ake calls and control music with RemoteTalk cable</li>
														</ul>-->
														<p>' . $v['product_description'] . '</p>
														<h6>Giá mua gốc:&nbsp;' . $product_price . 'đ</h6>
														<h6>Giá thuê:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $product_rental_price . 'đ</h6>
														<a href="edit-product.html?product_id=' . $v['product_id'] . '" class="waves-effect waves-light btn gradient-45deg-deep-purple-blue mt-2 mr-2">CHỈNH SỬA</a>
														<!--<a class="waves-effect waves-light btn gradient-45deg-purple-deep-orange mt-2">BUY NOW</a>-->
													</div>
												</div>
											</div>
										</div>
									</div>';
							}
							?>
							<!-- Pagination -->
							<div class="col s12 center">
								<ul class="pagination">
									<?php
									// $total = $products->getCount();
									$limit = (($page - 1) * DATA_PER_PAGE) . ',' . DATA_PER_PAGE;
									$end_page =  ceil($total / DATA_PER_PAGE);
									$page_item = [];
									for ($i = 1; $i <= $end_page; $i++) if (abs($page - $i) <= 3 || $i == 1 || $i == $end_page) {
										$page_item[] = $i;
										echo '<li class="' . ($page == $i ? 'active' : 'waves-effect') . '"><a href="?page=' . $i . '">' . $i . '</a></li>';
									}
									?>
									<!-- <li class="disabled">
										<a href="#!">
											<i class="material-icons">chevron_left</i>
										</a>
									</li>
									<li class="active"><a href="#!">1</a>
									</li>
									<li class="waves-effect"><a href="#!">2</a>
									</li>
									<li class="waves-effect"><a href="#!">3</a>
									</li>
									<li class="waves-effect"><a href="#!">4</a>
									</li>
									<li class="waves-effect"><a href="#!">5</a>
									</li>
									<li class="waves-effect">
										<a href="#!">
											<i class="material-icons">chevron_right</i>
										</a>
									</li> -->
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