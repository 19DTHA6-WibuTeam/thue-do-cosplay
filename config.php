<?php
error_reporting(0);
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

define('DB_HOST', '103.200.23.160');
define('DB_USER', 'phatdevx_wibu_team');
define('DB_PASS', 'Wibu@2022');
define('DB_NAME', 'phatdevx_thue_do_cosplay');
// $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die('Không thể kết nối tới database');
// mysqli_set_charset($conn, "utf8");
define('SALT', 'Wibu2022!@#'); // SALT để trộn
define('ADMIN_PASSWORD', 'Wibu@2022'); // Mật khẩu đăng nhập Admin
define('DATA_PER_PAGE', 40); // Số dữ liệu hiển thị trên mỗi trang
define('RECAPTCHA_SITE_KEY', '6LeShkgfAAAAAD17sscX7kYWeY4yrHcbNR__Smsv');
define('RECAPTCHA_SECRET_KEY', '6LeShkgfAAAAAGhsTOj5fVVt_MtHxiX-XmyF--yC');

require_once('function.php');
require_once('class.php');

new DB();
