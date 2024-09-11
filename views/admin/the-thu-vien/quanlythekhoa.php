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
$dsTheThuVien = $theThuVienController->layTheThuVienBiKhoa();

?>

<body class="bg-gray-100">

<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-8">Quản Lý Thẻ Thư Viện Bị Khóa</h1>
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="bg-green-500 p-4 text-white text-center mb-4">
            <?= $_SESSION['success'] ?>
        </div>
    <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="bg-red-500 p-4 text-white text-center mb-4">
            <?= $_SESSION['error'] ?>
        </div>
    <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
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
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="?url=admin/quanlythethuvien/mokhoathe&id=<?= $theThuVien['Id'] ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-unlock-alt mr-2"></i> Mở Khóa Thẻ
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <a href="?url=admin/quanlythethuvien/quanlythe" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center mt-4">
            <i class="fas fa-arrow-left mr-2"></i> Quay Lại
        </a>
    </div>
</div>

