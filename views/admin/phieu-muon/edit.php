<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}

$phieuMuonController = new PhieuMuonController();

if (!isset($_GET['id'])) {
    echo "ID phiếu mượn không hợp lệ.";
    exit();
}

$id = $_GET['id'];
$phieuMuon = $phieuMuonController->getPhieuMuonById($id);

if (!$phieuMuon) {
    echo "Phiếu mượn không tồn tại.";
    exit();
}
?>

<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Sửa Phiếu Mượn Sách</h1>

    <?php
    if (isset($_GET['error'])) {
        echo "
    <div class='flex items-center bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>
        <svg class='fill-current w-6 h-6 mr-2' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'><path d='M10 15a1.5 1.5 0 110-3 1.5 1.5 0 010 3zm.02-5c-.64 0-1.13-.48-1.16-1.08l-.21-5.25c-.02-.35.07-.7.26-.98C8.94 2.2 9.46 2 10 2s1.06.2 1.39.59c.18.28.28.63.26.98l-.21 5.25c-.03.6-.52 1.08-1.16 1.08h-.02z'/></svg>
        <span class='block sm:inline'>" . htmlspecialchars($_GET['error']) . "</span>
    </div>";
    }
    ?>



    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 max-w-lg mx-auto">
        <form action="?url=admin/quanlyphieumuon/update" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($phieuMuon['Id']) ?>">

            <div class="mb-4">
                <label for="soLuong" class="block text-sm font-medium text-gray-700">Số Lượng</label>
                <input type="number" id="soLuong" name="soLuong" value="<?= htmlspecialchars($phieuMuon['SoLuong']) ?>" class="p-2 block w-full border border-gray-300 rounded-md">
            </div>

            <div class="mb-4">
                <label for="ngayTra" class="block text-sm font-medium text-gray-700">Ngày Trả</label>
                <input type="date" id="ngayTra" name="ngayTra" value="<?= htmlspecialchars($phieuMuon['NgayTra']) ?>" class="p-2 block w-full border border-gray-300 rounded-md">
            </div>

            <div class="flex justify-end">
                <a href="?url=admin/quanlyphieumuon" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Quay Lại
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center ml-4">
                    <i class="fas fa-save mr-2"></i> Cập Nhật
                </button>
            </div>
        </form>
    </div>
</div>
</body>

<?php
require_once dirname(__FILE__) . '/../layouts/footer.php';
?>
