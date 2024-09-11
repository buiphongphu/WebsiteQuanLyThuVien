<?php

$docGiaController = new DocGiaController();
$theThuVienController= new TheThuVienController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $password='Hello123@';
    $data = [
        'Ho' => $_POST['Ho'] ?? null,
        'Ten' => $_POST['Ten'] ?? null,
        'NgaySinh' => $_POST['NgaySinh'] ?? null,
        'GioiTinh' => $_POST['GioiTinh'] ?? null,
        'DiaChi' => $_POST['DiaChi'] ?? null,
        'DonVi' => $_POST['DonVi'] ?? null,
        'MaSo' => $_POST['MaSo'] ?? null,
        'SDT' => $_POST['SDT'] ?? null,
        'Password' => password_hash($password, PASSWORD_DEFAULT),
        'Email' => $_POST['Email'] ?? null
    ];
    if (empty($data['Ho'])) {
        $errors[] = 'Vui lòng nhập họ.';
    }
    if (empty($data['Ten'])) {
        $errors[] = 'Vui lòng nhập tên.';
    }
    if (empty($data['NgaySinh'])) {
        $errors[] = 'Vui lòng chọn ngày sinh.';
    }
    if (empty($data['GioiTinh'])) {
        $errors[] = 'Vui lòng chọn giới tính.';
    }
    if (empty($data['DiaChi'])) {
        $errors[] = 'Vui lòng nhập địa chỉ.';
    }
    if (empty($data['DonVi'])) {
        $errors[] = 'Vui lòng chọn đơn vị.';
    }
    if (empty($data['MaSo'])) {
        $errors[] = 'Vui lòng nhập mã số.';
    } elseif ($docGiaController->checkExistingMaSo($data['MaSo'])) {
        $errors[] = 'Mã số đã tồn tại.';
    }
    if (empty($data['SDT'])) {
        $errors[] = 'Vui lòng nhập số điện thoại.';
    } elseif (!is_numeric($data['SDT'])) {
        $errors[] = 'Số điện thoại phải là số.';
    }
    if (empty($data['Password'])) {
        $errors[] = 'Vui lòng nhập mật khẩu.';
    }
    if (empty($data['Email'])) {
        $errors[] = 'Vui lòng nhập email.';
    } elseif (!filter_var($data['Email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email không hợp lệ.';
    } elseif ($docGiaController->checkExistingEmail($data['Email'])) {
        $errors[] = 'Email đã tồn tại.';
    }
    $tuoi = date('Y') - date('Y', strtotime($data['NgaySinh']));
    if ($tuoi < 15) {
        $errors[] = "Tuổi phải từ 15 trở lên";
    }
    $ngaytaothe=date('Y-m-d');
    $ngayhethan=date('Y-m-d', strtotime('+1 year'));

    $activation_code = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);


    if (empty($errors)) {
        $Id_TheTV = $theThuVienController->createTheThuVien($data['DonVi'],$ngaytaothe, $ngayhethan,$activation_code);
        $data = [
            'Ho' => $_POST['Ho'] ?? null,
            'Ten' => $_POST['Ten'] ?? null,
            'NgaySinh' => $_POST['NgaySinh'] ?? null,
            'GioiTinh' => $_POST['GioiTinh'] ?? null,
            'DiaChi' => $_POST['DiaChi'] ?? null,
            'DonVi' => $_POST['DonVi'] ?? null,
            'MaSo' => $_POST['MaSo'] ?? null,
            'SDT' => $_POST['SDT'] ?? null,
            'Password' => password_hash($password, PASSWORD_DEFAULT),
            'Email' => $_POST['Email'] ?? null,
            'Id_TheTV' => $Id_TheTV
        ];
        if ($docGiaController->create($data)) {
            $_SESSION['success_message'] = "Thêm độc giả thành công!";
            header("Location: ?url=admin/quanlydocgia");
            exit();
        } else {
            $_SESSION['error_message'] = "Thêm độc giả thất bại!";
        }
    }
    else {
        $_SESSION['errors'] = $errors;
        header("Location: ?url=admin/quanlydocgia/add");
        exit();
    }
}
?>
