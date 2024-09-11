<?php

$quanTriVienController= new QuanTriVienController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $password='123';

    $data = [
        'Ho' => $_POST['Ho'] ?? null,
        'Ten' => $_POST['Ten'] ?? null,
        'DiaChi' => $_POST['DiaChi'] ?? null,
        'SDT' => $_POST['SDT'] ?? null,
        'Password' => password_hash(md5($password), PASSWORD_DEFAULT),
        'Email' => $_POST['Email'] ?? null,
    ];

    var_dump($data);

    if (empty($data['Ho'])) {
        $errors[] = 'Vui lòng nhập họ.';
    }
    if (empty($data['Ten'])) {
        $errors[] = 'Vui lòng nhập tên.';
    }

    if (empty($data['DiaChi'])) {
        $errors[] = 'Vui lòng nhập địa chỉ.';
    }
    if (empty($data['SDT'])) {
        $errors[] = 'Vui lòng nhập số điện thoại.';
    } elseif (!is_numeric($data['SDT'])) {
        $errors[] = 'Số điện thoại phải là số.';
    }

    if (empty($data['Email'])) {
        $errors[] = 'Vui lòng nhập email.';
    } elseif (!filter_var($data['Email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email không hợp lệ.';
    } elseif ($quanTriVienController->checkExistingEmail($data['Email'])) {
        $errors[] = 'Email đã tồn tại.';
    }

    if (empty($errors)) {
        if ($quanTriVienController->create($data)) {
            $_SESSION['success_message'] = "Thêm quản trị viên thành công!";
            header("Location: ?url=admin/quantrivien/list");
            exit();
        } else {
            $_SESSION['error_message'] = "Thêm quản trị viên thất bại!";
        }
    }
    else {
        $_SESSION['errors'] = $errors;
        header("Location: ?url=admin/quantrivien/add");
        exit();
    }
}
?>
