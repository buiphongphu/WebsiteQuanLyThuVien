<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

$registerController = new RegisterController();
$theThuVienController = new TheThuVienController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = $_FILES['file']['tmp_name'];
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        $errors = [];

        foreach ($data as $index => $row) {
            if ($index == 0) {
                continue;
            }

            $ho = trim($row[0]);
            $ten = trim($row[1]);
            $dob = trim($row[2]);
            $gender = trim($row[3]);
            $address = preg_replace('/\s+/', ' ', trim($row[4]));
            $unit = preg_replace('/\s+/', ' ', trim($row[5]));
            $id_number = preg_replace('/\s+/', ' ', trim($row[6]));
            $sdt = trim($row[7]);
            $email = trim($row[8]);
            $password = trim($row[9]);

            if (empty($dob)) {
                $errors[] = "Ngày Sinh không được để trống tại dòng $index";
            } elseif (strtotime($dob) > strtotime(date('Y-m-d'))) {
                $errors[] = "Ngày sinh không hợp lệ tại dòng $index";
            }

            if (empty($gender)) {
                $errors[] = "Giới Tính không được để trống tại dòng $index";
            }

            if (empty($address)) {
                $errors[] = "Địa Chỉ không được để trống tại dòng $index";
            }

            if (empty($unit)) {
                $errors[] = "Đơn Vị không được để trống tại dòng $index";
            }

            if (empty($id_number)) {
                $errors[] = "Mã số không được để trống tại dòng $index";
            } elseif ($registerController->kiemtra_masodocgia($id_number)) {
                $errors[] = "Mã số độc giả đã tồn tại tại dòng $index";
            }
            if (!preg_match('/^(SV|GV|NV)[0-9]{5}$/', $id_number)) {
                $errors[] = "Mã số không hợp lệ tại dòng $index";
            }

            if (empty($sdt)) {
                $errors[] = "Số Điện Thoại không được để trống tại dòng $index";
            } elseif (!preg_match('/^[0-9]{10}$/', $sdt)) {
                $errors[] = "Số Điện Thoại không hợp lệ tại dòng $index";
            }

            if (empty($email)) {
                $errors[] = "Email không được để trống tại dòng $index";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ tại dòng $index";
            } elseif ($registerController->kiemtra_email($email)) {
                $errors[] = "Email đã tồn tại tại dòng $index";
            }

            if (empty($password)) {
                $errors[] = "Mật Khẩu không được để trống tại dòng $index";
            } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{8,}$/', $password)) {
                $errors[] = "Mật khẩu tại dòng $index phải chứa ít nhất 1 chữ cái viết hoa, 1 chữ cái viết thường, 1 số và 1 ký tự đặc biệt";
            }

            $tuoi = date('Y') - date('Y', strtotime($dob));
            if ($tuoi < 15) {
                $errors[] = "Tuổi phải từ 15 trở lên tại dòng $index";
            }

            if (!empty($errors)) {
                continue;
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
        }

        if (!empty($errors)) {
            $_SESSION['error'] = $errors;
            header('Location: ?url=import');
            exit();
        }

        $_SESSION['success'] = "Nhập dữ liệu thành công";
        header('Location: ?url=admin/quanlydocgia');
        exit();
    } else {
        $_SESSION['error'] = ["Lỗi khi tải file."];
        header('Location: ?url=import');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập Dữ Liệu Độc Giả</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Nhập Dữ Liệu Độc Giả Từ File Excel</h1>
    <?php
    if (!empty($_SESSION['error'])) {
        echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">';
        echo '<strong class="font-bold">Lỗi:</strong>';
        echo '<span class="block sm:inline">' . implode('<br>', $_SESSION['error']) . '</span>';
        echo '</div>';
        unset($_SESSION['error']);
    }
    if (!empty($_SESSION['success'])) {
        echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">';
        echo '<strong class="font-bold">Thành công:</strong>';
        echo '<span class="block sm:inline">' . $_SESSION['success'] . '</span>';
        echo '</div>';
        unset($_SESSION['success']);
    }
    ?>
    <form action="import.php" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="file">Chọn file Excel:</label>
            <input type="file" name="file" id="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Nhập</button>
        </div>
    </form>
</div>
</body>
</html>
