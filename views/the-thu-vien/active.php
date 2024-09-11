<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kích Hoạt Mã</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="public/images/2p.png" type="image/x-icon">
</head>
<?php
if (isset($_SESSION['error'])) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-auto mt-4" role="alert">';
    echo '<strong class="font-bold">Lỗi! </strong>';
    if (is_array($_SESSION['error'])) {
        foreach ($_SESSION['error'] as $error) {
            echo '<span class="block sm:inline">' . $error . '</span>';
        }
    } else {
        echo '<span class="block sm:inline">' . $_SESSION['error'] . '</span>';
    }
    echo '</div>';
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-auto mt-4" role="alert">';
    echo '<strong class="font-bold">Thành công! </strong>';
    echo '<span class="block sm:inline">' . $_SESSION['success'] . '</span>';
    echo '</div>';
    unset($_SESSION['success']);
}
?>
<body class="bg-gray-100">
<div class="flex justify-center items-center h-screen">
    <div class="w-1/3 bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-blue-600 mb-4">Nhập Mã Kích Hoạt</h2>
        <form action="?url=the-thu-vien/check_active" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="activation_code">Mã Kích Hoạt:</label>
                <input type="text" name="activation_code" id="activation_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Kích Hoạt</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>



