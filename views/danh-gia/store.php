<?php
if (!isset($_SESSION['user'])) {
    header("Location: ?url=login");
    exit();
}

// Gửi thông báo về việc đánh giá sách
$alert='';
$_SESSION['alert'] = $alert;

$userId = $_SESSION['user']['Id'];
$sachId = $_POST['sach_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $diem = $_POST['diem'];
    $noiDung = $_POST['noi_dung'];
    $ngayDanhGia = date('Y-m-d');

    $danhGiaController = new DanhGiaController();
    $danhGiaController->store($userId, $sachId, $diem, $noiDung, $ngayDanhGia);

    if($danhGiaController) {
        $alert = 'Đánh giá thành công!';
        $_SESSION['alert-success'] = $alert;
        header("Location: ?url=chi-tiet-sach&id=$sachId");
        exit();
    }
    else{
        $alert = 'Đánh giá thất bại!';
        $_SESSION['alert-erorr'] = $alert;
        header("Location: ?url=chi-tiet-sach&id=$sachId");
        exit();
    }
}
?>
