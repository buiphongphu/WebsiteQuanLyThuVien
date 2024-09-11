<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="public/images/2p.png" type="image/x-icon">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
<div id="offline-container" class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-lg flex flex-col items-center space-y-6">
    <div class="flex flex-col items-center space-y-6">
        <h1 class="text-3xl font-bold">Bạn đang ngoại tuyến</h1>
        <p class="text-lg">Hãy kiểm tra lại kết nối internet của bạn.</p>
        <?php
        if (isset($_SESSION['admin'])) {
            echo '<a href="?url=admin/dashboard" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-arrow-left"></i> Quay về trang quản lý
                </a>';
        } else {
            echo '<a href="?url=index" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-arrow-left"></i> Quay về trang chủ
                </a>';
        }
        ?>
        <button id="show-guide" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
            <i class="fas fa-info-circle"></i> Hướng dẫn kết nối
        </button>
        <p class="mt-4 text-gray-500">Bạn nên kiểm tra hóa đơn tiền mạng tháng này!</p>

    </div>
    <div class="flex justify-center">
        <img src="public/images/offine-icon.jpg" alt="Offline Illustration" class="h-100 w-100">
    </div>
</div>

<div id="guide-container" class="max-w-4xl mx-auto bg-white p-6 mt-6 rounded-lg shadow-lg hidden">
    <h2 class="text-2xl font-bold mb-4">Hướng dẫn kết nối internet</h2>
    <ol class="list-decimal list-inside text-lg space-y-4">
        <li class="flex items-start space-x-2">
            <i class="fas fa-signal text-blue-500"></i>
            <span>Kiểm tra kết nối mạng của bạn bằng cách xem các đèn báo trên modem hoặc router. Nếu đèn báo không sáng hoặc có màu đỏ, hãy thử khởi động lại thiết bị.</span>
        </li>
        <li class="flex items-start space-x-2">
            <i class="fas fa-plug text-blue-500"></i>
            <span>Đảm bảo rằng cáp mạng hoặc dây điện thoại được kết nối chặt chẽ vào modem và router.</span>
        </li>
        <li class="flex items-start space-x-2">
            <i class="fas fa-laptop text-blue-500"></i>
            <span>Khởi động lại máy tính hoặc thiết bị di động của bạn.</span>
        </li>
        <li class="flex items-start space-x-2">
            <i class="fas fa-wifi text-blue-500"></i>
            <span>Nếu bạn sử dụng Wi-Fi, hãy kiểm tra xem bạn có đang kết nối với mạng Wi-Fi chính xác hay không.</span>
        </li>
        <li class="flex items-start space-x-2">
            <i class="fas fa-phone-alt text-blue-500"></i>
            <span>Nếu vẫn không kết nối được, hãy liên hệ với nhà cung cấp dịch vụ internet của bạn để được hỗ trợ.</span>
        </li>
    </ol>
    <button id="back-to-offline" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out transform hover:scale-105">
        <i class="fas fa-arrow-left"></i> Quay lại
    </button>
</div>

<script>
    document.getElementById('show-guide').addEventListener('click', function() {
        document.getElementById('offline-container').classList.add('hidden');
        document.getElementById('guide-container').classList.remove('hidden');
    });

    document.getElementById('back-to-offline').addEventListener('click', function() {
        document.getElementById('guide-container').classList.add('hidden');
        document.getElementById('offline-container').classList.remove('hidden');
    });
</script>
</body>
</html>
