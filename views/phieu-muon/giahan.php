<?php

if (!isset($_SESSION['user'])) {
    header('Location: ?url=login');
    exit();
}

$alert = '';
$_SESSION['alert'] = $alert;

$giaHanController = new GiaHanController();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['extend_id']) && isset($_POST['new_return_date']) && !empty($_POST['new_return_date'])) {
    $data = [
        'id_PhieuMuon' => $_POST['extend_id'],
        'id_DocGia' => $_SESSION['user']['Id'],
        'NgayTraMoi' => $_POST['new_return_date']
    ];

    try {
        if (!$giaHanController->checkGiaHan($data)) {
            $giahan = $giaHanController->giaHanPhieuMuon($data);
            $alert = 'Gia hạn thành công';
        } else {
            $alert = 'Bạn đã gia hạn rồi! Bạn hãy trả sách đúng hạn !';
        }
    } catch (Exception $e) {
        $alert = 'Lỗi: ' . $e->getMessage();
    }
} else {
    $alert = 'Yêu cầu không hợp lệ';
}

$_SESSION['alert'] = $alert;
header('Location: ?url=phieu-muon');
exit();
?>
