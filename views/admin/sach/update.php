<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sachController= new SachController();
    $imageSachController= new ImageSachController();


    $data = [
        'Id' => isset($_POST['id']) ? $_POST['id'] : null,
        'TenSach' => isset($_POST['TenSach']) ? $_POST['TenSach'] : null,
        'NamXB' => $_POST['NamXB'],
        'SoLuong' => isset($_POST['SoLuong']) ? $_POST['SoLuong'] : null,
        'NgayNhap' => isset($_POST['NgayNhap']) ? $_POST['NgayNhap'] : null,
        'Id_DauSach' => isset($_POST['Id_DauSach']) ? $_POST['Id_DauSach'] : null,
        'Id_NhaXuatBan' => isset($_POST['Id_NhaXuatBan']) ? $_POST['Id_NhaXuatBan'] : null,
        'Id_TacGia' => isset($_POST['Id_TacGia']) ? $_POST['Id_TacGia'] : null
    ];

    if (empty($data['TenSach'])) {
        $_SESSION['error_message'] = "Vui lòng nhập tên sách.";
        header("Location: ?url=admin/quanlysach/edit&id=" . $data['Id']);
        exit;
    }
    if (empty($data['NamXB'])) {
        $_SESSION['error_message'] = "Vui lòng nhập năm xuất bản.";
        header("Location: ?url=admin/quanlysach/edit&id=" . $data['Id']);
        exit;
    }
    if (empty($data['SoLuong'])) {
        $_SESSION['error_message'] = "Vui lòng nhập số lượng.";
        header("Location: ?url=admin/quanlysach/edit&id=" . $data['Id']);
        exit;
    }

    if (!is_numeric($data['SoLuong'])) {
        $_SESSION['error_message'] = "Số lượng phải là số.";
        header("Location: ?url=addmin/quanlysach/edit&id=" . $data['Id']);
        exit;
    }
    if (!is_numeric($data['NamXB'])) {
        $_SESSION['error_message'] = "Năm xuất bản phải là số.";
        header("Location: ?url=admin/quanlysach/edit&id=" . $data['Id']);
        exit;
    }

    if ($data['SoLuong'] < 0 || strpos($data['SoLuong'], '.') !== false) {
        $_SESSION['error_message'] = "Số lượng phải là số nguyên không âm.";
        header("Location: ?url=admin/quanlysach/edit&id=" . $data['Id']);
        exit;
    }

    if ($data['NamXB'] < 0 || strpos($data['NamXB'], '.') !== false) {
        $_SESSION['error_message'] = "Năm xuất bản phải là số nguyên không âm.";
        header("Location: ?url=admin/quanlysach/edit&id=" . $data['Id']);
        exit;
    }

    if ($data['NamXB'] > date('Y')) {
        $_SESSION['error_message'] = "Năm xuất bản không được lớn hơn năm hiện tại.";
        header("Location: ?url=admin/quanlysach/edit&id=" . $data['Id']);
        exit;
    }

    foreach ($data as $key => $value) {
        if (empty($value)) {
            $_SESSION['error_message'] = "Vui lòng nhập đầy đủ thông tin.";
            header("Location: ?url=admin/quanlysach/edit&id=" . $data['Id']);
            exit;
        }
    }

    if ($_FILES['HinhAnh']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../../public/uploads/';
        $fileExtension = pathinfo($_FILES['HinhAnh']['name'], PATHINFO_EXTENSION);
        $uniqueFilename = uniqid() . '.' . $fileExtension;
        $targetFile = $uploadDir . $uniqueFilename;

        if ($_FILES['HinhAnh']['size'] > 100 * 1024 * 1024) {
            $_SESSION['error_message'] = "File quá lớn. Chỉ cho phép tối đa 100MB.";
            header("Location: ?url=admin/quanlysach/edit&id=" . $data['Id']);
            exit;
        }

        $allowedTypes = ['jpg', 'jpeg', 'png'];
        if (!in_array(strtolower($fileExtension), $allowedTypes)) {
            $_SESSION['error_message'] = "Chỉ cho phép các file JPG, JPEG hoặc PNG.";
            header("Location: ?url=admin/quanlysach/edit&id=" . $data['Id']);
            exit;
        }

        if (move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $targetFile)) {
            $data['TenHinh'] = $uniqueFilename;
            $data['Url'] = '/public/uploads/' . $uniqueFilename;

            if ($sachController->update($data)) {
                $imageData = [
                    'TenHinh' => $uniqueFilename,
                    'Url' => $data['Url'],
                    'Id_Sach' => $data['Id']
                ];

                $existingImage = $imageSachController->getById($data['Id']);

                if ($existingImage) {
                    $imageSachController->update($imageData);
                } else {
                    $imageSachController->insert($imageData);
                }

                $_SESSION['success_message'] = "Cập nhật sách và hình ảnh thành công!";
            } else {
                $_SESSION['error_message'] = "Cập nhật sách thất bại!";
            }
        } else {
            $_SESSION['error_message'] = "Upload hình ảnh thất bại.";
        }
    } else {
        if ($sachController->update($data)) {
            $_SESSION['success_message'] = "Cập nhật sách thành công!";
        } else {
            $_SESSION['error_message'] = "Cập nhật sách thất bại!";
        }
    }

    header("Location: ?url=admin/quanlysach");
    exit;
} else {
    header("Location: ?url=admin/quanlysach");
    exit;
}


?>
