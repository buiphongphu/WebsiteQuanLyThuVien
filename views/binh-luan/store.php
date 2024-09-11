<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user'])) {
        $_SESSION['alert'] = "Bạn cần đăng nhập để bình luận.";
        header("Location: ?url=login");
        exit();
    }

    $Id_DocGia = $_SESSION['user']['Id'];
    $Id_Sach = $_GET['id'];
    $NoiDung = $_POST['noidung'];
    $NgayBinhLuan = date('Y-m-d');

    $binhLuanController=new BinhLuanController();
    $binhLuanController->storeBinhLuan($Id_DocGia, $Id_Sach, $NoiDung, $NgayBinhLuan);

    if(isset($_SESSION['alert'])){
        header("Location: ?url=chi-tiet-sach&id=$Id_Sach");
        exit();
    }

    header("Location: ?url=chi-tiet-sach&id=$Id_Sach");
    exit();
}
?>
