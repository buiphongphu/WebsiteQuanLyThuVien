<?php
$theThuVienController = new TheThuVienController();
$theThuVien = $theThuVienController->layTheChoDocGia($_SESSION['user']['Id']);
$ngayHetHan = date('Y-m-d', strtotime('+1 year'));
$theThuVienController->capNhatNgayHetHan($theThuVien['Id'], $ngayHetHan);
if($theThuVien){
    $_SESSION['success'] = 'Gia hạn thẻ thành công';
    header('location: ?url=the-thu-vien');
    exit;
}else{
    $_SESSION['error'] = 'Gia hạn thẻ thất bại';
    header('location: ?url=the-thu-vien');
    exit;
}
