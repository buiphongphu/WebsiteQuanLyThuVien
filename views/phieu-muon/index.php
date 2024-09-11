<?php

if (!isset($_SESSION['user'])) {
    header('Location: ?url=login');
    exit();
}

$phieuMuonController = new PhieuMuonController();
$phieuMuonList = $phieuMuonController->getPhieuMuonByUserId($_SESSION['user']['Id']);

$sachController = new SachController();
$trangThaiController = new TrangThaiController();

?>
<!DOCTYPE html>
<html lang="en">

<?php require_once dirname(__FILE__) . '/../layouts/head.php'; ?>

<body class="bg-gray-100 min-h-screen">
<?php require_once dirname(__FILE__) . '/../layouts/header.php'; ?>

<div class="container mx-auto px-4 py-10">
    <div class="bg-white shadow-md rounded-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-center">Danh sách Phiếu Mượn</h1>
            <div class="mt-6 flex justify-center">
                <a href="?url=phieu-muon/history" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                    <i class="fas fa-history mr-2"></i>
                    Lịch sử mượn sách
                </a>
            </div>

        </div>

        <?php if (isset($_SESSION['alert'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <?= htmlspecialchars($_SESSION['alert']) ?>
            </div>
            <?php unset($_SESSION['alert']); ?>
        <?php endif; ?>

        <div class="space-y-6">
            <?php foreach ($phieuMuonList as $phieuMuon): ?>
                <?php
                $maPhieuMuon = "PM" . str_pad($phieuMuon['phieumuon_id'], 5, '0', STR_PAD_LEFT);
                $ngayMuon = $phieuMuon['NgayMuon'];
                $ngayTra = $phieuMuon['NgayTra'];

                $trangThai = $trangThaiController->getTrangThaiById($phieuMuon['id_trangthai']);
                if (is_array($trangThai)) {
                    $trangThai = htmlspecialchars($trangThai['tentrangthai']);
                } else {
                    $trangThai = 'Không xác định';
                }

                if ($trangThai == 'đã trả' || $trangThai == 'đã hủy') {
                    continue;
                }

                $today = new DateTime();
                $ngayMuonDate = new DateTime($ngayMuon);
                $ngayTraDate = new DateTime($ngayTra);

                if ($today < $ngayMuonDate) {
                    $remainingDays = $ngayTraDate->diff($ngayMuonDate)->days;
                } elseif ($today > $ngayMuonDate) {
                    $remainingDays = $ngayTraDate->diff($today)->days;
                } else {
                    $remainingDays = $ngayTraDate->diff($today)->days;
                }

                $isDueSoon = $remainingDays <= 3;

                $ngayMuon = date('d/m/Y', strtotime($ngayMuon));
                $ngayTra = date('d/m/Y', strtotime($ngayTra));
                ?>
                <div class="bg-gray-200 rounded-md p-4 shadow-md">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-lg font-semibold text-blue-500">Mã phiếu mượn:
                            <?= htmlspecialchars($maPhieuMuon) ?></p>
                        <a href="?url=phieu-muon/detail&id=<?= $phieuMuon['phieumuon_id'] ?>"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-info-circle"></i> Xem chi tiết</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php if (isset($phieuMuon['books']) && is_array($phieuMuon['books'])): ?>
                            <?php $i=0; foreach ($phieuMuon['books'] as $book): $i++; ?>
                                <div class="bg-white p-4 rounded shadow">
                                    <p><strong>Sách <?=$i?>:</strong> <?= htmlspecialchars($book['TuaSach'])?></p>
                                    <p><strong>Số lượng mượn:</strong> <?= htmlspecialchars($book['SoLuong']) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <div class="mt-4">
                        <p><strong>Ngày mượn:</strong> <?= htmlspecialchars($ngayMuon) ?></p>
                        <p><strong>Ngày trả:</strong> <?= htmlspecialchars($ngayTra) ?></p>
                        <p>Bạn <?= htmlspecialchars($trangThai) ?> sách của thư viện của chúng tôi.</p>
                        <p class="text-red-500 font-semibold">
                            <i class="fas fa-exclamation-triangle text-red-700"></i> Lưu ý:
                            <?php if ($today > $ngayTraDate): ?>
                                <span class="text-red-700">Quá hạn trả sách. Yêu cầu bạn đến thư viện trả sách
                                ngay!</span>
                            <?php else: ?>
                                <?php if ($remainingDays > 1): ?>
                                    Còn <?= $remainingDays ?> ngày để trả sách. Hãy thư giãn và đọc sách thật vui vẻ.
                                <?php elseif ($remainingDays == 0): ?>
                                    Hôm nay là hạn trả sách. Bạn hãy đến thư viện trả sách ngay!
                                <?php elseif ($remainingDays == 1): ?>
                                    Bạn còn 1 ngày để trả sách. Nếu bạn chưa gia hạn thì hãy gia hạn ngay!
                                <?php endif; ?>
                            <?php endif; ?>
                        </p>
                    </div>
                    <?php if ($isDueSoon): ?>
                        <div class="mt-4">
                            <button onclick="document.getElementById('extend-form-<?= $phieuMuon['phieumuon_id'] ?>').style.display='block'"
                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-clock"></i> Gia hạn</button>
                        </div>
                        <div id="extend-form-<?= $phieuMuon['phieumuon_id'] ?>" style="display:none;"
                             class="mt-4 md:flex md:items-center">
                            <form action="?url=phieu-muon/giahan" method="post"
                                  class="md:flex md:space-x-4">
                                <input type="hidden" name="extend_id" value="<?= $phieuMuon['phieumuon_id'] ?>">
                                <label for="new_return_date" class="block">Ngày trả mới:</label>
                                <input type="date" name="new_return_date" required
                                       class="border rounded p-2 md:w-auto">
                                <button type="submit"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-check"></i> Cập nhật</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-6">
            <a href="?url=index"
               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-arrow-left"></i> Quay lại</a>
        </div>
    </div>
</div>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
</body>

</html>
