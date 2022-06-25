
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanly_nhansu`
--

-- --------------------------------------------------------
--



--
-- Cấu trúc bảng cho bảng `chinh_luong`
--

CREATE TABLE `chinh_luong` (
  `id` int(11) NOT NULL,
  `nhanvien_id` int(11) NOT NULL,
  `ngay_ky_ket` datetime NOT NULL,
  `ngay_dieu_chinh` datetime NOT NULL,
  `heso_luong_cu` double NOT NULL,
  `heso_luong_moi` double NOT NULL,
  `nguoi_tao_id` int(11) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua_id` int(11) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



--
-- Cấu trúc bảng cho bảng `chuc_vu`
--

CREATE TABLE `chuc_vu` (
  `id` int(11) NOT NULL,
  `ma_chuc_vu` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ten_chuc_vu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `luong_ngay` double NOT NULL,
  `ghi_chu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nguoi_tao` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Cấu trúc bảng cho bảng `khen_thuong_ky_luat`
--

CREATE TABLE `khen_thuong_ky_luat` (
  `id` int(11) NOT NULL,
  `ma_kt` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nhanvien_id` int(11) NOT NULL,
  `loai_kt_id` int(11) NOT NULL,
  `ten_khen_thuong` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `so_tien` double NOT NULL,
  `ghi_chu` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `flag` tinyint(1) NOT NULL,
  `nguoi_tao` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- Đang đổ dữ liệu cho bảng `khen_thuong_ky_luat`
--

CREATE TABLE `loai_khen_thuong_ky_luat` (
  `id` int(11) NOT NULL,
  `ma_loai` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ten_loai` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ghi_chu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flag` tinyint(1) NOT NULL,
  `nguoi_tao` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Cấu trúc bảng cho bảng `luong`
--

CREATE TABLE `luong` (
  `id` int(11) NOT NULL,
  `ma_luong` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `nhanvien_id` int(11) NOT NULL,
  `luong_thang` double NOT NULL,
  `ngay_cong` int(11) NOT NULL,
  `ngay_cham` date NOT NULL,
  `ghi_chu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nguoi_tao_id` int(11) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua_id` int(11) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `luong`
--



-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhanvien`
--

CREATE TABLE `nhanvien` (
  `id` int(11) NOT NULL,
  `ma_nv` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hinh_anh` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ten_nv` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gioi_tinh` tinyint(1) NOT NULL,
  `ngay_sinh` date NOT NULL,
  `so_cmnd` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `tam_tru` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phong_ban_id` int(11) NOT NULL,
  `chuc_vu_id` int(11) NOT NULL,
  `nguoi_tao_id` int(11) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua_id` int(11) NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



--
-- Cấu trúc bảng cho bảng `phong_ban`
--

CREATE TABLE `phong_ban` (
  `id` int(11) NOT NULL,
  `ma_phong_ban` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ten_phong_ban` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ghi_chu` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nguoi_tao` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `nguoi_sua` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ngay_sua` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phong_ban`
--

INSERT INTO `phong_ban` (`id`, `ma_phong_ban`, `ten_phong_ban`, `ghi_chu`, `nguoi_tao`, `ngay_tao`, `nguoi_sua`, `ngay_sua`) VALUES
(1, 'MBP1569204111', 'Phòng Kĩ Thuật', '', 'Ngô Văn Minh', '2022-02-12 09:01:51', 'Ngô Văn Minh', '2022-02-13 09:03:00');




--
-- Cấu trúc bảng cho bảng `tai_khoan`
--

CREATE TABLE `tai_khoan` (
  `id` int(11) NOT NULL,
  `ho` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ten` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `hinh_anh` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mat_khau` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `so_dt` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `quyen` tinyint(1) NOT NULL,
  `trang_thai` tinyint(1) NOT NULL,
  `truy_cap` int(11) NOT NULL,
  `ngay_tao` datetime NOT NULL,
  `ngay_sua` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `tai_khoan`
--

INSERT INTO `tai_khoan` (`id`, `ho`, `ten`, `hinh_anh`, `email`, `mat_khau`, `so_dt`, `quyen`, `trang_thai`, `truy_cap`, `ngay_tao`, `ngay_sua`) VALUES
(1, 'Ngô', 'Minh', 'admin.png', 'minh66hn@gmail.com', '123123', '099999999999', 1, 1, 45, '2022-02-12 00:00:00', '2022-02-13 06:32:36'),
(2, 'Hoàng', 'Hải', '1568644813.jpg', 'hoanghai@gmail.com', '123123', '099999999', 1, 1, 19, '2022-02-12 21:15:00', '2022-02-13 18:07:30'),
(3, 'Bạch', 'Hùng', '1568647601.jpg', 'bachhung@gmail.com', '123123', '0932312994', 0, 1, 1, '2022-02-12 22:08:30', '2022-02-13 08:37:05'),
(4, 'Hoàng', 'Tùng', '1568856833.jpg', 'hoangtung@gmail.com', '123123', '1234567890', 0, 1, 6, '2022-02-12 08:09:19', '2022-02-13 08:45:36'),
(5, 'Mạnh', 'Đức', 'admin.png', 'ducmanh@gmail.com', '123123', '1234567890', 1, 1, 15, '2022-02-12 00:00:00', '2022-02-13 00:00:00');


-- Chỉ mục cho các bảng đã đổ


--
-- Chỉ mục cho bảng `chinh_luong`
--
ALTER TABLE `chinh_luong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nhanvien_id` (`nhanvien_id`);



--
-- Chỉ mục cho bảng `chuc_vu`
--
ALTER TABLE `chuc_vu`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `loai_khen_thuong_ky_luat`
ADD PRIMARY KEY (`id`);

ALTER TABLE `loai_khen_thuong_ky_luat`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;




--
-- Chỉ mục cho bảng `khen_thuong_ky_luat`
--
ALTER TABLE `khen_thuong_ky_luat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nhanvien_id` (`nhanvien_id`);




--
-- Chỉ mục cho bảng `luong`
--
ALTER TABLE `luong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nhanvien_id` (`nhanvien_id`);

--
-- Chỉ mục cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD PRIMARY KEY (`id`),
  ADD KEY `phong_ban_id` (`phong_ban_id`),
  ADD KEY `chuc_vu_id` (`chuc_vu_id`),
  ADD KEY `nguoi_tao_id` (`nguoi_tao_id`),
  ADD KEY `nguoi_sua_id` (`nguoi_sua_id`);



--
-- Chỉ mục cho bảng `phong_ban`
--
ALTER TABLE `phong_ban`
  ADD PRIMARY KEY (`id`);



--
-- Chỉ mục cho bảng `tai_khoan`
--
ALTER TABLE `tai_khoan`
  ADD PRIMARY KEY (`id`);






--
-- AUTO_INCREMENT cho các bảng đã đổ
--
--

--
-- AUTO_INCREMENT cho bảng `chinh_luong`
--
ALTER TABLE `chinh_luong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;



--
-- AUTO_INCREMENT cho bảng `chuc_vu`
--
ALTER TABLE `chuc_vu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;







--
-- AUTO_INCREMENT cho bảng `khen_thuong_ky_luat`
--
ALTER TABLE `khen_thuong_ky_luat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;





--
-- AUTO_INCREMENT cho bảng `luong`
--
ALTER TABLE `luong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;



--
-- AUTO_INCREMENT cho bảng `phong_ban`
--
ALTER TABLE `phong_ban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;



--
-- AUTO_INCREMENT cho bảng `tai_khoan`
--
ALTER TABLE `tai_khoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `chinh_luong`
  ADD CONSTRAINT `chinh_luong_ibfk_1` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;



--
-- Các ràng buộc cho bảng `khen_thuong_ky_luat`
--
ALTER TABLE `khen_thuong_ky_luat`
  ADD CONSTRAINT `khen_thuong_ky_luat_ibfk_1` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `khen_thuong_ky_luat_ibfk_2` FOREIGN KEY (`loai_kt_id`) REFERENCES `loai_khen_thuong_ky_luat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `luong`
--
ALTER TABLE `luong`
  ADD CONSTRAINT `luong_ibfk_1` FOREIGN KEY (`nhanvien_id`) REFERENCES `nhanvien` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `nhanvien`
--
ALTER TABLE `nhanvien`
  ADD CONSTRAINT `nhanvien_ibfk_8` FOREIGN KEY (`phong_ban_id`) REFERENCES `phong_ban` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `nhanvien_ibfk_9` FOREIGN KEY (`chuc_vu_id`) REFERENCES `chuc_vu` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
