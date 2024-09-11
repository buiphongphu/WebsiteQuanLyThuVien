<?php
$currentPasswordCorrect = true;
$errors = [];
$id= $_SESSION['user']['Id'];
$docGiaController = new DocGiaController();
$email = $docGiaController->getEmail($id);
if ($currentPasswordCorrect && isset($_POST['new_password'], $_POST['confirm_password'])) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (empty($newPassword)) {
        $errors[] = "Mật khẩu không được để trống";
    } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()])[A-Za-z\d!@#$%^&*()]{8,}$/', $newPassword)) {
        $errors[] = "Mật khẩu phải chứa ít nhất 1 chữ cái viết hoa, 1 chữ cái viết thường, 1 số và 1 ký tự đặc biệt";
    }

    if (empty($confirmPassword)) {
        $errors[] = "Nhập lại Mật Khẩu không được để trống";
    }

    var_dump($newPassword);
    var_dump($confirmPassword);

    if (empty($errors) && $newPassword === $confirmPassword) {
        $docGiaController->updatePassword($email, password_hash(md5($newPassword), PASSWORD_DEFAULT));

        $_SESSION['success'] = 'Mật khẩu đã được cập nhật thành công.';
        header("Location: ?url=profile");
        exit();
    } elseif ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = 'Mật khẩu không khớp. Vui lòng thử lại.';
    } else {
        $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
    }
}