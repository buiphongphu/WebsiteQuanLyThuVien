<?php
$errors = [];
$currentPasswordCorrect = false;

if (!isset($_SESSION['admin']['Id'])) {
    header("Location: ?url=login");
    exit();
}

$id = $_SESSION['admin']['Id'];

$quanTriVienController= new QuanTriVienController();
$currentPasswordFromDB = $quanTriVienController->getPassword($id);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['current_password'])) {
    $currentPassword = $_POST['current_password'];

    if (empty($currentPassword)) {
        $errors[] = "Mật khẩu hiện tại không được để trống";
    } elseif (!password_verify(md5($currentPassword), $currentPasswordFromDB)) {
        $errors[] = "Mật khẩu hiện tại không đúng";
        if (!isset($_SESSION['failed_attempts'])) {
            $_SESSION['failed_attempts'] = 1;
        } else {
            $_SESSION['failed_attempts']++;
        }

        if ($_SESSION['failed_attempts'] >= 3) {
            session_destroy();
            header("Location: ?url=login");
            exit();
        }
    } else {
        $currentPasswordCorrect = true;
        $_SESSION['failed_attempts'] = 0;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mật khẩu mới</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="public/images/2p.png" type="image/x-icon">
    <style>
        body {
            background-color: #9fa1a6;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const togglePassword = document.querySelectorAll('.toggle-password');
            togglePassword.forEach(element => {
                element.addEventListener('click', function() {
                    const input = document.getElementById(this.dataset.input);
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            });
        });
    </script>
</head>
<body class="bg-gray-100">
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center">Mật khẩu mới</h2>
        <?php if (!empty($errors)): ?>
            <div class="mb-4">
                <?php foreach ($errors as $error): ?>
                    <p class="text-center text-red-500"><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <p class="text-center text-red-500"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <?php if (!$currentPasswordCorrect): ?>
            <form action="" method="POST">
                <div class="mb-4">
                    <label for="current_password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu hiện tại:</label>
                    <div class="relative">
                        <input type="password" id="current_password" name="current_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <i class="toggle-password fa fa-eye absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" data-input="current_password"></i>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        <i class="fas fa-check"></i>
                        Xác nhận</button>
                </div>
            </form>
        <?php else: ?>
            <form action="?url=admin/quantrivien/update-password" method="POST">
                <div class="mb-4">
                    <label for="new_password" class="block text-gray-700 text-sm font-bold mb-2">Mật khẩu mới:</label>
                    <div class="relative">
                        <input type="password" id="new_password" name="new_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <i class="toggle-password fa fa-eye absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" data-input="new_password"></i>
                    </div>
                </div>
                <div class="mb-6">
                    <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">Xác nhận mật khẩu:</label>
                    <div class="relative">
                        <input type="password" id="confirm_password" name="confirm_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <i class="toggle-password fa fa-eye absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer" data-input="confirm_password"></i>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        <i class="fas fa-check"></i>
                        Xác nhận</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
