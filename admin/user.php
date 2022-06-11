<?php
include 'views/header.php';

$users = new User;
$u = $users->getUser(getGET('user_id'));
$statistic = new Statistic;
?>
<link rel="stylesheet" type="text/css" href="./app-assets/css/pages/page-users.css">
<!-- BEGIN: Page Main-->
<div id="main">
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-purple-deep-purple"></div>
        <div class="breadcrumbs-dark pb-0 pt-4" id="breadcrumbs-wrapper">
            <!-- Search for small screen-->
            <div class="container">
                <div class="row">
                    <div class="col s10 m6 l6">
                        <h5 class="breadcrumbs-title mt-0 mb-0"><span>Chi tiết người dùng</span></h5>
                        <ol class="breadcrumbs mb-0">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">User</a></li>
                            <li class="breadcrumb-item active">Users View</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="col s12">
            <div class="container">
                <!-- users view start -->
                <div class="section users-view">
                    <!-- users view card details start -->
                    <div class="card">
                        <div class="card-content">
                            <div class="row indigo lighten-5 border-radius-4 mb-2">
                                <div class="col s12 m6 users-view-timeline">
                                    <h6 class="indigo-text m-0">Tổng đơn đã đặt: <span><?php echo $statistic->totalInvoicesByUserId($u['user_id']); ?></span></h6>
                                </div>
                                <div class="col s12 m6 users-view-timeline">
                                    <h6 class="indigo-text m-0">Tổng đơn huỷ: <span><?php echo $statistic->totalInvoicesByUserIdWithInvoiceStatusId($u['user_id'], 1); ?></span></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <table class="striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 25%"></th>
                                                <th style="width: 75%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Họ tên:</td>
                                                <td><?php echo $u['user_fullname']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Email:</td>
                                                <td class="users-view-name"><?php echo $u['user_email']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>SĐT:</td>
                                                <td><?php echo $u['user_phone_number']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Địa chỉ giao hàng mặc định:</td>
                                                <td><?php echo $u['user_address']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Số tài khoản ngân hàng hoàn tiền:</td>
                                                <td><?php echo $u['user_bank_account_number']; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tên ngân hàng:</td>
                                                <td><?php echo $u['user_bank_name']; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <!-- users view card details ends -->

                </div>
                <!-- users view ends -->
            </div>
            <div class="content-overlay"></div>
        </div>
    </div>
</div>
<!-- END: Page Main-->
<?php
include 'views/footer.php';
