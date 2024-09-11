<?php
$loginController= new LoginController();
$loginController->checkLoginCookie();
if(!isset($_SESSION['user'])){
    header('Location: ?url=login');
    exit();
}

?>

<header class="bg-blue-500 py-4">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <a href="?url=index" class="text-white text-2xl font-bold">Thư Viện 2P</a>
        <div class="block lg:hidden">
            <button id="mobile-menu-toggle" class="text-white focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <nav class="hidden lg:flex lg:items-center lg:space-x-4">
            <ul class="flex space-x-4 items-center">
                <li><a href="?url=index" class="text-white hover:text-gray-300 flex items-center"><i class="fas fa-home mr-2"></i> Trang chủ</a></li>
                <li><a href="?url=about" class="text-white hover:text-gray-300 flex items-center"><i class="fas fa-info-circle mr-2"></i> Giới thiệu</a></li>
                <li><a href="?url=contact" class="text-white hover:text-gray-300 flex items-center"><i class="fas fa-phone-alt mr-2"></i> Liên hệ</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a href="?url=yeu-thich-sach" class="text-white hover:text-gray-300 flex items-center"><i class="fas fa-heart mr-2"></i> Yêu thích</a></li>
                    <li><a href="?url=the-thu-vien" class="text-white hover:text-gray-300 flex items-center"><i class="fas fa-id-card mr-2"></i> Thẻ thư viện</a></li>
                    <li><a href="?url=phieu-muon" class="text-white hover:text-gray-300 flex items-center"><i class="fas fa-book-open mr-2"></i> Phiếu mượn</a></li>
                    <li><a href="?url=dang-ky-muon" class="text-white hover:text-gray-300 flex items-center"><i class="fas fa-edit mr-2"></i> Đăng ký mượn</a></li>
                    <li><a href="?url=cart" class="text-white hover:text-gray-300 flex items-center" id="cart-link"><i class="fas fa-shopping-cart mr-2"></i> Giỏ sách <span id="cart-count" class="bg-red-500 text-white px-2 py-1 rounded-full"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span></a></li>
                    <li><a href="?url=profile" class="text-white hover:text-gray-300 flex items-center"><i class="fas fa-user mr-2"></i> Xin chào, <?php echo $_SESSION['user']['Ho'].$_SESSION['user']['Ten'] ?></a></li>
                    <li><a href="?url=logout" class="text-white hover:text-gray-300 flex items-center"><i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất</a></li>
                <?php else: ?>
                    <li><a href="?url=login" class="text-white hover:text-gray-300 flex items-center"><i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập</a></li>
                    <li><a href="?url=register" class="text-white hover:text-gray-300 flex items-center"><i class="fas fa-user-plus mr-2"></i> Đăng ký</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <div id="mobile-menu" class="lg:hidden hidden">
        <ul class="bg-blue-500 space-y-2">
            <li><a href="?url=index" class="block py-2 px-4 text-white hover:bg-blue-600"><i class="fas fa-home mr-2"></i> Trang chủ</a></li>
            <li><a href="?url=about" class="block py-2 px-4 text-white hover:bg-blue-600"><i class="fas fa-info-circle mr-2"></i> Giới thiệu</a></li>
            <li><a href="?url=contact" class="block py-2 px-4 text-white hover:bg-blue-600"><i class="fas fa-phone-alt mr-2"></i> Liên hệ</a></li>
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="?url=yeu-thich-sach" class="block py-2 px-4 text-white hover:bg-blue-600"><i class="fas fa-heart mr-2"></i> Yêu thích</a></li>
                <li><a href="?url=the-thu-vien" class="block py-2 px-4 text-white hover:bg-blue-600"><i class="fas fa-id-card mr-2"></i> Thẻ thư viện</a></li>
                <li><a href="?url=phieu-muon" class="block py-2 px-4 text-white hover:bg-blue-600"><i class="fas fa-book-open mr-2"></i> Phiếu mượn</a></li>
                <li><a href="?url=dang-ky-muon" class="block py-2 px-4 text-white hover:bg-blue-600"><i class="fas fa-edit mr-2"></i> Đăng ký mượn</a></li>
                <li><a href="?url=cart" class="block py-2 px-4 text-white hover:bg-blue-600" id="mobile-cart-link"><i class="fas fa-shopping-cart mr-2"></i> Giỏ sách <span id="mobile-cart-count" class="bg-red-500 text-white px-2 py-1 rounded-full"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span></a></li>
                <li><a href="?url=profile" class="block py-2 px-4 text-white hover:bg-blue-600"><i class="fas fa-user mr-2"></i> Xin chào, <?php echo $_SESSION['user']['Ho'].$_SESSION['user']['Ten']; ?></a></li>
                <li><a href="?url=logout" class="block py-2 px-4 text-white hover:bg-blue-600"><i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất</a></li>
            <?php else: ?>
                <li><a href="?url=login" class="block py-2 px-4 text-white hover:bg-blue-600"><i class="fas fa-sign-in-alt mr-2"></i> Đăng nhập</a></li>
                <li><a href="?url=register" class="block py-2 px-4 text-white hover:bg-blue-600"><i class="fas fa-user-plus mr-2"></i> Đăng ký</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var mobileMenuToggle = document.getElementById('mobile-menu-toggle');
        var mobileMenu = document.getElementById('mobile-menu');
        mobileMenuToggle.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>
