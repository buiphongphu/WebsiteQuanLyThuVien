-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th7 26, 2024 lúc 03:24 AM
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
-- Cơ sở dữ liệu: `quanlythuvien`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `reset_points_and_save_history` ()   BEGIN
    -- Lưu trữ các điểm số hiện tại vào bảng lịch sử
    INSERT INTO danhgia_history (Id_DocGia, Id_Sach, Diem, NoiDung, NgayDanhGia, ResetDate)
    SELECT Id_DocGia, Id_Sach, Diem, NoiDung, NgayDanhGia, CURDATE()
    FROM danhgia;
    
    DELETE FROM danhgia;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binhluan`
--

CREATE TABLE `binhluan` (
  `Id` int(11) NOT NULL,
  `Id_DocGia` int(11) DEFAULT NULL,
  `Id_Sach` int(11) DEFAULT NULL,
  `NoiDung` text DEFAULT NULL,
  `NgayBinhLuan` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `binhluan`
--

INSERT INTO `binhluan` (`Id`, `Id_DocGia`, `Id_Sach`, `NoiDung`, `NgayBinhLuan`) VALUES
(10, 22, 97, 'sách đọc cũng ổn', '2024-07-06'),
(12, 22, 98, 'sách khá hay', '2024-07-09'),
(13, 22, 44, 'hello', '2024-07-09'),
(14, 22, 98, 'ổn', '2024-07-11'),
(15, 22, 98, 'dở tệ', '2024-07-11');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangky`
--

CREATE TABLE `dangky` (
  `Id` int(11) NOT NULL,
  `Id_DocGia` int(11) DEFAULT NULL,
  `NgayDangKy` date NOT NULL,
  `NgayMuon` date NOT NULL,
  `NgayTra` date NOT NULL,
  `id_trangthai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dangky`
--

INSERT INTO `dangky` (`Id`, `Id_DocGia`, `NgayDangKy`, `NgayMuon`, `NgayTra`, `id_trangthai`) VALUES
(96, 22, '2024-07-07', '2024-07-07', '2024-07-08', 8),
(97, 22, '2024-07-07', '2024-07-08', '2024-07-08', 7),
(98, 22, '2024-07-07', '2024-07-09', '2024-07-07', 7),
(99, 22, '2024-07-09', '2024-07-10', '2024-07-12', 7),
(100, 23, '2024-07-09', '2024-07-10', '2024-07-15', 7),
(101, 25, '2024-07-11', '2024-07-12', '2024-07-15', 7),
(102, 22, '2024-07-11', '2024-07-12', '2024-07-16', 6),
(103, 22, '2024-07-11', '2024-07-14', '2024-07-15', 8),
(104, 19, '2024-07-14', '2024-07-15', '2024-07-20', 7),
(105, 19, '2024-07-14', '2024-07-15', '2024-07-22', 6),
(106, 19, '2024-07-14', '2024-07-11', '2024-07-13', 7),
(107, 19, '2024-07-14', '2024-07-17', '2024-07-25', 6),
(108, 19, '2024-07-14', '2024-07-11', '2024-07-12', 7),
(109, 19, '2024-07-14', '2024-07-14', '2024-07-14', 7),
(110, 19, '2024-07-15', '2024-07-16', '2024-07-18', 6),
(111, 19, '2024-07-21', '2024-07-22', '2024-07-25', 6),
(112, 19, '2024-07-21', '2024-07-22', '2024-07-25', 6);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dangky_chitiet`
--

CREATE TABLE `dangky_chitiet` (
  `id` int(11) NOT NULL,
  `id_dangky` int(11) NOT NULL,
  `id_sach` int(11) NOT NULL,
  `SoLuong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dangky_chitiet`
--

INSERT INTO `dangky_chitiet` (`id`, `id_dangky`, `id_sach`, `SoLuong`) VALUES
(11, 96, 97, 2),
(12, 97, 98, 2),
(13, 97, 97, 4),
(14, 98, 44, 3),
(15, 98, 97, 3),
(16, 98, 98, 3),
(17, 99, 97, 3),
(18, 99, 44, 3),
(19, 100, 97, 1),
(20, 101, 98, 2),
(21, 102, 98, 1),
(22, 103, 98, 1),
(23, 104, 98, 4),
(24, 105, 44, 1),
(25, 106, 44, 3),
(26, 107, 44, 3),
(27, 108, 98, 5),
(28, 109, 44, 1),
(29, 110, 44, 4),
(30, 111, 44, 1),
(31, 112, 97, 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia`
--

CREATE TABLE `danhgia` (
  `Id` int(11) NOT NULL,
  `Id_DocGia` int(11) DEFAULT NULL,
  `Id_Sach` int(11) DEFAULT NULL,
  `Diem` int(11) DEFAULT NULL CHECK (`Diem` >= 1 and `Diem` <= 5),
  `NoiDung` text DEFAULT NULL,
  `NgayDanhGia` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhgia`
--

INSERT INTO `danhgia` (`Id`, `Id_DocGia`, `Id_Sach`, `Diem`, `NoiDung`, `NgayDanhGia`) VALUES
(20, 23, 97, 4, 'oki\r\n', '2024-07-09'),
(21, 23, 98, 3, 'đc', '2024-07-09'),
(22, 19, 98, 3, 'oki', '2024-07-18'),
(23, 19, 98, 1, 'dở', '2024-07-18'),
(24, 19, 98, 3, 'đ', '2024-07-19'),
(25, 19, 98, 5, 'hay', '2024-07-19'),
(26, 19, 98, 5, 'ok', '2024-07-19'),
(27, 26, 44, 4, 'hisd', '2024-07-19'),
(28, 26, 44, 5, 'ewwff', '2024-07-19'),
(29, 19, 111, 4, 'sách hay', '2024-07-25');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhgia_history`
--

CREATE TABLE `danhgia_history` (
  `Id` int(11) NOT NULL,
  `Id_DocGia` int(11) NOT NULL,
  `Id_Sach` int(11) NOT NULL,
  `Diem` int(11) NOT NULL,
  `NoiDung` varchar(255) DEFAULT NULL,
  `NgayDanhGia` date NOT NULL,
  `ResetDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `danhgia_history`
--

INSERT INTO `danhgia_history` (`Id`, `Id_DocGia`, `Id_Sach`, `Diem`, `NoiDung`, `NgayDanhGia`, `ResetDate`) VALUES
(177, 23, 44, 3, 'oki', '2024-07-09', '2024-07-09');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dausach`
--

CREATE TABLE `dausach` (
  `Id` int(11) NOT NULL,
  `TuaSach` varchar(100) NOT NULL,
  `Id_LoaiSach` int(11) DEFAULT NULL,
  `id_tacgia` int(11) NOT NULL,
  `id_nxb` int(11) NOT NULL,
  `namxb` year(4) NOT NULL,
  `ngaynhap` date NOT NULL,
  `soluong` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `dausach`
--

INSERT INTO `dausach` (`Id`, `TuaSach`, `Id_LoaiSach`, `id_tacgia`, `id_nxb`, `namxb`, `ngaynhap`, `soluong`) VALUES
(33, 'xs', 24, 28, 25, '2024', '2024-07-05', 5),
(40, 'fg', 16, 23, 25, '2024', '2024-07-06', 28),
(41, 'gh', 17, 24, 28, '2024', '2024-07-06', 33),
(49, 'Ngữ Văn (tập 1)', 16, 30, 17, '2022', '2024-07-25', 145),
(50, 'Ngữ Văn (tập 2)', 16, 30, 17, '2022', '2024-07-25', 120),
(51, 'Toán (tập 1)', 14, 31, 17, '2022', '2024-07-25', 90),
(52, 'Toán (tập 2)', 14, 31, 17, '2022', '2024-07-25', 87),
(53, 'Vật lí (tập 1)', 2, 32, 17, '2022', '2024-07-25', 50),
(54, 'Lý Thuyết Trò Chơi', 18, 33, 33, '2023', '2024-07-25', 42);

--
-- Bẫy `dausach`
--
DELIMITER $$
CREATE TRIGGER `update_sach_trangthai` AFTER UPDATE ON `dausach` FOR EACH ROW BEGIN
    IF NEW.soluong = 0 AND OLD.soluong > 0 THEN
        UPDATE sach SET id_trangthai = 11 WHERE Id_DauSach = NEW.Id;
    ELSEIF NEW.soluong > 0 THEN
        UPDATE sach SET id_trangthai = 10 WHERE Id_DauSach = NEW.Id;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_trangthai_on_soluong` AFTER UPDATE ON `dausach` FOR EACH ROW BEGIN
    IF NEW.soluong = 0 AND OLD.soluong > 0 THEN
        UPDATE sach SET id_trangthai = 11 WHERE Id_DauSach = NEW.Id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diem`
--

CREATE TABLE `diem` (
  `Id` int(11) NOT NULL,
  `Id_TheTV` int(11) NOT NULL,
  `diem` float NOT NULL,
  `thuhang` enum('2PVIP','2PGold','2PSilver','2P','Lock') NOT NULL DEFAULT '2P'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `diem`
--

INSERT INTO `diem` (`Id`, `Id_TheTV`, `diem`, `thuhang`) VALUES
(1, 11, 0, 'Lock'),
(2, 12, 200, '2P');

--
-- Bẫy `diem`
--
DELIMITER $$
CREATE TRIGGER `update_diemsach_zero` BEFORE UPDATE ON `diem` FOR EACH ROW BEGIN
    IF NEW.diem < 0 THEN
        SET NEW.diem = 0;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_thuhang_update` BEFORE UPDATE ON `diem` FOR EACH ROW BEGIN
    IF NEW.diem < 50 THEN
        SET NEW.thuhang = 'Lock';
        UPDATE thethuvien SET id_trangthai = 2 WHERE Id =  NEW.Id_TheTV;

    ELSEIF NEW.diem >= 50 AND NEW.diem < 1000 THEN
        SET NEW.thuhang = '2P';
    ELSEIF NEW.diem >= 1000 AND NEW.diem < 5000 THEN
        SET NEW.thuhang = '2PSilver';
    ELSEIF NEW.diem >= 5000 AND NEW.diem < 10000 THEN
        SET NEW.thuhang = '2PGold';
    ELSE
        SET NEW.thuhang = '2PVIP';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `docgia`
--

CREATE TABLE `docgia` (
  `Id` int(11) NOT NULL,
  `Ho` varchar(50) NOT NULL,
  `Ten` varchar(10) NOT NULL,
  `NgaySinh` date NOT NULL,
  `GioiTinh` enum('Nam','Nữ') NOT NULL,
  `DiaChi` varchar(255) NOT NULL,
  `DonVi` varchar(15) DEFAULT NULL,
  `MaSo` varchar(15) NOT NULL,
  `SDT` varchar(10) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Id_TheTV` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `docgia`
--

INSERT INTO `docgia` (`Id`, `Ho`, `Ten`, `NgaySinh`, `GioiTinh`, `DiaChi`, `DonVi`, `MaSo`, `SDT`, `Password`, `Email`, `Id_TheTV`) VALUES
(19, 'Bùi Phong', 'Phú', '2002-12-28', 'Nam', 'Bến Tre', 'Sinh Viên', 'DH52001882', '0388193175', '$2y$10$7ovCUgkuSElfZqYLGoAWSeGAzQ3ogNQqZrPa3OmeJS9QPXhCX9M6u', 'buiphongphu2002@gmail.com', 16),
(21, 'Trần Văn ', 'Thời', '1976-03-13', 'Nam', 'Đồng Nai', 'Giáo Viên', 'GV52001882', '0388193175', '$2y$10$hsRfgjT/HCB3eHAvyMHYe.Pw5bW8XviX6o4K9wcZq74.Rfai5w8CK', 'tvt@gmail.com', NULL),
(22, 'a', 'b', '2002-12-28', 'Nam', 'ddd', 'Sinh Viên', 'Dh520000', '0388193176', '$2y$10$cBR8Ir3zt0F1kcMtK.GQl.XIm8cXRju8EiUkvs9fBKZ1DHGnpGPa6', 'c@gmail.com', 10),
(23, 'v', 'c', '2002-12-18', 'Nam', 'Bến Tre', 'Sinh Viên', 'Dt52001882', '0388193175', '$2y$10$tFpW.vAdSSAjeDWpHQjPV.essoiMBnx0YbVTgFcydGsDbMPt3MdNi', 'v@gmail.com', 11),
(24, 't', 'z', '2002-12-18', 'Nam', 'Bến Tre', 'Sinh Viên', 'Dt52001881', '0388193175', '$2y$10$.3aeA9nOcERZcXaCCsR7k.0ESQxWYpmVoVOwxaPRIy.H.HT0y354e', 'phanhoangphuc050512345@gmail.com', 12),
(25, 'Phan Minh ', 'Thiện', '2003-08-15', 'Nam', 'Bến Tre', 'Sinh Viên', 'Dh52001992', '0388193175', '$2y$10$UhbwVtKBVngP98AZUBXSlekcyq2OiPvUw9T7HezGftZW0YZSPLj/2', 'phanminhthien2003@gmail.com', 13),
(26, 'a', 'a', '2002-12-28', 'Nam', 'Bến Tre', 'Sinh Viên', 'Dh52001889', '0388193175', '$2y$10$x6D5Qv3nf9vvlDSgfz48QuXO4/uvR0zvmKpi3PtSyChNTAWTzyuG.', 's@gmail.com', 15);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giahan`
--

CREATE TABLE `giahan` (
  `id` int(11) NOT NULL,
  `ngaytramoi` date NOT NULL,
  `id_DocGia` int(11) NOT NULL,
  `id_PhieuMuon` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `giahan`
--

INSERT INTO `giahan` (`id`, `ngaytramoi`, `id_DocGia`, `id_PhieuMuon`) VALUES
(7, '2024-07-14', 22, 93);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `image_sach`
--

CREATE TABLE `image_sach` (
  `Id` int(11) NOT NULL,
  `TenHinh` varchar(255) NOT NULL,
  `Url` varchar(255) NOT NULL,
  `id_dausach` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `image_sach`
--

INSERT INTO `image_sach` (`Id`, `TenHinh`, `Url`, `id_dausach`) VALUES
(56, 'b614391cbc46f57ca5110587f5be1151.jpeg', 'public/uploads/b614391cbc46f57ca5110587f5be1151.jpeg', 33),
(57, 'fadbb2c98682dc74da8c1cf717f25ead.jpg', 'public/uploads/fadbb2c98682dc74da8c1cf717f25ead.jpg', 33),
(58, '58add2c2638aa3f5da7e86c028ada5fe.jpeg', 'public/uploads/58add2c2638aa3f5da7e86c028ada5fe.jpeg', 33),
(71, 'beautiful_fantasy_map_of_Nimit.webp', 'public/uploads/beautiful_fantasy_map_of_Nimit.webp', 40),
(72, 'c62173ef13a7e354df9f6140e108719c.jpg', 'public/uploads/c62173ef13a7e354df9f6140e108719c.jpg', 41),
(73, '250px-Harry_Potter_và_Hòn_đá_phù_thủy_bìa_2003.jpeg', 'public/uploads/250px-Harry_Potter_và_Hòn_đá_phù_thủy_bìa_2003.jpeg', 41),
(89, 'nguvan10.jpg', 'public/uploads/nguvan10.jpg', 49),
(90, 'nguvan10_2.jpg', 'public/uploads/nguvan10_2.jpg', 50),
(91, 'Toan10.jpg', 'public/uploads/Toan10.jpg', 51),
(92, 'Toan10_2.jpg', 'public/uploads/Toan10_2.jpg', 52),
(93, 'Vatly10.jpg', 'public/uploads/Vatly10.jpg', 53),
(94, 'lythuyettrochoi5.jpg', 'public/uploads/lythuyettrochoi5.jpg', 54),
(95, 'lythuyettrochoi4.jpg', 'public/uploads/lythuyettrochoi4.jpg', 54),
(96, 'lythuyettrochoi3.jpg', 'public/uploads/lythuyettrochoi3.jpg', 54),
(97, 'lythuyettrochoi2.jpg', 'public/uploads/lythuyettrochoi2.jpg', 54),
(98, 'lythuyettrochoi1.jpg', 'public/uploads/lythuyettrochoi1.jpg', 54);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisach`
--

CREATE TABLE `loaisach` (
  `Id` int(11) NOT NULL,
  `TenLoai` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisach`
--

INSERT INTO `loaisach` (`Id`, `TenLoai`) VALUES
(2, 'Khoa học'),
(14, 'Toán Học'),
(15, 'Khoa học máy tính'),
(16, 'Văn học'),
(17, 'Kinh tế'),
(18, 'Tâm lý học'),
(19, 'Lịch sử'),
(20, 'Triết học'),
(21, 'Y Khoa'),
(22, 'Kỹ thuật'),
(23, 'Giáo dục'),
(24, 'Nghệ thuật'),
(25, 'Trinh Thám');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhaxuatban`
--

CREATE TABLE `nhaxuatban` (
  `Id` int(11) NOT NULL,
  `TenNXB` varchar(50) NOT NULL,
  `DiaChiNXB` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `nhaxuatban`
--

INSERT INTO `nhaxuatban` (`Id`, `TenNXB`, `DiaChiNXB`) VALUES
(15, 'Nhà xuất bản Trẻ', '161B Lý Chính Thắng, Quận 3, TP. Hồ Chí Minh'),
(16, 'Nhà xuất bản Kim Đồng', '55 Quang Trung, Quận Hai Bà Trưng, Hà Nội'),
(17, 'Nhà xuất bản Giáo dục Việt Nam', '81 Trần Hưng Đạo, Quận Hoàn Kiếm, Hà Nội'),
(18, 'Nhà xuất bản Văn học', '52 Hai Bà Trưng, Quận Hoàn Kiếm, Hà Nội'),
(19, 'Nhà xuất bản Thế giới', '46 Trần Hưng Đạo, Quận Hoàn Kiếm, Hà Nội'),
(20, 'Nhà xuất bản Lao Động', '175 Giảng Võ, Quận Đống Đa, Hà Nội'),
(21, 'Nhà xuất bản Chính trị Quốc gia Sự thật', '6/86 Duy Tân, Quận Cầu Giấy, Hà Nội'),
(22, 'Nhà xuất bản Phụ Nữ', '39 Hàng Chuối, Quận Hai Bà Trưng, Hà Nội'),
(23, 'Nhà xuất bản Thanh Niên', '145 Pasteur, Quận 3, TP. Hồ Chí Minh'),
(24, 'Nhà xuất bản Tổng hợp Thành phố Hồ Chí Minh', '62 Nguyễn Thị Minh Khai, Quận 3, TP. Hồ Chí Minh'),
(25, 'Penguin Random House', '1745 Broadway, New York, NY 10019, Mỹ'),
(26, 'HarperCollins', '195 Broadway, New York, NY 10007, Mỹ'),
(27, 'Simon & Schuster', '1230 Avenue of the Americas, New York, NY 10020, Mỹ'),
(28, 'Hachette Livre', '58 Rue Jean Bleuzen, 92170 Vanves, Pháp'),
(29, 'Macmillan Publishers', 'The Macmillan Building, 4 Crinan St, London N1 9XW, Anh'),
(30, 'Bloomsbury Publishing', '50 Bedford Square, London WC1B 3DP, Anh'),
(31, 'Nhà xuất bản Bến Mới', '124 Đại lộ Đồng Khởi, khu phố 4, phường Hưng Phú, Thành Phố Bến Tre, tỉnh Bến Tre'),
(33, 'Nhà Xuất Bản Dân Trí', 'Số 9, ngõ 26, phố Hoàng Cầu, phường Ô Chợ Dừa, quận Đống Đa, Hà Nội');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieumuonsach`
--

CREATE TABLE `phieumuonsach` (
  `Id` int(11) NOT NULL,
  `Id_QTV` int(11) DEFAULT NULL,
  `Id_DocGia` int(11) DEFAULT NULL,
  `id_DangKy` int(11) NOT NULL,
  `id_trangthai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieumuonsach`
--

INSERT INTO `phieumuonsach` (`Id`, `Id_QTV`, `Id_DocGia`, `id_DangKy`, `id_trangthai`) VALUES
(91, 1, 22, 97, 1),
(93, 1, 22, 98, 3),
(94, 1, 22, 99, 4),
(95, 1, 23, 100, 1),
(96, 1, 25, 101, 1),
(99, 1, 19, 104, 1),
(100, 1, 19, 109, 1),
(101, 1, 19, 108, 1),
(102, 1, 19, 106, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `phieutra`
--

CREATE TABLE `phieutra` (
  `Id` int(11) NOT NULL,
  `Id_DocGia` int(11) DEFAULT NULL,
  `Id_PhieuMuon` int(11) NOT NULL,
  `ngayTra` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `phieutra`
--

INSERT INTO `phieutra` (`Id`, `Id_DocGia`, `Id_PhieuMuon`, `ngayTra`) VALUES
(36, 22, 91, '2024-07-09'),
(37, 19, 100, '2024-07-14'),
(38, 19, 99, '2024-07-14'),
(39, 19, 101, '2024-07-14');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `quantrivien`
--

CREATE TABLE `quantrivien` (
  `Id` int(11) NOT NULL,
  `Ho` varchar(50) NOT NULL,
  `Ten` varchar(10) NOT NULL,
  `SDT` varchar(10) NOT NULL,
  `DiaChi` varchar(255) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `quantrivien`
--

INSERT INTO `quantrivien` (`Id`, `Ho`, `Ten`, `SDT`, `DiaChi`, `Password`, `Email`) VALUES
(1, 'Phan Hoàng ', 'Phúc', '2222222222', 'aaaaa', '$2y$10$B7H.Tx4Qt5iy8icSKlWpFedY/pEf3yE10oUZyDZSorvIFYWgaCPbe', 'b@gmail.com'),
(5, 'Ngô Trung', 'Hiếu', '0388193175', 'Cần Thơ', '$2y$10$OIgr3jCgt0vQG3WS2DY6cedELTdb99YQbhPbY9VcBjT0RRUFdabcS', 'ngotrunghieu@gmail.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sach`
--

CREATE TABLE `sach` (
  `Id` int(11) NOT NULL,
  `Id_DauSach` int(11) DEFAULT NULL,
  `id_trangthai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sach`
--

INSERT INTO `sach` (`Id`, `Id_DauSach`, `id_trangthai`) VALUES
(44, 33, 10),
(97, 40, 10),
(98, 41, 10),
(106, 49, 10),
(107, 50, 10),
(108, 51, 10),
(109, 52, 10),
(110, 53, 10),
(111, 54, 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sach_mat_hong`
--

CREATE TABLE `sach_mat_hong` (
  `id` int(11) NOT NULL,
  `id_phieumuon` int(11) NOT NULL,
  `id_sach` int(11) NOT NULL,
  `soluong` int(11) NOT NULL,
  `id_trangthai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sach_mat_hong`
--

INSERT INTO `sach_mat_hong` (`id`, `id_phieumuon`, `id_sach`, `soluong`, `id_trangthai`) VALUES
(80, 93, 44, 2, 1),
(81, 93, 97, 1, 1),
(82, 102, 44, 3, 9),
(83, 95, 97, 1, 12),
(84, 96, 98, 1, 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tacgia`
--

CREATE TABLE `tacgia` (
  `Id` int(11) NOT NULL,
  `Ho` varchar(20) NOT NULL,
  `Ten` varchar(20) NOT NULL,
  `quoctich` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `tacgia`
--

INSERT INTO `tacgia` (`Id`, `Ho`, `Ten`, `quoctich`) VALUES
(19, 'Tolstoy', 'Leo', 'Nga'),
(20, 'Rowling', 'J.K.', 'Anh'),
(21, 'Murakami', 'Haruki', 'Nhật Bản'),
(22, 'Austen', 'Jane', 'Anh'),
(23, 'Dickens', 'Charles', 'Anh'),
(24, 'Márquez', 'Gabriel García', 'Colombia'),
(25, 'Hugo', 'Victor', 'Pháp'),
(26, 'Shakespeare', 'William', 'Anh'),
(28, 'Camus', 'Albert', 'Pháp'),
(30, 'Trần', 'Ngọc Hiếu', 'Việt Nam'),
(31, 'Hạ', 'Vũ Anh', 'Việt Nam'),
(32, 'Phạm', 'Kim Chung', 'Việt Nam'),
(33, 'Trần', 'Phách Hàm', 'Việt Nam');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thethuvien`
--

CREATE TABLE `thethuvien` (
  `Id` int(11) NOT NULL,
  `LoaiThe` enum('Sinh viên','Giáo viên','Cán bộ','Khác') NOT NULL,
  `NgayLapThe` date NOT NULL,
  `NgayHetHan` date NOT NULL,
  `id_trangthai` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thethuvien`
--

INSERT INTO `thethuvien` (`Id`, `LoaiThe`, `NgayLapThe`, `NgayHetHan`, `id_trangthai`) VALUES
(10, 'Sinh viên', '2024-06-24', '2025-06-23', 7),
(11, 'Sinh viên', '2024-07-09', '2025-07-09', 2),
(12, 'Sinh viên', '2024-07-10', '2025-07-10', 7),
(13, 'Sinh viên', '2024-07-11', '2025-07-11', 7),
(15, 'Sinh viên', '2024-07-19', '2025-07-19', 6),
(16, 'Sinh viên', '2024-07-20', '2025-07-20', 7);

--
-- Bẫy `thethuvien`
--
DELIMITER $$
CREATE TRIGGER `delete_expired_card_after_update` AFTER UPDATE ON `thethuvien` FOR EACH ROW BEGIN
    DECLARE today DATE;
    SET today = CURDATE();
    IF NEW.NgayHetHan = today THEN
        DELETE FROM thethuvien WHERE Id = NEW.Id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `trangthai`
--

CREATE TABLE `trangthai` (
  `id` int(11) NOT NULL,
  `tentrangthai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `trangthai`
--

INSERT INTO `trangthai` (`id`, `tentrangthai`) VALUES
(0, 'chưa lấy'),
(1, 'đã trả'),
(2, 'đã khóa'),
(3, 'đang mượn'),
(4, 'đã hủy'),
(5, 'quá hạn'),
(6, 'đang chờ'),
(7, 'đã duyệt'),
(8, 'từ chối'),
(9, 'hỏng'),
(10, 'còn'),
(11, 'hết'),
(12, 'mất');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `yeuthichsach`
--

CREATE TABLE `yeuthichsach` (
  `id` int(11) NOT NULL,
  `id_DocGia` int(11) NOT NULL,
  `id_Sach` int(11) NOT NULL,
  `thoi_gian_tao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `yeuthichsach`
--

INSERT INTO `yeuthichsach` (`id`, `id_DocGia`, `id_Sach`, `thoi_gian_tao`) VALUES
(45, 22, 44, '2024-07-06 10:08:07'),
(55, 23, 97, '2024-07-09 14:14:01'),
(56, 22, 98, '2024-07-11 21:19:29'),
(61, 19, 97, '2024-07-21 00:58:58');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_DocGia` (`Id_DocGia`),
  ADD KEY `Id_Sach` (`Id_Sach`);

--
-- Chỉ mục cho bảng `dangky`
--
ALTER TABLE `dangky`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_DangKy` (`Id_DocGia`),
  ADD KEY `id_trangthai` (`id_trangthai`);

--
-- Chỉ mục cho bảng `dangky_chitiet`
--
ALTER TABLE `dangky_chitiet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_dangky` (`id_dangky`),
  ADD KEY `id_sach` (`id_sach`);

--
-- Chỉ mục cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_DocGia` (`Id_DocGia`),
  ADD KEY `Id_Sach` (`Id_Sach`);

--
-- Chỉ mục cho bảng `danhgia_history`
--
ALTER TABLE `danhgia_history`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `dausach`
--
ALTER TABLE `dausach`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_LoaiSach` (`Id_LoaiSach`),
  ADD KEY `id_tacgia` (`id_tacgia`,`id_nxb`),
  ADD KEY `id_nxb` (`id_nxb`);

--
-- Chỉ mục cho bảng `diem`
--
ALTER TABLE `diem`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_TheTV` (`Id_TheTV`);

--
-- Chỉ mục cho bảng `docgia`
--
ALTER TABLE `docgia`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_TheTV` (`Id_TheTV`);

--
-- Chỉ mục cho bảng `giahan`
--
ALTER TABLE `giahan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Sach` (`id_DocGia`,`id_PhieuMuon`),
  ADD KEY `id_PhieuMuon` (`id_PhieuMuon`);

--
-- Chỉ mục cho bảng `image_sach`
--
ALTER TABLE `image_sach`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `id_sach` (`id_dausach`);

--
-- Chỉ mục cho bảng `loaisach`
--
ALTER TABLE `loaisach`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `nhaxuatban`
--
ALTER TABLE `nhaxuatban`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `phieumuonsach`
--
ALTER TABLE `phieumuonsach`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_QTV` (`Id_QTV`),
  ADD KEY `Id_DocGia` (`Id_DocGia`),
  ADD KEY `phieumuonsach_ibfk_5` (`id_DangKy`),
  ADD KEY `id_trangthai` (`id_trangthai`);

--
-- Chỉ mục cho bảng `phieutra`
--
ALTER TABLE `phieutra`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_DocGia` (`Id_DocGia`),
  ADD KEY `Id_PhieuMuon` (`Id_PhieuMuon`);

--
-- Chỉ mục cho bảng `quantrivien`
--
ALTER TABLE `quantrivien`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `sach`
--
ALTER TABLE `sach`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_DauSach` (`Id_DauSach`),
  ADD KEY `id_trangthai` (`id_trangthai`);

--
-- Chỉ mục cho bảng `sach_mat_hong`
--
ALTER TABLE `sach_mat_hong`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_phieumuon` (`id_phieumuon`);

--
-- Chỉ mục cho bảng `tacgia`
--
ALTER TABLE `tacgia`
  ADD PRIMARY KEY (`Id`);

--
-- Chỉ mục cho bảng `thethuvien`
--
ALTER TABLE `thethuvien`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `id_trangthai` (`id_trangthai`);

--
-- Chỉ mục cho bảng `trangthai`
--
ALTER TABLE `trangthai`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `yeuthichsach`
--
ALTER TABLE `yeuthichsach`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_DocGia` (`id_DocGia`,`id_Sach`),
  ADD KEY `id_Sach` (`id_Sach`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT cho bảng `dangky`
--
ALTER TABLE `dangky`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT cho bảng `dangky_chitiet`
--
ALTER TABLE `dangky_chitiet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `danhgia_history`
--
ALTER TABLE `danhgia_history`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT cho bảng `dausach`
--
ALTER TABLE `dausach`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `diem`
--
ALTER TABLE `diem`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `docgia`
--
ALTER TABLE `docgia`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `giahan`
--
ALTER TABLE `giahan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `image_sach`
--
ALTER TABLE `image_sach`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT cho bảng `loaisach`
--
ALTER TABLE `loaisach`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `nhaxuatban`
--
ALTER TABLE `nhaxuatban`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `phieumuonsach`
--
ALTER TABLE `phieumuonsach`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT cho bảng `phieutra`
--
ALTER TABLE `phieutra`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT cho bảng `quantrivien`
--
ALTER TABLE `quantrivien`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `sach`
--
ALTER TABLE `sach`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT cho bảng `sach_mat_hong`
--
ALTER TABLE `sach_mat_hong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT cho bảng `tacgia`
--
ALTER TABLE `tacgia`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT cho bảng `thethuvien`
--
ALTER TABLE `thethuvien`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `yeuthichsach`
--
ALTER TABLE `yeuthichsach`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`Id_DocGia`) REFERENCES `docgia` (`Id`),
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`Id_Sach`) REFERENCES `sach` (`Id`);

--
-- Các ràng buộc cho bảng `dangky`
--
ALTER TABLE `dangky`
  ADD CONSTRAINT `dangky_ibfk_2` FOREIGN KEY (`Id_DocGia`) REFERENCES `docgia` (`Id`),
  ADD CONSTRAINT `dangky_ibfk_3` FOREIGN KEY (`id_trangthai`) REFERENCES `trangthai` (`id`);

--
-- Các ràng buộc cho bảng `dangky_chitiet`
--
ALTER TABLE `dangky_chitiet`
  ADD CONSTRAINT `dangky_chitiet_ibfk_1` FOREIGN KEY (`id_dangky`) REFERENCES `dangky` (`Id`),
  ADD CONSTRAINT `dangky_chitiet_ibfk_2` FOREIGN KEY (`id_sach`) REFERENCES `sach` (`Id`);

--
-- Các ràng buộc cho bảng `danhgia`
--
ALTER TABLE `danhgia`
  ADD CONSTRAINT `danhgia_ibfk_1` FOREIGN KEY (`Id_DocGia`) REFERENCES `docgia` (`Id`),
  ADD CONSTRAINT `danhgia_ibfk_2` FOREIGN KEY (`Id_Sach`) REFERENCES `sach` (`Id`);

--
-- Các ràng buộc cho bảng `dausach`
--
ALTER TABLE `dausach`
  ADD CONSTRAINT `dausach_ibfk_1` FOREIGN KEY (`Id_LoaiSach`) REFERENCES `loaisach` (`Id`),
  ADD CONSTRAINT `dausach_ibfk_2` FOREIGN KEY (`id_tacgia`) REFERENCES `tacgia` (`Id`),
  ADD CONSTRAINT `dausach_ibfk_3` FOREIGN KEY (`id_nxb`) REFERENCES `nhaxuatban` (`Id`);

--
-- Các ràng buộc cho bảng `diem`
--
ALTER TABLE `diem`
  ADD CONSTRAINT `diem_ibfk_1` FOREIGN KEY (`Id_TheTV`) REFERENCES `thethuvien` (`Id`);

--
-- Các ràng buộc cho bảng `docgia`
--
ALTER TABLE `docgia`
  ADD CONSTRAINT `docgia_ibfk_1` FOREIGN KEY (`Id_TheTV`) REFERENCES `thethuvien` (`Id`);

--
-- Các ràng buộc cho bảng `giahan`
--
ALTER TABLE `giahan`
  ADD CONSTRAINT `giahan_ibfk_1` FOREIGN KEY (`id_PhieuMuon`) REFERENCES `phieumuonsach` (`Id`),
  ADD CONSTRAINT `giahan_ibfk_2` FOREIGN KEY (`id_DocGia`) REFERENCES `docgia` (`Id`);

--
-- Các ràng buộc cho bảng `image_sach`
--
ALTER TABLE `image_sach`
  ADD CONSTRAINT `image_sach_ibfk_1` FOREIGN KEY (`id_dausach`) REFERENCES `dausach` (`Id`);

--
-- Các ràng buộc cho bảng `phieumuonsach`
--
ALTER TABLE `phieumuonsach`
  ADD CONSTRAINT `phieumuonsach_ibfk_1` FOREIGN KEY (`Id_QTV`) REFERENCES `quantrivien` (`Id`),
  ADD CONSTRAINT `phieumuonsach_ibfk_2` FOREIGN KEY (`Id_DocGia`) REFERENCES `docgia` (`Id`),
  ADD CONSTRAINT `phieumuonsach_ibfk_5` FOREIGN KEY (`id_DangKy`) REFERENCES `dangky` (`Id`),
  ADD CONSTRAINT `phieumuonsach_ibfk_6` FOREIGN KEY (`id_trangthai`) REFERENCES `trangthai` (`id`);

--
-- Các ràng buộc cho bảng `phieutra`
--
ALTER TABLE `phieutra`
  ADD CONSTRAINT `phieutra_ibfk_2` FOREIGN KEY (`Id_DocGia`) REFERENCES `docgia` (`Id`),
  ADD CONSTRAINT `phieutra_ibfk_3` FOREIGN KEY (`Id_PhieuMuon`) REFERENCES `phieumuonsach` (`Id`);

--
-- Các ràng buộc cho bảng `sach`
--
ALTER TABLE `sach`
  ADD CONSTRAINT `sach_ibfk_1` FOREIGN KEY (`id_trangthai`) REFERENCES `trangthai` (`id`),
  ADD CONSTRAINT `sach_ibfk_2` FOREIGN KEY (`Id_DauSach`) REFERENCES `dausach` (`Id`);

--
-- Các ràng buộc cho bảng `sach_mat_hong`
--
ALTER TABLE `sach_mat_hong`
  ADD CONSTRAINT `sach_mat_hong_ibfk_1` FOREIGN KEY (`id_phieumuon`) REFERENCES `phieumuonsach` (`Id`);

--
-- Các ràng buộc cho bảng `thethuvien`
--
ALTER TABLE `thethuvien`
  ADD CONSTRAINT `thethuvien_ibfk_1` FOREIGN KEY (`id_trangthai`) REFERENCES `trangthai` (`id`);

--
-- Các ràng buộc cho bảng `yeuthichsach`
--
ALTER TABLE `yeuthichsach`
  ADD CONSTRAINT `yeuthichsach_ibfk_1` FOREIGN KEY (`id_DocGia`) REFERENCES `docgia` (`Id`),
  ADD CONSTRAINT `yeuthichsach_ibfk_2` FOREIGN KEY (`id_Sach`) REFERENCES `sach` (`Id`);

DELIMITER $$
--
-- Sự kiện
--
CREATE DEFINER=`root`@`localhost` EVENT `yearly_reset_points` ON SCHEDULE EVERY 1 MINUTE STARTS '2025-01-01 23:26:46' ON COMPLETION NOT PRESERVE ENABLE DO CALL reset_points_and_save_history()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
