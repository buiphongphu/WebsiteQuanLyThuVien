<?php
require_once dirname(__FILE__).'/../layouts/head.php';
require_once dirname(__FILE__).'/../layouts/header.php';
?>

    <div class="container mx-auto flex flex-wrap py-6">
        <?php require_once dirname(__FILE__).'/../layouts/sidebar.php'; ?>
        <main class="w-full md:w-3/4 px-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Thêm Loại Sách</h2>

                <?php if (isset($_SESSION['errors'])): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
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

                <form action="?url=admin/quanlyloaisach/store" method="POST">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="ten_loai" class="block text-gray-700 text-sm font-bold mb-2">Tên Loại Sách:</label>
                            <input type="text" id="ten_loai" name="TenLoai" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="<?php echo isset($_POST['TenLoai']) ? $_POST['TenLoai'] : ''; ?>">
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline flex items-center">
                            <i class="fas fa-plus-circle mr-2"></i> Thêm
                        </button>
                        <a href="?url=admin/quanlyloaisach" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i> Quay Lại
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

<?php require_once dirname(__FILE__).'/../layouts/footer.php'; ?>
