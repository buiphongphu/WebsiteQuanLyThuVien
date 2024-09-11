<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}
function formatDate($date)
{
    return date('d/m/Y', strtotime($date));
}
$theThuVienController = new TheThuVienController();
$dsTheThuVien = $theThuVienController->layTheThuVienDaDuyet();

?>

<body class="bg-gray-100">

<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Quản Lý Thẻ Thư Viện</h1>
    <a href="?url=admin/quanlythethuvien/quanlythekhoa" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center mb-4">
        <i class="fas fa-id-card-alt mr-2"></i> Thẻ bị khóa
    </a>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
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
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">
                        Tùy Chọn
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <?php foreach ($dsTheThuVien as $theThuVien) : ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?= htmlspecialchars($theThuVien['Ho'].$theThuVien['Ten']) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?= htmlspecialchars($theThuVien['LoaiThe']) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?= htmlspecialchars(formatDate($theThuVien['NgayLapThe'])) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?= htmlspecialchars(formatDate($theThuVien['NgayHetHan'])) ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex justify-center space-x-2">
                            <button onclick="printCard('<?= $theThuVien['IdTV'] ?>')" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                <i class="fas fa-print mr-2"></i> In
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="?url=admin/quanlythethuvien" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center mt-4">
            <i class="fas fa-arrow-left mr-2"></i> Quay Lại
        </a>
    </div>
</div>


<script>
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
