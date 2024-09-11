<?php
if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID phiếu mượn không hợp lệ.";
    exit();
}

$id = $_GET['id'];
$phieuMuonController = new PhieuMuonController();

$phieumuon=$phieuMuonController->getPhieuMuonById($id);
foreach ($phieumuon['books'] as $books) {
    $data = [
        'Id_DauSach' => $books['Id_DauSach'],
        'SoLuong' => $books['SoLuong']
    ];

    $soluong=$phieuMuonController->updateSoLuong($data);
    if($soluong){
        try {
            if ($phieuMuonController->cancelPhieuMuon($id)) {
                $message = "Hủy phiếu mượn thành công!";
            } else {
                throw new Exception("Hủy phiếu mượn thất bại!");
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
    } else {
        $message = "Hủy phiếu mượn thất bại!";
    }

}

// Chuyển hướng về trang quản lý phiếu mượn và hiển thị thông báo
header("Location: ?url=admin/quanlyphieumuon&message=" . urlencode($message));
exit();
?>

