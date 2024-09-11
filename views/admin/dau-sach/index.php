<?php

require_once dirname(__FILE__).'/../layouts/head.php';
require_once dirname(__FILE__).'/../layouts/header.php';


$dauSachController = new DauSachController();
$dauSachs = $dauSachController->index();
function formatDate($date)
{
    return date('d/m/Y', strtotime($date));
}



?>

<div class="container mx-auto flex flex-wrap py-6">
    <?php require_once dirname(__FILE__).'/../layouts/sidebar.php'; ?>
    <main class="w-full md:w-3/4 px-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Danh Sách Đầu Sách</h2>

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
                        <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 00-1.414 0L10 8.586 7.066 5.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 11.414l2.934-2.934a1 1 0 000-1.414z"/></svg>
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
                <a href="?url=admin/quanlydausach/add" class="bg-blue-500 text-white p-2 rounded-md mb-4 inline-block">
                    <i class="fas fa-plus"></i> Thêm Đầu Sách
                </a>
                <div class="flex items-center">
                    <input type="text" id="searchInput" name="keyword" class="border border-gray-300 p-2 rounded-md" placeholder="Tìm kiếm đầu sách...">
                    <button id="searchBtn" class="bg-blue-500 text-white p-2 rounded-md ml-2">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div id="searchResults">
                <?php if (!empty($dauSachs)): ?>
                    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                            <thead>
                            <tr class="bg-gray-50">
                                <th class="py-2 px-3 border-b border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tựa Sách</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tác Giả</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Năm Xuất Bản</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nhà Xuất Bản</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số Lượng</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày Nhập</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loại Sách</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hình Ảnh</th>
                                <th class="py-2 px-3 border-b border-gray-300 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hành Động</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($dauSachs as $dauSach): ?>
                                <tr class="hover:bg-gray-100">
                                    <td class="py-2 px-3 border-b border-gray-300 text-sm text-gray-900"><?php echo $dauSach['Id']; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300 text-sm text-gray-900"><?php echo $dauSach['TuaSach']; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300 text-sm text-gray-900"><?php echo $dauSach['HoTenTacGia']; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300 text-sm text-gray-900"><?php echo $dauSach['namxb']; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300 text-sm text-gray-900"><?php echo $dauSach['TenNXB']; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300 text-sm text-gray-900"><?php echo $dauSach['soluong']; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300 text-sm text-gray-900"><?php echo formatDate($dauSach['ngaynhap']); ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300 text-sm text-gray-900"><?php echo isset($dauSach['TenLoaiSach']) ? $dauSach['TenLoaiSach'] : 'Chưa có loại'; ?></td>
                                    <td class="py-2 px-3 border-b border-gray-300 text-sm text-gray-900">
                                        <?php if (isset($dauSach['images']) && !empty($dauSach['images'])): ?>
                                            <div class="carousel relative" id="carousel-<?php echo $dauSach['Id']; ?>">
                                                <div class="carousel-inner relative overflow-hidden w-full">
                                                    <?php
                                                    $imageLinks = explode(',', $dauSach['images']);
                                                    foreach ($imageLinks as $index => $image): ?>
                                                        <div class="carousel-item <?php echo $index === 0 ? 'active' : 'hidden'; ?>">
                                                            <img src="<?php echo $image; ?>" alt="Image" class="w-20 h-20 object-cover">
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <button class="carousel-prev absolute top-1/2 left-0 transform -translate-y-1/2 bg-white text-gray-700 p-2 rounded-full hover:bg-gray-200" onclick="prevSlide(<?php echo $dauSach['Id']; ?>)">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                                <button class="carousel-next absolute top-1/2 right-0 transform -translate-y-1/2 bg-white text-gray-700 p-2 rounded-full hover:bg-gray-200" onclick="nextSlide(<?php echo $dauSach['Id']; ?>)">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500">No images available</p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-2 px-3 border-b border-gray-300 flex space-x-2">
                                        <a href="?url=admin/quanlydausach/edit&id=<?php echo $dauSach['Id']; ?>" class="bg-blue-500 text-white p-2 rounded-md flex items-center">
                                            <i class="fas fa-edit mr-1"></i> Sửa
                                        </a>
                                        <button class="bg-red-500 text-white p-2 rounded-md flex items-center" onclick="confirmDelete(<?php echo $dauSach['Id']; ?>)">
                                            <i class="fas fa-trash-alt mr-1"></i> Xóa
                                        </button>
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
<div id="deleteModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Xóa Đầu Sách</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">Bạn có chắc chắn muốn xóa đầu sách này? Thao tác này không thể hoàn tác.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="confirmDeleteBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Xóa
                </button>
                <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Hủy
                </button>
            </div>
        </div>
    </div>
</div>

<?php require_once dirname(__FILE__).'/../layouts/footer.php'; ?>

<script>
    function confirmDelete(id) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('confirmDeleteBtn').onclick = function () {
            window.location.href = '?url=admin/quanlydausach/delete&id=' + id;
        };
    }


    async function searchDauSach() {
        const keyword = document.getElementById('searchInput').value;
        try {
            const response = await fetch('?url=admin/quanlydausach/search', {
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
                table.className = 'min-w-full bg-white border border-gray-300 rounded-lg';
                const thead = document.createElement('thead');
                thead.innerHTML = `
            <tr>
                <th class="py-2 px-3 border-b border-gray-300 text-left">ID</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Tựa Sách</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Tác Giả</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Năm Xuất Bản</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Nhà Xuất Bản</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Số Lượng</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Ngày Nhập</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Loại Sách</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Hình Ảnh</th>
                <th class="py-2 px-3 border-b border-gray-300 text-left">Hành Động</th>
            </tr>
            `;
                table.appendChild(thead);
                const tbody = document.createElement('tbody');

                for (const dauSach of data) {
                    const tr = document.createElement('tr');
                    tr.className = 'hover:bg-gray-100';
                    tr.innerHTML = `
                <td class="py-2 px-3 border-b border-gray-300">${dauSach.Id}</td>
                <td class="py-2 px-3 border-b border-gray-300">${dauSach.TuaSach}</td>
                <td class="py-2 px-3 border-b border-gray-300">${dauSach.HoTenTacGia}</td>
                <td class="py-2 px-3 border-b border-gray-300">${dauSach.namxb}</td>
                <td class="py-2 px-3 border-b border-gray-300">${dauSach.TenNXB}</td>
                <td class="py-2 px-3 border-b border-gray-300">${dauSach.soluong}</td>
                <td class="py-2 px-3 border-b border-gray-300">${dauSach.ngaynhap}</td>
                <td class="py-2 px-3 border-b border-gray-300">${dauSach.TenLoaiSach ? dauSach.TenLoaiSach : 'Chưa có loại'}</td>
                <td class="py-2 px-3 border-b border-gray-300">
                    ${dauSach.images ? `
                        <div class="carousel relative" id="carousel-${dauSach.Id}" style="max-height: 200px; overflow-y: auto;">
                            <div class="carousel-inner relative overflow-hidden w-full">
                                ${dauSach.images.split(',').map((image, index) => `
                                    <div class="carousel-item ${index === 0 ? 'active' : 'hidden'}">
                                        <img src="${image}" alt="Image" class="w-20 h-20 object-cover">
                                    </div>
                                `).join('')}
                            </div>
                            <button class="carousel-prev absolute top-1/2 left-0 transform -translate-y-1/2 bg-white text-gray-700 p-2 rounded-full hover:bg-gray-200" onclick="prevSlide(${dauSach.Id})">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button class="carousel-next absolute top-1/2 right-0 transform -translate-y-1/2 bg-white text-gray-700 p-2 rounded-full hover:bg-gray-200" onclick="nextSlide(${dauSach.Id})">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    ` : 'No images available'}
                </td>
                <td class="py-2 px-3 border-b border-gray-300 flex space-x-2">
                    <a href="?url=admin/quanlydausach/edit&id=${dauSach.Id}" class="bg-blue-500 text-white p-2 rounded-md flex items-center">
                        <i class="fas fa-edit mr-1"></i> Sửa
                    </a>
                    <button class="bg-red-500 text-white p-2 rounded-md flex items-center" onclick="confirmDelete(${dauSach.Id})">
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
                searchResults.innerHTML = '<p>Không có đầu sách nào được tìm thấy.</p>';
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }


    document.getElementById('searchBtn').addEventListener('click', function (event) {
        event.preventDefault();
        searchDauSach();
    });


    function closeModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function nextSlide(carouselId) {
        const carousel = document.getElementById('carousel-' + carouselId);
        const activeSlide = carousel.querySelector('.carousel-item.active');
        let nextSlide = activeSlide.nextElementSibling;
        if (!nextSlide || !nextSlide.classList.contains('carousel-item')) {
            nextSlide = carousel.querySelector('.carousel-item:first-child');
        }
        activeSlide.classList.add('hidden');
        activeSlide.classList.remove('active');
        nextSlide.classList.remove('hidden');
        nextSlide.classList.add('active');
    }

    function prevSlide(carouselId) {
        const carousel = document.getElementById('carousel-' + carouselId);
        const activeSlide = carousel.querySelector('.carousel-item.active');
        let prevSlide = activeSlide.previousElementSibling;
        if (!prevSlide || !prevSlide.classList.contains('carousel-item')) {
            prevSlide = carousel.querySelector('.carousel-item:last-child');
        }
        activeSlide.classList.add('hidden');
        activeSlide.classList.remove('active');
        prevSlide.classList.remove('hidden');
        prevSlide.classList.add('active');
    }


</script>

