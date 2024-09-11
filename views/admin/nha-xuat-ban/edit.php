<?php
require_once dirname(__FILE__).'/../layouts/head.php';
require_once dirname(__FILE__).'/../layouts/header.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "ID nhà xuất bản không hợp lệ";
    header("Location: ?url=admin/quanlynhaxuatban");
    exit();
}

$nxbModel = new NhaXuatBan();
$nxb = $nxbModel->getById($_GET['id']);

if (!$nxb) {
    $_SESSION['error_message'] = "Không tìm thấy nhà xuất bản";
    header("Location: ?url=admin/quanlynhaxuatban");
    exit();
}
?>

    <div class="container mx-auto flex flex-wrap py-6">
        <?php require_once dirname(__FILE__).'/../layouts/sidebar.php'; ?>
        <main class="w-full md:w-3/4 px-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Sửa Nhà Xuất Bản</h2>
                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="alert alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Lỗi!</strong>
                        <ul>
                            <?php foreach ($_SESSION['errors'] as $error): ?>
                                <li><?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path
                                    d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934-2.934a1 1 0 000-1.414z"/>
                            </svg>
                        </span>
                    </div>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>
                <form action="?url=admin/quanlynhaxuatban/update" method="POST">
                    <input type="hidden" name="Id" value="<?php echo $nxb['Id']; ?>">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="TenNXB" class="block text-gray-700 text-sm font-bold mb-2">Tên Nhà Xuất Bản:</label>
                            <input type="text" id="TenNXB" name="TenNXB" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo $nxb['TenNXB']; ?>">
                        </div>
                        <div>
                            <label for="DiaChiNXB" class="block text-gray-700 text-sm font-bold mb-2">Địa Chỉ Nhà Xuất Bản:</label>
                            <input type="text" id="DiaChiNXB" name="DiaChiNXB" class="appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo $nxb['DiaChiNXB']; ?>">
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center">
                            <i class="fas fa-save mr-2"></i> Cập Nhật
                        </button>
                        <a href="?url=admin/quanlynhaxuatban" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i> Quay Lại
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

<?php require_once dirname(__FILE__).'/../layouts/footer.php'; ?>
