<?php

$tacGiaController = new TacGiaController();
$errors = [];

if (empty($_POST['Ho'])) {
    $errors['Ho'] = "Vui lòng nhập họ tác giả.";
}

if (empty($_POST['Ten'])) {
    $errors['Ten'] = "Vui lòng nhập tên tác giả.";
}

if (empty($errors)) {
    $data = [
        'Ho' => trim($_POST['Ho']),
        'Ten' => trim($_POST['Ten']),
        'QuocTich' => trim($_POST['QuocTich']),
    ];

    if ($tacGiaController->create($data)) {
        $_SESSION['success_message'] = "Thêm tác giả thành công!";
    } else {
        $_SESSION['error_message'] = "Thêm tác giả thất bại! Vui lòng thử lại.";
    }

    header("Location: ?url=admin/quanlytacgia");
} else {
    $_SESSION['errors'] = $errors;
    header("Location: ?url=admin/quanlytacgia/add");
}
?>
