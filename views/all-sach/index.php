<?php
$sachController = new SachController();
function showBorrowButton($sach) {
    if (isset($_SESSION['user'])) {
        return '<button onclick="showBorrowForm(' . htmlspecialchars(json_encode($sach)) . ')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
<i class="fas fa-shopping-cart"></i>
 Mượn</button>';
    }
    return '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once dirname(__FILE__).'/../layouts/head.php'; ?>
</head>
<body class="bg-gray-100">

<?php require_once dirname(__FILE__).'/../layouts/header.php'; ?>

<main class="container mx-auto px-4 py-8">
    <section class="mb-8">
        <h2 class="text-2xl font-bold mb-4">Tất cả các sách</h2>
        <div id="featured-books" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php
            $danhGiaController = new DanhGiaController();
            $allBooks = $sachController->index();

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

            foreach ($allBooks as $sach):
                $isFavorite = isFavorite($sach['Id']);
                $averageRating = $danhGiaController->getAverageRating($sach['Id']);
                ?>
                <div class="relative bg-white p-4 rounded-lg shadow-md hover:shadow-lg transform hover:scale-105 transition duration-300 ease-in-out">
                    <?php if (!empty($sach['images'])): ?>
                        <div class="carousel relative" id="carousel-<?php echo $sach['Id']; ?>">
                            <div class="carousel-inner relative overflow-hidden w-full">
                                <?php foreach (explode(',', $sach['images']) as $index => $image): ?>
                                    <div class="carousel-item <?php echo $index === 0 ? 'active' : 'hidden'; ?>">
                                        <img src="<?php echo $image; ?>" alt="Image" class="w-full h-64 object-cover rounded-lg mb-4">
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
</main>

<?php require_once dirname(__FILE__).'/../layouts/footer.php'; ?>
<script>
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

    // Hàm cập nhật kết quả tìm kiếm
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

    // Hàm đặt lại kết quả tìm kiếm về trạng thái ban đầu
    function resetSearchResults() {
        const searchResults = document.getElementById('search-results');
        searchResults.innerHTML = '';
    }


    // Hàm tạo phần tử hiển thị sách
    function createBookDiv(sach) {
        const bookDiv = document.createElement('div');
        bookDiv.classList.add('relative', 'bg-white', 'p-4', 'rounded-lg', 'shadow-md', 'hover:shadow-lg', 'transform', 'hover:scale-105', 'transition', 'duration-300', 'ease-in-out');
        bookDiv.onclick = () => {
            window.location.href = '?url=chi-tiet-sach&id=' + sach.Id;
        };

        let images = [];

        // Kiểm tra xem sach.images có phải là một chuỗi phân tách bằng dấu phẩy không
        if (typeof sach.images === 'string') {
            images = sach.images.split(',');
        } else if (Array.isArray(sach.images)) {
            images = sach.images;
        }

        const carousel = document.createElement('div');
        carousel.id = `carousel-${sach.Id}`;
        carousel.classList.add('carousel', 'relative');

        if (images.length > 0) {
            images.forEach((url, index) => {
                const bookImage = document.createElement('img');
                bookImage.src = url;
                bookImage.alt = sach.TuaSach;
                bookImage.classList.add('w-full', 'h-64', 'object-cover', 'rounded-lg', 'mb-4', 'carousel-item', index === 0 ? 'active' : 'hidden');
                carousel.appendChild(bookImage);
            });

            const prevButton = document.createElement('button');
            prevButton.classList.add('carousel-control-prev', 'absolute', 'left-0', 'top-1/2', 'transform', '-translate-y-1/2', 'bg-gray-700', 'text-white', 'p-2', 'rounded-full');
            prevButton.innerHTML = '<i class="fas fa-chevron-left"></i>';
            prevButton.onclick = (event) => {
                event.stopPropagation();
                prevSlide(sach.Id);
            };

            const nextButton = document.createElement('button');
            nextButton.classList.add('carousel-control-next', 'absolute', 'right-0', 'top-1/2', 'transform', '-translate-y-1/2', 'bg-gray-700', 'text-white', 'p-2', 'rounded-full');
            nextButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
            nextButton.onclick = (event) => {
                event.stopPropagation();
                nextSlide(sach.Id)
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

        const bookRating = document.createElement('div');
        bookRating.classList.add('mt-2');
        const averageRating = sach.averageRating ? sach.averageRating : 0;
        bookRating.innerHTML = displayStars(averageRating);
        bookDiv.appendChild(bookRating);

        const favoriteDiv = document.createElement('div');
        favoriteDiv.classList.add('absolute', 'top-2', 'right-2');

        <?php if (isset($_SESSION['user'])): ?>
        const isFavorite = sach.isFavorite ? sach.isFavorite : false;
        if (isFavorite) {
            const favoriteForm = document.createElement('form');
            favoriteForm.action = '?url=yeu-thich-sach/delete';
            favoriteForm.method = 'post';
            favoriteForm.style.display = 'inline';

            const favoriteButton = document.createElement('button');
            favoriteButton.type = 'submit';
            favoriteButton.classList.add('favorite-button', 'text-2xl', 'text-red-500');
            favoriteButton.innerHTML = '<i class="fas fa-heart"></i>';
            favoriteButton.onclick = (event) => {
                event.stopPropagation();
            };

            const bookIdInput = document.createElement('input');
            bookIdInput.type = 'hidden';
            bookIdInput.name = 'bookId';
            bookIdInput.value = sach.Id;

            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'delete';

            favoriteForm.appendChild(favoriteButton);
            favoriteForm.appendChild(bookIdInput);
            favoriteForm.appendChild(actionInput);

            favoriteDiv.appendChild(favoriteForm);
        } else {
            const favoriteForm = document.createElement('form');
            favoriteForm.action = '?url=yeu-thich-sach/store';
            favoriteForm.method = 'post';
            favoriteForm.style.display = 'inline';

            const favoriteButton = document.createElement('button');
            favoriteButton.type = 'submit';
            favoriteButton.classList.add('favorite-button', 'text-2xl', 'text-gray-500');
            favoriteButton.innerHTML = '<i class="far fa-heart"></i>';
            favoriteButton.onclick = (event) => {
                event.stopPropagation();
            };

            const bookIdInput = document.createElement('input');
            bookIdInput.type = 'hidden';
            bookIdInput.name = 'bookId';
            bookIdInput.value = sach.Id;

            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'store';

            favoriteForm.appendChild(favoriteButton);
            favoriteForm.appendChild(bookIdInput);
            favoriteForm.appendChild(actionInput);

            favoriteDiv.appendChild(favoriteForm);
        }
        <?php endif; ?>

        bookDiv.appendChild(favoriteDiv);

        const bookActions = document.createElement('div');
        bookActions.classList.add('flex', 'mt-4', 'space-x-2');

        <?php if (isset($_SESSION['user'])): ?>
        const borrowButton = document.createElement('a');
        borrowButton.href = '?url=dang-ky-muon/index&id=' + sach.Id;
        borrowButton.classList.add('bg-green-500', 'hover:bg-green-700', 'text-white', 'font-bold', 'py-2', 'px-4', 'rounded');
        borrowButton.textContent = 'Mượn';
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


    let currentSlide = {};

    function showSlide(carouselId, slideIndex) {
        const carousel = document.getElementById(`carousel-${carouselId}`);
        const slides = carousel.querySelectorAll('.carousel-item');

        if (!currentSlide[carouselId]) {
            currentSlide[carouselId] = 0;
        }

        if (slideIndex >= slides.length) {
            currentSlide[carouselId] = 0;
        } else if (slideIndex < 0) {
            currentSlide[carouselId] = slides.length - 1;
        } else {
            currentSlide[carouselId] = slideIndex;
        }

        slides.forEach((slide, index) => {
            if (index === currentSlide[carouselId]) {
                slide.classList.remove('hidden');
                slide.classList.add('active');
            } else {
                slide.classList.add('hidden');
                slide.classList.remove('active');
            }
        });
    }

    function prevSlidet(carouselId) {
        showSlide(carouselId, currentSlide[carouselId] - 1);
    }

    function nextSlidet(carouselId) {
        showSlide(carouselId, currentSlide[carouselId] + 1);
    }







    // Hiển thị sách tìm kiếm
    function displaySearchedBooks(books) {
        const booksContainer = document.getElementById('searched-books');
        booksContainer.innerHTML = '';

        if (books.length === 0) {
            const noBooksMessage = document.createElement('p');
            noBooksMessage.textContent = 'Không có sách nào được tìm thấy.';
            booksContainer.appendChild(noBooksMessage);
            return;
        }

        books.forEach(sach => {
            const bookDiv = createBookDiv(sach);
            booksContainer.appendChild(bookDiv);
        });
    }

    // Giả sử bạn có một hàm displayStars(averageRating) để hiển thị sao đánh giá
    function displayStars(averageRating) {
        // Cập nhật mã hiển thị sao đánh giá tương ứng
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
        quantityInput.value = 1;
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


    // Hàm mượn sách
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
                    alert('Mượn sách thành công.');
                } else {
                    alert('Mượn sách thất bại.');
                }
            })
            .catch(error => {
                console.error('Lỗi khi mượn sách:', error);
                alert('Đã xảy ra lỗi khi mượn sách.');
            });
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
                        // Xử lý thành công
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

    function nextSlide(carouselId) {
        const carousel = document.getElementById(`carousel-${carouselId}`);
        const activeItem = carousel.querySelector('.carousel-item.active');
        let nextItem = activeItem.nextElementSibling;

        if (!nextItem) {
            nextItem = carousel.querySelector('.carousel-item:first-child');
        }

        activeItem.classList.remove('active');
        activeItem.classList.add('hidden');

        if (nextItem) {
            nextItem.classList.remove('hidden');
            nextItem.classList.add('active');
        } else {
            const firstItem = carousel.querySelector('.carousel-item:first-child');
            firstItem.classList.remove('hidden');
            firstItem.classList.add('active');
        }
    }



    function prevSlide(carouselId) {
        const carousel = document.getElementById(`carousel-${carouselId}`);
        const activeItem = carousel.querySelector('.carousel-item.active');
        let prevItem = activeItem.previousElementSibling;

        if (!prevItem) {
            prevItem = carousel.querySelector('.carousel-item:last-child');
        }

        activeItem.classList.remove('active');
        activeItem.classList.add('hidden');
        prevItem.classList.remove('hidden');
        prevItem.classList.add('active');
    }

</script>

</body>
</html>
