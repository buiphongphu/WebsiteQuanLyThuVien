<?php

$nxbController=new NhaXuatBan();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['TenNXB'])) {
        $errors['TenNXB'] = "Vui lòng nhập tên nhà xuất bản.";
    } elseif (trim($_POST['TenNXB']) == "") {
        $errors['TenNXB'] = "Tên nhà xuất bản không được chỉ chứa khoảng trắng.";
    } elseif ($nxbController->existsByName($_POST['TenNXB'])) {
        $errors['TenNXB'] = "Tên nhà xuất bản đã tồn tại.";
    }

    if (empty($_POST['DiaChiNXB'])) {
        $errors['DiaChiNXB'] = "Vui lòng nhập địa chỉ nhà xuất bản.";
    }


    if (empty($errors)) {
        $data = [
            'TenNXB' => trim($_POST['TenNXB']),
            'DiaChiNXB' => trim($_POST['DiaChiNXB'])
        ];

        if ($nxbController->insert($data)) {
            $_SESSION['success_message'] = "Thêm nhà xuất bản thành công!";
            header("Location: ?url=admin/quanlynhaxuatban");
            exit();
        } else {
            $_SESSION['error_message'] = "Thêm nhà xuất bản thất bại! Vui lòng thử lại.";
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ?url=admin/quanlynhaxuatban/add");
        exit();
    }
}
?>
