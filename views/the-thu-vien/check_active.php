<?php
$theThuVienController = new TheThuVienController();
$activation_code = $_POST['activation_code'];
$check_activation_code = $theThuVienController->kiemtra_makichhoat($activation_code);
if ($check_activation_code) {
    $theThuVienController->updateTrangThaiThe($check_activation_code['Id'], 7);
    $_SESSION['success'] = 'Kích hoạt thẻ thành công.';
    header('Location: ?url=the-thu-vien');
} else {
    $_SESSION['error'] = 'Mã kích hoạt không hợp lệ.';
    header('Location: ?url=the-thu-vien/active');
}
?>

