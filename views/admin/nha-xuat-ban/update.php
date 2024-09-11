<?php

$nxbController = new NhaXuatBan();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['TenNXB'])) {
        $errors['TenNXB'] = "Vui lòng nhập tên nhà xuất bản.";
    } elseif (trim($_POST['TenNXB']) == "") {
        $errors['TenNXB'] = "Tên nhà xuất bản không được chỉ chứa khoảng trắng.";
    }

    if (empty($_POST['DiaChiNXB'])) {
        $errors['DiaChiNXB'] = "Vui lòng nhập địa chỉ nhà xuất bản.";
    }


    if (empty($errors)) {
        $data = [
            'Id' => $_POST['Id'],
            'TenNXB' => trim($_POST['TenNXB']),
            'DiaChiNXB' => trim($_POST['DiaChiNXB'])
        ];

        if ($nxbController->update($data)) {
            $_SESSION['success_message'] = "Cập nhật nhà xuất bản thành công!";
            header("Location: ?url=admin/quanlynhaxuatban");
        } else {
            $_SESSION['error_message'] = "Cập nhật nhà xuất bản thất bại! Vui lòng thử lại.";
            header("Location: ?url=admin/quanlynhaxuatban/edit&id=" . $_POST['Id']);
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ?url=admin/quanlynhaxuatban/edit&id=" . $_POST['Id']);
    }
    exit();
}
?>
