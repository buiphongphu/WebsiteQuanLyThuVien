<?php

$loaiSachController = new LoaiSachController();

if ($loaiSachController->delete($_GET['id'])) {
    $_SESSION['delete_message'] = "Xóa loại sách thành công!";
} else {
    $_SESSION['error_message'] = "Xóa loại sách thất bại!";
}

header("Location: ?url=admin/quanlyloaisach");
?>
