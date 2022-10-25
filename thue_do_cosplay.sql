-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th10 25, 2022 lúc 05:52 PM
-- Phiên bản máy phục vụ: 10.3.36-MariaDB-cll-lve
-- Phiên bản PHP: 7.4.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `phatdevx_thue_do_cosplay`
--
CREATE DATABASE IF NOT EXISTS `phatdevx_thue_do_cosplay` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `phatdevx_thue_do_cosplay`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `user_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `cart_product_quantity` int(11) NOT NULL DEFAULT 0,
  UNIQUE KEY `user_id` (`user_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`user_id`, `product_id`, `cart_product_quantity`) VALUES
(1, 2, 10),
(1, 9, 4),
(1, 11, 8),
(3, 5, 1),
(3, 6, 1),
(3, 12, 401),
(3, 14, 2),
(4, 13, 9),
(11, 1, 47),
(11, 2, 1),
(11, 3, 1),
(11, 4, 1),
(11, 6, 1),
(11, 7, 1),
(11, 8, 1),
(11, 9, 1),
(11, 10, 1),
(11, 12, 1),
(11, 13, 1),
(13, 1, 1),
(13, 4, 1),
(13, 5, 2),
(13, 7, 1),
(13, 13, 1),
(15, 15, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoices`
--

DROP TABLE IF EXISTS `invoices`;
CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(30) NOT NULL AUTO_INCREMENT,
  `user_id` int(30) NOT NULL,
  `invoice_user_fullname` varchar(50) NOT NULL,
  `invoice_user_phone_number` varchar(30) NOT NULL,
  `invoice_user_email` varchar(50) NOT NULL,
  `invoice_user_address` text NOT NULL,
  `invoice_num_rental_days` int(11) NOT NULL,
  `invoice_note` text DEFAULT NULL,
  `invoice_note_admin` text DEFAULT NULL,
  `invoice_subtotal` int(30) NOT NULL,
  `invoice_fee_transport` int(10) NOT NULL,
  `invoice_fee_bond` int(10) NOT NULL,
  `invoice_status_id` int(1) NOT NULL DEFAULT 2,
  `invoice_created_at` int(30) NOT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `user_id` (`user_id`),
  KEY `invoice_status_id` (`invoice_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `user_id`, `invoice_user_fullname`, `invoice_user_phone_number`, `invoice_user_email`, `invoice_user_address`, `invoice_num_rental_days`, `invoice_note`, `invoice_note_admin`, `invoice_subtotal`, `invoice_fee_transport`, `invoice_fee_bond`, `invoice_status_id`, `invoice_created_at`) VALUES
(1, 1, 'Nguyễn Phát', '0777100449', 'phatvphat@gmail.com', 'Hiệp Bình Chánh, Thủ Đức, TP. HCM', 3, 'không có gì.', NULL, 640000, 15000, 500000, 1, 1650011497),
(2, 1, 'Nguyễn Phát', '0777100449', 'phatvphat@gmail.com', 'Hiệp Bình Chánh, Thủ Đức, TP. HCM', 3, '', NULL, 885000, 22000, 500000, 3, 1650718590),
(3, 2, 'Ngô Thế Bách', '0358125654', 'a@a.com', 'Tăng Nhơn Phú A', 3, '', NULL, 170000, 15000, 500000, 3, 1653891425),
(4, 3, 'Lý Quốc Thịnh', '0932178534', 'lythinh1805@gmail.com', 'Điện biên phủ  , TPHCM', 3, 'abc', NULL, 50000, 15000, 500000, 3, 1653897474),
(5, 2, 'Ngô Thế Bách', '0358125655', 'a@a.com', 'Tăng Nhơn Phú A', 3, '', NULL, 170000, 15000, 500000, 4, 1653916148),
(6, 1, 'Nguyễn Phát', '0777100449', 'phatvphat@gmail.com', '', 3, '', NULL, 100000, 22000, 500000, 3, 1654073987),
(7, 1, 'Nguyễn Phát', '0777100449', 'phatvphat@gmail.com', 'Hiệp Bình Chánh, Thủ Đức, TP. HCM', 5, 'test đơn từ dt.', NULL, 375000, 15000, 500000, 2, 1654074856),
(8, 3, 'Lý Quốc Thịnh', '0932178534', 'lythinh1805@gmail.com', 'Phú Hữu Đồng Nai', 10, '', NULL, 165000, 15000, 500000, 2, 1654275783),
(9, 4, 'Ngô Thế Bách', '0358125655', 'ngothebach181001@gmail.com', 'Tăng Nhơn Phú A', 3, '', NULL, 56000, 15000, 500000, 3, 1655047374),
(10, 4, 'Ngô Thế Bách', '0358125655', 'ngothebach181001@gmail.com', 'Tang Nhon Phu A', 5, 'Giao gio hanh chinh', NULL, 452000, 15000, 500000, 2, 1655110666),
(11, 3, 'Lý Quốc Thịnh', '0773113885', 'lythinh1805@gmail.com', 'Điện biên phủ  , TPHCM', 3, '', NULL, 55000, 15000, 500000, 2, 1655278129),
(12, 3, 'Lý Quốc Thịnh', '0773113855', 'lythinh1805@gmail.com', 'Điện biên phủ  , Binh Thanh , TPHCM', 5, 'abc', NULL, 275000, 15000, 500000, 3, 1655306198),
(13, 5, 'Mã Lương Linh', '0366784239', 'maluonglinh3@gmail.com', '5412D', 3, 'sgffdgfdgfdg', NULL, 25000, 15000, 500000, 3, 1655452042),
(14, 6, 'tuấn', '0372953855', 'tuansk1002@gmail.com', 'bình thuận', 3, '', NULL, 5000, 15000, 500000, 3, 1655872205),
(15, 4, 'Ngô Thế Bách', '0358125655', 'ngothebach181001@gmail.com', 'Tăng Nhơn Phú A', 3, '', NULL, 475000, 15000, 500000, 3, 1656053666),
(16, 2, 'Aaa', '0123', 'a@a.com', 'aqw', 5, '', NULL, 390000, 15000, 500000, 3, 1656054232),
(17, 3, 'Lý Quốc Thịnh', '0773113855', 'lythinh1805@gmail.com', 'Điện biên phủ  , Binh Thanh , TPHCM', 3, '', NULL, 840000, 42000, 500000, 2, 1660030468),
(18, 3, 'Lý Quốc Thịnh', '0773113855', 'lythinh1805@gmail.com', 'Điện biên phủ  , Binh Thanh , TPHCM', 9, '', NULL, 25000, 15000, 500000, 2, 1660033775),
(19, 8, 'Thanh Ngoc Truong', '0908278519', 'truongthanh97o1@gmail.com', '123123', 3, '123123', NULL, 110000, 15000, 500000, 2, 1660037571),
(20, 8, 'Thanh', '0908278519', 'tnthanh@gmail.com', 'sfsdf', 3, 'sdfasd', NULL, 56000, 15000, 500000, 2, 1660037700),
(21, 13, 'wibu', '0932178534', 'wibu123@gmail.com', 'Điện biên phủ  , TPHCM', 8, '', NULL, 295000, 15000, 500000, 3, 1660312790),
(22, 13, 'wibu', '0932178534', 'wibu123@gmail.com', 'Điện biên phủ  , TPHCM', 8, '', NULL, 60000, 15000, 500000, 2, 1660312916),
(23, 3, 'Lý Quốc Thịnh', '0773113855', 'lythinh1805@gmail.com', 'Điện biên phủ  , Binh Thanh , TPHCM', 8, '', NULL, 235000, 15000, 500000, 2, 1660582417),
(24, 3, 'Lý Quốc Thịnh', '0773113855', 'lythinh1805@gmail.com', 'Điện biên phủ  , Binh Thanh , TPHCM', 8, '', NULL, 60000, 15000, 500000, 2, 1660583295),
(25, 14, 'h', '0395254369', 'a@gmail.com', '1234', 3, '', NULL, 100000, 15000, 500000, 2, 1664543722),
(26, 14, 'Hoa Nguyen', '0395254369', 'nguyenduchoa.data@gmail.com', '1234', 3, '', NULL, 200000, 15000, 500000, 2, 1664543875),
(27, 14, 'Hoa Nguyen', '0395254369', 'nguyenduchoa.data@gmail.com', '1234', 3, '', NULL, 110000, 15000, 500000, 2, 1664545213),
(28, 14, 'Hoa Nguyen', '0395254369', 'nguyenduchoa.data@gmail.com', '1234', 3, '', NULL, 110000, 15000, 500000, 2, 1664545537);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice_details`
--

DROP TABLE IF EXISTS `invoice_details`;
CREATE TABLE IF NOT EXISTS `invoice_details` (
  `invoice_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `invd_product_quantity` int(30) NOT NULL,
  `invd_product_rental_price` int(30) NOT NULL,
  UNIQUE KEY `invoice_id` (`invoice_id`,`product_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `invoice_details`
--

INSERT INTO `invoice_details` (`invoice_id`, `product_id`, `invd_product_quantity`, `invd_product_rental_price`) VALUES
(1, 2, 5, 15000),
(1, 5, 5, 35000),
(1, 7, 3, 130000),
(2, 2, 4, 15000),
(2, 5, 5, 35000),
(2, 7, 5, 130000),
(3, 1, 1, 20000),
(3, 4, 1, 130000),
(3, 8, 1, 5000),
(3, 9, 3, 5000),
(4, 2, 1, 15000),
(4, 5, 1, 35000),
(5, 4, 1, 130000),
(5, 11, 2, 20000),
(6, 9, 20, 5000),
(7, 5, 10, 35000),
(7, 9, 5, 5000),
(8, 5, 1, 35000),
(8, 7, 1, 130000),
(9, 12, 1, 56000),
(10, 1, 2, 20000),
(10, 12, 2, 56000),
(10, 13, 2, 150000),
(11, 5, 1, 35000),
(11, 11, 1, 20000),
(12, 6, 1, 25000),
(12, 11, 5, 20000),
(12, 13, 1, 150000),
(13, 8, 4, 5000),
(13, 9, 1, 5000),
(14, 9, 1, 5000),
(15, 6, 1, 25000),
(15, 13, 3, 150000),
(16, 4, 3, 130000),
(17, 11, 42, 20000),
(18, 6, 1, 25000),
(19, 14, 1, 110000),
(20, 12, 1, 56000),
(21, 5, 1, 35000),
(21, 7, 2, 130000),
(22, 5, 1, 35000),
(22, 6, 1, 25000),
(23, 2, 1, 15000),
(23, 14, 2, 110000),
(24, 5, 1, 35000),
(24, 6, 1, 25000),
(25, 15, 1, 100000),
(26, 15, 2, 100000),
(27, 14, 1, 110000),
(28, 14, 1, 110000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoice_status`
--

DROP TABLE IF EXISTS `invoice_status`;
CREATE TABLE IF NOT EXISTS `invoice_status` (
  `invoice_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_status_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`invoice_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `invoice_status`
--

INSERT INTO `invoice_status` (`invoice_status_id`, `invoice_status_name`) VALUES
(1, 'Đã huỷ'),
(2, 'Chờ thanh toán'),
(3, 'Đã thanh toán'),
(4, 'Đã trả hàng');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_methods`
--

DROP TABLE IF EXISTS `payment_methods`;
CREATE TABLE IF NOT EXISTS `payment_methods` (
  `pm_id` int(30) NOT NULL AUTO_INCREMENT,
  `pm_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`pm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `product_id` int(30) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) NOT NULL,
  `product_type_id` int(30) DEFAULT NULL,
  `product_price` int(30) NOT NULL DEFAULT 0,
  `product_rental_price` int(30) NOT NULL DEFAULT 0,
  `product_img` text DEFAULT NULL,
  `product_quantity` int(30) DEFAULT 0,
  `product_sizes` varchar(30) DEFAULT NULL,
  `product_weight` int(30) NOT NULL DEFAULT 0,
  `product_description` text DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `product_id` (`product_id`),
  KEY `product_type_id` (`product_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_type_id`, `product_price`, `product_rental_price`, `product_img`, `product_quantity`, `product_sizes`, `product_weight`, `product_description`) VALUES
(1, 'Tai mèo', 2, 123000, 20000, 'https://cf.shopee.vn/file/20e88689b1ac3c3b06c46739729a9a5f', 47, '', 0, ''),
(2, 'Quạt cổ trang', 2, 80000, 15000, 'https://cf.shopee.vn/file/db2ce906c00098a96d0a596b1944e9f3', 44, '', 0, 'Quạt cổ trang quạt chụp kèm sườn sám quạt cosplay'),
(3, 'Áo dài nam Bến Thượng Hải', 3, 349000, 34000, 'https://cf.shopee.vn/file/e37c124fc687d61bbf6a028fec4da004', 10, 'M|L', 0, ''),
(4, 'Akali KDA Liên Minh Huyền Thoại', 3, 799000, 130000, 'https://i.etsystatic.com/12608488/r/il/e7b4f4/1890108946/il_fullxfull.1890108946_m3jm.jpg', 45, 'S|M', 220, ''),
(5, 'Tóc giả Naruto', 1, 390000, 35000, 'https://poolhouse.lt/1-image/35243_Naruto-uzumaki-perukai-aukso-trumpas-purus-shaggy-sluoksni%C5%B3-uploads.jpeg', 78, '', 0, ''),
(6, 'Tóc giả đen trắng black white', 1, 259000, 25000, 'https://img.bestdealplus.com/ae04/kf/H60e595a7b25f4b67adb7f9d740735e04o.jpg', 45, '', 100, 'Black/White in your areaaaaa.'),
(7, 'Kimetsu no Yaiba nhân vật Kamado Tanjirou', 3, 1300000, 130000, 'https://ae01.alicdn.com/kf/Hbc5b8c22836447498c2852c6fabce135z/Anime-Demon-Slayer-Cosplay-Kimetsu-kh-ng-Yaiba-Tanjiro-Kamado-ng-B-Trang-Ph-c-H.jpg_Q90.jpg_.webp|https://i.pinimg.com/originals/3e/2b/81/3e2b817dae54071125ffe5a23a8f0112.jpg', 42, 'M', 300, ''),
(8, 'Shuriken Phi tiêu Naruto', 2, 44000, 5000, 'https://ae01.alicdn.com/kf/HTB1pWs4nIuYBuNkSmRyq6AA3pXaG.jpg', 95, '', 50, '- Chất liệu làm bằng nhựa , không bén , không gây sát thương\r\n- Kích thước : Khoảng 9.5cm.'),
(9, 'Phi tiêu Naruto', 2, 50000, 5000, 'https://cf.shopee.vn/file/cdda8f1d40c2308dc7081c45ff167cf7', 70, '', 100, ''),
(10, 'Áo chùng Harry Potter', 3, 190000, 25000, 'https://cf.shopee.vn/file/792667a85b647b4a6ec571102aa0375b|https://cf.shopee.vn/file/4ab031fe9d9b08c5dc470b8ac994d78d|https://cf.shopee.vn/file/566da019cd2ee1fb838603782f430fd0|https://cf.shopee.vn/file/244564a9c12bfc53dc2512ddcacc200f|https://cf.shopee.vn/file/8cd6033216d6d312c5ee1a95dc8e06ed', 100, 'S|M|L|XL', 200, 'Size S: 1,5m-1,63m\r\nSize M: 1,64m-1,69m\r\nSize L: 1,7-1,75m\r\nSize XL: trên 1,75m'),
(11, 'Tóc giả Satoru Gojo', 1, 143000, 20000, 'https://cf.shopee.vn/file/7cfc2e8ec5a838aaed72000bc880cb20', 0, '', 100, 'Màu sắc: Xám tím'),
(12, ' Thủy Thủ Sao Thủy', 3, 12000, 56000, 'https://ae01.alicdn.com/kf/Hed5ef96829b5453ba094238219974dbfS/2017-Anime-M-i-Th-y-Th-M-t-Tr-ng-Trang-Ph-c-H-a.jpg_Q90.jpg_.webp', 16, 'L', 35, 'Chiều cao 1m60'),
(13, 'Shinobu Kochou trong Kimetsu no Yaiba', 3, 60000, 150000, 'https://cf.shopee.vn/file/8ecc6e188e54765d6cde5434f415a97f_tn', 9, 'S', 32, 'Size S: 1,5m-1,63m Size M: 1,64m-1,69m Size L: 1,7-1,75m Size XL: trên 1,75m'),
(14, 'Áo SakaGe', 3, 200000, 110000, 'https://cf.shopee.vn/file/8f1fb439c31af2464f67b2e6a80715d3', 18, 'L', 200, 'Hàng likenew'),
(15, 'quần áo 1', 3, 26000, 100000, 'https://bizweb.dktcdn.net/thumb/1024x1024/100/103/283/products/quan-ao-nhay-hip-hop-8.jpg?v=1556942993807', 100, 'XL', 40, 'sdasdasd');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_sizes`
--

DROP TABLE IF EXISTS `product_sizes`;
CREATE TABLE IF NOT EXISTS `product_sizes` (
  `product_size_id` int(30) NOT NULL AUTO_INCREMENT,
  `product_id` int(30) NOT NULL,
  `product_size_name` varchar(50) NOT NULL,
  `product_size_quantity` int(30) DEFAULT NULL,
  PRIMARY KEY (`product_size_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_types`
--

DROP TABLE IF EXISTS `product_types`;
CREATE TABLE IF NOT EXISTS `product_types` (
  `product_type_id` int(30) NOT NULL AUTO_INCREMENT,
  `product_type_name` varchar(30) NOT NULL,
  PRIMARY KEY (`product_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `product_types`
--

INSERT INTO `product_types` (`product_type_id`, `product_type_name`) VALUES
(1, 'Wig'),
(2, 'Phụ kiện'),
(3, 'Trang phục');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(30) NOT NULL AUTO_INCREMENT,
  `user_fullname` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `user_phone_number` varchar(30) DEFAULT NULL,
  `user_address` text DEFAULT NULL,
  `user_bank_account_number` varchar(30) DEFAULT NULL,
  `user_bank_name` varchar(30) DEFAULT NULL,
  `user_created_at` int(30) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `user_fullname`, `user_email`, `user_password`, `user_phone_number`, `user_address`, `user_bank_account_number`, `user_bank_name`, `user_created_at`) VALUES
(1, 'Nguyễn Phát', 'phatvphat@gmail.com', '342876e5376e548ca8fa8867d2f53d1dd743aeab', '0777100449', 'Hiệp Bình Chánh, Thủ Đức, TP. HCM', '0531002589292', 'VCB', 1649149252),
(2, 'Aaa', 'a@a.com', '342876e5376e548ca8fa8867d2f53d1dd743aeab', '0123', 'aqw', '123', 'asd', 1650465713),
(3, 'Lý Quốc Thịnh', 'lythinh1805@gmail.com', '9b876477a3d2753e9ae218604c8f8dc9b3d601ef', '0773113855', 'Điện biên phủ  , Binh Thanh , TPHCM', '0212124124256', 'VP Bank', 1653896948),
(4, 'Ngô Thế Bách', 'ngothebach181001@gmail.com', '8b550693411b89c43857273527292925b55076e9', NULL, NULL, NULL, NULL, 1655044688),
(5, 'Mã Lương Linh', 'maluonglinh3@gmail.com', '9b876477a3d2753e9ae218604c8f8dc9b3d601ef', NULL, NULL, NULL, NULL, 1655451936),
(6, 'tuấn', 'tuansk1002@gmail.com', '342876e5376e548ca8fa8867d2f53d1dd743aeab', NULL, NULL, NULL, NULL, 1655872093),
(7, 'Thanh Ngoc Truong', 'truongthanh97o1@gmail.com', '27f0a0a9884b3e7a1d27ff69ba79359221c5bc98', NULL, NULL, NULL, NULL, 1659882647),
(8, 'Thanh', 'tnthanh@gmail.com', '27f0a0a9884b3e7a1d27ff69ba79359221c5bc98', NULL, NULL, NULL, NULL, 1659981390),
(9, '123', 'ngothebach@gmail.com', '9b876477a3d2753e9ae218604c8f8dc9b3d601ef', NULL, NULL, NULL, NULL, 1660053100),
(10, 'ly thinh', 'lythinh123@gmail.com', '382c9d9cf144266edd3a4952cc5c8506b4100c34', NULL, NULL, NULL, NULL, 1660143936),
(11, 'ly thinh', 'lythinh123123@gmail.com', '382c9d9cf144266edd3a4952cc5c8506b4100c34', '0932178534', 'Điện biên phủ  , TPHCM', '05415151514654645', 'VP Bank', 1660144089),
(12, 'ly thinh 1', 'lythinh100@gmail.com', 'd42639a2db89fa0f9f991dbb91e6947b231dcf77', NULL, NULL, NULL, NULL, 1660144268),
(13, 'wibu', 'wibu123@gmail.com', '382c9d9cf144266edd3a4952cc5c8506b4100c34', '0932178534', 'Điện biên phủ  , TPHCM', '0212124124256', 'VP Bank', 1660312485),
(14, 'h', 'a@gmail.com', '342876e5376e548ca8fa8867d2f53d1dd743aeab', NULL, NULL, NULL, NULL, 1664543665),
(15, 'an', 'anbinh123@gmail.com', '9b876477a3d2753e9ae218604c8f8dc9b3d601ef', NULL, NULL, NULL, NULL, 1666251594);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products` ADD FULLTEXT KEY `product_name` (`product_name`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users` ADD FULLTEXT KEY `user_fullname` (`user_fullname`,`user_email`,`user_phone_number`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`invoice_status_id`) REFERENCES `invoice_status` (`invoice_status_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Các ràng buộc cho bảng `invoice_details`
--
ALTER TABLE `invoice_details`
  ADD CONSTRAINT `invoice_details_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `invoice_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`product_type_id`) REFERENCES `product_types` (`product_type_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
