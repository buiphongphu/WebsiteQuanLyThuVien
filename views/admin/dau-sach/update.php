<?php
$dauSachController = new DauSachController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $data = [
        'Id' => $_POST['id'],
        'TuaSach' => $_POST['TuaSach'],
        'Id_TacGia' => $_POST['Id_TacGia'],
        'Id_NhaXuatBan' => $_POST['Id_NhaXuatBan'],
        'NamXuatBan' => $_POST['NamXuatBan'],
        'SoLuong' => $_POST['SoLuong'],
        'NgayNhap' => $_POST['NgayNhap'],
        'Id_LoaiSach' => $_POST['Id_LoaiSach'],
        'selectedImageId' => $_POST['selectedImageId']
    ];

    // Validate the input data here
    // Example validation
    if (empty($data['TuaSach'])) {
        $errors[] = 'Tựa sách không được để trống.';
    }


    if (empty($errors)) {
        if ($dauSachController->update($data)) {
            $_SESSION['success_message'] = "Cập nhật đầu sách thành công!";
        } else {
            $_SESSION['error_message'] = "Cập nhật đầu sách thất bại!";
        }

        header("Location: ?url=admin/quanlydausach");
        exit();
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ?url=admin/quanlydausach/edit&id=" . $data['Id']);
        exit();
    }
} else {
    header("Location: ?url=admin/quanlydausach");
    exit();
}
?>
