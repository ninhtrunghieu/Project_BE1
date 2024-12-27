-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 26, 2024 lúc 09:56 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_be1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `product_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`brand_id`, `name`, `product_count`) VALUES
(1, 'Apple', 29),
(2, 'Realme', 29),
(3, 'Xiaomi', 29),
(4, 'Oppo', 29),
(5, 'Asus', 29),
(6, 'Samsung', 19),
(7, 'Acer', 29),
(8, 'Lenovo', 29),
(9, 'Dell', 29);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `status_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `order_status`
--

INSERT INTO `order_status` (`id`, `status_name`) VALUES
(1, 'Đang xử lý'),
(2, 'Đã giao'),
(3, 'Đã hủy'),
(4, 'Hoàn tiền');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `name`, `description`, `price`, `image_url`, `category_id`, `brand_id`, `created_at`) VALUES
(1, 'Điện thoại iPhone 16 Pro', 'Điện thoại thông minh', 1000.00, 'img/home/iPhone 16 Pro.jpg', 1, 1, '2024-12-26 11:16:45'),
(2, 'Điện thoại iPhone 15 Pro', 'Điện thoại thông minh', 900.00, 'img/home/iphone 15 Pro.jpg', 1, 1, '2024-12-26 11:16:45'),
(3, 'Điện thoại realme 12', 'Điện thoại thông minh', 850.00, 'img/home/realme 12.jpg', 1, 2, '2024-12-26 11:16:45'),
(4, 'Điện thoại Xiaomi Note 14', 'Điện thoại thông minh', 780.00, 'img/home/xiaomi note 14.jpg', 1, 3, '2024-12-26 11:16:45'),
(5, 'Laptop TUFGAMING', 'Laptop ', 780.00, 'img/home/TUF F15.jpg', 2, 5, '2024-12-26 11:16:45'),
(6, 'Laptop Acer nitro5', 'Laptop ', 780.00, 'img/home/Acer Nitro 5.jpg', 2, 7, '2024-12-26 11:16:45'),
(7, 'Lenovo IdeaPad Gaming 3.', 'Laptop ', 780.00, 'img/home/Lenovo IdeaPad Gaming 3..jpg', 2, 8, '2024-12-26 11:16:45'),
(8, 'Dell Latitude 7410 Carbon', 'Laptop ', 780.00, 'img/home/Dell Latitude 7410 Carbon.jpg', 2, 9, '2024-12-26 11:16:45'),
(9, 'Điện thoại Xiaomi Note 16', 'Điện thoại thông minh', 780.00, 'img/home/xiaomi note 14.jpg', 1, 3, '2024-12-26 11:16:45'),
(10, 'Điện thoại Xiaomi Note 17', 'Điện thoại thông minh', 780.00, 'img/home/xiaomi note 14.jpg', 1, 3, '2024-12-26 11:16:45'),
(11, 'Điện thoại realme 13', 'Điện thoại thông minh', 850.00, 'img/home/realme 12.jpg', 1, 2, '2024-12-26 11:16:45'),
(12, 'Điện thoại iPhone 17 Pro', 'Điện thoại thông minh', 1000.00, 'img/home/iPhone 16 Pro.jpg', 1, 1, '2024-12-26 11:16:45'),
(13, 'Điện thoại iPhone 18 Pro', 'Điện thoại thông minh', 1000.00, 'img/home/iPhone 16 Pro.jpg', 1, 1, '2024-12-26 11:16:45'),
(14, 'Điện thoại iPhone 19 Pro', 'Điện thoại thông minh', 1000.00, 'img/home/iPhone 16 Pro.jpg', 1, 1, '2024-12-26 11:16:45');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_categories`
--

CREATE TABLE `product_categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `total_products` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_categories`
--

INSERT INTO `product_categories` (`category_id`, `name`, `total_products`) VALUES
(1, 'Điện thoại di động', 3600),
(2, 'Laptop', 3600),
(3, 'Máy tính bảng', 3600),
(4, 'Phụ kiện', 3600);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_details`
--

CREATE TABLE `product_details` (
  `detail_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `attribute_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `attribute_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `url_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_details`
--

INSERT INTO `product_details` (`detail_id`, `product_id`, `description`, `attribute_name`, `attribute_value`, `url_image`) VALUES
(1, 1, 'Điện thoại thông minh, màn hình 6.1 inch, camera 12MP, bộ vi xử lý A16 Bionic, dung lượng bộ nhớ 128GB', 'Loại', 'Điện thoại thông minh', 'img/home/iPhone 16 Pro.jpg'),
(2, 1, 'Điện thoại thông minh, màn hình 6.1 inch, camera 12MP, bộ vi xử lý A16 Bionic, dung lượng bộ nhớ 128GB', 'Tình trạng', 'Còn hàng', NULL),
(3, 2, 'Điện thoại thông minh, màn hình 6.1 inch, camera 12MP, bộ vi xử lý A15 Bionic, dung lượng bộ nhớ 128GB', 'Loại', 'Điện thoại thông minh', NULL),
(4, 2, 'Điện thoại thông minh, màn hình 6.1 inch, camera 12MP, bộ vi xử lý A15 Bionic, dung lượng bộ nhớ 128GB', 'Tình trạng', 'Còn hàng', NULL),
(5, 3, 'Điện thoại thông minh, màn hình 6.5 inch, camera 50MP, bộ vi xử lý Dimensity 8100, dung lượng bộ nhớ 128GB', 'Loại', 'Điện thoại thông minh', NULL),
(6, 3, 'Điện thoại thông minh, màn hình 6.5 inch, camera 50MP, bộ vi xử lý Dimensity 8100, dung lượng bộ nhớ 128GB', 'Tình trạng', 'Còn hàng', NULL),
(7, 4, 'Điện thoại thông minh, màn hình 6.7 inch, camera 48MP, bộ vi xử lý Snapdragon 888, dung lượng bộ nhớ 128GB', 'Loại', 'Điện thoại thông minh', NULL),
(8, 4, 'Điện thoại thông minh, màn hình 6.7 inch, camera 48MP, bộ vi xử lý Snapdragon 888, dung lượng bộ nhớ 128GB', 'Tình trạng', 'Còn hàng', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(11, 'Admin', 'admin', 'admin123', NULL, 'admin', '2024-12-16 03:29:01'),
(12, 'Ninh Trung Hiếu', 'hieu', 'hieu123', NULL, 'user', '2024-12-16 03:29:01'),
(13, 'Hoàng Đức Khiêm', 'khiem', 'khiem123', NULL, 'user', '2024-12-16 03:29:01');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Chỉ mục cho bảng `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `product_details`
--
ALTER TABLE `product_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`category_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`);

--
-- Các ràng buộc cho bảng `product_details`
--
ALTER TABLE `product_details`
  ADD CONSTRAINT `product_details_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
