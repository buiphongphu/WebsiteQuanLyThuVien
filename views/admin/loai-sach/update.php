<?php

$loaiSachController = new LoaiSachController();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['TenLoai'])) {
        $errors['TenLoai'] = "Vui lòng nhập tên loại sách.";
    } elseif (trim($_POST['TenLoai']) == "") {
        $errors['TenLoai'] = "Tên loại sách không được chỉ chứa khoảng trắng.";
    }

    if (empty($errors)) {
        $data = [
            'Id' => $_POST['Id'],
            'TenLoai' => trim($_POST['TenLoai'])
        ];

        if ($loaiSachController->update($data)) {
            $_SESSION['success_message'] = "Cập nhật loại sách thành công!";
            header("Location: ?url=admin/quanlyloaisach");
            exit();
        } else {
            $_SESSION['error_message'] = "Cập nhật loại sách thất bại! Vui lòng thử lại.";
            header("Location: ?url=admin/quanlyloaisach/edit&id=" . $_POST['Id']);
            exit();
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ?url=admin/quanlyloaisach/edit&id=" . $_POST['Id']);
        exit();
    }
}
?>
