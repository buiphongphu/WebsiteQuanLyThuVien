<?php

$tacGiaController = new TacGiaController();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['Ho'])) {
        $errors['Ho'] = "Vui lòng nhập họ tác giả.";
    }

    if (empty($_POST['Ten'])) {
        $errors['Ten'] = "Vui lòng nhập tên tác giả.";
    }

    if (empty($errors)) {
        $data = [
            'Id' => $_POST['Id'],
            'Ho' => trim($_POST['Ho']),
            'Ten' => trim($_POST['Ten']),
            'quoctich' => trim($_POST['QuocTich']),

        ];

        if ($tacGiaController->update($data)) {
            $_SESSION['success_message'] = "Cập nhật tác giả thành công!";
            header("Location: ?url=admin/quanlytacgia");
        } else {
            $_SESSION['error_message'] = "Cập nhật tác giả thất bại! Vui lòng thử lại.";
            header("Location: ?url=admin/quanlytacgia/edit&id=" . $_POST['Id']);
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("Location: ?url=admin/quanlytacgia/edit&id=" . $_POST['Id']);
    }
    exit();
}
?>
