<!--footer area start-->
<footer class="footer_widgets">
	<div class="footer_top">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-6 col-sm-7">
					<div class="widgets_container contact_us">
						<div class="footer_logo">
							<a href="index.html"><img src="assets/img/logo/logo.webp" alt=""></a>
						</div>
						<div class="footer_desc">
							<p>Website cho thuê các loại Wig, phụ kiện, trang phục Cosplay...</p>
						</div>

						<p><span>Địa chỉ:</span> KCN cao, TP. Thủ Đức trực thuộc TP. HCM</p>
						<p><span>Email:</span> <a href="javascript:void();">contact@wibuteam.phatdev.xyz</a></p>
						<p><span>Số điện thoại:</span> <a href="tel:+84777100xxx">+84 777 100 xxx</a></p>
					</div>
				</div>
				<div class="col-lg-2 col-md-6 col-sm-5">
					<div class="widgets_container widget_menu">
						<h3>Thông tin</h3>
						<div class="footer_menu">
							<ul>
								<li><a href="about.html">About Us</a></li>
								<li><a href="products.html">Sản phẩm mới</a></li>
								<li><a href="my-account.html">Tài khoản</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="footer_bottom">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6 col-md-6">
					<div class="copyright_area">
						<p>Copyright &copy; 2022 <a href="javascript:void();">WibuTeam</a>.</p>
					</div>
				</div>
				<div class="col-lg-6 col-md-6">
				</div>
			</div>
		</div>
	</div>
</footer>
<!--footer area end-->

<!-- JS
============================================ -->
<!-- Plugins JS -->
<script src="assets/js/plugins.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!-- <script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_SITE_KEY; ?>"></script> -->
<!-- Main JS -->
<script src="assets/js/main.js"></script>
<script src="admin/app-assets/vendors/select2/select2.full.min.js"></script>
<script src="//rawgit.com/notifyjs/notifyjs/master/dist/notify.js"></script>
<script>
	$(".select2").select2({
		dropdownAutoWidth: true,
		width: '100%',
		minimumResultsForSearch: Infinity,
	});
	if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
	}

	function redirectParams(name, value) {
		var url = new URL(window.location.href);
		url.searchParams.set(name, value);
		window.location.href = url.href;
	}
	var select_option = document.getElementById('select_option');
	try {
		select_option.onchange = function() {
			redirectParams('order_by', document.getElementById('order_by').value);
		};
	} catch (e) {}

	function pagination(num) {
		redirectParams('page', num);
	}

	function numberWithDot(x) {
		return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
	}

	function add_to_cart(product_id, cart_product_quantity = 1) {
		$.ajax({
			type: "POST",
			url: "api/?action=post_cart&user_id=<?php if (isset($_SESSION['user_id'])) echo $_SESSION['user_id']; ?>&cart_product_quantity=" + cart_product_quantity + "&product_id=" + product_id,
			// data: q,
			success: function(result) {
				// console.log(result);
				// result = JSON.parse(result);
				if (result.success) $.notify("Đã thêm vào giỏ hàng!", "success");
				else $.notify("<?php echo isset($_SESSION['user_id']) == true ? 'Không thể thêm vào giỏ hàng!' : 'Vui lòng đăng nhập để thêm vào giỏ hàng!'; ?>", "error");
			}
		});
	}

	function add_to_cart_(product_id) {
		add_to_cart(product_id, $('#product_quantity').val());
		return false;
	}

	function update_cart(product_id, cart_product_quantity) {
		$.ajax({
			type: "POST",
			url: "api/?action=update_cart&user_id=<?php if (isset($_SESSION['user_id'])) echo $_SESSION['user_id']; ?>&product_id=" + product_id + '&cart_product_quantity=' + cart_product_quantity,
			// data: q,
			success: function(result) {
				if (result.success) {
					$.notify("Cập nhật giỏ hàng thành công!", "success");
					$('#product_subtotal_' + product_id).text(numberWithDot(cart_product_quantity * $('#product_price_' + product_id).data('price')) + 'đ');
					// Cập nhật tạm tính
					var cart_subtotal = 0;
					$('.product_price').each(function() {
						cart_subtotal += $(this).data("price") * $('#product_quantity_' + $(this).attr("id").replace('product_price_', '')).val();
					});
					$('#cart_subtotal').text(numberWithDot(cart_subtotal) + 'đ');
				} else $.notify("Không thể cập nhật giỏ hàng!", "error");
			}
		});
	}

	function delete_from_cart(product_id) {
		if (confirm('Bạn có muốn xoá sản phẩm này khỏi giỏ hàng?'))
			$.ajax({
				type: "POST",
				url: "api/?action=delete_cart&user_id=<?php if (isset($_SESSION['user_id'])) echo $_SESSION['user_id']; ?>&product_id=" + product_id,
				// data: q,
				success: function(result) {
					if (result.success) {
						// window.location.reload();
						$.notify("Cập nhật giỏ hàng thành công!", "success");
						$('#product_' + product_id).remove();
						// Cập nhật tạm tính
						var cart_subtotal = 0;
						$('.product_price').each(function() {
							cart_subtotal += $(this).data("price") * $('#product_quantity_' + $(this).attr("id").replace('product_price_', '')).val();
						});
						$('#cart_subtotal').text(numberWithDot(cart_subtotal) + 'đ');
					} else $.notify("Không thể cập nhật giỏ hàng!", "error");
				}
			});
	}
</script>
</body>

</html>