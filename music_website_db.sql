-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2023 at 03:42 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `music_website_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `bio` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `name`, `bio`, `user_id`, `image`) VALUES
(1, 'Trung Quan Idol', 'Bùi Nguyễn Trung Quân, hay còn được biết đến với nghệ danh Trung Quân (sinh ngày 20 tháng 1 năm 1989), là một nam ca sĩ người Việt Nam. Anh được biết đến sau khi tham gia Thần tượng âm nhạc Việt Nam mùa thứ ba năm 2010 và liên tục ra các bài hit cho đến nay. Anh là cựu sinh viên của Trường Đại học Kiến trúc Thành phố Hồ Chí Minh.\r\n\r\nTrung Quân sinh ra và lớn lên ở Đà Lạt, giọng ca “bay” mà Quân có được thừa hưởng từ mẹ. Trước Vietnam Idol, anh từng hát cho các TVC quảng cáo. Trung Quân cũng từng tham gia Vietnam Idol năm 2008 nhưng dừng lại ở top 16. Anh ruột của Quân là rapper Quân Rapsoul (Bùi Nguyễn Minh Quân) cũng tham gia vào hoạt động nghệ thuật (trong đó có làm VJ của YanTV với cái tên Rapsoul) và ít nhiều cũng đã giành được sự quan tâm từ dư luận.', 1, 'upload/Trung Quân Idol.jpg'),
(2, 'Ha Anh Tuan', '', 1, 'upload/ha-anh-tuan-2796-1644390477.jpg'),
(3, 'Ha Nhi', '', 1, 'upload/ha-nhi2-4080.jpg'),
(4, 'Bui Anh Tuan', '', 1, 'upload/bui-anh-tuan-cover-love-song-tang-sinh-nhat-thay-ho-ngoc-ha.jpg'),
(5, 'Hoa Minzy', '', 1, 'upload/saostar-f8yuwwbaz6odaiph.jpg'),
(7, 'Duc Phuc', 'Nguyễn Đức Phúc (sinh ngày 15 tháng 10 năm 1996), còn được biết đến với nghệ danh Đức Phúc, là một nam ca sĩ người Việt Nam. Anh được khán giả biết đến rộng rãi với tư cách quán quân của The Voice Vietnam 2015[1].\n\nAnh từng là sinh viên khoa kiến trúc Trường Đại học Xây dựng vào năm 2014 và sau khi quyết định Nam tiến, theo học khoa Mỹ thuật công nghiệp ở Trường Đại học Văn Lang, sau đó tạm dừng và bảo lưu kết quả học tập để bước vào sự nghiệp âm nhạc.[2]', 1, 'upload/channels4_profile.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` varchar(30) NOT NULL,
  `disable` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `disable`) VALUES
(2, 'Pop', 0),
(3, 'Ballad', 0),
(56, 'VPOP', 0);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `artist_id` int(11) NOT NULL,
  `image` varchar(1024) NOT NULL,
  `file` varchar(1024) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `views` int(11) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `features` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `title`, `user_id`, `artist_id`, `image`, `file`, `category_id`, `date`, `views`, `slug`, `features`) VALUES
(1, 'I Do', 1, 7, 'upload/c40dbb2a1bf4dfd1229b7bc29efebe4b.jpg', 'upload/EmDongYIDo-DucPhucx911-8679310.mp3', 2, '2023-02-24 10:32:42', 0, 'i-do', 1),
(2, 'Va Ngay Nao Do', 1, 1, 'uploads/nao do .jpg', 'upload/VaNgayNaoDo1-TrungQuanIdol-7861301.mp3', 3, '2023-02-24 10:47:20', 22, 'va-ngay-nao-do', 0),
(3, 'Chon con tym hay nghe ly tri', 1, 6, 'upload/1537156446247_500.jpg', 'upload/EmKhongLaDuyNhat-TocTien-4781181.mp3', 2, '2023-02-25 15:07:37', 3, 'chon-con-tym-hay-nghe-ly-tri', 1),
(4, 'Nam Ay', 1, 7, 'upload/background-playlist.jfif', 'upload/NamAy-DucPhuc-5305026.mp3', 3, '2023-02-25 16:50:33', 7, 'nam-ay', 1),
(5, 'Ngay Dau Tien - First Day', 1, 7, 'upload/ngay dau tien.jpg', 'upload/NgayDauTien-DucPhuc-7129810.mp3', 2, '2023-02-27 15:26:03', 1, 'ngay-dau-tien-first-day', 1),
(6, 'Tinh Yeu Den Sau', 1, 7, 'upload/tinh yeu den.jpg', 'upload/TinhYeuDenSau-MyraTranDucPhuc-8558756.mp3', 2, '2023-02-27 15:26:52', 0, 'tinh-yeu-den-sau', 1),
(7, 'Nguoi oi Nguoi o dung ve', 1, 7, 'upload/o dung ve.jpg', 'upload/NguoiOiNguoiODungVe-DucPhucSuboi-6652270.mp3', 56, '2023-02-27 15:27:39', 0, 'nguoi-oi-nguoi-o-dung-ve', 1),
(8, 'Anh nang cua anh', 1, 7, 'upload/anh nnag.jpg', 'upload/AnhNangCuaAnhChoEmDenNgayMaiOst-DucPhuc-4701036.mp3', 3, '2023-02-27 15:28:25', 1, 'anh-nang-cua-anh', 1),
(9, 'Cu Yeu Di', 1, 7, 'upload/cu ye.jpg', 'upload/CuYeuDi100NgayBenEmOst-DucPhucHoaMinzy-5448301.mp3', 3, '2023-02-27 15:29:07', 0, 'cu-yeu-di', 1),
(10, 'Tu Tinh 2 - Cover', 1, 1, 'upload/tu tinh.jpg', 'upload/TuTinh2-TrungQuanIdol-7944467.mp3', 2, '2023-02-27 15:32:55', 0, 'tu-tinh-2', 0),
(11, 'Buon Khong The Buong', 1, 1, 'upload/buon k.jpg', 'upload/BuonKhongTheBuong-TrungQuanIdol-7983906.mp3', 3, '2023-02-27 15:33:52', 0, 'buon-khong-the-buong', 0),
(12, 'Dau Mua', 1, 1, 'upload/dau.jpg', 'upload/DauMua-TrungQuanIdol-2640897.mp3', 3, '2023-02-27 15:34:29', 7, 'dau-mua', 1),
(13, 'Nguoi tinh mua dong', 1, 2, 'upload/mua dong.png', 'upload/NguoiTinhMuaDongSEESINGSHARE2-HaAnhTuan-5104816.mp3', 2, '2023-02-27 15:35:17', 1, 'nguoi-tinh-mua-dong', 1),
(14, 'Thang May Em Nho Anh', 1, 2, 'upload/nho ah.jpg', 'upload/ThangMayEmNhoAnh-HaAnhTuan-6995531.mp3', 2, '2023-02-27 15:36:03', 0, 'thang-may-em-nho-anh', 0),
(15, 'Noi Tinh Yeu Bat Dau', 1, 4, 'upload/bat dau.jpg', 'upload/NoiTinhYeuBatDau-BuiAnhTuan-1915267.mp3', 2, '2023-02-27 15:36:55', 1, 'noi-tinh-yeu-bat-dau', 0),
(16, 'Mo Ho', 1, 4, 'upload/mo ho.jpg', 'upload/MoHo-BuiAnhTuan-3264100.mp3', 3, '2023-02-27 15:37:35', 0, 'mo-ho', 0),
(17, 'Buong - Bui Anh Tuan', 1, 4, 'upload/maxresdefault.jpg', 'upload/Buong-BuiAnhTuan-4042300.mp3', 2, '2023-02-27 15:38:28', 0, 'buong-bui-anh-tuan', 0),
(18, 'Chua Quen Nguoi Yeu Cu', 1, 3, 'upload/maxresdefault (1).jpg', 'upload/ChuaQuenNguoiYeuCu-HaNhi-7662060.mp3', 56, '2023-02-27 15:39:03', 0, 'chua-quen-nguoi-yeu-cu', 0),
(19, 'Di Vang Nhat Nhoa', 1, 3, 'upload/Di Vang Nhat Nhoa.jpg', 'upload/DiVangNhatNhoa-HaNhi-5734586.mp3', 1, '2023-02-27 15:39:34', 0, 'di-vang-nhat-nhoa', 0),
(20, 'Roi Bo', 1, 5, 'upload/maxresdefault (2).jpg', 'upload/RoiBo-HoaMinzy-5468827.mp3', 2, '2023-02-27 15:40:11', 1, 'roi-bo', 0),
(21, 'Mua Nho', 1, 5, 'upload/download.jfif', 'upload/MuaNho-HoaMinzy-4110080.mp3', 2, '2023-02-27 15:40:41', 0, 'mua-nho', 0),
(22, 'Xin chao VN', 1, 4, 'upload/ezgif-5-ca42555e44-removebg-preview.png', 'upload/NguoiTinhMuaDongSEESINGSHARE2-HaAnhTuan-5104816 (1).mp3', 2, '2023-02-28 03:39:53', 33, 'xin-chao-vn', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `date`) VALUES
(1, 'anhkhoa', 'hanhkhoatptg@gmail.com', '$2y$10$kNtE/NpfU3yXWMZKTkfhROSVh.a52ml.sBuxDxxei902CVFQvtota', 'admin', '2023-02-21 15:52:08'),
(2, 'Trung Quan', 'trungquankol@gmail.com', '$2y$10$7F96vvBjhKlrxvMu42SMRO2I6f39sOX4QWMfgY7NuLOAi/B9KVoxS', 'user', '2023-02-21 15:52:24'),
(3, 'Duc Phuc', 'ducphuckol@gmail.com', '$2y$10$7Bwsux.vPjEI/hZ3tvIkNOfJ9ylms58Jq1ltQFUxoCj2tLWpqEb7u', 'user', '2023-02-21 15:52:33'),
(5, 'Bui Anh Tuan', 'buianhtuankol@gmail.com', '$2y$10$lqDxtO8SVkaF8zWIL8IDQumwZfexW3FmsrL/AYi1VxMu5Q1ApecmS', 'user', '2023-02-27 15:43:11'),
(6, 'Ha Nhi', 'hanhikol@gmail.com', '$2y$10$bRa2xYb23MQ/AOuMF0DcLO42LTw6.1mjtx6ODkfrJF2SSpSahaVtK', 'user', '2023-02-27 15:43:36'),
(7, 'Ha Anh Tuan', 'haanhtuankol@gmail.com', '$2y$10$qniiWv2RZ1TMWrUuISw7g.SsNpLO.jTgVEYDleX8iO9sl8mFpyUEK', 'user', '2023-02-27 15:44:09'),
(8, 'Hoa Minzy', 'hoaminzykol@gmail.com', '$2y$10$fo1pg.d.XUkWT3qTzSaE9uiWX7WpVv.3gkWSFanA0JtT4fk4NE6Qq', 'user', '2023-02-27 15:44:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category` (`category`),
  ADD KEY `disabled` (`disable`) USING BTREE;

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `artist_id` (`artist_id`),
  ADD KEY `views` (`views`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `title` (`title`),
  ADD KEY `slug` (`slug`),
  ADD KEY `features` (`features`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `date` (`date`),
  ADD KEY `role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
