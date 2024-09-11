<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}

$dangKyMuonController = new DangKyMuonController();
$dsDangKyMuon = [];
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

if (isset($_SESSION['search_results'])) {
    $dsDangKyMuon = $_SESSION['search_results'];
    $keyword = $_SESSION['search_keyword'];
    unset($_SESSION['search_results']);
    unset($_SESSION['search_keyword']);
} else {
    $dsDangKyMuon = $dangKyMuonController->getDanhSachChoDuyet();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Quản Lý Duyệt Mượn Sách</title>
</head>
<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Quản Lý Duyệt Mượn Sách</h1>

    <?php if (isset($message)): ?>
        <div class="text-center text-green-500 font-semibold mb-4"><?= $message ?></div>
    <?php endif; ?>

    <form action="?url=admin/quanlydangkymuon/search" method="post" class="mb-4">
        <div class="flex justify-center space-x-2">
            <input type="text" name="keyword" class="border border-gray-300 rounded-md py-2 px-4" placeholder="Tìm kiếm theo tên sách hoặc đọc giả">
            <button type="submit" name="search" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <i class="fas fa-search"></i> Tìm Kiếm
            </button>
        </div>
    </form>

    <?php if (isset($keyword)): ?>
        <div class="text-center text-gray-700 mb-4">Kết quả tìm kiếm cho: <strong><?= htmlspecialchars($keyword) ?></strong></div>
    <?php endif; ?>

    <div class="container mx-auto py-8 px-4 sm:px-8">
        <h1 class="text-3xl font-bold text-center mb-8">Quản Lý Đăng Ký Mượn Sách</h1>

        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Đọc Giả</th>
                    <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày Đăng Ký</th>
                    <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng Thái</th>
                    <th scope="col" class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sách Mượn</th>
                    <th scope="col" class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tùy Chọn</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                <?php foreach ($dsDangKyMuon as $dangKy) :
                    $dangKyId = htmlspecialchars($dangKy['dangky_id']);
                    $docGia = htmlspecialchars($dangKy['HoTenDocGia']);
                    $ngayDangKy = date('d/m/Y', strtotime($dangKy['NgayDangKy']));
                    $trangThai = htmlspecialchars($dangKy['tentrangthai']);
                    ?>
                    <tr>
                        <td class="px-2 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?= $docGia ?></div>
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?= $ngayDangKy ?></div>
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900"><?= $trangThai ?></div>
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-2">
                                <?php foreach ($dangKy['books'] as $book) : ?>
                                    <div class="p-2 bg-gray-50 rounded shadow">
                                        <div class="font-semibold"><?= htmlspecialchars($book['TuaSach']) ?></div>
                                        <div class="text-sm text-gray-600">Số lượng: <?= htmlspecialchars($book['SoLuong']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-sm font-medium flex items-center justify-center h-full">
                            <div class="flex flex-col items-center space-y-2">
                                <a href="?url=admin/quanlydangkymuon/store&id=<?= $dangKyId ?>&status=da_duyet" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center h-full">
                                    <i class="fas fa-check mr-2"></i> Duyệt
                                </a>
                                <a href="?url=admin/quanlydangkymuon/store&id=<?= $dangKyId ?>&status=tu_choi" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center h-full">
                                    <i class="fas fa-times mr-2"></i> Từ Chối
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
    <a href="?url=admin/dashboard" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center justify-center mt-4">
        <i class="fas fa-arrow-left mr-2"></i> Quay Lại
    </a>

    <?php
require_once dirname(__FILE__) . '/../layouts/footer.php';
?>
</body>
</html>
