<?php
ob_start();
$dauSachController = new DauSachController();
$sachController= new SachController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $data = [
        'TuaSach' => $_POST['TenDauSach'] ?? null,
        'Id_LoaiSach' => $_POST['Id_LoaiSach'] ?? null,
        'Id_NXB' => $_POST['Id_NhaXuatBan'] ?? null,
        'NamXuatBan' => $_POST['NamSanXuat'] ?? null,
        'SoLuong' => $_POST['SoLuong'] ?? null,
        'Id_TacGia' => $_POST['Id_TacGia'] ?? null,
        'NgayNhap' => date('Y-m-d'),
    ];

    if (empty($data['TuaSach'])) {
        $errors[] = 'Vui lòng nhập tựa sách.';
    }
    if (empty($data['SoLuong'])) {
        $errors[] = 'Vui lòng nhập số lượng.';
    } else if (!is_numeric($data['SoLuong'])) {
        $errors[] = 'Số lượng phải là số.';
    } else if ($data['SoLuong'] <= 0 || $data['SoLuong'] >= 1000) {
        $errors[] = 'Số lượng phải lớn hơn 0 và nhỏ hơn 1000.';
    } else if (preg_match('/[a-zA-Z]/', $data['SoLuong'])) {
        $errors[] = 'Số lượng không được chứa chữ cái.';
    } else if (preg_match('/\s/', $data['SoLuong'])) {
        $errors[] = 'Số lượng không được chứa khoảng trắng.';
    } else if (preg_match('/\./', $data['SoLuong'])) {
        $errors[] = 'Số lượng không được chứa dấu chấm.';
    } else if (preg_match('/,/', $data['SoLuong'])) {
        $errors[] = 'Số lượng không được chứa dấu phẩy.';
    }

    $uploadedFiles = $_FILES['images'];
    $uploadDir = 'public/uploads/';
    $imageNames = [];

    for ($i = 0; $i < count($uploadedFiles['name']); $i++) {
        if ($uploadedFiles['error'][$i] == UPLOAD_ERR_OK) {
            $tmpName = $uploadedFiles['tmp_name'][$i];
            $fileName = basename($uploadedFiles['name'][$i]);
            $filePath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $filePath)) {
                $imageNames[] = $fileName;
            } else {
                $errors[] = "Không thể tải lên tệp $fileName.";
            }
        } else {
            $errors[] = "Lỗi khi tải lên tệp $fileName.";
        }
    }

    if (empty($errors)) {
        $inserted = $dauSachController->create($data);
        $dt=['id_dausach' => $inserted,
            'TrangThai' => 10
        ];
        $sachController->create($dt);

        if ($inserted) {
            $dauSachId = $inserted;

            foreach ($imageNames as $imageName) {
                $dauSachController->addImages([
                    'TenHinh' => $imageName,
                    'Url' => $uploadDir . $imageName,
                    'id_dausach' => $dauSachId
                ]);
            }

            $_SESSION['success_message'] = 'Thêm đầu sách thành công!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi thêm đầu sách!';
        }

        header('Location: ?url=admin/quanlydausach');
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        header('Location: ?url=admin/quanlydausach/add');
        exit();
    }

}
ob_end_flush();
?>
