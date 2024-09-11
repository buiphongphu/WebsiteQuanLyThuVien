<?php

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

require 'vendor/autoload.php';

$registerController = new RegisterController();
$theThuVienController = new TheThuVienController();

$ho = $_POST['name'];
$ten = $_POST['firstname'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$address = preg_replace('/\s+/', ' ', trim($_POST['address']));
$unit = preg_replace('/\s+/', ' ', trim($_POST['unit']));
$id_number = preg_replace('/\s+/', ' ', trim($_POST['id_number']));
$sdt = trim($_POST['phone']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

$errors = [];

if (empty($dob)) {
    $errors[] = "Ngày Sinh không được để trống";
} elseif (strtotime($dob) > strtotime(date('Y-m-d'))) {
    $errors[] = "Ngày sinh không hợp lệ";
}

if (empty($gender)) {
    $errors[] = "Giới Tính không được để trống";
}

if (empty($address)) {
    $errors[] = "Địa Chỉ không được để trống";
}

if (empty($unit)) {
    $errors[] = "Đơn Vị không được để trống";
}

if (empty($id_number)) {
    $errors[] = "Mã số không được để trống";
} elseif ($registerController->kiemtra_masodocgia($id_number)) {
    $errors[] = "Mã số độc giả đã tồn tại";
}
if (!preg_match('/^(SV|GV|NV)[0-9]{5}$/', $id_number)) {
    $errors[] = "Mã số không hợp lệ";
}

if (empty($sdt)) {
    $errors[] = "Số Điện Thoại không được để trống";
} elseif (!preg_match('/^[0-9]{10}$/', $sdt)) {
    $errors[] = "Số Điện Thoại không hợp lệ";
}

if (empty($email)) {
    $errors[] = "Email không được để trống";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email không hợp lệ";
} elseif ($registerController->kiemtra_email($email)) {
    $errors[] = "Email đã tồn tại";
}

if (empty($password)) {
    $errors[] = "Mật Khẩu không được để trống";
} elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{8,}$/', $password)) {
    $errors[] = "Mật khẩu phải chứa ít nhất 1 chữ cái viết hoa, 1 chữ cái viết thường, 1 số và 1 ký tự đặc biệt";
}

if (empty($confirm_password)) {
    $errors[] = "Nhập lại Mật Khẩu không được để trống";
} elseif ($password !== $confirm_password) {
    $errors[] = "Mật khẩu không khớp";
}

$tuoi = date('Y') - date('Y', strtotime($dob));
if ($tuoi < 15) {
    $errors[] = "Tuổi phải từ 15 trở lên";
}

function check_id_in_excel($file_path, $id_number) {
    $spreadsheet = IOFactory::load($file_path);
    $worksheet = $spreadsheet->getActiveSheet();
    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        foreach ($cellIterator as $cell) {
            if ($cell->getValue() == $id_number) {
                return true;
            }
        }
    }
    return false;
}

$file_path_sv ='public/data/sample_datasv.xlsx';
$file_path_gv ='public/data/sample_datagv.xlsx';
$file_path_nv ='public/data/sample_datanv.xlsx';

if (preg_match('/^SV[0-9]{5}$/', $id_number)) {
    if (!check_id_in_excel($file_path_sv, $id_number)) {
        $errors[] = "Mã số sinh viên không tồn tại !";
    }
} elseif (preg_match('/^GV[0-9]{5}$/', $id_number)) {
    if (!check_id_in_excel($file_path_gv, $id_number)) {
        $errors[] = "Mã số giáo viên không tồn tại !";
    }
} elseif (preg_match('/^NV[0-9]{5}$/', $id_number)) {
    if (!check_id_in_excel($file_path_nv, $id_number)) {
        $errors[] = "Mã số nhân viên không tồn tại !";
    }
} else {
    $errors[] = "Mã số không hợp lệ";
}

if (!empty($errors)) {
    $_SESSION['error'] = $errors;
    header('Location: ?url=register');
    exit();
}

$password = md5($password);
$password = password_hash($password, PASSWORD_DEFAULT);
$ngaytaothe = date('Y-m-d');
$ngayhethan = date('Y-m-d', strtotime('+1 year'));

$activation_code = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);

$Id_TheTV = $theThuVienController->createTheThuVien($unit, $ngaytaothe, $ngayhethan, $activation_code);

$data = [
    'Ho' => $ho,
    'Ten' => $ten,
    'NgaySinh' => $dob,
    'GioiTinh' => $gender,
    'DiaChi' => $address,
    'DonVi' => $unit,
    'MaSo' => $id_number,
    'SDT' => $sdt,
    'Password' => $password,
    'Email' => $email,
    'Id_TheTV' => $Id_TheTV
];
$registerController->register($data);

$_SESSION['success'] = "Đăng ký thành công";
header('Location: ?url=login');
exit();
?>
