<?php

    $loginController= new LoginController();
    $loginController->checkLoginCookie();
    if(!isset($_SESSION['admin'])){
        header('Location: ?url=login');
        exit();
    }

    $admin = $_SESSION['admin'];
    $admin = $admin['Ho'].' '.$admin['Ten'];

?>

<header class="bg-gray-800 py-4 px-6">
    <div class="container mx-auto flex items-center justify-between">
        <a href="?url=admin/dashboard" class="text-white text-lg font-bold">Quản lý Thư viện 2P</a>
        <div class="flex items-center">
            <a href="?url=admin/quantrivien" class="text-white mr-4">Xin chào, <?php echo htmlspecialchars($admin); ?></a>
            <a href="?url=logout" class="text-white">Đăng xuất</a>
        </div>
    </div>
</header>

