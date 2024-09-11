<?php

if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}

if (!isset($_GET['id'])) {
    $_SESSION['message'] = "ID phiếu mượn không hợp lệ.";
    exit();
}

$id = $_GET['id'];

$phieuMuonController = new PhieuMuonController();
$phieuTraController= new PhieuTraController();
$diemController= new DiemController();
$docGiaController= new DocGiaController();
$phieuMuon = $phieuMuonController->getPhieuMuonById($id);
$NgayTra=date('Y-m-d');

if (!$phieuMuon) {
    $_SESSION['message'] = "Không tìm thấy phiếu mượn!";
    exit();
}
if($phieuMuon){
    $data1 = [
        'Id_PhieuMuon' => $id,
        'Id_DocGia' => $phieuMuon['Id_DocGia'],
        'NgayTra' => $NgayTra
    ];
}
$phieutra=$phieuTraController->create($data1);
if(!$phieutra){
    $_SESSION['message'] = "Trả sách thất bại!";
    exit();
}
foreach ($phieuMuon['books'] as $books) {
    $data = [
        'Id_DauSach' => $books['Id_DauSach'],
        'SoLuong' => $books['SoLuong']
    ];

    $soluong = $phieuMuonController->updateSoLuong($data);
    if ($soluong) {
        try {
                $trangthai=$phieuMuonController->updateStatus($id, 1);
                $ngayTraPM=$phieuMuon['NgayTra'];
                $docgia= $docGiaController->getDocGiaById($phieuMuon['Id_DocGia']);
                if($NgayTra>$ngayTraPM){
                    $data_diem = [
                        'Id_TheTV' => $docgia['Id_TheTV'],
                        'Diem' => -100
                    ];
                    $diemController->updateDiem($data_diem);
                }else{
                    $data_diem = [
                        'Id_TheTV' => $phieuMuon['Id_DocGia'],
                        'Diem' => 50
                    ];
                    $diemController->updateDiem($data_diem);
                }
                if($trangthai){
                    $_SESSION['message'] = "Trả sách thành công!";
                } else {
                    throw new Exception("Trả sách thất bại!");
                }

        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage();
        }
    } else {
        $_SESSION['message'] = "Trả sách thất bại!";
    }
}
header("Location: ?url=admin/quanlyphieumuon");
exit();
?>
