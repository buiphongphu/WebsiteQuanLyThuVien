<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sachController = new SachController();
    $imageSachController = new ImageSachController();

    if (!isset($_FILES['HinhAnh']) || $_FILES['HinhAnh']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['error_message'] = 'Lỗi: Không có hình ảnh được tải lên.';
        header("Location: ?url=admin/quanlysach/add");
        exit;
    }

    $tenSach = trim($_POST['TenSach']);
    $namXB = trim($_POST['NamXB']);
    $soLuong = trim($_POST['SoLuong']);
    $ngayNhap = trim($_POST['NgayNhap']);
    $idDauSach = trim($_POST['Id_DauSach']);
    $idNhaXuatBan = trim($_POST['Id_NhaXuatBan']);
    $idTacGia = trim($_POST['Id_TacGia']);

    if (empty($tenSach) || empty($namXB) || empty($soLuong) || empty($ngayNhap) || empty($idDauSach) || empty($idNhaXuatBan) || empty($idTacGia)) {
        $_SESSION['error_message'] = 'Lỗi: Vui lòng điền đầy đủ thông tin.';
        header("Location: ?url=admin/quanlysach/add");
        exit;
    }

    if (!is_numeric($soLuong)) {
        $_SESSION['error_message'] = 'Lỗi: Số lượng phải là số.';
        header("Location: ?url=admin/quanlysach/add");
        exit;
    }
    if ($soLuong < 0 || strpos($soLuong, '.') !== false) {
        $_SESSION['error_message'] = 'Lỗi: Số lượng phải là số nguyên không âm.';
        header("Location: ?url=admin/quanlysach/add");
        exit;
    }
    if (!is_numeric($namXB)) {
        $_SESSION['error_message'] = 'Lỗi: Năm xuất bản phải là số.';
        header("Location: ?url=admin/quanlysach/add");
        exit;
    }
    if ($namXB < 0 || strpos($namXB, '.') !== false) {
        $_SESSION['error_message'] = 'Lỗi: Năm xuất bản phải là số nguyên không âm.';
        header("Location: ?url=admin/quanlysach/add");
        exit;
    }

    if (!preg_match('/^[a-zA-Z0-9\sÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]+$/', $_POST['TenSach'])) {
        $errors['TenSach'] = "Lỗi: Tên sách không chứa ký tự đặc biệt.";
    }

    if ($namXB > date('Y')) {
        $_SESSION['error_message'] = 'Lỗi: Năm xuất bản không được lớn hơn năm hiện tại.';
        header("Location: ?url=admin/quanlysach/add");
        exit;
    }

    $sach = $sachController->findByTenSach(['TenSach' => $tenSach]);
    if ($sach) {
        $_SESSION['error_message'] = 'Lỗi: Tên sách đã tồn tại.';
        header("Location: ?url=admin/quanlysach/add");
        exit;
    }


    $hinhAnh = $_FILES['HinhAnh'];
    $targetDir = __DIR__ . '/../../../public/uploads/';

    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0777, true)) {
            $_SESSION['error_message'] = "Lỗi: Không thể tạo thư mục lưu trữ hình ảnh.";
            header("Location: ?url=admin/quanlysach/add");
            exit;
        }
    }

    if ($hinhAnh["size"] > 100 * 1024 * 1024) {
        $_SESSION['error_message'] = "Lỗi: Kích thước file quá lớn.";
        header("Location: ?url=admin/quanlysach/add");
        exit;
    }

    $imageFileType = strtolower(pathinfo($hinhAnh['name'], PATHINFO_EXTENSION));
    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
        $_SESSION['error_message'] = "Lỗi: Chỉ cho phép các định dạng JPG, JPEG hoặc PNG.";
        header("Location: ?url=admin/quanlysach/add");
        exit;
    }

    $targetFile = $targetDir . uniqid() . '.' . $imageFileType;
    if (!move_uploaded_file($hinhAnh['tmp_name'], $targetFile)) {
        $_SESSION['error_message'] = "Lỗi: Không thể lưu trữ hình ảnh.";
        header("Location: ?url=admin/quanlysach/add");
        exit;
    }

    $dataSach = [
        'TenSach' => $tenSach,
        'NamXB' => $namXB,
        'SoLuong' => $soLuong,
        'NgayNhap' => $ngayNhap,
        'Id_DauSach' => $idDauSach,
        'Id_NhaXuatBan' => $idNhaXuatBan,
        'Id_TacGia' => $idTacGia
    ];
    $sachId = $sachController->create($dataSach);

    $dataImageSach = [
        'TenHinh' => $hinhAnh['name'],
        'Url' => '/public/uploads/' . basename($targetFile),
        'Id_Sach' => $sachId
    ];
    $imageSachController->create($dataImageSach);

    $_SESSION['success_message'] = "Thêm sách thành công!";

    header("Location: ?url=admin/quanlysach");
    exit;
}
?>
