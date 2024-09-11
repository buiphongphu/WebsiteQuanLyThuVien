<?php

if (!isset($_SESSION['user'])) {
    header('location: ?url=login');
    exit;
}

$theThuVienController = new TheThuVienController();
$theThuVien = $theThuVienController->layTheChoDocGia($_SESSION['user']['Id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loaiThe = $_POST['loai-the'];
    $ngayLapThe = $_POST['ngay-lap-the'];
    $ngayHetHan = $_POST['ngay-het-han'];

    if ($theThuVien) {
        $theThuVienController->capNhatTrangThaiThe($theThuVien['Id'], 6);
    } else {
        $theThuVienController->dangKyThe($loaiThe, $ngayLapThe, $ngayHetHan);
    }

    header('location: ?url=the-thu-vien');
    exit;
} else {
    header('location: ?url=the-thu-vien/dangky');
    exit;
}
?>
