<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['id'])) {
        echo "ID phiếu mượn không hợp lệ.";
        exit();
    }

    $id_PhieuMuon = $_POST['id'];
    $phieuMuonController = new PhieuMuonController();
    $phieuMuon = $phieuMuonController->getPhieuMuonById($id_PhieuMuon);
    if (!$phieuMuon) {
        echo "Phiếu mượn không tồn tại.";
        exit();
    }
    $id = $phieuMuon['id_DangKy'];
    $soLuong = $_POST['soLuong'];
    $ngayTra = $_POST['ngayTra'];

    $dangKyMuonController = new DangKyMuonController();
    $dangKyMuon = $dangKyMuonController->getDangKyMuonById($id);
    $NgayMuon = $dangKyMuon['NgayMuon'];

    $error = "";

    if (strtotime($ngayTra) < strtotime($NgayMuon)) {
        $error = "Ngày trả không được nhỏ hơn ngày mượn";
    } elseif (strtotime($ngayTra) > strtotime('+14 days', strtotime($NgayMuon))) {
        $error = "Sách mượn tối đa 14 ngày";
    }

    if ($error) {
        // Chuyển hướng về trang edit và hiển thị thông báo lỗi
        header("Location: ?url=admin/quanlyphieumuon/edit&id=" . $id_PhieuMuon . "&error=" . urlencode($error));
        exit();
    }

    $data = [
        'id' => $id,
        'soLuong' => $soLuong,
        'ngayTra' => $ngayTra,
    ];

    try {
        if ($dangKyMuonController->updateDangKyMuon($data)) {
            $message = "Cập nhật phiếu mượn thành công!";
        } else {
            throw new Exception("Cập nhật phiếu mượn thất bại!");
        }
    } catch (Exception $e) {
        $message = $e->getMessage();
    }

    // Chuyển hướng về trang quản lý phiếu mượn và hiển thị thông báo
    header("Location: ?url=admin/quanlyphieumuon&message=" . urlencode($message));
    exit();

} else {
    echo "Phương thức yêu cầu không hợp lệ.";
}
?>
