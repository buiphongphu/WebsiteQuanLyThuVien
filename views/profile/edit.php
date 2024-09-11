<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: ?url=login');
    exit();
}

$user = $_SESSION['user'];
$userModel = new DocGia();
$user = $userModel->getById($user['Id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once dirname(__FILE__) . '/../layouts/head.php'; ?>
</head>
<body class="bg-gray-100">
<?php require_once dirname(__FILE__) . '/../layouts/header.php'; ?>

<section class="profile-detail py-8">
    <div class="container mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8 max-w-4xl mx-auto text-gray-800">
            <h1 class="text-4xl font-bold mb-6 text-center text-blue-500">Thông tin độc giả</h1>
            <form action="?url=profile/update" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-8 text-lg">
                <div>
                    <label for="ho" class="block font-semibold mb-2">Họ:</label>
                    <input type="text" id="ho" name="ho" value="<?= htmlspecialchars($user['Ho']) ?>" class="form-input w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 ease-in-out">
                </div>
                <div>
                    <label for="ten" class="block font-semibold mb-2">Tên:</label>
                    <input type="text" id="ten" name="ten" value="<?= htmlspecialchars($user['Ten']) ?>" class="form-input w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 ease-in-out">
                </div>
                <div>
                    <label for="ngaySinh" class="block font-semibold mb-2">Ngày sinh:</label>
                    <input type="date" id="ngaySinh" name="ngaySinh" value="<?= htmlspecialchars($user['NgaySinh']) ?>" class="form-input w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 ease-in-out">
                </div>
                <div>
                    <label for="gioiTinh" class="block font-semibold mb-2">Giới tính:</label>
                    <select id="gioiTinh" name="gioiTinh" class="form-input w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 ease-in-out">
                        <option value="Nam" <?= ($user['GioiTinh'] == 'Nam') ? 'selected' : '' ?>>Nam</option>
                        <option value="Nữ" <?= ($user['GioiTinh'] == 'Nữ') ? 'selected' : '' ?>>Nữ</option>
                    </select>
                </div>
                <div>
                    <label for="diaChi" class="block font-semibold mb-2">Địa chỉ:</label>
                    <input type="text" id="diaChi" name="diaChi" value="<?= htmlspecialchars($user['DiaChi']) ?>" class="form-input w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 ease-in-out">
                </div>
                <div>
                    <label for="donVi" class="block font-semibold mb-2">Đơn vị:</label>
                    <input type="text" id="donVi" name="donVi" value="<?= htmlspecialchars($user['DonVi']) ?>" class="form-input w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 ease-in-out">
                </div>
                <div>
                    <label for="maSo" class="block font-semibold mb-2">Mã số:</label>
                    <input type="text" id="maSo" name="maSo" value="<?= htmlspecialchars($user['MaSo']) ?>" class="form-input w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 ease-in-out">
                </div>
                <div>
                    <label for="sdt" class="block font-semibold mb-2">Số điện thoại:</label>
                    <input type="text" id="sdt" name="sdt" value="<?= htmlspecialchars($user['SDT']) ?>" class="form-input w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 ease-in-out">
                </div>
                <div>
                    <label for="email" class="block font-semibold mb-2">Email:</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['Email']) ?>" class="form-input w-full border border-gray-300 rounded p-2 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition duration-200 ease-in-out">
                </div>
                <div class="mt-8 col-span-2 flex justify-end space-x-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200 ease-in-out">
                        <i class="fas fa-save"></i> Lưu thay đổi
                    </button>
                    <a href="?url=profile" class="bg-gray-200 hover:bg-gray-300 text-blue-500 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-200 ease-in-out">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
</body>
</html>
