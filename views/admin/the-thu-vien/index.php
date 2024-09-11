<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}

$theThuVienController= new TheThuVienController();
$trangThaiController= new TrangThaiController();
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
$dsTheThuVien = isset($_SESSION['search_results']) ? $_SESSION['search_results'] : $theThuVienController->layTheThuVienDangChoPheDuyet();
unset($_SESSION['search_results']);
unset($_SESSION['search_keyword']);
?>

<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Duyệt Thẻ Thư Viện</h1>

    <?php if (!empty($_SESSION['message'])): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Thành công:</strong>
            <span class="block sm:inline"><?php echo $_SESSION['message']; ?></span>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Lỗi:</strong>
            <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <a href="?url=admin/quanlythethuvien/quanlythe" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center mb-4">
            <i class="fas fa-list mr-2"></i> Quản Lý Thẻ Thư Viện
        </a>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Họ và Tên
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Loại Thẻ
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ngày Lập Thẻ
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Ngày Hết Hạn
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Mã Kích Hoạt
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                        Tùy Chọn
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <?php
                if (!empty($dsTheThuVien)):
                    foreach ($dsTheThuVien as $theThuVien):
                        $tentrangthai = $trangThaiController->getTrangThaiById($theThuVien['id_trangthai']);
                        if ($tentrangthai['tentrangthai'] != "đang chờ") {
                            continue;
                        }
                        ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($theThuVien['Ho'].$theThuVien['Ten']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($theThuVien['LoaiThe']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($theThuVien['NgayLapThe']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($theThuVien['NgayHetHan']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?= htmlspecialchars($theThuVien['ma_kich_hoat']) ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex justify-center space-x-4">
                                <form action="?url=admin/quanlythethuvien/sendCode" method="POST" class="inline-block">
                                    <input type="hidden" name="id" value="<?= $theThuVien['Id'] ?>">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center">
                                        <i class="fas fa-paper-plane mr-2"></i> Gửi Mã Kích Hoạt
                                    </button>
                                </form>
                                <?php
                                $docgiaController = new DocGiaController();
                                $docgia = $docgiaController->getDocGiaByIdTheTV($theThuVien['Id']);
                                ?>
                                <button onclick="printCard('<?= $docgia['Id_TheTV'] ?>')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center">
                                    <i class="fas fa-print mr-2"></i> In
                                </button>
                                <button onclick="openConfirmDialog('<?= $theThuVien['Id'] ?>', 'Từ chối')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center">
                                    <i class="fas fa-times mr-2"></i> Từ Chối
                                </button>
                            </td>


                        </tr>
                    <?php endforeach;
                else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center">
                            Không có kết quả tìm kiếm phù hợp
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <a href="?url=admin/dashboard" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center mt-4">
            <i class="fas fa-arrow-left mr-2"></i> Quay Lại
        </a>
    </div>


<div id="confirmDialog" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                            Xác nhận
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500" id="confirmMessage">
                                Bạn có chắc chắn muốn duyệt thẻ này?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="confirmForm" method="POST" action="?url=admin/quanlythethuvien/store" class="inline-block">
                    <input type="hidden" name="id" id="confirmId">
                    <input type="hidden" name="trang_thai" id="confirmTrangThai">
                    <button type="submit" id="confirmButton" class="text-white font-bold py-2 px-4 rounded flex items-center">
                        <i class="fas fa-check mr-2"></i> Xác nhận
                    </button>
                </form>
                <button onclick="closeConfirmDialog()" type="button" class="mt-3 w-full sm:w-auto inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:text-sm">
                    <i class="fas fa-times mr-2"></i> Hủy bỏ
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openConfirmDialog(id, trangThai) {
        document.getElementById('confirmId').value = id;
        document.getElementById('confirmTrangThai').value = trangThai;
        document.getElementById('confirmMessage').innerText = trangThai === 'Đã duyệt' ? 'Bạn có chắc chắn muốn duyệt thẻ này?' : 'Bạn có chắc chắn muốn từ chối thẻ này?';
        const confirmButton = document.getElementById('confirmButton');
        if (trangThai === 'Đã duyệt') {
            confirmButton.classList.remove('bg-red-500', 'hover:bg-red-700');
            confirmButton.classList.add('bg-green-500', 'hover:bg-green-700');
        } else {
            confirmButton.classList.remove('bg-green-500', 'hover:bg-green-700');
            confirmButton.classList.add('bg-red-500', 'hover:bg-red-700');
        }
        document.getElementById('confirmDialog').classList.remove('hidden');
    }

    function closeConfirmDialog() {
        document.getElementById('confirmDialog').classList.add('hidden');
    }

        function printCard(id) {
        fetch(`?url=admin/quanlythethuvien/print&id=${id}`)
            .then(response => response.text())
            .then(data => {
                const printWindow = window.open('', '', 'height=600,width=800');
                printWindow.document.write('<html><head><title>In Thẻ Thư Viện</title>');
                printWindow.document.write('</head><body>');
                printWindow.document.write(data);
                printWindow.document.write('</body></html>');
                printWindow.document.close();
                printWindow.print();
            })
            .catch(error => console.error('Error:', error));
    }

</script>

</body>
<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
