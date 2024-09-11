<?php

// lấy id từ url
if (!isset($_GET['id'])) {
    $_SESSION['message'] = "ID phiếu mượn không hợp lệ.";
    exit();
}

$id = $_GET['id'];

$sachHongHoacMatController = new SachHongHoacMatController();
$phieuMuonController= new PhieuMuonController();
$phieuPhat = $sachHongHoacMatController->getDanhSachXuPhatById($id);

echo "<pre>".print_r($phieuPhat, true)."</pre>";

foreach ($phieuPhat as $phieu) {
    foreach ($phieu['books'] as $book) {
        $data=[
            'Id_DauSach' => $book['Id_DauSach'],
            'SoLuong' => $book['SoLuong']
        ];
        $soluong = $phieuMuonController->updateSoLuong($data);
        $trangthai=$sachHongHoacMatController->updateStatus($phieu['phieumuon_id']);
        if($soluong){
            if($trangthai){
                $_SESSION['message'] = "Trả sách thành công!";
                header('Location: ?url=admin/quanlyxuphat');
                exit();
            }
            else{
                $_SESSION['message'] = "Trả sách thất bại!";
                header('Location: ?url=admin/quanlyxuphat');
                exit();
            }
        }
        else{
            $_SESSION['message'] = "Trả sách thất bại!";
            header('Location: ?url=admin/quanlyxuphat');
            exit();
        }

    }

}
