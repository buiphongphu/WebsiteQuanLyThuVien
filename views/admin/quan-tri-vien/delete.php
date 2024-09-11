<?php

$quanTriVienController= new QuanTriVienController();
// lấy id quản trị viên từ session
$id_qtv=$_SESSION['admin']['Id'];
$id=$_GET['id'];
if($id==$id_qtv){
    $_SESSION['error_message'] = "Không thể xóa quản trị viên đang đăng nhập!";
    header("Location: ?url=admin/quantrivien/list");
    exit();
}
if ($quanTriVienController->delete($id)) {
    $_SESSION['delete_message'] = "Xóa quản trị viên thành công!";
} else {
    $_SESSION['error_message'] = "Xóa quản trị viên thất bại!";
}

header("Location: ?url=admin/quantrivien/list");

?>