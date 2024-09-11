<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}

$message = $_GET['message'] ?? null;

$phieuMuonController = new PhieuMuonController();
$dsPhieuMuon = $phieuMuonController->getDanhSachPhieuMuon();
$trangThaiController= new TrangThaiController();



function formatDate($date)
{
    return date('d/m/Y', strtotime($date));
}

?>

<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Quản Lý Phiếu Mượn Sách</h1>

    <?php
    if (isset($message)) {
        echo "<div class='text-center text-green-500 font-semibold mb-4'>$message</div>";
    }
    ?>

    <?php
    $message = "";
    if (isset($_SESSION['message'])) {
        $message = "<div class='alert alert-success'>" . htmlspecialchars($_SESSION['message']) . "</div>";
        unset($_SESSION['message']);
    }
    ?>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto sm:overflow-x-visible">
            <table class="min-w-full divide-y divide-gray-200 overflow-y-auto sm:overflow-y-visible">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã Phiếu Mượn</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Độc Giả</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên Sách</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số Lượng</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày Mượn</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày Trả</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng Thái</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao Tác</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($dsPhieuMuon as $phieuMuon): ?>
                    <?php if ($phieuMuon['id_trangthai'] == 4) continue; ?>
                    <?php $trangthai = $trangThaiController->getTrangThaiById($phieuMuon['id_trangthai']); ?>
                    <?php $phieuMuon['TrangThai'] = $trangthai['tentrangthai'] ?? 'Không xác định'; ?>
                    <?php $maPM="PM" . str_pad($phieuMuon['phieumuon_id'], 5, '0', STR_PAD_LEFT); ?>

                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($maPM) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($phieuMuon['HoTenDocGia']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php foreach ($phieuMuon['books'] as $books): ?>
                                <div><?= htmlspecialchars($books['TuaSach']) ?></div>
                            <?php endforeach; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php foreach ($phieuMuon['books'] as $books): ?>
                                <div><?= htmlspecialchars($books['SoLuong']) ?> </div>
                            <?php endforeach; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars(formatDate($phieuMuon['NgayMuon'])) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars(formatDate($phieuMuon['NgayTra'])) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?= htmlspecialchars($phieuMuon['TrangThai']) ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex justify-center space-x-2">
                            <?php if ($phieuMuon['id_trangthai'] == 0): ?>
                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center"
                                        onclick="showConfirmDialog('<?= htmlspecialchars($phieuMuon['phieumuon_id']) ?>', 'delete')">
                                    <i class="fas fa-trash-alt mr-2"></i> Hủy
                                </button>
                                <a href="?url=admin/quanlyphieumuon/print&id=<?= htmlspecialchars($phieuMuon['phieumuon_id']) ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                    <i class="fas fa-print mr-2"></i> In phiếu mượn
                                </a>
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center"
                                        onclick="showConfirmDialog('<?= htmlspecialchars($phieuMuon['phieumuon_id']) ?>', 'receive')">
                                    <i class="fas fa-check mr-2"></i> Nhận sách
                                </button>
                            <?php endif; ?>
                            <?php if ($phieuMuon['id_trangthai'] == 3): ?>
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center"
                                        onclick="showConfirmDialog('<?= htmlspecialchars($phieuMuon['phieumuon_id']) ?>', 'return')">
                                    <i class="fas fa-check mr-2"></i> Trả sách
                                </button>
                                <a href="?url=admin/quanlyphieumuon/returnBrokenOrLost&id=<?= htmlspecialchars($phieuMuon['phieumuon_id']) ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> Hỏng sách & Mất sách
                                </a>

                            <?php endif; ?>
                            <?php if ($phieuMuon['id_trangthai'] == 1): ?>
                                <i class="fas fa-check mr-2"></i>
                            <?php endif; ?>
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
            case 'delete':
                actionText = 'hủy';
                break;
            case 'receive':
                actionText = 'nhận sách';
                break;
            case 'return':
                actionText = 'trả sách';
                break;
            default:
                actionText = '';
        }

        confirmMessage.innerText = `Bạn có chắc chắn muốn ${actionText} phiếu mượn này?`;

        confirmBtn.onclick = function () {
            window.location.href = `?url=admin/quanlyphieumuon/${action}&id=${id}`;
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
