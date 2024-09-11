<?php

function showBorrowButton($sach) {
    if (isset($_SESSION['user'])) {
        return '<button onclick="showBorrowForm(' . htmlspecialchars(json_encode($sach), ENT_QUOTES, 'UTF-8') . ')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Mượn</button>';
    }
    return '';
}

$sachController = new SachController();
$sachId = isset($_GET['id']) ? $_GET['id'] : 0;
if ($sachId == 0) {
    header('Location: ?url=index');
}
$sach = $sachController->getChiTietSach($sachId);
$trangThaiController = new TrangThaiController();
$trangThai = $trangThaiController->getTrangThaiById($sach['id_trangthai']);
$sach['tinhtrang'] = $trangThai['tentrangthai'];
if (!$sach) {
    header('Location: ?url=index');
}

function hideButton() {
    if (!isset($_SESSION['user'])) {
        return 'hidden';
    }
    return '';
}
function formatDate($date) {
    return date('d/m/Y', strtotime($date));
}

function getStatusClass($status) {
    switch ($status) {
        case 'còn':
            return 'bg-green-500';
        case 'hết':
            return 'bg-red-500';
        case 'hỏng':
            return 'bg-yellow-500';
        default:
            return 'bg-gray-500';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once dirname(__FILE__).'/../layouts/head.php'; ?>
    <style>
        .transition-transform {
            transition: transform 0.3s;
        }
        .hover-zoom:hover {
            transform: scale(1.05);
        }
        .status-indicator {
            width: 1rem;
            height: 1rem;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }
        .carousel-item {
            display: none;
        }
        .carousel-item.active {
            display: block;
        }
    </style>
</head>
<body class="bg-gray-100">

<?php require_once dirname(__FILE__).'/../layouts/header.php'; ?>
<?php if (isset($_SESSION['alert-success'])): ?>
    <div id="success-dialog" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-black bg-opacity-80 rounded-lg p-10 shadow-lg bg-green-600 w-1/2 max-w-lg h-auto">
            <div class="flex items-center mb-6">
                <i class="fas fa-check-circle text-gray-100 text-4xl mr-3 glow-green"></i>
                <h2 class="text-2xl font-bold text-white">Thông báo thành công</h2>
            </div>
            <p class="text-lg text-white"><?php echo $_SESSION['alert-success']; ?></p>
            <script>
                setTimeout(() => {
                    document.getElementById('success-dialog').style.display = 'none';
                }, 1100);
            </script>
        </div>
    </div>
    <?php unset($_SESSION['alert-success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['alert-error'])): ?>
    <div id="error-dialog" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-black bg-opacity-80 rounded-lg p-10 shadow-lg bg-neon-red w-1/2 max-w-lg h-auto">
            <div class="flex items-center mb-6">
                <i class="fas fa-times-circle text-neon-red text-4xl mr-3 glow-red"></i>
                <h2 class="text-2xl font-bold text-white">Thông báo thất bại</h2>
            </div>
            <p class="text-lg text-white"><?php echo $_SESSION['alert-error']; ?></p>
            <script>
                setTimeout(() => {
                    document.getElementById('error-dialog').style.display = 'none';
                }, 1100);
            </script>
        </div>
    </div>
    <?php unset($_SESSION['alert-error']); ?>
<?php endif; ?>


<div class="h-8"></div>

<section class="book-detail mb-8">
    <div class="container mx-auto p-6 p-6 bg-gradient-to-r from-indigo-300 to-purple-300 shadow-md rounded-lg">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php if (!empty($sach['images'])): ?>
                <div class="carousel relative" id="carousel-<?php echo $sach['Id']; ?>">
                    <div class="carousel-inner relative overflow-hidden w-full">
                        <?php foreach (explode(',', $sach['images']) as $index => $image): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img src="<?php echo htmlspecialchars($image, ENT_QUOTES, 'UTF-8'); ?>" alt="Image" class="w-full h-64 object-cover rounded-lg mb-4">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-prev absolute top-1/2 left-0 transform -translate-y-1/2 bg-white text-gray-700 p-2 rounded-full hover:bg-gray-200" onclick="prevSlide(<?php echo $sach['Id']; ?>)">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="carousel-next absolute top-1/2 right-0 transform -translate-y-1/2 bg-white text-gray-700 p-2 rounded-full hover:bg-gray-200" onclick="nextSlide(<?php echo $sach['Id']; ?>)">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            <?php else: ?>
                <div class="w-full h-64 bg-gray-300 rounded-lg mb-4"></div>
            <?php endif; ?>
            <div class="lg:w-2/3">
                <h1 class="text-4xl font-bold text-gray-900"><?= htmlspecialchars($sach['TuaSach'], ENT_QUOTES, 'UTF-8') ?></h1>
                <div class="mt-4 space-y-2 text-lg text-gray-700">
                    <p><strong>Tác giả:</strong> <?= htmlspecialchars($sach['Ho'], ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($sach['Ten'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Nhà xuất bản:</strong> <?= htmlspecialchars($sach['TenNXB'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Tên đầu sách:</strong> <?= htmlspecialchars($sach['TuaSach'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Thể loại:</strong> <?= htmlspecialchars($sach['TenLoai'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p><strong>Năm xuất bản:</strong> <?= htmlspecialchars($sach['namxb'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="mt-4">
                    <h2 class="text-xl font-bold text-gray-900">Tình trạng sách</h2>
                    <p class="text-lg text-gray-700 flex items-center">
                        <span class="status-indicator <?= htmlspecialchars(getStatusClass($sach['tinhtrang']), ENT_QUOTES, 'UTF-8') ?>"></span>
                        <?= htmlspecialchars($sach['tinhtrang'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </div>
                <div class="mt-6 flex flex-wrap gap-4">
                    <?php if (isset($_SESSION['user'])): ?>
                        <button onclick="showBorrowForm(<?php echo htmlspecialchars(json_encode($sach), ENT_QUOTES, 'UTF-8'); ?>)" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            <i class="fas fa-shopping-cart"></i>
                             Mượn</button>
                    <?php endif; ?>

                    <a href="?url=danh-gia&id=<?= htmlspecialchars($sach['Id'], ENT_QUOTES, 'UTF-8') ?>" class="px-4 py-2 bg-yellow-500 text-white rounded shadow-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-opacity-50">
                        <i class="fas fa-star"></i> Đánh giá
                    </a>
                    <a href="?url=index" class="px-4 py-2 bg-gray-600 text-white rounded shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container mx-auto p-6 bg-gray-300 shadow-md rounded-lg mb-8">
    <div class="flex flex-col md:flex-row gap-6">
        <div class="md:w-2/3">
            <?php
            $binhLuanController = new BinhLuanController();
            $stmt = $binhLuanController->getBinhLuanBySach($sach['Id']);
            $docGiaController = new DocGiaController();

            if (count($stmt) > 0) {
                foreach ($stmt as $binhLuan) {
                    $hoten = $docGiaController->getDocGiaById($binhLuan['Id_DocGia']);
                    $hoten = $hoten['Ho'] . ' ' . $hoten['Ten'];
                    ?>
                    <div class="relative bg-gray-100 rounded-lg shadow-lg p-4 mb-4 overflow-hidden group">
                        <p class="font-semibold text-indigo-600"><?= htmlspecialchars($hoten, ENT_QUOTES, 'UTF-8') ?>:</p>
                        <p class="text-gray-700"><?= htmlspecialchars($binhLuan['NoiDung'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p class="text-gray-500 text-sm mt-2"><?= htmlspecialchars(formatDate($binhLuan['NgayBinhLuan']), ENT_QUOTES, 'UTF-8') ?></p>
                        <div class="absolute inset-0 bg-blue-400 opacity-0 transition-opacity duration-500 group-hover:opacity-50"></div>
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            <div class="absolute inset-0 neon-ripple rounded-lg"></div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p class='text-gray-500 mt-4'>Chưa có bình luận nào.</p>";
            }
            ?>
        </div>

        <div class="md:w-1/3 p-6 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold text-white mb-4">Thêm Bình Luận</h2>
            <form action="?url=binh-luan/store&id=<?= htmlspecialchars($sachId, ENT_QUOTES, 'UTF-8') ?>" method="post">
                <textarea name="noidung" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-white placeholder-gray-500 bg-white text-gray-900" placeholder="Nội dung bình luận..."></textarea>
                <button type="submit" class="w-full mt-4 px-4 py-2 bg-white text-indigo-600 font-bold rounded-lg shadow-md hover:bg-indigo-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-opacity-50 transition duration-300 ease-in-out">
                    <i class="fas fa-paper-plane"></i>
                     Gửi bình luận</button>
            </form>
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

    .bg-neon-purple{
        background: linear-gradient(45deg, #f5f4ec, #2d2a2b);
    }


</style>


<script>


    let currentSlide = 0;

    function showSlide(carouselId, slideIndex) {
        const carousel = document.getElementById(`carousel-${carouselId}`);
        const slides = carousel.querySelectorAll('.carousel-item');
        if (slideIndex >= slides.length) {
            currentSlide = 0;
        } else if (slideIndex < 0) {
            currentSlide = slides.length - 1;
        } else {
            currentSlide = slideIndex;
        }
        slides.forEach((slide, index) => {
            slide.classList.toggle('active', index === currentSlide);
        });
    }

    function prevSlide(carouselId) {
        showSlide(carouselId, currentSlide - 1);
    }

    function nextSlide(carouselId) {
        showSlide(carouselId, currentSlide + 1);
    }

    function showModal(content) {
        const modal = document.createElement('div');
        modal.classList.add('fixed', 'inset-0', 'bg-gray-900', 'bg-opacity-50', 'flex', 'items-center', 'justify-center');
        modal.innerHTML = `<div class="bg-white p-4 rounded-lg">${content}</div>`;
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });
        document.body.appendChild(modal);
    }

    function closeModal() {
        const modal = document.querySelector('.fixed.inset-0');
        if (modal) {
            modal.remove();
        }
    }
    function showBorrowForm(sach) {
        const borrowButton = document.querySelector('button[data-book-id="' + sach.Id + '"]');
        const existingForm = document.querySelector('.borrow-form');

        if (existingForm) {
            if (existingForm.dataset.bookId === sach.Id.toString()) {
                existingForm.remove();
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
        borrowForm.dataset.bookId = sach.Id;

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
        quantityInput.value = 1;
        quantityInput.classList.add('border', 'border-gray-300', 'rounded-lg', 'px-4', 'py-2', 'focus:outline-none', 'focus:border-blue-500');
        quantityInput.addEventListener('input', function() {
            if (quantityInput.value < 1) {
                quantityInput.value = 1;
            }
            quantityInput.value = Math.floor(quantityInput.value);
        });
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

    }


    function closeBorrowForm(form, overlay, button) {
        if (form) {
            form.remove();
        }
        if (overlay) {
            overlay.remove();
        }
        if (button) {
            button.style.display = 'inline';
        }
    }

    function borrowBook(sach, quantity) {
        const data = {
            bookId: sach.Id,
            quantity: quantity
        };

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

</script>

</body>
<?php require_once dirname(__FILE__).'/../layouts/footer.php'; ?>
</html>
