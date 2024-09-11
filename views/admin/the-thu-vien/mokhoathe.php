<?php

$idDocGia = $_GET['id'];
$theThuVienController = new TheThuVienController();
$theThuVien = $theThuVienController->layTheChoDocGia($idDocGia);
$capNhat=$theThuVienController->updateTrangThaiThe($theThuVien['Id'], 7);
if($capNhat){
   $_SESSION['success'] = "Mở khóa thẻ thành công!";
   header('Location: ?url=admin/quanlythethuvien/quanlythekhoa');
   exit();
}
else{
    $_SESSION['error'] = "Mở khóa thẻ thất bại!";
    header('Location: ?url=admin/quanlythethuvien/quanlythekhoa');
    exit();
}
?>
