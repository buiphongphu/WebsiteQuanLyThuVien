<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="public/images/2p.png" type="image/x-icon">
    <style>
        body {
            background-color: #cecfd2;
        }
    </style>
</head>

<body class="flex justify-center items-center h-screen">
<div class="bg-white p-8 rounded-lg shadow-md md:w-96 w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Quên Mật Khẩu</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline"><?php echo $_SESSION['error']; ?></span>
            <span class="absolute top-0 right-0 -mt-1 -mr-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </span>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="?url=send_reset_email" method="POST" id="sendEmailForm" class="mt-4">
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email người dùng</label>
            <input type="email" id="email" name="email" required
                   class="w-full px-3 py-2 mt-1 block w-full border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
        </div>
        <button type="submit" id="sendEmailBtn"
                class="w-full bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition duration-300 ease-in-out flex items-center justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m0-4h.01M21 12c0 4.418-3.582 8-8 8s-8-3.582-8-8 3.582-8 8-8 8 3.582 8 8zM12 8v4h4" />
            </svg>
            Gửi Mã Xác Nhận
        </button>
    </form>

    <button onclick="window.history.back()" class="w-full mt-4 bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-50 transition duration-300 ease-in-out flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Quay Lại
    </button>
</div>
</body>

</html>
