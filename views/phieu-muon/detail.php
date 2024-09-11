<?php
if (!isset($_SESSION['user'])) {
    header('Location: ?url=login');
    exit();
}

$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    echo "ID phiếu mượn không hợp lệ.";
    exit();
}

$phieuMuonController = new PhieuMuonController();
$phieuMuon = $phieuMuonController->getPhieuMuonById($id);

if (!$phieuMuon) {
    echo "Không tìm thấy phiếu mượn!";
    exit();
}

$maPhieuMuon = "PM" . str_pad($phieuMuon['phieumuon_id'], 5, '0', STR_PAD_LEFT);
$ngayMuon = $phieuMuon['NgayMuon'];
$ngayTra = $phieuMuon['NgayTra'];

// Lấy trạng thái từ bảng bảng trạng thái thông qua id_trangthai
$trangThaiController = new TrangThaiController();
$trangThai = $trangThaiController->getTrangThaiById($phieuMuon['id_trangthai']);
$trangThai = htmlspecialchars($trangThai['tentrangthai']);

// Lấy thông tin độc giả
$docGiaController = new DocGiaController();
$docGia = $docGiaController->getDocGiaById($phieuMuon['Id_DocGia']);
$hoTenDocGia = htmlspecialchars($docGia['Ho'].' '.$docGia['Ten']);

$ngayMuonFormatted = date('d/m/Y', strtotime($ngayMuon));
$ngayTraFormatted = date('d/m/Y', strtotime($ngayTra));

$today = new DateTime();
$ngayMuonObj = new DateTime($ngayMuon);
$ngayTraObj = new DateTime($ngayTra);

if ($today < $ngayMuonObj) {
    $interval = $ngayTraObj->diff($ngayMuonObj);
} else {
    $interval = $ngayTraObj->diff($today);
}

$soNgayConLai = $interval->days;
$overdueMessage = ($today > $ngayTraObj) ? "Phiếu mượn này đã quá hạn" : "{$soNgayConLai} ngày";

?>

<!DOCTYPE html>
<html lang="en">
<?php require_once dirname(__FILE__) . '/../layouts/head.php'; ?>

<body class="bg-gray-100">
<?php require_once dirname(__FILE__) . '/../layouts/header.php'; ?>

<div class="max-w-3xl mx-auto bg-white shadow-md rounded-md p-6 mt-10">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold">Chi tiết Phiếu Mượn</h1>
            <p class="text-sm text-gray-500">Mã phiếu mượn: <?= htmlspecialchars($maPhieuMuon) ?></p>
        </div>
        <div>
            <a href="?url=phieu-muon" class="flex items-center text-blue-500 hover:text-blue-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6.293 3.293a1 1 0 0 1 1.414 0L12 7.586V4a1 1 0 0 1 2 0v6a1 1 0 0 1-1 1h-6a1 1 0 0 1 0-2h3.586l-4.293-4.293a1 1 0 0 1 0-1.414z" clip-rule="evenodd" />
                </svg>
                Quay lại
            </a>
        </div>
    </div>

    <div class="bg-gray-200 rounded-md p-4 shadow-md mb-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm font-semibold">Ngày mượn:</p>
                <p><?= $ngayMuonFormatted ?></p>
            </div>
            <div>
                <p class="text-sm font-semibold">Ngày trả:</p>
                <p><?= $ngayTraFormatted ?></p>
            </div>
            <div>
                <p class="text-sm font-semibold">Trạng thái:</p>
                <p><?= htmlspecialchars($trangThai) ?></p>
            </div>
            <div>
                <p class="text-sm font-semibold">Độc giả:</p>
                <p><?= $hoTenDocGia ?></p>
            </div>
        </div>
    </div>

    <div class="bg-gray-200 rounded-md p-4 shadow-md">
        <p class="text-lg font-semibold text-blue-500">Thông tin sách</p>
        <div class="grid grid-cols-2 gap-4 mt-2">
            <?php $i=0; foreach ($phieuMuon['books'] as $book): $i++;?>
                <div class="bg-white p-4 rounded-md shadow-md">
                    <p class="text-sm font-semibold">Sách <?=$i;?>: <?= htmlspecialchars($book['TuaSach']) ?></p>
                    <p class="text-sm font-semibold">Số lượng: <?= htmlspecialchars($book['SoLuong']) ?></p>
                </div>
            <?php endforeach; ?>
            <div class="col-span-2">
                <p class="text-sm font-semibold">Tình trạng:</p>
                <p class="text-red-700">
                    <i class="fas fa-exclamation-triangle text-red-500"></i>
                    Số ngày còn lại: <?= $overdueMessage ?>
                </p>
            </div>
        </div>
    </div>

</div>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
</body>

</html>
