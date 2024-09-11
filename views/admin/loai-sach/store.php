<?php

$loaiSachController = new LoaiSachController();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['TenLoai'])) {
        $errors['TenLoai'] = "Vui lòng nhập tên loại sách.";
    } elseif (trim($_POST['TenLoai']) == "") {
        $errors['TenLoai'] = "Tên loại sách không được chỉ chứa khoảng trắng.";
    } elseif (!preg_match('/^[a-zA-Z\sÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]+$/', $_POST['TenLoai'])) {
        $errors['TenLoai'] = "Tên loại sách không hợp lệ.";
    } elseif ($loaiSachController->existsByName($_POST['TenLoai'])) {
        $errors['TenLoai'] = "Tên loại sách đã tồn tại.";
    }

    if (empty($errors)) {
        $data = [
            'TenLoai' => trim($_POST['TenLoai'])
        ];

        if ($loaiSachController->create($data)) {
            $_SESSION['success_message'] = "Thêm loại sách thành công!";
            header("Location: ?url=admin/quanlyloaisach");
            exit();
        } else {
            $_SESSION['error_message'] = "Thêm loại sách thất bại! Vui lòng thử lại.";
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ?url=admin/quanlyloaisach/add"); // Giả sử đây là route đến trang thêm mới
        exit();
    }
}
?>
