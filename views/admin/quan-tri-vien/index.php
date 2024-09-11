<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

$adminModel = new QuanTriVien();
$admin = $_SESSION['admin'];
$admin = $admin['Id'];
$adminInfo = $adminModel->getById($admin);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once dirname(__FILE__) . '/../layouts/head.php'; ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-200">
<?php require_once dirname(__FILE__) . '/../layouts/header.php'; ?>
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4" role="alert">
        <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4" role="alert">
        <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
    </div>
<?php endif; ?>
<section class="flex items-center justify-center min-h-screen py-8">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
        <h1 class="text-3xl font-semibold text-center text-gray-800 mb-6">Thông Tin Quản Trị Viên</h1>
        <div class="space-y-4">
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Tên:</span>
                <span class="text-gray-600"><?= htmlspecialchars($adminInfo['Ho'] . ' ' . $adminInfo['Ten']) ?></span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Email:</span>
                <span class="text-gray-600"><?= htmlspecialchars($adminInfo['Email']) ?></span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Địa Chỉ:</span>
                <span class="text-gray-600"><?= htmlspecialchars($adminInfo['DiaChi']) ?></span>
            </div>
            <div class="flex justify-between">
                <span class="font-medium text-gray-700">Số Điện Thoại:</span>
                <span class="text-gray-600"><?= htmlspecialchars($adminInfo['SDT']) ?></span>
            </div>
        </div>
        <div class="mt-8 flex justify-around space-x-4">
            <a href="?url=admin/quantrivien/edit" class="w-full text-center py-2 px-4 bg-blue-500 text-white rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                <i class="fas fa-edit"></i> Cập Nhật Tài Khoản
            </a>
            <a href="?url=admin/quantrivien/change-password" class="w-full text-center py-2 px-4 bg-green-500 text-white rounded-lg shadow hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                <i class="fas fa-key"></i> Cập Nhật Mật Khẩu
            </a>
        </div>
        <div class="mt-4 text-center">
            <a href="?url=admin/dashboard" class="inline-block py-2 px-4 bg-gray-600 text-white rounded-lg shadow hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                <i class="fas fa-arrow-left"></i> Quay Lại
            </a>
        </div>
    </div>
</section>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
</body>
</html>

