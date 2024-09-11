<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';
?>

<div class="container mx-auto flex flex-wrap py-6">
    <?php require_once dirname(__FILE__) . '/../layouts/sidebar.php'; ?>
    <main class="w-full md:w-3/4 px-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Thêm Độc Giả</h2>
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
            <form action="?url=admin/quantrivien/store" method="post">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="Ho" class="block text-sm font-medium text-gray-700">Họ</label>
                        <input type="text" name="Ho" id="Ho" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="Ten" class="block text-sm font-medium text-gray-700">Tên</label>
                        <input type="text" name="Ten" id="Ten" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="DiaChi" class="block text-sm font-medium text-gray-700">Địa Chỉ</label>
                        <input type="text" name="DiaChi" id="DiaChi" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="SDT" class="block text-sm font-medium text-gray-700">Số Điện Thoại</label>
                        <input type="text" name="SDT" id="SDT" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="Email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="Email" id="Email" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
                    </div>
                </div>
                <div class="mt-4 flex justify-between">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 flex items-center">
                        <i class="fas fa-plus-circle mr-2"></i> Thêm
                    </button>
                    <a href="?url=admin/quantrivien/list" class="ml-4 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Quay Lại
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
