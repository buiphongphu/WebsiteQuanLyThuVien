<?php
if (!isset($_SESSION['user'])) {
    header('Location: ?url=login');
    exit;
}

$user_id = $_SESSION['user']['Id'];
$yeuThichSach = new YeuThichSachController();
$favoriteBooks = $yeuThichSach->getFavoriteBooks($user_id);

// Group books by 'book_id' to handle multiple images for the same book
$groupedBooks = [];
foreach ($favoriteBooks as $book) {
    $bookId = $book['book_id'];
    if (!isset($groupedBooks[$bookId])) {
        $groupedBooks[$bookId] = [
            'book_id' => $book['book_id'],
            'TuaSach' => $book['TuaSach'],
            'Ho' => $book['Ho'],
            'Ten' => $book['Ten'],
            'TenNXB' => $book['TenNXB'],
            'images' => []
        ];
    }
    $groupedBooks[$bookId]['images'][] = $book['Url'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once dirname(__FILE__) . '/../layouts/head.php'; ?>
    <title>Sách Yêu Thích</title>
</head>
<body class="bg-gray-100">

<?php require_once dirname(__FILE__) . '/../layouts/header.php'; ?>

<main class="container mx-auto px-4 py-8">

    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Sách Yêu Thích</h2>
        <div id="favorite-books" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php if (!empty($groupedBooks)): ?>
                <?php foreach ($groupedBooks as $book): ?>
                    <div class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                        <a href="?url=chi-tiet-sach&id=<?php echo htmlspecialchars($book['book_id']); ?>">
                            <?php if (!empty($book['images'][0])): ?>
                                <img src="<?php echo htmlspecialchars($book['images'][0]); ?>" alt="<?php echo htmlspecialchars($book['TuaSach']); ?>"
                                     class="w-full h-64 object-cover rounded-lg mb-4">
                            <?php else: ?>
                                <div class="w-full h-64 bg-gray-300 rounded-lg mb-4"></div>
                            <?php endif; ?>
                            <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($book['TuaSach']); ?></h3>
                            <p class="text-gray-700 mb-2">Tác giả: <?php echo htmlspecialchars($book['Ho'] . ' ' . $book['Ten']); ?></p>
                            <p class="text-gray-700">Nhà xuất bản: <?php echo htmlspecialchars($book['TenNXB']); ?></p>
                        </a>
                        <div class="flex mt-4 space-x-2">
                            <form action="?url=yeu-thich-sach/delete" method="post" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sách này khỏi danh sách yêu thích không?');">
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-heart-broken"></i> Xóa khỏi yêu thích
                                </button>
                                <input type="hidden" name="bookId" value="<?php echo htmlspecialchars($book['book_id']); ?>">
                                <input type="hidden" name="action" value="delete">
                            </form>
                            <a href="?url=chi-tiet-sach&id=<?php echo htmlspecialchars($book['book_id']); ?>"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-info-circle"></i> Xem chi tiết
                            </a>
                        </div>
                        <?php if (count($book['images']) > 1): ?>
                            <div class="mt-4">
                                <h4 class="font-bold">Xem thêm hình ảnh:</h4>
                                <div class="grid grid-cols-2 gap-2 mt-2">
                                    <?php foreach (array_slice($book['images'], 1) as $image): ?>
                                        <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($book['TuaSach']); ?>"
                                             class="w-full h-32 object-cover rounded-lg">
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center mt-4">Không có sách nào trong danh sách yêu thích.</p>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>

</body>
</html>
