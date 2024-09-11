<?php

$docGiaController = new DocGiaController();

if ($docGiaController->delete($_GET['id'])) {
    $_SESSION['delete_message'] = "Xóa độc giả thành công!";
} else {
    $_SESSION['error_message'] = "Xóa độc giả thất bại!";
}

header("Location: ?url=admin/quanlydocgia");

?>
