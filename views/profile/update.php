<?php
if (!isset($_SESSION['user'])) {
    header('Location: ?url=login');
    exit();
}

$userModel = new DocGia();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedData = [
        'Id' => $_SESSION['user']['Id'],
        'Ho' => $_POST['ho'],
        'Ten'=> $_POST['ten'],
        'NgaySinh' => $_POST['ngaySinh'],
        'GioiTinh' => $_POST['gioiTinh'],
        'DiaChi' => $_POST['diaChi'],
        'DonVi' => $_POST['donVi'],
        'Email' => $_POST['email'],
        'MaSo' => $_POST['maSo'],
        'SDT' => $_POST['sdt']
    ];

    if ($userModel->updateuser($updatedData)) {
        $_SESSION['success_message'] = "Cập nhật thông tin thành công";
        header('Location: ?url=profile');
        exit();
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra. Vui lòng thử lại.";
        header('Location: ?url=profile/update');
        exit();
    }
}
?>
