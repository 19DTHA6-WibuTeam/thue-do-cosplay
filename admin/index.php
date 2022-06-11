<?php
include 'views/header.php';

$statistic = new Statistic();
?>
<!-- BEGIN: Page Main-->
<div id="main">
	<div class="row">
		<div class="content-wrapper-before gradient-45deg-purple-deep-purple"></div>
		<div class="col s12">
			<div class="container">
				<div class="section">
					<div id="card-stats" class="pt-0">
						<div class="row">
							<div class="col s12 m6 l6 xl3">
								<div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
									<div class="padding-4">
										<div class="row">
											<div class="col s7 m7">
												<i class="material-icons background-round mt-5">add_shopping_cart</i>
												<p>Tổng đơn hàng</p>
											</div>
											<div class="col s5 m5 right-align">
												<h5 class="mb-0 white-text"><?php echo $statistic->totalInvoices(); ?></h5>
												<!-- <p class="no-margin">New</p>
												<p>6,00,00</p> -->
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col s12 m6 l6 xl3">
								<div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeLeft">
									<div class="padding-4">
										<div class="row">
											<div class="col s7 m7">
												<i class="material-icons background-round mt-5">perm_identity</i>
												<p>Tổng khách hàng</p>
											</div>
											<div class="col s5 m5 right-align">
												<h5 class="mb-0 white-text"><?php echo $statistic->totalUsers(); ?></h5>
												<!-- <p class="no-margin">New</p>
												<p>1,12,900</p> -->
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col s12 m6 l6 xl3">
								<div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text animate fadeRight">
									<div class="padding-4">
										<div class="row">
											<div class="col s7 m7">
												<i class="material-icons background-round mt-5">timeline</i>
												<p>Tổng sản phẩm</p>
											</div>
											<div class="col s5 m5 right-align">
												<h5 class="mb-0 white-text"><?php echo $statistic->totalProducts(); ?></h5>
												<!-- <p class="no-margin">Growth</p>
												<p>3,42,230</p> -->
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col s12 m6 l6 xl3">
								<div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
									<div class="padding-4">
										<div class="row">
											<div class="col s7 m7">
												<i class="material-icons background-round mt-5">attach_money</i>
												<p>Doanh thu</p>
											</div>
											<div class="col s5 m5 right-align">
												<h5 class="mb-0 white-text"><?php echo formatPrice($statistic->totalRevenue()); ?>đ</h5>
												<p class="no-margin"></p>
												<p>(ước tính)</p>
											</div>
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
	</div>
</div>
<!-- END: Page Main-->
<?php
include 'views/footer.php';
?>