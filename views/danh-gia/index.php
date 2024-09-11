<?php
if (!isset($_SESSION['user'])) {
    header("Location: ?url=login");
    exit();
}

$sachId = $_GET['id'];
$sachController = new SachController();
$sach = $sachController->getChiTietSach($sachId);
$imageUrls = explode(',', $sach['images']);
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once dirname(__FILE__) . '/../layouts/head.php'; ?>
<body class="bg-gray-50 text-gray-900">
<?php require_once dirname(__FILE__) . '/../layouts/header.php'; ?>
<style>
    .text-primary {
        color: #1d4ed8;
    }

    .bg-primary {
        background-color: #1d4ed8;
        color: #ffffff;
    }

    .hover-bg-primary:hover {
        background-color: #1e40af;
    }

    .star-rating input[type="radio"] + label {
        color: #e8d23c;
    }

    .star-rating input[type="radio"]:checked + label,
    .star-rating input[type="radio"] + label:hover {
        color: #f59e0b; olor */
    }

    .text-yellow {
        color: #f59e0b;
    }

    .carousel-container {
        position: relative;
        width: 100%;
        height: 300px;
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .carousel-container img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: opacity 0.5s ease-in-out;
        opacity: 0;
    }

    .carousel-container img.active {
        opacity: 1;
    }

    .carousel-button {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.4);
        color: #ffffff;
        border: none;
        border-radius: 50%;
        padding: 12px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .carousel-button:hover {
        background-color: rgba(0, 0, 0, 0.6);
    }

    .carousel-button.prev {
        left: 10px;
    }

    .carousel-button.next {
        right: 10px;
    }
</style>

<div class="container mx-auto p-8">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-6 text-center text-primary">Đánh Giá Sách: <?php echo htmlspecialchars($sach['TuaSach']); ?></h1>

        <div class="relative mb-8 carousel-container">
            <?php foreach ($imageUrls as $index => $imageUrl): ?>
                <img src="<?php echo htmlspecialchars($imageUrl); ?>" alt="<?php echo htmlspecialchars($sach['TuaSach']); ?>" class="<?php echo $index === 0 ? 'active' : ''; ?>">
            <?php endforeach; ?>
            <button id="prevBtn" class="carousel-button prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button id="nextBtn" class="carousel-button next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

        <form action="?url=danh-gia/store" method="POST">
            <input type="hidden" name="sach_id" value="<?php echo htmlspecialchars($sachId); ?>">

            <div class="mb-6">
                <label for="diem" class="block text-gray-700 text-sm font-semibold mb-2">Điểm:</label>
                <div class="star-rating flex space-x-2">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <input type="radio" name="diem" id="diem_<?php echo $i; ?>" value="<?php echo $i; ?>" class="hidden" required>
                        <label for="diem_<?php echo $i; ?>" class="fas fa-star text-yellow text-2xl cursor-pointer transition duration-200"></label>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="mb-6">
                <label for="noi_dung" class="block text-gray-700 text-sm font-semibold mb-2">Nội Dung:</label>
                <textarea name="noi_dung" id="noi_dung" required class="shadow appearance-none border rounded w-full py-3 px-4 text-gray-900 leading-tight focus:outline-none focus:shadow-outline bg-gray-100"></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-primary hover-bg-primary text-white font-bold py-3 px-6 rounded focus:outline-none shadow-md transition duration-200">
                    <i class="fas fa-paper-plane"></i> Gửi Đánh Giá
                </button>
                <a href="?url=chi-tiet-sach&id=<?php echo htmlspecialchars($sachId); ?>" class="inline-block font-semibold text-sm text-primary hover:text-gray-700 transition duration-200">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const stars = document.querySelectorAll('.star-rating label');

        stars.forEach(function(star, index) {
            star.addEventListener('mouseover', function() {
                resetStars();
                highlightStars(index);
            });

            star.addEventListener('mouseleave', function() {
                resetStars();
                const rated = document.querySelector('.star-rating input:checked + label');
                if (rated) {
                    const index = Array.from(stars).indexOf(rated);
                    highlightStars(index);
                }
            });

            star.addEventListener('click', function() {
                const rating = index + 1;
                const ratingElement = document.getElementById('diem_' + rating);
                if (ratingElement) {
                    ratingElement.checked = true;
                }
                resetStars();
                highlightStars(index);
            });
        });

        function resetStars() {
            stars.forEach(function(star) {
                star.classList.remove('fas');
                star.classList.add('far');
            });
        }

        function highlightStars(index) {
            for (let i = 0; i <= index; i++) {
                if (stars[i]) {
                    stars[i].classList.remove('far');
                    stars[i].classList.add('fas');
                }
            }
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        const images = document.querySelectorAll('.carousel-container img');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        let currentIndex = 0;

        function showImage(index) {
            images.forEach((img, i) => {
                img.classList.toggle('active', i === index);
            });
        }

        prevBtn.addEventListener('click', function() {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            showImage(currentIndex);
        });

        nextBtn.addEventListener('click', function() {
            currentIndex = (currentIndex + 1) % images.length;
            showImage(currentIndex);
        });

        showImage(currentIndex);
    });
</script>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
</body>
</html>
