<?php
if (!isset($_SESSION['user'])) {
    header('Location: ?url=login');
    exit();
}
$userModel = new DocGia();
$user = $_SESSION['user'];
$user = $user['Id'];
$userInfo = $userModel->getById($user);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <?php require_once dirname(__FILE__) . '/../layouts/head.php'; ?>
    <style>
        .profile-card {
            background: #ffffff;
        }
        .profile-card-header {
            background: linear-gradient(135deg, #4c51bf, #6b46c1);
        }
        .profile-field label {
            color: #4a5568;
        }
    </style>
</head>
<body class="bg-gray-100">
<?php require_once dirname(__FILE__) . '/../layouts/header.php'; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="bg-green-500 text-white text-center py-4">
        <?php echo $_SESSION['success_message']; ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="bg-red-500 text-white text-center py-4">
        <?php echo $_SESSION['error_message']; ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<section class="profile-detail py-8">
    <div class="container mx-auto">
        <div class="profile-card rounded-lg shadow-lg p-8 max-w-4xl mx-auto">
            <div class="profile-card-header rounded-t-lg p-6 text-white text-center">
                <h1 class="text-4xl font-bold mb-2">Thông tin độc giả</h1>
                <p class="text-lg">Dưới đây là thông tin chi tiết của bạn.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-lg p-6">
                <div class="col-span-1 space-y-4">
                    <div class="profile-field">
                        <label class="block font-semibold">Họ tên:</label>
                        <span class="block text-gray-700"><?= htmlspecialchars($userInfo['Ho'] . ' ' . $userInfo['Ten']) ?></span>
                    </div>
                    <div class="profile-field">
                        <label class="block font-semibold">Ngày sinh:</label>
                        <span class="block text-gray-700"><?= htmlspecialchars($userInfo['NgaySinh']) ?></span>
                    </div>
                    <div class="profile-field">
                        <label class="block font-semibold">Giới tính:</label>
                        <span class="block text-gray-700"><?= htmlspecialchars($userInfo['GioiTinh']) ?></span>
                    </div>
                </div>
                <div class="col-span-1 space-y-4">
                    <div class="profile-field">
                        <label class="block font-semibold">Địa chỉ:</label>
                        <span class="block text-gray-700"><?= htmlspecialchars($userInfo['DiaChi']) ?></span>
                    </div>
                    <div class="profile-field">
                        <label class="block font-semibold">Đơn vị:</label>
                        <span class="block text-gray-700"><?= htmlspecialchars($userInfo['DonVi']) ?></span>
                    </div>
                    <div class="profile-field">
                        <label class="block font-semibold">Mã số:</label>
                        <span class="block text-gray-700"><?= htmlspecialchars($userInfo['MaSo']) ?></span>
                    </div>
                </div>
                <div class="col-span-1 space-y-4">
                    <div class="profile-field">
                        <label class="block font-semibold">Số điện thoại:</label>
                        <span class="block text-gray-700"><?= htmlspecialchars($userInfo['SDT']) ?></span>
                    </div>
                </div>
                <div class="col-span-1 space-y-4">
                    <div class="profile-field">
                        <label class="block font-semibold">Email:</label>
                        <span class="block text-gray-700"><?= htmlspecialchars($userInfo['Email']) ?></span>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-6 space-x-4">
                <a href="?url=profile/edit" class="inline-block px-6 py-2 bg-indigo-500 text-white rounded shadow hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50">
                    <i class="fas fa-edit"></i> Cập Nhật Tài Khoản
                </a>
                <a href="?url=profile/change-password" class="inline-block px-6 py-2 bg-red-500 text-white rounded shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                    <i class="fas fa-key"></i> Cập Nhật Mật Khẩu
                </a>
                <a href="?url=index" class="inline-block px-6 py-2 bg-gray-500 text-white rounded shadow hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>

</body>
</html>
