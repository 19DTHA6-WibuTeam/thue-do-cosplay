<?php
include 'views/header.php';


if (isset($_POST['submit'])) {
    $invoices = new Invoice;
    if ($invoices->postInvoice($_SESSION['user_id'], $_POST['user_fullname'], $_POST['user_phone_number'], $_POST['user_email'], $_POST['user_address'], $_POST['order_note'])) {
        echo '<script>location.replace("order-success.html");</script>';
    }
}

$users = new User;
$user = $users->getUser($_SESSION['user_id']);
?>
<!--breadcrumbs area start-->
<div class="breadcrumbs_area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb_content">
                    <ul>
                        <li><a href="index.html">Trang chủ</a></li>
                        <li>Thanh toán</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--breadcrumbs area end-->

<!--Checkout page section-->
<div class="Checkout_section mt-60">
    <div class="container">
        <!-- <div class="row">
            <div class="col-12">
                <div class="user-actions">
                    <h3>
                        <i class="fa fa-file-o" aria-hidden="true"></i>Returning customer?
                        <a class="Returning" href="#" data-bs-toggle="collapse" data-bs-target="#checkout_login" aria-expanded="true">Click here to login</a>
                    </h3>
                    <div id="checkout_login" class="collapse" data-parent="#accordion">
                        <div class="checkout_info">
                            <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing & Shipping section.</p>
                            <form action="#">
                                <div class="form_group">
                                    <label>Username or email <span>*</span></label>
                                    <input type="text">
                                </div>
                                <div class="form_group">
                                    <label>Password <span>*</span></label>
                                    <input type="text">
                                </div>
                                <div class="form_group group_3 ">
                                    <button type="submit">Login</button>
                                    <label for="remember_box">
                                        <input id="remember_box" type="checkbox">
                                        <span> Remember me </span>
                                    </label>
                                </div>
                                <a href="#">Lost your password?</a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="user-actions">
                    <h3>
                        <i class="fa fa-file-o" aria-hidden="true"></i>Returning customer?
                        <a class="Returning" href="#" data-bs-toggle="collapse" data-bs-target="#checkout_coupon" aria-expanded="true">Click here to enter your code</a>
                    </h3>
                    <div id="checkout_coupon" class="collapse" data-parent="#accordion">
                        <div class="checkout_info">
                            <form action="#">
                                <input placeholder="Coupon code" type="text">
                                <button type="submit">Apply coupon</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="checkout_form">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <form method="POST" action="">
                        <h3>Chi tiết đơn hàng</h3>
                        <div class="row">
                            <div class="col-lg-12 mb-20">
                                <label>Họ tên <span>*</span></label>
                                <input type="text" name="user_fullname" value="<?php echo $user['user_fullname']; ?>" required />
                            </div>
                            <!-- <div class="col-12 mb-20">
                                <label for="country">country <span>*</span></label>
                                <select class="niceselect_option" name="cuntry" id="country">
                                    <option value="2">bangladesh</option>
                                    <option value="3">Algeria</option>
                                    <option value="4">Afghanistan</option>
                                    <option value="5">Ghana</option>
                                    <option value="6">Albania</option>
                                    <option value="7">Bahrain</option>
                                    <option value="8">Colombia</option>
                                    <option value="9">Dominican Republic</option>
                                </select>
                            </div> -->
                            <div class="col-lg-6 mb-20">
                                <label>SĐT<span>*</span></label>
                                <input type="text" name="user_phone_number" value="<?php echo $user['user_phone_number']; ?>" pattern="(84|0[3|5|7|8|9])+([0-9]{8})" required />
                            </div>
                            <div class="col-lg-6 mb-20">
                                <label>Email <span>*</span></label>
                                <input type="email" name="user_email" value="<?php echo $user['user_email']; ?>" required />
                            </div>
                            <div class="col-12 mb-20">
                                <label>Địa chỉ giao hàng <span>*</span></label>
                                <input type="text" name="user_address" placeholder="House number and street name" value="<?php echo $user['user_address']; ?>" required />
                            </div>
                            <!-- <div class="col-12 mb-20">
                                <input placeholder="Apartment, suite, unit etc. (optional)" type="text" />
                            </div> -->
                            <!-- <div class="col-12 mb-20">
                                <label>Town / City <span>*</span></label>
                                <input type="text" />
                            </div>
                            <div class="col-12 mb-20">
                                <label>State / County <span>*</span></label>
                                <input type="text" />
                            </div> -->
                            <!-- <div class="col-12 mb-20">
                                <input id="account" type="checkbox" data-bs-target="createp_account" />
                                <label for="account" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne">Create an account?</label>
                                <div id="collapseOne" class="collapse one" data-parent="#accordion">
                                    <div class="card-body1">
                                        <label> Account password <span>*</span></label>
                                        <input placeholder="password" type="password" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <input id="address" type="checkbox" data-bs-target="createp_account" />
                                <label class="righ_0" for="address" data-bs-toggle="collapse" data-bs-target="#collapsetwo" aria-controls="collapseOne">Ship to a different address?</label>
                                <div id="collapsetwo" class="collapse one" data-parent="#accordion">
                                    <div class="row">
                                        <div class="col-lg-6 mb-20">
                                            <label>First Name <span>*</span></label>
                                            <input type="text">
                                        </div>
                                        <div class="col-lg-6 mb-20">
                                            <label>Last Name <span>*</span></label>
                                            <input type="text">
                                        </div>
                                        <div class="col-12 mb-20">
                                            <label>Company Name</label>
                                            <input type="text">
                                        </div>
                                        <div class="col-12 mb-20">
                                            <div class="select_form_select">
                                                <label for="countru_name">country <span>*</span></label>
                                                <select class="niceselect_option" name="cuntry" id="countru_name">
                                                    <option value="2">bangladesh</option>
                                                    <option value="3">Algeria</option>
                                                    <option value="4">Afghanistan</option>
                                                    <option value="5">Ghana</option>
                                                    <option value="6">Albania</option>
                                                    <option value="7">Bahrain</option>
                                                    <option value="8">Colombia</option>
                                                    <option value="9">Dominican Republic</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-20">
                                            <label>Street address <span>*</span></label>
                                            <input placeholder="House number and street name" type="text">
                                        </div>
                                        <div class="col-12 mb-20">
                                            <input placeholder="Apartment, suite, unit etc. (optional)" type="text">
                                        </div>
                                        <div class="col-12 mb-20">
                                            <label>Town / City <span>*</span></label>
                                            <input type="text">
                                        </div>
                                        <div class="col-12 mb-20">
                                            <label>State / County <span>*</span></label>
                                            <input type="text">
                                        </div>
                                        <div class="col-lg-6 mb-20">
                                            <label>Phone<span>*</span></label>
                                            <input type="text">
                                        </div>
                                        <div class="col-lg-6">
                                            <label> Email Address <span>*</span></label>
                                            <input type="text">
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-12">
                                <div class="order-notes">
                                    <label for="order_note">Ghi chú đơn hàng</label>
                                    <textarea id="order_note" name="order_note" placeholder="Size sản phẩm, thông tin giao hàng..." style="height: 100px;"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="order_button">
                                    <button type="submit" name="submit" value="submit_order">Đặt hàng</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 col-md-6">
                    <form action="#">
                        <h3>SẢN PHẨM</h3>
                        <p>(Kiểm tra kĩ SỐ LƯỢNG và ĐƠN GIÁ, dữ liệu có thể thay đổi từng thời điểm)</p>
                        <p><a target="_blank" href="faq.html">Ấn vào đây để xem Câu hỏi thường gặp!</a></p>
                        <div class="order_table table-responsive" style="overflow-x: hidden;">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Số tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                        <td> Handbag fringilla <strong> × 2</strong></td>
                                        <td> $165.00</td>
                                    </tr>
                                    <tr>
                                        <td> Handbag justo <strong> × 2</strong></td>
                                        <td> $50.00</td>
                                    </tr>
                                    <tr>
                                        <td> Handbag elit <strong> × 2</strong></td>
                                        <td> $50.00</td>
                                    </tr>
                                    <tr>
                                        <td> Handbag Rutrum <strong> × 1</strong></td>
                                        <td> $50.00</td>
                                    </tr> -->
                                    <?php
                                    $carts = new Cart;
                                    $cart_subtotal = 0;
                                    $cart_weight = 0;
                                    foreach ($carts->getCart($_SESSION['user_id']) as $k => $v) {
                                        $product_id = $v['product_id'];
                                        $product_img = explode('|', $v['product_img'])[0];
                                        if ($v['cart_product_quantity'] > $v['product_quantity']) {
                                            $cart_product_quantity = $v['product_quantity'];
                                            $carts->updateCart($_SESSION['user_id'], $product_id, $cart_product_quantity);
                                        } else $cart_product_quantity = $v['cart_product_quantity'];
                                        $product_price_total = $cart_product_quantity * $v['product_rental_price'];
                                        echo '<tr>
                                                <td>' . $v['product_name'] . '<strong> × ' . $cart_product_quantity . '</strong></td>
                                                <td>' . number_format($product_price_total, 0, ',', '.') . 'đ</td>
                                            </tr>';
                                        $cart_subtotal += $product_price_total;
                                        $cart_weight += $cart_product_quantity * $v['product_weight'];
                                    }
                                    $fee = new Fee;
                                    $fee_transport = $fee->transport($cart_weight);
                                    $fee_bond = $fee->bond($cart_subtotal);
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Tạm tính</th>
                                        <td><?php echo number_format($cart_subtotal, 0, ',', '.'); ?>đ</td>
                                    </tr>
                                    <tr>
                                        <th>Phí vận chuyển</th>
                                        <td><?php echo number_format($fee_transport, 0, ',', '.'); ?>đ</td>
                                    </tr>
                                    <tr>
                                        <th>Phí đảm bảo tài sản</th>
                                        <td><?php echo number_format($fee_bond, 0, ',', '.'); ?>đ</td>
                                    </tr>
                                    <tr class="order_total">
                                        <th>Tổng thanh toán</th>
                                        <td><strong><?php echo number_format($cart_subtotal + $fee_transport + $fee_bond, 0, ',', '.'); ?>đ</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment_method">
                            <!-- <div class="panel-default">
                                <input id="payment" name="check_method" type="radio" data-bs-target="createp_account" />
                                <label for="payment" data-bs-toggle="collapse" data-bs-target="#method" aria-controls="method">Create an account?</label>
                                <div id="method" class="collapse one" data-parent="#accordion">
                                    <div class="card-body1">
                                        <p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-default">
                                <input id="payment_defult" name="check_method" type="radio" data-bs-target="createp_account" />
                                <label for="payment_defult" data-bs-toggle="collapse" data-bs-target="#collapsedefult" aria-controls="collapsedefult">PayPal <img src="assets/img/icon/papyel.webp" alt=""></label>
                                <div id="collapsedefult" class="collapse one" data-parent="#accordion">
                                    <div class="card-body1">
                                        <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.</p>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="order_button">
                                <button type="submit">Đặt hàng</button>
                            </div> -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Checkout page section end-->
<?php
include 'views/footer.php';
?>