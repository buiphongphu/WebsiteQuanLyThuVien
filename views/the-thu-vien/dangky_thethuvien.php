<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng Ký Thẻ Thư Viện</title>
    <!-- Thêm Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Thêm Alpine.js cho JavaScript tương tác -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.7.0/dist/alpine.min.js" defer></script>
    <style>
        /* CSS để thiết kế thẻ thư viện */
        .card {
            width: 240px;
            height: 150px;
            background-color: #4CAF50;
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform-style: preserve-3d;
            transition: transform 0.5s;
        }

        .card:hover {
            transform: rotateY(180deg);
        }

        .card-front,
        .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card-back {
            transform: rotateY(180deg);
        }
    </style>
</head>

<body class="bg-gray-100">

<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

$ngayLapThe = date('Y-m-d');
$ngayHetHan = date('Y-m-d', strtotime('+1 year'));

?>

<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold text-center mb-4">Đăng Ký Thẻ Thư Viện</h1>
    <div class="bg-white p-6 rounded-lg shadow-md max-w-md mx-auto">
        <form action="?url=the-thu-vien/dangky/store" method="post">

            <div class="mb-4">
                <label for="loai-the" class="block text-gray-700 font-bold mb-2">Loại Thẻ</label>
                <select name="loai-the" id="loai-the"
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                    <option value="Sinh Viên">Sinh Viên</option>
                    <option value="Giáo Viên">Giáo Viên</option>
                    <option value="Cán Bộ">Cán Bộ</option>
                    <option value="Khác">Khác</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="ngay-lap-the" class="block text-gray-700 font-bold mb-2">Ngày Lập Thẻ</label>
                <input type="date" name="ngay-lap-the" id="ngay-lap-the" value="<?= $ngayLapThe ?>"
                       class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       readonly required>
            </div>

            <div class="mb-4">
                <label for="ngay-het-han" class="block text-gray-700 font-bold mb-2">Ngày Hết Hạn</label>
                <input type="date" name="ngay-het-han" id="ngay-het-han" value="<?= $ngayHetHan ?>"
                       class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                       readonly required>
            </div>

            <div class="flex justify-center">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    Đăng Ký Thẻ
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
</body>

</html>

