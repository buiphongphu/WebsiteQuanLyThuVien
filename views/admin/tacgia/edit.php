<?php
require_once dirname(__FILE__).'/../layouts/head.php';
require_once dirname(__FILE__).'/../layouts/header.php';


$tacGiaController = new TacGiaController();
$tacGia = $tacGiaController->detail($_GET['id']);
?>

    <div class="container mx-auto flex flex-wrap py-6">
        <?php require_once dirname(__FILE__).'/../layouts/sidebar.php'; ?>
        <main class="w-full md:w-3/4 px-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Sửa Tác Giả</h2>
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
                <form action="?url=admin/quanlytacgia/update" method="post">
                    <input type="hidden" name="Id" value="<?php echo $tacGia['Id']; ?>">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="Ho" class="block text-sm font-medium text-gray-700">Họ</label>
                            <input type="text" name="Ho" id="Ho" class="mt-1 p-2 w-full border border-gray-300 rounded-md" value="<?php echo $tacGia['Ho']; ?>">
                        </div>
                        <div>
                            <label for="Ten" class="block text-sm font-medium text-gray-700">Tên</label>
                            <input type="text" name="Ten" id="Ten" class="mt-1 p-2 w-full border border-gray-300 rounded-md" value="<?php echo $tacGia['Ten']; ?>">
                        </div>
                        <div>
                            <label for="QuocTich" class="block text-sm font-medium text-gray-700">Quốc tịch</label>
                            <input type="text" name="QuocTich" id="QuocTich" class="mt-1 p-2 w-full border border-gray-300 rounded-md" value="<?php echo $tacGia['quoctich']; ?>">
                        </div>
                    </div>

                    <div class="mb-4 flex justify-between">
                        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md flex items-center">
                            <i class="fas fa-save mr-2"></i> Lưu
                        </button>
                        <a href="?url=admin/quanlytacgia" class="bg-gray-500 text-white p-2 rounded-md flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

<?php require_once dirname(__FILE__).'/../layouts/footer.php'; ?>
