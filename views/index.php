<?php
function showBorrowButton($sach) {
    if (isset($_SESSION['user'])) {
        return '<button onclick="showBorrowForm(' . htmlspecialchars(json_encode($sach)) . ')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
 <i class="fas fa-shopping-cart"></i>
 Mượn</button>';
    }
    return '';
}
$danhGiaController = new DanhGiaController();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'layouts/head.php'; ?>
    <style>
        .bg-image {
            background-image: url('public/images/vector1.jpeg');
            background-size: cover;
            background-position: center;
        }
        .bg-topmembers{
            background-image: url('public/images/vector2.jpeg');
            background-size: cover;
            background-position: center;
        }
        .bg-featured {
            background-image: url('public/images/vector3.jpg');
            background-size: cover;
            background-position: center;
        }

    </style>
</head>
<body class="bg">

<?php require_once 'layouts/header.php'; ?>

<main class="container mx-auto px-4 py-8">

    <section class="bg-image p-8 rounded-lg shadow-md mb-8 text-center relative">
        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-blue-600 opacity-50 rounded-lg"></div>
        <div class="relative rounded-lg">
            <h1 class="text-4xl font-bold mb-4 text-white">Chào mừng đến với Thư viện 2P</h1>
            <p class="text-gray-200 mb-6">Khám phá thế giới sách và mở mang kiến thức.</p>
            <button id="exploreButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
                Khám phá ngay
            </button>
        </div>
    </section>

    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Thành Viên Nổi Bật</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
            $theThuVienController = new TheThuVienController();
            $thanhViens = $theThuVienController->getTopMembers();
            ?>
            <?php if (!empty($thanhViens)): ?>
                <?php foreach ($thanhViens as $thanhVien): ?>
                    <div class="bg-topmembers p-4 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                        <div class="flex flex-col items-start">
                            <h3 class="text-lg font-bold mb-2"><?php echo $thanhVien['Ho'] . ' ' . $thanhVien['Ten']; ?></h3>
                            <p class="text-gray-700 mb-2"><?php echo $thanhVien['Email']; ?></p>
                            <div class="flex items-center mb-2">
                                <span class="text-gray-700 mr-2">Điểm: <?php echo $thanhVien['diem']; ?></span>
                                <span class="text-gray-700">Thứ hạng:</span>
                                <?php
                                $rankColorClass = '';
                                $rankIcon = '';
                                switch ($thanhVien['thuhang']) {
                                    case '2P':
                                        $rankColorClass = 'text-blue-500';
                                        $rankIcon = 'fa-star';
                                        break;
                                    case '2PSilver':
                                        $rankColorClass = 'text-gray-500';
                                        $rankIcon = 'fa-star';
                                        break;
                                    case '2PGold':
                                        $rankColorClass = 'text-yellow-500';
                                        $rankIcon = 'fa-star';
                                        break;
                                    case '2PVIP':
                                        $rankColorClass = 'text-red-500';
                                        $rankIcon = 'fa-star';
                                        break;
                                    default:
                                        $rankColorClass = 'text-gray-500';
                                        $rankIcon = 'fa-star';
                                        break;
                                }
                                ?>
                                <span class="<?php echo $rankColorClass; ?> ml-1"><i class="fas <?php echo $rankIcon; ?>"> <?php echo $thanhVien['thuhang']?></i></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-gray-700">Không có thành viên nào.</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Tìm Kiếm Sách</h2>
        <div class="flex items-center gap-4 relative">
            <input type="text" id="search-input" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500" placeholder="Nhập từ khóa tìm kiếm">
            <button class="absolute right-3">
                <i class="fas fa-search text-gray-500"></i>
            </button>
        </div>
        <div id="search-results" class="mt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        </div>
    </section>


    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Thể Loại Sách</h2>
        <div class="flex flex-wrap gap-4" id="filter-categories">
            <?php
            $loaiSachController = new LoaiSachController();
            $loaiSachs = $loaiSachController->index();
            ?>
            <?php if (!empty($loaiSachs)): ?>
                <?php foreach ($loaiSachs as $loaiSach): ?>
                    <a href="#" class="px-4 py-2 bg-gray-200 rounded-full hover:bg-gray-300 filter-category" data-category="<?php echo $loaiSach['Id']; ?>">
                        # <?php echo  $loaiSach['TenLoai']; ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
            <a href="?url=all-sach"  class="px-4 py-2 bg-gray-200 rounded-full hover:bg-gray-300">
                <i class="fas fa-book"></i> Tất cả sách
            </a>
            <a href="#" class="px-4 py-2 bg-gray-200 rounded-full hover:bg-gray-300 filter-category" id="clear-filter">
                # Bỏ bộ lọc
            </a>
        </div>

    </section>

    <?php
    $sachController = new SachController();
    $danhGia = new DanhGia();
    $sachs = $sachController->index();
    ?>

    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Sách Nổi Bật</h2>
        <div id="featured-books" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
            $danhGiaController = new DanhGiaController();
            $featuredBooks = $danhGiaController->getFeaturedBooks();

            function isFavorite($Id)
            {
                if (!isset($_SESSION['user'])) {
                    return false;
                }
                $yeuThichSach = new YeuThichSachController();
                $favoriteBooks = $yeuThichSach->getFavoriteBooks($_SESSION['user']['Id']);
                foreach ($favoriteBooks as $book) {
                    if ($book['book_id'] == $Id) {
                        return true;
                    }
                }
                return false;
            }

            foreach ($featuredBooks as $sachId):
                $sach = $sachController->detail($sachId['Id_Sach']);
                $isFavorite = isFavorite($sach['Id']);
                $averageRating = $danhGiaController->getAverageRating($sach['Id']);
                ?>
                <div class="relative bg-featured p-4 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                    <?php if (!empty($sach['images'])): ?>
                        <div class="carousel relative" id="carousel-<?php echo $sach['Id']; ?>">
                            <div class="carousel-inner relative overflow-hidden w-full">
                                <?php foreach (explode(',', $sach['images']) as $index => $image): ?>
                                    <div class="carousel-item <?php echo $index === 0 ? 'active' : 'hidden'; ?>">
                                        <img src="<?php echo $image; ?>" alt="Image" class="w-full h-64 object-cover rounded-lg mb-4">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button class="carousel-prev absolute top-1/2 left-0 transform -translate-y-1/2 bg-white text-gray-700 p-2 rounded-full hover:bg-gray-200" onclick="prevSlide(event, <?php echo $sach['Id']; ?>)">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="carousel-next absolute top-1/2 right-0 transform -translate-y-1/2 bg-white text-gray-700 p-2 rounded-full hover:bg-gray-200" onclick="nextSlide(event, <?php echo $sach['Id']; ?>)">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="w-full h-64 bg-gray-300 rounded-lg mb-4"></div>
                    <?php endif; ?>
                    <a href="?url=chi-tiet-sach&id=<?php echo $sach['Id']; ?>">
                        <h3 class="text-xl font-bold mb-2"><?php echo $sach['TuaSach']; ?></h3>
                        <p class="text-gray-700 mb-2">Tác giả: <?php echo $sach['Ho'] . ' ' . $sach['Ten']; ?></p>
                        <p class="text-gray-700">Nhà xuất bản: <?php echo $sach['TenNXB']; ?></p>
                        <div class="mt-2">
                            <?php echo displayStars($averageRating); ?>
                        </div>
                    </a>
                    <div class="absolute top-2 right-2">
                        <?php if (isset($_SESSION['user'])): ?>
                            <?php if ($isFavorite): ?>
                                <form action="?url=yeu-thich-sach/delete" method="post" style="display: inline;">
                                    <button type="submit" class="favorite-button text-2xl text-red-500" data-book-id="<?= $sach['Id']; ?>">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                    <input type="hidden" name="bookId" value="<?= $sach['Id']; ?>">
                                    <input type="hidden" name="action" value="delete">
                                </form>
                            <?php else: ?>
                                <form action="?url=yeu-thich-sach/store" method="post" style="display: inline;">
                                    <button type="submit" class="favorite-button text-2xl text-gray-500" data-book-id="<?= $sach['Id']; ?>">
                                        <i class="far fa-heart"></i>
                                    </button>
                                    <input type="hidden" name="bookId" value="<?= $sach['Id']; ?>">
                                    <input type="hidden" name="action" value="store">
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="flex mt-4 space-x-2 items-center">
                        <?php if (isset($_SESSION['user'])): ?>
                            <?php echo showBorrowButton($sach); ?>
                        <?php endif; ?>
                        <a href="?url=chi-tiet-sach&id=<?php echo $sach['Id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>Xem chi tiết
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Sách Mới Phát Hành</h2>
        <div id="new-books" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
            $currentYear = date('Y');
            $newBooks = array_filter($sachs, function ($sach) use ($currentYear) {
                return $sach['namxb'] == $currentYear;
            });
            ?>
            <?php if (!empty($newBooks)): ?>
                <?php foreach ($newBooks as $sach):
                    $isFavorite = isFavorite($sach['Id']);
                    $averageRating = $danhGiaController->getAverageRating($sach['Id']);
                    ?>
                    <div class="relative bg-featured p-4 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                        <?php if (!empty($sach['images'])): ?>
                            <div class="carousel relative" id="carousels-<?php echo $sach['Id']; ?>">
                                <div class="carousel-inner relative overflow-hidden w-full">
                                    <?php foreach (explode(',', $sach['images']) as $index => $image): ?>
                                        <div class="carousel-item <?php echo $index === 0 ? 'active' : 'hidden'; ?>">
                                            <img src="<?php echo $image; ?>" alt="Image" class="w-full h-64 object-cover rounded-lg mb-4">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <button class="carousel-prev absolute top-1/2 left-0 transform -translate-y-1/2 bg-white text-gray-700 p-2 rounded-full hover:bg-gray-200" onclick="prevSlideNewBooks(event, <?php echo $sach['Id']; ?>)">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="carousel-next absolute top-1/2 right-0 transform -translate-y-1/2 bg-white text-gray-700 p-2 rounded-full hover:bg-gray-200" onclick="nextSlideNewBooks(event, <?php echo $sach['Id']; ?>)">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="w-full h-64 bg-gray-300 rounded-lg mb-4"></div>
                        <?php endif; ?>
                        <a href="?url=chi-tiet-sach&id=<?php echo $sach['Id']; ?>">
                            <h3 class="text-xl font-bold mb-2"><?php echo $sach['TuaSach']; ?></h3>
                            <p class="text-gray-700 mb-2">Tác giả: <?php echo $sach['HoTenTacGia']; ?></p>
                            <p class="text-gray-700">Nhà xuất bản: <?php echo $sach['TenNXB']; ?></p>
                            <div class="mt-2">
                                <?php echo displayStars($averageRating); ?>
                            </div>
                        </a>
                        <div class="absolute top-2 right-2">
                            <?php if (isset($_SESSION['user'])): ?>
                                <?php $isFavorite = isFavorite($sach['Id']); ?>
                                <?php if ($isFavorite): ?>
                                    <form action="?url=yeu-thich-sach/delete" method="post" style="display: inline;">
                                        <button type="submit" class="favorite-button text-2xl text-red-500" data-book-id="<?= $sach['Id']; ?>">
                                            <i class="fas fa-heart"></i>
                                        </button>
                                        <input type="hidden" name="bookId" value="<?= $sach['Id']; ?>">
                                        <input type="hidden" name="action" value="delete">
                                    </form>
                                <?php else: ?>
                                    <form action="?url=yeu-thich-sach/store" method="post" style="display: inline;">
                                        <button type="submit" class="favorite-button text-2xl text-gray-500" data-book-id="<?= $sach['Id']; ?>">
                                            <i class="far fa-heart"></i>
                                        </button>
                                        <input type="hidden" name="bookId" value="<?= $sach['Id']; ?>">
                                        <input type="hidden" name="action" value="store">
                                    </form>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <div class="flex mt-4 space-x-2 items-center">
                            <?php if (isset($_SESSION['user'])): ?>
                                <?php echo showBorrowButton($sach); ?>
                            <?php endif; ?>
                            <a href="?url=chi-tiet-sach&id=<?php echo $sach['Id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>Xem chi tiết
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có sách mới phát hành trong năm nay.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<div id="borrowFormContainer" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-md">
        <div class="mb-4">
            <h2 class="text-2xl font-bold mb-4">Đăng ký mượn sách</h2>
            <label class="block text-gray-700 text-sm font-bold mb-2" for="TenSach">
                Tên Sách: <span id="borrowFormBookName"></span>
            </label>
        </div>

        <input type="hidden" id="Id_sach" name="Id_sach" value="">

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="SoLuong">
                Số Lượng
            </label>
            <input name="SoLuong" id="SoLuong" type="number" min="1" max="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="NgayMuon">
                Ngày Mượn
            </label>
            <input name="NgayMuon" id="NgayMuon" type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="NgayTra">
                Ngày Trả
            </label>
            <input name="NgayTra" id="NgayTra" type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="flex items-center justify-between">
            <button type="button" onclick="submitBorrowForm()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Đăng Ký
            </button>
            <button type="button" onclick="hideBorrowForm()" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Hủy
            </button>
        </div>
    </div>
</div>

<div id="error-dialog" class="hidden fixed inset-0 flex items-center justify-center z-50">
    <div class="bg-black bg-opacity-80 rounded-lg p-10 shadow-lg bg-neon-red w-1/2 max-w-lg h-auto">
        <div class="flex items-center mb-6">
            <i class="fas fa-times-circle text-neon-red text-4xl mr-3 glow-red"></i>
            <h2 class="text-2xl font-bold text-white">Thêm sách thất bại</h2>
        </div>
        <p class="text-lg text-white">Đã xảy ra lỗi khi mượn sách. Vui lòng thử lại.</p>
    </div>
</div>

<div id="error-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

<div id="complaint-dialog" class="hidden fixed inset-0 flex items-center justify-center z-50">
    <div class="bg-black bg-opacity-80 rounded-lg p-10 shadow-lg bg-green-600 w-1/2 max-w-lg h-auto">
        <div class="flex items-center mb-6">
            <i class="fas fa-check-circle text-gray-100 text-4xl mr-3 glow-green"></i>
            <h2 class="text-2xl font-bold text-white">Thêm sách thành công</h2>
        </div>
        <p class="text-lg text-white">Sách đã được thêm vào giỏ hàng của bạn.</p>
    </div>
</div>

<div id="complaint-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

<style>
    .text-xl {
        font-size: 1.25rem;
    }

    .font-bold {
        font-weight: bold;
    }

    .text-2xl {
        font-size: 1.5rem;
    }

    .text-white {
        color: white;
    }

    .text-gray-100 {
        color: #f7fafc;
    }

    .glow-red {
        text-shadow: 0 0 10px #ff073a, 0 0 20px #ff073a, 0 0 30px #ff073a, 0 0 40px #ff073a, 0 0 50px #ff073a, 0 0 60px #ff073a, 0 0 70px #ff073a;
    }

    .glow-green {
        text-shadow: 0 0 10px #39ff14, 0 0 20px #39ff14, 0 0 30px #39ff14, 0 0 40px #39ff14, 0 0 50px #39ff14, 0 0 60px #39ff14, 0 0 70px #39ff14;
    }

    .bg-neon-red {
        text-shadow: 0 0 8px #a91a1a, 0 0 16px #d52e2e, 0 0 24px #e53e3e, 0 0 32px #ff073a, 0 0 40px #ff073a, 0 0 48px #ff073a, 0 0 56px #ff073a;
    }


    .bg-green-600 {
        text-shadow: 0 0 8px #1e3a1e, 0 0 16px #2e6f2e, 0 0 24px #3d8c3d, 0 0 32px #39ff14, 0 0 40px #39ff14, 0 0 48px #39ff14, 0 0 56px #39ff14;
    }


</style>

<?php require_once 'layouts/footer.php'; ?>

<script>
    function prevSlideNewBooks(event, bookId) {
        event.stopPropagation();
        const carousel = document.getElementById('carousels-' + bookId);
        const items = carousel.querySelectorAll('.carousel-item');
        let activeIndex = 0;

        items.forEach((item, index) => {
            if (item.classList.contains('active')) {
                item.classList.remove('active');
                item.classList.add('hidden');
                activeIndex = index;
            }
        });

        const prevIndex = (activeIndex - 1 + items.length) % items.length;
        items[prevIndex].classList.remove('hidden');
        items[prevIndex].classList.add('active');
    }

    function nextSlideNewBooks(event, bookId) {
        event.stopPropagation();
        const carousel = document.getElementById('carousels-' + bookId);
        const items = carousel.querySelectorAll('.carousel-item');
        let activeIndex = 0;

        items.forEach((item, index) => {
            if (item.classList.contains('active')) {
                item.classList.remove('active');
                item.classList.add('hidden');
                activeIndex = index;
            }
        });

        const nextIndex = (activeIndex + 1) % items.length;
        items[nextIndex].classList.remove('hidden');
        items[nextIndex].classList.add('active');
    }


    document.addEventListener('DOMContentLoaded', function() {
        const clearFilterButton = document.getElementById('clear-filter');
        const searchInput = document.getElementById('search-input');
        const filterCategoryButtons = document.querySelectorAll('.filter-category');
        let lastSearchKeyword = '';

        searchInput.addEventListener('input', function() {
            const keyword = this.value.trim().toLowerCase();
            if (keyword === lastSearchKeyword) {
                return;
            }
            lastSearchKeyword = keyword;

            if (keyword === '') {
                resetSearchResults();
            } else {
                searchBooks(keyword);
            }
        });

        filterCategoryButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                const id= this.getAttribute('data-category');
                console.log('Lọc theo thể loại:', id);
                filterBooks(id);
            });
        });

        clearFilterButton.addEventListener('click', function(event) {
            event.preventDefault();

            const filterLinks = document.querySelectorAll('.filter-category');
            filterLinks.forEach(link => {
                link.classList.remove('bg-gray-500', 'text-white');
            });
        });

    });

    function searchBooks(keyword) {
        const searchResults = document.getElementById('search-results');
        searchResults.innerHTML = '<p>Đang tìm kiếm...</p>';
        fetch('?url=timkiem&q=' + keyword)
            .then(response => response.json())
            .then(data => updateSearchResults(data))
            .catch(error => {
                console.error('Lỗi khi tìm kiếm sách:', error);
                resetSearchResults();
            });
    }


    function filterBooks(id) {
        const searchResults = document.getElementById('search-results');
        searchResults.innerHTML = '<p>Đang tìm kiếm...</p>';
        fetch('?url=locsach&id=' + id)
            .then(response => response.json())
            .then(data => updateSearchResults(data))
            .catch(error => {
                console.error('Lỗi khi tìm kiếm sách:', error);
                resetSearchResults();
            });
    }

    function updateSearchResults(data) {
        const searchResults = document.getElementById('search-results');
        searchResults.innerHTML = '';
        if (data.length > 0) {
            data.forEach(sach => {
                const bookDiv = createBookDiv(sach);
                searchResults.appendChild(bookDiv);
            });
        }

        else {
            searchResults.innerHTML = '<p>Không có sách nào được tìm thấy.</p>';
        }
    }

    function resetSearchResults() {
        const searchResults = document.getElementById('search-results');
        searchResults.innerHTML = '';
    }

    function createBookDiv(sach) {
        const bookDiv = document.createElement('div');
        bookDiv.classList.add('relative', 'bg-featured', 'p-4', 'rounded-lg', 'shadow-md', 'hover:shadow-lg', 'transform', 'hover:scale-105', 'transition', 'duration-300', 'ease-in-out');
        bookDiv.onclick = () => {
            window.location.href = '?url=chi-tiet-sach&id=' + sach.Id;
        };

        let images = [];

        if (typeof sach.images === 'string') {
            images = sach.images.split(',');
        } else if (Array.isArray(sach.images)) {
            images = sach.images;
        } else {
            console.error('Invalid images data:', sach.images);
        }

        const carousel = document.createElement('div');
        carousel.id = `carousel-${sach.Id}`;
        carousel.classList.add('carousel', 'relative');
        const bookLink = document.createElement('a');
        bookLink.href = '?url=chi-tiet-sach&id=' + sach.Id;
        bookDiv.appendChild(bookLink);

        if (images.length > 0) {
            images.forEach((url, index) => {
                const bookImage = document.createElement('img');
                bookImage.src = url.trim();
                bookImage.alt = sach.TuaSach;
                bookImage.classList.add('w-full', 'h-64', 'object-cover', 'rounded-lg', 'mb-4', 'carousel-item', index === 0 ? 'active' : 'hidden');
                carousel.appendChild(bookImage);
            });

            const prevButton = document.createElement('button');
            prevButton.classList.add('carousel-control-prev', 'absolute', 'left-0', 'top-1/2', 'transform', '-translate-y-1/2', 'bg-gray-700', 'text-white', 'p-2', 'rounded-full');
            prevButton.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevButton.onclick = (event) => {
                event.stopPropagation();
                prevSlide(event, sach.Id);
            };

            const nextButton = document.createElement('button');
            nextButton.classList.add('carousel-control-next', 'absolute', 'right-0', 'top-1/2', 'transform', '-translate-y-1/2', 'bg-gray-700', 'text-white', 'p-2', 'rounded-full');
            nextButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextButton.onclick = (event) => {
                event.stopPropagation();
                nextSlide(event, sach.Id);
            };

            carousel.appendChild(prevButton);
            carousel.appendChild(nextButton);
            bookDiv.appendChild(carousel);
        }

        const bookTitle = document.createElement('h3');
        bookTitle.textContent = sach.TuaSach;
        bookTitle.classList.add('text-xl', 'font-bold', 'mb-2');
        bookDiv.appendChild(bookTitle);

        const bookAuthor = document.createElement('p');
        bookAuthor.textContent = 'Tác giả: ' + sach.Ho + ' ' + sach.Ten;
        bookAuthor.classList.add('text-gray-700', 'mb-2');
        bookDiv.appendChild(bookAuthor);

        const bookPublisher = document.createElement('p');
        bookPublisher.textContent = 'Nhà xuất bản: ' + sach.TenNXB;
        bookPublisher.classList.add('text-gray-700');
        bookDiv.appendChild(bookPublisher);

        const bookActions = document.createElement('div');
        bookActions.classList.add('flex', 'mt-4', 'space-x-2');

        <?php if (isset($_SESSION['user'])): ?>
        const borrowButton = document.createElement('button');
        borrowButton.type = 'button';
        borrowButton.classList.add('bg-green-500', 'hover:bg-green-700', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded', 'flex', 'items-center');
        borrowButton.innerHTML = '<i class="fas fa-book mr-2"></i> Mượn sách';
        borrowButton.onclick = (event) => {
            event.stopPropagation();
            showBorrowForm(sach);
        };
        bookActions.appendChild(borrowButton);
        <?php endif; ?>

        const detailButton = document.createElement('a');
        detailButton.href = '?url=chi-tiet-sach&id=' + sach.Id;
        detailButton.classList.add('bg-blue-500', 'hover:bg-blue-700', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded');
        detailButton.textContent = 'Xem chi tiết';
        detailButton.onclick = (event) => {
            event.stopPropagation();
            window.location.href = '?url=chi-tiet-sach&id=' + sach.Id;
        };
        bookActions.appendChild(detailButton);

        bookDiv.appendChild(bookActions);

        return bookDiv;
    }

    function prevSlide(event, carouselId) {
        event.stopPropagation();
        const carousel = document.getElementById(`carousel-${carouselId}`);
        const items = carousel.querySelectorAll('.carousel-item');
        let activeIndex = findActiveIndex(items);

        const prevIndex = (activeIndex - 1 + items.length) % items.length;
        updateCarousel(items, activeIndex, prevIndex);
    }

    function nextSlide(event, carouselId) {
        event.stopPropagation();
        const carousel = document.getElementById(`carousel-${carouselId}`);
        const items = carousel.querySelectorAll('.carousel-item');
        let activeIndex = findActiveIndex(items);

        const nextIndex = (activeIndex + 1) % items.length;
        updateCarousel(items, activeIndex, nextIndex);
    }

    function findActiveIndex(items) {
        let activeIndex = 0;
        items.forEach((item, index) => {
            if (item.classList.contains('active')) {
                activeIndex = index;
            }
        });
        return activeIndex;
    }

    function updateCarousel(items, currentIndex, targetIndex) {
        items[currentIndex].classList.remove('active');
        items[currentIndex].classList.add('hidden');

        items[targetIndex].classList.remove('hidden');
        items[targetIndex].classList.add('active');
    }

    function displayStars(averageRating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= averageRating) {
                stars += '<i class="fas fa-star text-yellow-500"></i>';
            } else {
                stars += '<i class="far fa-star text-yellow-500"></i>';
            }
        }
        return stars;
    }


    function showBorrowForm(sach) {
        const borrowButton = document.querySelector('button[data-book-id="' + sach.Id + '"]');
        const existingForm = document.querySelector('.borrow-form');

        if (existingForm) {
            existingForm.remove();
            if (existingForm === borrowButton.nextElementSibling) {
                borrowButton.style.display = 'inline';
                document.querySelector('.overlay').remove();
                return;
            }
        }

        const overlay = document.createElement('div');
        overlay.classList.add('overlay', 'fixed', 'inset-0', 'bg-black', 'bg-opacity-50', 'z-40');
        document.body.appendChild(overlay);

        const borrowForm = document.createElement('div');
        borrowForm.classList.add('borrow-form', 'fixed', 'z-50', 'bg-white', 'p-6', 'rounded-lg', 'shadow-lg', 'flex', 'flex-col', 'items-center');
        borrowForm.style.top = '50%';
        borrowForm.style.left = '50%';
        borrowForm.style.transform = 'translate(-50%, -50%)';

        const formTitle = document.createElement('h2');
        formTitle.classList.add('text-xl', 'font-bold', 'mb-4', 'flex', 'items-center');
        formTitle.innerHTML = '<i class="fas fa-book mr-2"></i> Nhập số lượng sách muốn mượn';
        borrowForm.appendChild(formTitle);

        const quantityInputGroup = document.createElement('div');
        quantityInputGroup.classList.add('flex', 'items-center', 'mb-4');

        const quantityLabel = document.createElement('label');
        quantityLabel.classList.add('mr-2', 'font-bold');
        quantityLabel.textContent = 'Số lượng:';
        quantityInputGroup.appendChild(quantityLabel);

        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.min = 1;
        quantityInput.max = 10;
        quantityInput.value = 1;
        quantityInput.addEventListener('input', function() {
            if (this.value < 1 || !Number.isInteger(Number(this.value))) {
                this.value = 1;
            }
        });
        quantityInput.classList.add('border', 'border-gray-300', 'rounded-lg', 'px-4', 'py-2', 'focus:outline-none', 'focus:border-blue-500');
        quantityInputGroup.appendChild(quantityInput);

        borrowForm.appendChild(quantityInputGroup);

        const buttonGroup = document.createElement('div');
        buttonGroup.classList.add('flex', 'space-x-2');

        const borrowSubmitButton = document.createElement('button');
        borrowSubmitButton.type = 'button';
        borrowSubmitButton.classList.add('bg-green-500', 'hover:bg-green-700', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded', 'flex', 'items-center');
        borrowSubmitButton.innerHTML = '<i class="fas fa-check mr-2"></i> Xác nhận';
        borrowSubmitButton.addEventListener('click', function() {
            borrowBook(sach, quantityInput.value);
            closeBorrowForm(borrowForm, overlay, borrowButton);
        });
        buttonGroup.appendChild(borrowSubmitButton);

        const cancelButton = document.createElement('button');
        cancelButton.type = 'button';
        cancelButton.classList.add('bg-red-500', 'hover:bg-red-700', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded', 'flex', 'items-center');
        cancelButton.innerHTML = '<i class="fas fa-times mr-2"></i> Hủy';
        cancelButton.addEventListener('click', function() {
            closeBorrowForm(borrowForm, overlay, borrowButton);
        });
        buttonGroup.appendChild(cancelButton);

        borrowForm.appendChild(buttonGroup);

        document.body.appendChild(borrowForm);

        function closeBorrowForm(form, overlay, button) {
            button.style.display = 'inline';
            form.remove();
            overlay.remove();
        }
    }

    function borrowBook(sach, quantity) {
        const data = {
            bookId: sach.Id,
            quantity: quantity
        };

        showLoadingNotification('Đang xử lý...', quantity);

        fetch('?url=cart/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showComplaintDialog();
                } else {
                    showErrorDialog();
                }
            })
            .catch(error => {
                console.error('Lỗi khi mượn sách:', error);
                showErrorDialog();
            });
    }

    function showLoadingNotification(message, quantity) {
        const alert = document.createElement('div');
        alert.id = 'notification';
        alert.className = 'fixed left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-center py-4 px-8 font-bold rounded-lg shadow-xl bg-blue-500 flex items-center space-x-4 notification fade-in';
        alert.innerHTML = `<i class="fas fa-spinner icon animate-spin"></i> <span class="message">${message} (${quantity} quyển)...</span>`;
        document.body.appendChild(alert);
        setTimeout(() => {
            alert.classList.add('show');
        }, 10);
    }

    function showComplaintDialog() {
        const dialog = document.getElementById('complaint-dialog');
        const overlay = document.getElementById('complaint-overlay');

        dialog.classList.remove('hidden');
        overlay.classList.remove('hidden');

        setTimeout(() => {
            dialog.classList.add('hidden');
            overlay.classList.add('hidden');
        }, 1100);
        location.reload();
    }

    function showErrorDialog() {
        const dialog = document.getElementById('error-dialog');
        const overlay = document.getElementById('error-overlay');

        dialog.classList.remove('hidden');
        overlay.classList.remove('hidden');

        setTimeout(() => {
            dialog.classList.add('hidden');
            overlay.classList.add('hidden');
        }, 1100);
    }

    function toggleFavorite(button) {
        var bookId = button.getAttribute('data-book-id');
        var action = button.getAttribute('data-action');

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '?url=yeu-thich-sach/store', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        if (action === 'delete') {
                            button.setAttribute('data-action', 'store');
                            button.classList.remove('text-red-500');
                            button.classList.add('text-gray-500');
                        } else if (action === 'store') {
                            button.setAttribute('data-action', 'delete');
                            button.classList.remove('text-gray-500');
                            button.classList.add('text-red-500');
                        }
                    } else {
                        alert('Đã xảy ra lỗi khi thực hiện hành động yêu thích.');
                    }
                } else {
                    alert('Đã xảy ra lỗi ' + xhr.status);
                }
            }
        };
        xhr.send('action=' + action + '&bookId=' + bookId);
    }

    const exploreButton = document.getElementById('exploreButton');
    const featuredBooks = document.getElementById('featured-books');

    exploreButton.addEventListener('click', function() {
        featuredBooks.scrollIntoView({ behavior: 'smooth' });
    });



</script>
</body>
</html>
