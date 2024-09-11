<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

$sachController = new SachController();
$sach = $sachController->detail($_GET['id']);

if (!$sach) {
    header('Location: ?url=admin/quanlysach');
    exit;
}

$nhaXuatBanModel = new NhaXuatBan();
$nhaXuatBans = $nhaXuatBanModel->getAll();

$tacGiaModel = new TacGia();
$tacGias = $tacGiaModel->getAll();

$dauSachModel = new DauSach();
$dauSachs = $dauSachModel->getAll();

$imageSachModel = new ImageSach();
$imageSach = $imageSachModel->getById($sach['Id']);

?>

    <div class="container mx-auto flex flex-wrap py-6">
        <?php require_once dirname(__FILE__) . '/../layouts/sidebar.php'; ?>
        <main class="w-full md:w-3/4 px-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Chỉnh Sửa Sách</h2>

                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                         role="alert">
                        <strong class="font-bold">Lỗi!</strong>
                        <?php echo $_SESSION['error_message']; ?>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3"
                              onclick="this.parentElement.style.display='none';">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button"
                                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path
                                    d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934-2.934a1 1 0 000-1.414z"/>
                            </svg>
                        </span>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <form action="?url=admin/quanlysach/update" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $sach['Id']; ?>">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="TenSach" class="block text-sm font-medium text-gray-700">Tên Sách:</label>
                            <input type="text" id="TenSach" name="TenSach" required
                                   class="mt-1 p-2 block w-full border border-gray-300 rounded-md"
                                   value="<?php echo $sach['TenSach']; ?>">
                        </div>
                        <div>
                            <label for="NamXB" class="block text-sm font-medium text-gray-700">Năm Xuất Bản:</label>
                            <input type="text" id="NamXB" name="NamXB" required
                                   class="mt-1 p-2 block w-full border border-gray-300 rounded-md"
                                   value="<?php echo $sach['NamXB']; ?>">
                        </div>
                        <div>
                            <label for="SoLuong" class="block text-sm font-medium text-gray-700">Số Lượng:</label>
                            <input type="number" id="SoLuong" name="SoLuong" required
                                   class="mt-1 p-2 block w-full border border-gray-300 rounded-md"
                                   value="<?php echo $sach['SoLuong']; ?>">
                        </div>
                        <div>
                            <label for="NgayNhap" class="block text-sm font-medium text-gray-700">Ngày Nhập:</label>
                            <input type="date" id="NgayNhap" name="NgayNhap" required
                                   class="mt-1 p-2 block w-full border border-gray-300 rounded-md"
                                   value="<?php echo $sach['NgayNhap']; ?>">
                        </div>
                        <div>
                            <label for="Id_DauSach" class="block text-sm font-medium text-gray-700">Đầu Sách:</label>
                            <select id="Id_DauSach" name="Id_DauSach" required
                                    class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                                <?php foreach ($dauSachs as $dauSach): ?>
                                    <option value="<?php echo $dauSach['Id']; ?>" <?php echo $dauSach['Id'] == $sach['Id_DauSach'] ? 'selected' : ''; ?>>
                                        <?php echo $dauSach['TenDauSach']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="Id_NhaXuatBan" class="block text-sm font-medium text-gray-700">Nhà Xuất Bản:</label>
                            <select id="Id_NhaXuatBan" name="Id_NhaXuatBan" required
                                    class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                                <?php foreach ($nhaXuatBans as $nhaXuatBan): ?>
                                    <option value="<?php echo $nhaXuatBan['Id']; ?>" <?php echo $nhaXuatBan['Id'] == $sach['Id_NhaXuatBan'] ? 'selected' : ''; ?>>
                                        <?php echo $nhaXuatBan['TenNXB']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="Id_TacGia" class="block text-sm font-medium text-gray-700">Tác Giả:</label>
                            <select id="Id_TacGia" name="Id_TacGia" required
                                    class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                                <?php foreach ($tacGias as $tacGia): ?>
                                    <option value="<?php echo $tacGia['Id']; ?>" <?php echo $tacGia['Id'] == $sach['Id_TacGia'] ? 'selected' : ''; ?>>
                                        <?php echo $tacGia['Ho'] . ' ' . $tacGia['Ten']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label for="HinhAnh" class="block text-sm font-medium text-gray-700">Hình Ảnh:</label>
                            <?php if ($imageSach): ?>
                                <img src="<?php echo $imageSach['Url']; ?>" alt="Hình ảnh sách"
                                     class="mb-2 w-32 h-32 object-cover">
                            <?php endif; ?>
                            <input type="file" id="HinhAnh" name="HinhAnh"
                                   class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                        </div>
                    </div>

                    <div class="mt-4 flex justify-between">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 flex items-center">
                            <i class="fas fa-save mr-2"></i> Lưu
                        </button>
                        <a href="?url=admin/quanlysach"
                           class="ml-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i> Quay Lại
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
