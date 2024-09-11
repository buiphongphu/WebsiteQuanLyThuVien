<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="public/images/2p.png" type="image/x-icon">
    <style>
        .aurora-bg {
            background: linear-gradient(135deg, #020024 0%, #090979 35%, #00d4ff 100%);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .login-container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
        }

        .error-message {
            color: red;
            background-color: #ffe5e5;
            border: 1px solid red;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body class="aurora-bg flex justify-center items-center h-screen relative">
<a href="?url=index" class="absolute top-5 right-5 text-white hover:text-gray-200">
    <i class="fas fa-home fa-2x"></i>
</a>
<div class="login-container bg-white p-8 rounded-lg shadow-md md:w-96 w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Đăng Nhập</h2>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
    }
    ?>
    <form class="login-form" action="?url=check_login" method="POST">
        <input type="email" name="username" placeholder="Email người dùng" required class="w-full p-3 mb-4 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
        <div class="relative">
            <input type="password" id="password" name="password" placeholder="Mật khẩu" required class="w-full p-3 mb-4 border border-gray-300 rounded-lg pr-10 focus:outline-none focus:border-blue-500">
            <span class="absolute right-3 top-3 cursor-pointer text-gray-500" onclick="togglePasswordVisibility()">
                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                </span>
        </div>
        <a href="?url=forgot-password" class="text-blue-500 hover:underline block mb-4">Quên mật khẩu?</a>
        <input type="submit" value="Đăng Nhập" name="Dangnhap" class="p-3 bg-blue-500 text-white rounded-lg hover:bg-blue-700 cursor-pointer w-full">
        <p class="text-center mt-4">Chưa có tài khoản? <a href="?url=register" class="text-blue-500 hover:underline">Đăng ký tài khoản</a></p>
    </form>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordIcon.classList.remove('fa-eye');
            togglePasswordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            togglePasswordIcon.classList.remove('fa-eye-slash');
            togglePasswordIcon.classList.add('fa-eye');
        }
    }
</script>
</body>
</html>
