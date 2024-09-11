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

try {
    if ($phieuMuonController->receivePhieuMuon($id)) {
        $message = "Nhận sách thành công!";
    } else {
        throw new Exception("Nhận sách thất bại!");
    }
} catch (Exception $e) {
    $message = $e->getMessage();
}

header("Location: ?url=admin/quanlyphieumuon&message=" . urlencode($message));
exit();
?>
