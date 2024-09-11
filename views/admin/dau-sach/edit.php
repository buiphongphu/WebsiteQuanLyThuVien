<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

$dauSachController = new DauSachController();
$dauSach = $dauSachController->detail($_GET['id']);

$tacGiaController = new TacGiaController();
$tacGia = $tacGiaController->detail($dauSach['id_tacgia']);
$tacGia['tentacgia'] = $tacGia['Ho'] . ' ' . $tacGia['Ten'];

$nhaXuatBanController = new NhaXuatBanController();
$nhaXuatBan = $nhaXuatBanController->index();

$imageSachController = new ImageSachController();
$images = $imageSachController->layUrl($dauSach['Id']);

$loaiSachController = new LoaiSachController();
$loaiSachs = $loaiSachController->index();
$tacGias = $tacGiaController->index();
$nhaXuatBans = $nhaXuatBanController->index();
?>

<div class="container mx-auto flex flex-wrap py-6">
    <?php require_once dirname(__FILE__) . '/../layouts/sidebar.php'; ?>
    <main class="w-full md:w-3/4 px-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Sửa Đầu Sách</h2>
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
            <form action="?url=admin/quanlydausach/update" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $dauSach['Id']; ?>">
                <input type="hidden" name="selectedImageId" id="selectedImageId" value="">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="TuaSach" class="block text-sm font-medium text-gray-700">Tựa Sách</label>
                        <input type="text" name="TuaSach" id="TuaSach" class="mt-1 p-2 w-full border border-gray-300 rounded-md" value="<?php echo $dauSach['TuaSach']; ?>">
                    </div>
                    <div>
                        <label for="TacGia" class="block text-sm font-medium text-gray-700">Tác Giả</label>
                        <select name="Id_TacGia" id="TacGia" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                            <?php foreach ($tacGias as $tg): ?>
                                <option value="<?php echo $tg['Id']; ?>" <?php echo $tg['Id'] == $dauSach['id_tacgia'] ? 'selected' : ''; ?>>
                                    <?php echo $tg['Ho'] . ' ' . $tg['Ten']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="NhaXuatBan" class="block text-sm font-medium text-gray-700">Nhà Xuất Bản</label>
                        <select name="Id_NhaXuatBan" id="NhaXuatBan" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                            <?php foreach ($nhaXuatBans as $nxb): ?>
                                <option value="<?php echo $nxb['Id']; ?>" <?php echo $nxb['Id'] == $dauSach['id_nxb'] ? 'selected' : ''; ?>>
                                    <?php echo $nxb['TenNXB']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="NamXuatBan" class="block text-sm font-medium text-gray-700">Năm Xuất Bản</label>
                        <input type="text" name="NamXuatBan" id="NamXuatBan" class="mt-1 p-2 w-full border border-gray-300 rounded-md" value="<?php echo $dauSach['namxb']; ?>">
                    </div>
                    <div>
                        <label for="SoLuong" class="block text-sm font-medium text-gray-700">Số Lượng</label>
                        <input type="text" name="SoLuong" id="SoLuong" class="mt-1 p-2 w-full border border-gray-300 rounded-md" value="<?php echo $dauSach['soluong']; ?>">
                    </div>
                    <div>
                        <label for="NgayNhap" class="block text-sm font-medium text-gray-700">Ngày Nhập</label>
                        <input type="text" name="NgayNhap" id="NgayNhap" class="mt-1 p-2 w-full border border-gray-300 rounded-md" value="<?php echo $dauSach['ngaynhap']; ?>">
                    </div>
                    <div>
                        <label for="HinhAnh" class="block text-sm font-medium text-gray-700">Hình Ảnh</label>
                        <div class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                            <div class="grid grid-cols-2 gap-4">
                                <?php foreach ($images as $image): ?>
                                    <div class="relative">
                                        <img src="<?php echo $image['Url']; ?>" alt="Image" class="w-full h-32 object-cover rounded-md">
                                        <button type="button" onclick="selectImage('<?php echo $image['Id']; ?>')" class="absolute top-0 right-0 bg-red-500 text-white p-1 rounded-full">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="mt-2">
                            <input type="file" name="newImage" id="newImage" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                        </div>
                    </div>


                    <div>
                        <label for="Id_LoaiSach" class="block text-sm font-medium text-gray-700">Loại Sách</label>
                        <select name="Id_LoaiSach" id="Id_LoaiSach" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                            <?php foreach ($loaiSachs as $loaiSach) : ?>
                                <option value="<?php echo $loaiSach['Id']; ?>" <?php echo $loaiSach['Id'] == $dauSach['Id_LoaiSach'] ? 'selected' : ''; ?>><?php echo $loaiSach['TenLoai']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex justify-between">
                    <button type="submit" class="bg-blue-500 text-white p-2 rounded-md flex items-center">
                        <i class="fas fa-save mr-2"></i> Lưu
                    </button>
                    <a href="?url=admin/quanlydausach" class="bg-gray-500 text-white p-2 rounded-md flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Quay lại
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>

<script>
    function selectImage(id) {
        document.getElementById('selectedImageId').value = id;
    }
</script>

