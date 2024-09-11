<?php

$sachController = new SachController();
$books = [];
$totalQuantity = 0; // Renamed for clarity
if (isset($_SESSION['cart'])) {
    $bookIds = array_keys($_SESSION['cart']);
    $books = $sachController->getBooksByIds($bookIds);

    foreach ($books as &$book) {
        $book['quantity'] = $_SESSION['cart'][$book['Id']];
        $totalQuantity += $book['quantity']; // Total quantity of books
    }
}
unset($book);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once dirname(__FILE__) . '/../layouts/head.php'; ?>
    <script>
        async function fetchRequest(url, method, data) {
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                return await response.json();
            } catch (error) {
                console.error('Error:', error);
                return { success: false };
            }
        }

        function showNotification(message, type, detail = '') {
            const notification = document.getElementById('notification');
            const notificationIcon = document.getElementById('notification-icon');
            const notificationStatus = document.getElementById('notification-status');
            const notificationMessage = document.getElementById('notification-message');
            const notificationDetail = document.getElementById('notification-detail');

            notificationMessage.textContent = message;
            notificationDetail.textContent = detail;

            const types = {
                success: {
                    border: 'border-green-500',
                    bg: 'bg-green-50',
                    status: 'SUCCESS',
                    statusClass: 'text-green-500',
                    icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />',
                    iconClass: 'text-green-500'
                },
                error: {
                    border: 'border-red-500',
                    bg: 'bg-red-50',
                    status: 'ERROR',
                    statusClass: 'text-red-500',
                    icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01" />',
                    iconClass: 'text-red-500'
                },
                delete: {
                    border: 'border-yellow-500',
                    bg: 'bg-yellow-50',
                    status: 'DELETED',
                    statusClass: 'text-yellow-500',
                    icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />',
                    iconClass: 'text-yellow-500'
                }
            };

            notification.classList.remove('border-green-500', 'bg-green-50', 'border-red-500', 'bg-red-50', 'border-yellow-500', 'bg-yellow-50');
            notification.classList.add(types[type].border, types[type].bg);
            notificationStatus.textContent = types[type].status;
            notificationStatus.classList.remove('text-green-500', 'text-red-500', 'text-yellow-500');
            notificationStatus.classList.add(types[type].statusClass);
            notificationIcon.innerHTML = types[type].icon;
            notificationIcon.classList.remove('text-green-500', 'text-red-500', 'text-yellow-500');
            notificationIcon.classList.add(types[type].iconClass);

            notification.classList.remove('hidden');
            setTimeout(() => { hideNotification(); }, 4000);
        }

        function hideNotification() {
            const notification = document.getElementById('notification');
            notification.classList.add('hidden');
        }

        async function removeBook(bookId) {
            const data = await fetchRequest('?url=cart/remove', 'POST', { bookId: bookId });
            if (data.success) {
                showNotification('Thành công.', 'delete', 'Đã xóa sách khỏi giỏ hàng.');
                setTimeout(() => { location.reload(); }, 2000);
            } else {
                showNotification('Thất bại', 'error', 'Đã xảy ra lỗi khi xóa sách.');
            }
        }

        async function clearCart() {
            const data = await fetchRequest('?url=cart/clear', 'POST', { action: 'clear' });
            if (data.success) {
                showNotification('Thành công.', 'delete', 'Đã xóa giỏ sách thành công.');
                setTimeout(() => { location.reload(); }, 2000);
            } else {
                showNotification('Thất bại', 'error', 'Đã xảy ra lỗi khi xóa giỏ sách.');
            }
        }

        async function updateQuantity(bookId) {
            const quantity = document.getElementById('quantity-' + bookId).value;
            const data = await fetchRequest('?url=cart/update_quantity', 'POST', { bookId: bookId, quantity: quantity });
            if (data.success) {
                showNotification('Thành công', 'success', 'Đã cập nhật số lượng sách.');
                setTimeout(() => { location.reload(); }, 2000);
            } else {
                showNotification('Thất bại', 'error', 'Đã xảy ra lỗi khi cập nhật số lượng sách.');
            }
        }

        async function borrowBooks() {
            const borrowDate = document.getElementById('borrowDate').value;
            const returnDate = document.getElementById('returnDate').value;
            const data = await fetchRequest('?url=cart/borrow', 'POST', { borrowDate: borrowDate, returnDate: returnDate });
            if (data.success) {
                showNotification('Thành công', 'success', 'Đã mượn sách thành công.');
                setTimeout(() => { location.href = '?url=cart'; }, 2000);
            } else {
                showNotification('Thất bại', 'error', data.error || 'Đã xảy ra lỗi khi mượn sách.');
            }
        }
    </script>
    <style>
        .action-icons {
            display: flex;
            gap: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-50">
<?php include_once dirname(__FILE__) . '/../layouts/header.php'; ?>
<div id="notification" class="hidden fixed top-20 right-4 w-full max-w-md p-4 rounded-lg shadow-lg border-l-4">
    <div class="flex justify-between items-start">
        <div class="flex items-start">
            <svg id="notification-icon" class="h-6 w-6 flex-shrink-0 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"></svg>
            <div>
                <p id="notification-status" class="font-bold"></p>
                <p id="notification-message" class="text-sm"></p>
                <p id="notification-detail" class="text-xs text-gray-500"></p>
            </div>
        </div>
        <div class="pl-3">
            <button onclick="hideNotification()">
                <svg class="h-6 w-6 text-gray-400 hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm4.707-11.707a1 1 0 00-1.414-1.414L10 8.586 6.707 5.293a1 1 0 00-1.414 1.414L8.586 10l-3.293 3.293a1 1 0 001.414 1.414L10 11.414l3.293 3.293a1 1 0 001.414-1.414L11.414 10l3.293-3.293z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</div>

<div class="container mx-auto py-8">
    <h2 class="text-2xl font-semibold mb-6">Phiếu Đăng Ký</h2>
    <?php if (empty($books)) { ?>
        <p class="text-center text-gray-500">Không có sách nào trong phiếu đăng ký của bạn.</p>

    <?php } else { ?>
        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tên sách</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Hành động</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                <?php
                $totalQuantity = 0;
                foreach ($books as $book) {
                    $totalQuantity += $book['quantity'];
                    ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="text-sm font-medium text-gray-900"><?php echo $book['TuaSach']; ?></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <input id="quantity-<?php echo $book['Id']; ?>" type="number" min="1" class="form-input w-20 text-center" value="<?php echo $book['quantity']; ?>">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="action-icons">
                                <button onclick="updateQuantity(<?php echo $book['Id']; ?>)" class="bg-green-500 text-white p-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                                    <i class="fas fa-check"></i>
                                </button>
                                <button onclick="removeBook(<?php echo $book['Id']; ?>)" class="bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="1" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng số lượng</td>
                    <td colspan="2" class="px-6 py-3 text-center text-xs font-medium text-gray-900 uppercase tracking-wider"><?php echo $totalQuantity; ?></td>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="flex justify-between items-center mt-6">
            <div>
                <label for="borrowDate" class="block text-sm font-medium text-gray-700">Ngày mượn</label>
                <input type="date" id="borrowDate" class="mt-1 form-input block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div>
                <label for="returnDate" class="block text-sm font-medium text-gray-700">Ngày trả</label>
                <input type="date" id="returnDate" class="mt-1 form-input block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>
            <div class="flex-shrink-0">
                <button onclick="borrowBooks()" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    <i class="fas fa-book"></i> Mượn sách
                </button>
            </div>
        </div>
    <?php } ?>
</div>

<?php include_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
</body>
</html>
