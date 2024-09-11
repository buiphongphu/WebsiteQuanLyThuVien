<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

$adminModel = new QuanTriVien();
$admin = $_SESSION['admin'];
$admin = $admin['Id'];
$adminInfo = $adminModel->getById($admin);
?>

<div class="flex items-center justify-center min-h-screen py-6 px-4">
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Cập Nhật Thông Tin Quản Trị Viên</h2>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4" role="alert">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?url=admin/quantrivien/update">
            <div class="space-y-4">
                <div>
                    <label for="ho" class="block text-gray-700 font-medium">Họ</label>
                    <input type="text" id="ho" name="ho" value="<?php echo htmlspecialchars($adminInfo['Ho']); ?>" class="mt-1 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="name" class="block text-gray-700 font-medium">Tên</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($adminInfo['Ten']); ?>" class="mt-1 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="email" class="block text-gray-700 font-medium">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($adminInfo['Email']); ?>" class="mt-1 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="address" class="block text-gray-700 font-medium">Địa Chỉ</label>
                    <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($adminInfo['DiaChi']); ?>" class="mt-1 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="phone" class="block text-gray-700 font-medium">Số Điện Thoại</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($adminInfo['SDT']); ?>" class="mt-1 p-3 border border-gray-300 rounded-md w-full focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mt-6 flex justify-between items-center">
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <i class="fas fa-edit"></i> Cập Nhật
                    </button>
                    <a href="?url=admin/quantrivien" class="bg-gray-500 text-white py-2 px-4 rounded-md shadow hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        <i class="fas fa-arrow-left"></i> Quay Lại
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
