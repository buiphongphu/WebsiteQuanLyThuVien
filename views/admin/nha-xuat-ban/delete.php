<?php

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "ID nhà xuất bản không hợp lệ";
    header("Location: ?url=admin/quanlynhaxuatban");
    exit();
}

$nxbModel = new NhaXuatBan();
$nxbModel->delete($_GET['id']);

?>
