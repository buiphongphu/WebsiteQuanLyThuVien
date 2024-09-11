<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_code'])) {
    $resetCode = $_POST['reset_code'];

    if ($resetCode == $_SESSION['reset_code']) {
        header('Location: ?url=reset_password');
        unset($_SESSION['remaining_time']);
        exit();
    } else {
        $_SESSION['error'] = 'Mã xác nhận không đúng. Vui lòng thử lại.';
        $_SESSION['remaining_time'] = $_POST['remaining_time'];
    }
}

$remainingTime = isset($_SESSION['remaining_time']) ? $_SESSION['remaining_time'] : 60;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận mã</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="public/images/2p.png" type="image/x-icon">
    <style>
        body {
            background-color: #b4b6b9;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let timerElement = document.getElementById('timer');
            let initialTime = parseInt(timerElement.innerText);

            let interval;

            startCountdown(initialTime);

            function startCountdown(time) {
                interval = setInterval(() => {
                    time--;
                    timerElement.innerText = time;
                    document.getElementById('remaining_time').value = time;

                    if (time <= 0) {
                        clearInterval(interval);
                        <?php unset($_SESSION['remaining_time']); ?>
                        window.location.replace('?url=forgot-password');
                    }
                }, 1000);
            }

            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reset_code'])): ?>
            <?php if ($resetCode == $_SESSION['reset_code']): ?>
            localStorage.removeItem('startTime');
            <?php else: ?>
            clearInterval(interval);
            let remainingTime = parseInt(timerElement.innerText);
            setTimeout(() => {
                startCountdown(remainingTime);
            }, 1000);
            <?php endif; ?>
            <?php endif; ?>
        });
    </script>
</head>
<body class="bg-gray-100">
<div class="flex justify-center items-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm">
        <h2 class="text-2xl font-bold mb-6 text-center">Nhập mã xác nhận</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <p class="text-center text-red-500"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <p class="text-center text-gray-700">Thời gian còn lại: <span id="timer"><?php echo $remainingTime; ?></span> giây</p>
        <form action="" method="POST">
            <input type="hidden" id="remaining_time" name="remaining_time" value="<?php echo $remainingTime; ?>">
            <div class="mb-4">
                <label for="reset_code" class="block text-gray-700 text-sm font-bold mb-2">Mã xác nhận:</label>
                <input type="text" id="reset_code" name="reset_code" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Xác nhận</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
