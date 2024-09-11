<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}

$message = $_GET['message'] ?? null;

$sachHongHoacMatController = new SachHongHoacMatController();
$dsXuPhat = $sachHongHoacMatController->getDanhSachXuPhat();
$trangThaiController = new TrangThaiController();
$phieuMuonController = new PhieuMuonController();
$docGiaController = new DocGiaController();
$sachController = new SachController();

function formatDate($date)
{
    return date('d/m/Y', strtotime($date));
}

?>

<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Quản Lý Xử Phạt</h1>

    <?php
    if (isset($message)) {
        echo "<div class='text-center text-green-500 font-semibold mb-4'>$message</div>";
    }
    ?>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto sm:overflow-x-visible">
            <table class="min-w-full divide-y divide-gray-200 overflow-y-auto sm:overflow-y-visible">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Phiếu</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Độc Giả</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số Điện Thoại</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao Tác</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <?php foreach ($dsXuPhat as $index => $phieuMuon): ?>
                    <?php $docGia = $docGiaController->getDocGiaById($phieuMuon['Id_DocGia']); ?>
                    <tr class="<?= $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' ?>">
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($phieuMuon['phieumuon_id']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($docGia['Ho'] . ' ' . $docGia['Ten']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($phieuMuon['sdt']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                            <?php foreach ($phieuMuon['books'] as $book): ?>
                            <?php if ($book['id_trangthai'] != 1): ?>
                            <button onclick="showConfirmDialog(<?= $phieuMuon['phieumuon_id'] ?>, 'return')"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                <i class="fas fa-check mr-2"></i> Đã hoàn trả
                            </button>
                            <button onclick="showConfirmDialog(<?= $phieuMuon['phieumuon_id'] ?>, 'print')"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                <i class="fas fa-print mr-2"></i> In phiếu phạt
                            </button>
                            <?php else: ?>
                                <span class="bg-gray-300 text-gray-800 font-semibold px-2 rounded-full">
                                    <i class="fas fa-check mr-2"></i>
                                     Đã xử phạt</span>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </td>
                    </tr>

                    <tr class="<?= $index % 2 == 0 ? 'bg-gray-200' : 'bg-gray-100' ?>">
                        <td colspan="5" class="px-6 py-4">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Sách</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Sách</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số Lượng</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng Thái</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($phieuMuon['books'] as $book): ?>
                                    <?php $trangthai = $trangThaiController->getTrangThaiById($book['id_trangthai']) ?>
                                    <?php $book['TrangThai'] = $trangthai['tentrangthai'] ?? 'Không xác định'; ?>
                                    <tr class="<?= $index % 2 == 0 ? 'bg-gray-200' : 'bg-gray-100' ?>">
                                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($book['Id_Sach']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($book['TuaSach']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($book['SoLuong']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php if ($book['TrangThai'] == 'hỏng'): ?>
                                                <span class="bg-yellow-300 text-yellow-800 font-semibold px-2 rounded-full">
                                                    <i class="fas fa-exclamation-triangle mr-2"></i>
                                                     Hỏng</span>
                                            <?php elseif ($book['TrangThai'] == 'mất'): ?>
                                                <span class="bg-red-300 text-red-800 font-semibold px-2 rounded-full">
                                                    <i class="fas fa-times mr-2"></i>
                                                     Mất</span>
                                            <?php elseif ($book['TrangThai'] == 'đã trả'): ?>
                                                <span class="bg-green-300 text-green-800 font-semibold px-2 rounded-full">
                                                   <i class="fas fa-check mr-2"></i>
                                                    Đã trả</span>
                                            <?php else: ?>
                                                <span class="bg-gray-300 text-gray-800 font-semibold px-2 rounded-full">
                                                   <i class="fas fa-question mr-2"></i>
                                                    Không xác định</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="?url=admin/dashboard" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center mt-4">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
    </div>
</div>

<!-- Custom Confirmation Dialog -->
<div id="confirmDialog" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded shadow-md text-center w-1/3">
        <h2 class="text-lg font-semibold mb-4">Xác nhận hành động</h2>
        <p id="confirmMessage" class="mb-4">Bạn có chắc chắn muốn thực hiện hành động này?</p>
        <div class="flex justify-center space-x-4">
            <button id="confirmBtn" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <i class="fas fa-check mr-2"></i> Xác nhận
            </button>
            <button onclick="hideConfirmDialog()" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <i class="fas fa-times mr-2"></i> Hủy
            </button>
        </div>
    </div>
</div>

<script>
    function showConfirmDialog(id, action) {
        const dialog = document.getElementById('confirmDialog');
        const confirmBtn = document.getElementById('confirmBtn');
        const confirmMessage = document.getElementById('confirmMessage');

        let actionText;
        switch (action) {
            case 'return':
                actionText = 'trả sách';
                break;
            case 'print':
                actionText = 'in phiếu phạt';
                break;
            default:
                actionText = '';
        }

        confirmMessage.innerText = `Bạn có chắc chắn muốn ${actionText} phiếu phạt này?`;

        confirmBtn.onclick = function () {
            window.location.href = `?url=admin/quanlyxuphat/${action}&id=${id}`;
        };

        dialog.classList.remove('hidden');
    }

    function hideConfirmDialog() {
        const dialog = document.getElementById('confirmDialog');
        dialog.classList.add('hidden');
    }
</script>

</body>

<?php
require_once dirname(__FILE__) . '/../layouts/footer.php';
?>
