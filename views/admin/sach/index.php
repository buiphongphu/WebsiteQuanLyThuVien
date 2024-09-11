<?php
$sachController = new SachController();
$sachs = $sachController->index();
$dauSachController= new DauSachController();
$dausachs = $dauSachController->index();
$allNhaXuatBan = $sachController->getAllNhaXuatBan();
$allTacGia = $sachController->getAllTacGia();
$allImageSach = $sachController->getAllImageSach();
$allTrangThai = $sachController->getAllTrangThai();
?>

<?php require_once dirname(__FILE__) . '/../layouts/head.php'; ?>
<?php require_once dirname(__FILE__) . '/../layouts/header.php'; ?>

<div class="container mx-auto flex flex-wrap py-6">
    <?php require_once dirname(__FILE__) . '/../layouts/sidebar.php'; ?>
    <main class="w-full md:w-3/4 px-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Danh Sách Sách</h2>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo $_SESSION['success_message']; ?></span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934-2.934a1 1 0 000-1.414z"/></svg>
                    </span>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['delete_message'])): ?>
                <div class="alert alert-success bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo $_SESSION['delete_message']; ?></span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934-2.934a1 1 0 000-1.414z"/></svg>
                    </span>
                </div>
                <?php unset($_SESSION['delete_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-success bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo $_SESSION['error_message']; ?></span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none';">
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934-2.934a1 1 0 000-1.414z"/></svg>
                    </span>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-4">
                <a href="?url=admin/quanlydausach/add" class="bg-blue-500 text-white p-2 rounded-md flex items-center">
                    <i class="fas fa-plus mr-1"></i> Thêm Sách
                </a>
                <div class="flex items-center">
                    <input type="text" id="searchInput" name="keyword" class="border border-gray-300 p-2 rounded-md" placeholder="Tìm kiếm sách...">
                    <button id="searchBtn" class="bg-blue-500 text-white p-2 rounded-md ml-2">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>

            <div id="searchResults">
                <?php if (!empty($sachs)): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                            <thead>
                            <tr>
                                <th class="py-2 px-3 border-b border-gray-300 text-left">ID</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left">Tựa Sách</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left">Năm Xuất Bản</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left">Số Lượng</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left">Hình ảnh</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left">Trạng Thái</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left">Hành Động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sachs as $sach): ?>
                                <?php
                                $trangThai = $allTrangThai[$sach['id_trangthai']];
                                ?>
                                <tr class="hover:bg-gray-100">
                                    <td class="py-2 px-3 border-b border-gray-300"><?php echo $sach['Id']; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300"><?php echo $sach['TuaSach']; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300"><?php echo $sach['namxb']; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300"><?php echo $sach['soluong']; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300">
                                        <div class="flex items-center space-x-2">
                                            <button id="prevBtn" class="text-blue-500 underline hidden" onclick="navigateImages('prev')">←</button>
                                            <div class="flex overflow-hidden">
                                                <?php foreach ($allImageSach as $image): ?>
                                                    <?php if ($image['id_dausach'] == $sach['Id_DauSach']): ?>
                                                        <img src="<?php echo $image['Url']; ?>" alt="<?php echo $image['TenHinh']; ?>" class="w-10 h-10 object-cover rounded-full inline-block">
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </div>
                                            <button id="nextBtn" class="text-blue-500 underline hidden" onclick="navigateImages('next')">→</button>
                                        </div>
                                    </td>
                                    <td class="py-2 px-3 border-b border-gray-300"><?php echo $trangThai['tentrangthai']; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300 flex space-x-2">
                                        <a href="?url=admin/quanlydausach/edit&id=<?php echo $sach['Id']; ?>" class="bg-blue-500 text-white p-2 rounded-md flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Sửa
                                        </a>
                                        <?php foreach ($dausachs as $dausach): ?>
                                            <?php if ($dausach['Id'] == $sach['Id_DauSach']): ?>
                                                <button class="bg-red-500 text-white p-2 rounded-md flex items-center" onclick="confirmDelete(<?php echo $dausach['Id'] ?>)">
                                                    <i class="fas fa-trash-alt mr-1"></i> Xóa
                                                </button>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Không có sách nào được tìm thấy.</p>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<!-- Modal xác nhận xóa -->
<div id="deleteModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-xl p-6">
            <h2 class="text-xl font-bold mb-4">Xác nhận xóa</h2>
            <p>Bạn có chắc chắn muốn xóa sách này không?</p>
            <div class="mt-4 flex justify-end">
                <button class="bg-gray-500 text-white p-2 rounded-md mr-2" onclick="closeModal()">Hủy</button>
                <a id="confirmDeleteBtn" href="#" class="bg-red-500 text-white p-2 rounded-md">Xóa</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Hàm xác nhận xóa
    function confirmDelete(id) {
        var modal = document.getElementById('deleteModal');
        modal.classList.remove('hidden');
        var confirmBtn = document.getElementById('confirmDeleteBtn');
        confirmBtn.href = "?url=admin/quanlydausach/delete&id=" + id;
    }

    // Hàm đóng modal
    function closeModal() {
        var modal = document.getElementById('deleteModal');
        modal.classList.add('hidden');
    }

    // Hàm điều hướng hình ảnh
    var currentIndex = 0;
    var images = [];

    function navigateImages(direction) {
        if (direction === 'prev') {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
        } else {
            currentIndex = (currentIndex + 1) % images.length;
        }
        showCurrentImage();
    }

    function showCurrentImage() {
        var image = images[currentIndex];
        var imageElement = document.querySelector('.image-item');
        if (image && imageElement) {
            imageElement.src = image.Url;
            imageElement.alt = image.TenHinh;
        }
        updateNavigationButtons();
    }

    function updateNavigationButtons() {
        var prevBtn = document.getElementById('prevBtn');
        var nextBtn = document.getElementById('nextBtn');
        if (currentIndex === 0) {
            prevBtn.classList.add('hidden');
        } else {
            prevBtn.classList.remove('hidden');
        }
        if (currentIndex === images.length - 1) {
            nextBtn.classList.add('hidden');
        } else {
            nextBtn.classList.remove('hidden');
        }
    }

    function showAllImages(imgs) {
        images = imgs;
        currentIndex = 0;
        showCurrentImage();
        var modal = document.getElementById('imageModal');
        modal.classList.remove('hidden');
    }

    // Hàm tìm kiếm sách
    async function searchSach() {
        const keyword = document.getElementById('searchInput').value;
        try {
            const response = await fetch('?url=admin/quanlysach/search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'keyword=' + encodeURIComponent(keyword),
            });
            const data = await response.json();
            const searchResults = document.getElementById('searchResults');
            searchResults.innerHTML = '';

            if (data.length > 0) {
                const table = document.createElement('table');
                table.className = 'min-w-full bg-white border border-gray-300 rounded-lg overflow-x-auto';
                const thead = document.createElement('thead');
                thead.innerHTML = `
            <tr>
                <th class="py-2 px-3 border-b border-gray-300 text-left">ID</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Tựa Sách</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Năm Xuất Bản</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Tác Giả</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Nhà Xuất Bản</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Số Lượng</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Hình Ảnh</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Trạng Thái</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Hành Động</th>
            </tr>
            `;
                table.appendChild(thead);
                const tbody = document.createElement('tbody');

                for (const sach of data) {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-gray-100';
                    tr.innerHTML = `
                <td class="py-2 px-3 border-b border-gray-300">${sach.Id}</td>
                <td class="py-2 px-3 border-b border-gray-300">${sach.TuaSach}</td>
                <td class="py-2 px-3 border-b border-gray-300">${sach.namxb}</td>
                <td class="py-2 px-3 border-b border-gray-300">${sach.Ho} ${sach.Ten}</td>
                <td class="py-2 px-3 border-b border-gray-300">${sach.TenNXB}</td>
                <td class="py-2 px-3 border-b border-gray-300">${sach.soluong}</td>
                <td class="py-2 px-3 border-b border-gray-300">
                    <div class="flex items-center overflow-x-auto">
                        <button id="prevBtn" class="text-blue-500 underline mr-2 hidden" onclick="navigateImages('prev')">←</button>
                        ${sach.images && Array.isArray(sach.images.split(',')) ? sach.images.split(',').map(image => `<img src="${image}" class="w-10 h-10 object-cover rounded-full inline-block image-item">`).join('') : ''}
                        <button id="nextBtn" class="text-blue-500 underline ml-2 hidden" onclick="navigateImages('next')">→</button>
                    </div>
                </td>
                <td class="py-2 px-3 border-b border-gray-300">${sach.TenTrangThai}</td>
                <td class="py-2 px-3 border-b border-gray-300 flex space-x-2">
                    <a href="?url=admin/quanlysach/edit&id=${sach.Id}" class="bg-blue-500 text-white p-2 rounded-md flex items-center">
                        <i class="fas fa-edit mr-1"></i> Sửa
                    </a>
                    <button class="bg-red-500 text-white p-2 rounded-md flex items-center" onclick="confirmDelete(${sach.Id})">
                        <i class="fas fa-trash-alt mr-1"></i> Xóa
                    </button>
                </td>
                `;
                    tbody.appendChild(tr);
                }

                table.appendChild(tbody);
                searchResults.appendChild(table);

                // Thêm thanh cuộn dọc nếu nội dung vượt quá kích thước khung chứa
                searchResults.style.overflowY = 'auto';
                searchResults.style.maxHeight = '400px'; // Điều chỉnh độ cao tối đa của khung chứa

            } else {
                searchResults.innerHTML = '<p>Không có sách nào được tìm thấy.</p>';
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }


    document.getElementById('searchBtn').addEventListener('click', function (event) {
        event.preventDefault();
        searchSach();
    });
</script>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
