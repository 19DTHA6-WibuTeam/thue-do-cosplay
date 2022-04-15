<?php
include 'views/header.php';
?>
<!-- BEGIN: Page Main-->
<div id="main">
	<div class="row">
		<div class="content-wrapper-before gradient-45deg-purple-deep-purple"></div>
		<div class="col s12">
			<div class="container">
				<div class="section">
					<!-- Current balance & total transactions cards-->
					<div class="row vertical-modern-dashboard">
						<!-- <div class="col s12 m4 l4">
							<div class="card animate fadeLeft">
								<div class="card-content">
									<h6 class="mb-0 mt-0 display-flex justify-content-between">Current balance</h6>
									<p class="medium-small">This billing cycle</p>
									<div class="current-balance-container">
										<div id="current-balance-donut-chart" class="current-balance-shadow"></div>
									</div>
									<h5 class="center-align">$ 50,150.00</h5>
									<p class="medium-small center-align">Used balance this billing cycle</p>
								</div>
							</div>
						</div> -->
						<div class="col s12 m8 l8 animate fadeRight">
							<div class="card">
								<div class="card-content">
									<h4 class="card-title mb-0">Total Transaction <i class="material-icons float-right">more_vert</i></h4>
									<p class="medium-small">This month transaction</p>
									<div class="total-transaction-container">
										<div id="total-transaction-line-chart" class="total-transaction-shadow">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/ Current balance & total transactions cards-->

					<!-- User statistics & appointment cards-->
					<!-- <div class="row">
						<div class="col s12 l5">
							<div class="card user-statistics-card animate fadeLeft">
								<div class="card-content">
									<h4 class="card-title mb-0">User Statistics <i class="material-icons float-right">more_vert</i></h4>
									<div class="row">
										<div class="col s12 m6">
											<ul class="collection border-none mb-0">
												<li class="collection-item avatar">
													<i class="material-icons circle pink accent-2">trending_up</i>
													<p class="medium-small">This year</p>
													<h5 class="mt-0 mb-0">60%</h5>
												</li>
											</ul>
										</div>
										<div class="col s12 m6">
											<ul class="collection border-none mb-0">
												<li class="collection-item avatar">
													<i class="material-icons circle purple accent-4">trending_down</i>
													<p class="medium-small">Last year</p>
													<h5 class="mt-0 mb-0">40%</h5>
												</li>
											</ul>
										</div>
									</div>
									<div class="user-statistics-container">
										<div id="user-statistics-bar-chart" class="user-statistics-shadow ct-golden-section"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col s12 l4">
							<div class="card recent-buyers-card animate fadeUp">
								<div class="card-content">
									<h4 class="card-title mb-0">Recent Buyers <i class="material-icons float-right">more_vert</i></h4>
									<p class="medium-small pt-2">Today</p>
									<ul class="collection mb-0">
										<li class="collection-item avatar">
											<img src="./app-assets/images/avatar/avatar-7.png" alt="" class="circle" />
											<p class="font-weight-600">John Doe</p>
											<p class="medium-small">18, January 2019</p>
											<a href="#!" class="secondary-content"><i class="material-icons">star_border</i></a>
										</li>
										<li class="collection-item avatar">
											<img src="./app-assets/images/avatar/avatar-3.png" alt="" class="circle" />
											<p class="font-weight-600">Adam Garza</p>
											<p class="medium-small">20, January 2019</p>
											<a href="#!" class="secondary-content"><i class="material-icons">star_border</i></a>
										</li>
										<li class="collection-item avatar">
											<img src="./app-assets/images/avatar/avatar-5.png" alt="" class="circle" />
											<p class="font-weight-600">Jennifer Rice</p>
											<p class="medium-small">25, January 2019</p>
											<a href="#!" class="secondary-content"><i class="material-icons">star_border</i></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col s12 l3">
							<div class="card animate fadeRight">
								<div class="card-content">
									<h4 class="card-title mb-0">Conversion Ratio</h4>
									<div class="conversion-ration-container mt-8">
										<div id="conversion-ration-bar-chart" class="conversion-ration-shadow">
										</div>
									</div>
									<p class="medium-small center-align">This month conversion ratio</p>
									<h5 class="center-align mb-0 mt-0">62%</h5>
								</div>
							</div>
						</div>
					</div> -->
					<!--/ Current balance & appointment cards-->

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