<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
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

        .register-container {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 800px;
        }

        .register-container input,
        .register-container select,
        .register-container textarea {
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .register-container input:focus,
        .register-container select:focus,
        .register-container textarea:focus {
            border-color: #00d4ff;
            box-shadow: 0 0 10px rgba(0, 212, 255, 0.5);
        }
    </style>
</head>
<body class="aurora-bg flex justify-center items-center min-h-screen p-4">
<a href="?url=index" class="absolute top-5 right-0 text-white hover:text-gray-200">
    <i class="fas fa-home fa-2x"></i>
</a>
<div class="register-container bg-white p-6 rounded-lg shadow-md w-full mx-4">
    <h2 class="text-3xl font-bold mb-6 text-center text-gray-700">Đăng Ký</h2>
    <?php if (isset($_SESSION['error'])) { ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Lỗi!</strong>
            <?php
            if (is_array($_SESSION['error'])) {
                foreach ($_SESSION['error'] as $error) {
                    echo '<span class="block sm:inline">' . htmlspecialchars($error) . '</span>';
                }
            } else {
                echo '<span class="block sm:inline">' . htmlspecialchars($_SESSION['error']) . '</span>';
            }
            ?>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php } ?>

    <form class="register-form" action="?url=check_register" method="POST">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block mb-2 font-bold" for="name">Họ:</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-3"></i>
                    <input type="text" id="name" name="name" placeholder="Nhập họ" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div>
                <label class="block mb-2 font-bold" for="firstname">Tên:</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-3 top-3"></i>
                    <input type="text" id="firstname" name="firstname" placeholder="Nhập tên" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg">
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block mb-2 font-bold" for="dob">Ngày Sinh:</label>
                <div class="relative">
                    <i class="fas fa-calendar-alt absolute left-3 top-3"></i>
                    <input type="date" id="dob" name="dob" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div>
                <label class="block mb-2 font-bold" for="gender">Giới Tính:</label>
                <div class="relative">
                    <i class="fas fa-venus-mars absolute left-3 top-3"></i>
                    <select id="gender" name="gender" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg">
                        <option value="Nam" selected>Nam</option>
                        <option value="Nữ">Nữ</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block mb-2 font-bold" for="phone">Số Điện Thoại:</label>
                <div class="relative">
                    <i class="fas fa-phone-alt absolute left-3 top-3"></i>
                    <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg">
                </div>
            </div>
            <div>
                <label class="block mb-2 font-bold" for="address">Địa Chỉ:</label>
                <div class="relative">
                    <i class="fas fa-map absolute left-3 top-3"></i>
                    <textarea id="address" name="address" placeholder="Nhập địa chỉ" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg"></textarea>
                </div>
            </div>
        </div>
        <div>
            <label class="block mb-2 font-bold" for="id_number">Mã (Sinh viên | Giáo viên | Cán bộ khác):</label>
            <div class="relative">
                <i class="fas fa-id-card absolute left-3 top-3"></i>
                <input type="text" id="id_number" name="id_number" placeholder="Nhập mã số" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg" oninput="updateUnitBasedOnId()">
            </div>
        </div>
        <div>
            <label class="block mb-2 font-bold" for="unit_display">Đơn Vị:</label>
            <div class="relative">
                <i class="fas fa-building absolute left-3 top-3"></i>
                <select id="unit_display" name="unit_display" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg" disabled>
                    <option value="Sinh Viên">Sinh viên</option>
                    <option value="Giáo Viên">Giáo viên</option>
                    <option value="Cán Bộ Khác">Cán bộ khác</option>
                </select>
            </div>
            <input type="hidden" id="unit" name="unit">
        </div>
        <script>
            function updateUnitBasedOnId() {
                const idNumber = document.getElementById("id_number").value;
                const unitDisplay = document.getElementById("unit_display");
                const unit = document.getElementById("unit");

                if (idNumber.startsWith("SV")) {
                    unitDisplay.value = "Sinh Viên";
                    unit.value = "Sinh Viên";
                } else if (idNumber.startsWith("GV")) {
                    unitDisplay.value = "Giáo Viên";
                    unit.value = "Giáo Viên";
                } else if (idNumber.startsWith("NV")) {
                    unitDisplay.value = "Cán Bộ Khác";
                    unit.value = "Cán Bộ Khác";
                } else {
                    unitDisplay.value = "";
                    unit.value = "";
                }
            }

            document.addEventListener("DOMContentLoaded", function() {
                updateUnitBasedOnId();
            });
        </script>
        <div class="mb-6">
            <label class="block mb-2 font-bold" for="email">Email:</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-3 top-3"></i>
                <input type="email" id="email" name="email" placeholder="Nhập địa chỉ email" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg">
            </div>
        </div>
        <div class="mb-6">
            <label class="block mb-2 font-bold" for="password">Mật Khẩu:</label>
            <div class="relative">
                <i class="fas fa-lock absolute left-3 top-3"></i>
                <input type="password" id="password" name="password" placeholder="Nhập mật khẩu" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg pr-10">
                <span class="absolute right-3 top-3 cursor-pointer" onclick="togglePasswordVisibility('password', 'togglePasswordIcon')">
                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                </span>
            </div>
        </div>
        <div class="mb-6">
            <label class="block mb-2 font-bold" for="confirm_password">Nhập Lại Mật Khẩu:</label>
            <div class="relative">
                <i class="fas fa-lock absolute left-3 top-3"></i>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Nhập lại mật khẩu" required class="w-full p-3 pl-10 border border-gray-300 rounded-lg pr-10">
                <span class="absolute right-3 top-3 cursor-pointer" onclick="togglePasswordVisibility('confirm_password', 'toggleConfirmPasswordIcon')">
                    <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                </span>
            </div>
        </div>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg transition duration-300">
            Đăng Ký
        </button>
    </form>
</div>

<script>
    function togglePasswordVisibility(fieldId, iconId) {
        const field = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);
        if (field.type === "password") {
            field.type = "text";
            icon.classList.replace("fa-eye", "fa-eye-slash");
        } else {
            field.type = "password";
            icon.classList.replace("fa-eye-slash", "fa-eye");
        }
    }
</script>
</body>
</html>
