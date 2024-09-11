<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

$loaiSachController = new LoaiSachController();
$loaiSachs = $loaiSachController->index();

$tacGiaController = new TacGiaController();
$tacGias = $tacGiaController->index();

$nhaXuatBanController = new NhaXuatBanController();
$nhaXuatBans = $nhaXuatBanController->index();

$currentYear = date("Y");
$years = range($currentYear, $currentYear - 100);
?>

<div class="container mx-auto flex flex-wrap py-6">
    <?php require_once dirname(__FILE__) . '/../layouts/sidebar.php'; ?>
    <main class="w-full md:w-3/4 px-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Thêm đầu sách</h2>
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
                            <path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934-2.934a1 1 0 000-1.414z"/>
                        </svg>
                    </span>
                </div>
                <?php unset($_SESSION['errors']); ?>
            <?php endif; ?>
            <form action="?url=admin/quanlydausach/store" method="post" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="TenDauSach" class="block text-sm font-medium text-gray-700">Tựa sách</label>
                        <input type="text" name="TenDauSach" id="TenDauSach" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="Id_NhaXuatBan" class="block text-sm font-medium text-gray-700">Nhà xuất bản</label>
                        <select name="Id_NhaXuatBan" id="Id_NhaXuatBan" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                            <?php foreach ($nhaXuatBans as $nhaXuatBan) : ?>
                                <option value="<?php echo $nhaXuatBan['Id']; ?>"><?php echo $nhaXuatBan['TenNXB']; ?></option>
                            <?php endforeach; ?>
                            <option value="0">Thêm nhà xuất bản</option>
                            <script>
                                document.getElementById('Id_NhaXuatBan').addEventListener('change', function() {
                                    if (this.value == 0) {
                                        window.location.href = '?url=admin/quanlynhaxuatban/add';
                                    }
                                });
                            </script>
                        </select>
                    </div>
                    <div>
                        <label for="Id_TacGia" class="block text-sm font-medium text-gray-700">Tác giả (chỉ cần 1 tác giả đại diện)</label>
                        <select name="Id_TacGia" id="Id_TacGia" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                            <?php foreach ($tacGias as $tacGia) : ?>
                                <option value="<?php echo $tacGia['Id']; ?>"><?php echo $tacGia['Ho'].' '.$tacGia['Ten']; ?></option>
                            <?php endforeach; ?>
                            <option value="0">Thêm tác giả</option>
                            <script>
                                document.getElementById('Id_TacGia').addEventListener('change', function() {
                                    if (this.value == 0) {
                                        window.location.href = '?url=admin/quanlytacgia/add';
                                    }
                                });
                            </script>
                        </select>
                    </div>

                    <div>
                        <label for="NamSanXuat" class="block text-sm font-medium text-gray-700">Năm xuất bản</label>
                        <select name="NamSanXuat" id="NamSanXuat" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                            <?php foreach ($years as $year) : ?>
                                <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="SoLuong" class="block text-sm font-medium text-gray-700">Số lượng</label>
                        <input type="text" name="SoLuong" id="SoLuong" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                    </div>

                    <div>
                        <label for="Id_LoaiSach" class="block text-sm font-medium text-gray-700">Loại sách</label>
                        <select name="Id_LoaiSach" id="Id_LoaiSach" required class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                            <?php foreach ($loaiSachs as $loaiSach) : ?>
                                <option value="<?php echo $loaiSach['Id']; ?>"><?php echo $loaiSach['TenLoai']; ?></option>
                            <?php endforeach; ?>
                            <option value="0">Thêm loại sách</option>
                            <script>
                                document.getElementById('Id_LoaiSach').addEventListener('change', function() {
                                    if (this.value == 0) {
                                        window.location.href = '?url=admin/quanlyloaisach/add';
                                    }
                                });
                            </script>
                        </select>
                    </div>

                    <div>
                        <label for="images" class="block text-sm font-medium text-gray-700">Hình ảnh</label>
                        <input type="file" name="images[]" id="images" multiple class="mt-1 p-2 block w-full border border-gray-300 rounded-md">
                    </div>
                </div>
                <div class="mt-4 flex justify-between">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">
                        <i class="fas fa-plus-circle mr-2"></i> Thêm</button>
                    <a href="?url=admin/quanlydausach" class="px-4 py-2 bg-gray-500 text-white rounded-md">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại</a>
                </div>
            </form>
        </div>
    </main>
</div>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
