<?php
$adminModel = new QuanTriVien();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updatedData = [
        'Id' => $_SESSION['admin']['Id'],
        'Ho' => $_POST['ho'],
        'Ten' => $_POST['name'],
        'Email' => $_POST['email'],
        'DiaChi' => $_POST['address'],
        'SDT' => $_POST['phone']
    ];

    if ($adminModel->update($updatedData)) {
        $_SESSION['success_message'] = "Cập nhật thông tin thành công";
        header('Location: ?url=admin/quantrivien');
        exit();
    } else {
        $_SESSION['error_message'] = "Có lỗi xảy ra. Vui lòng thử lại.";
        header('Location: ?url=admin/quantrivien/edit');
        exit();
    }
} else {

    header('Location: ?url=admin/quantrivien');
    exit();
}
?>
