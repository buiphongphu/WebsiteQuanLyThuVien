<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lỗi hệ thống</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="public/images/2p.png" type="image/x-icon">
    <style>
        body {
            font-family: 'Fira Code', monospace;
            background-color: #1e1e1e;
            color: #d4d4d4;
        }

        .container {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .log-container {
            display: flex;
            max-height: 60vh;
            overflow-y: auto;
            background-color: #1e1e1e;
            border: 1px solid #333;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .line-numbers {
            padding: 0.5rem;
            background-color: #252526;
            color: #858585;
            text-align: right;
            user-select: none;
        }

        .log-content {
            padding: 0.5rem;
            flex: 1;
            white-space: pre;
        }

        .line-numbers span, .log-content span {
            display: block;
            line-height: 1.5em;
        }

        .log-content span.error {
            color: #f44747; /* Đỏ cho lỗi nghiêm trọng */
        }

        .log-content span.warning {
            color: #ffcc00; /* Vàng cho cảnh báo */
        }

        .log-content span.info {
            color: #75beff; /* Xanh cho thông tin */
        }

        .btn {
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #007acc;
        }

        .header {
            background-color: #007acc;
            padding: 1rem;
            border-radius: 0.5rem 0.5rem 0 0;
            color: #fff;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
<div class="container bg-[#1e1e1e] text-[#d4d4d4] p-8 rounded-lg shadow-lg max-w-3xl mx-auto">
    <div class="header text-center">
        <h1 class="text-4xl font-bold">Trang Kiểm Tra Lỗi</h1>
        <p class="text-lg">Vui lòng hãy fix bug giúp chúng tôi.</p>
    </div>

    <?php
    $logFile = 'config/error.log';
    if (file_exists($logFile)) {
        if (filesize($logFile) > 0) {
            echo '<h2 class="text-2xl font-bold text-red-600 mt-8 mb-4">Chi tiết lỗi:</h2>';
            $logContent = file_get_contents($logFile);
            $lines = explode("\n", $logContent);
            echo '<div class="log-container">';
            echo '<div class="line-numbers">';
            foreach ($lines as $index => $line) {
                echo '<span>' . ($index + 1) . '</span>';
            }
            echo '</div>';
            echo '<div class="log-content">';
            foreach ($lines as $line) {
                $lineClass = '';
                if (strpos($line, 'ERROR') !== false) {
                    $lineClass = 'error';
                } elseif (strpos($line, 'WARNING') !== false) {
                    $lineClass = 'warning';
                } elseif (strpos($line, 'INFO') !== false) {
                    $lineClass = 'info';
                }
                echo '<span class="' . $lineClass . '">' . htmlspecialchars($line) . '</span>';
            }
            echo '</div>';
            echo '</div>';
        } else {
            echo '<p class="text-center text-lg">File log rỗng.</p>';
        }
    } else {
        echo '<p class="text-center text-lg">Không tìm thấy file log.</p>';
    }
    ?>

    <div class="text-center mt-4">
        <a href="?url=index" class="btn bg-blue-500 text-white py-2 px-4 rounded-lg inline-block">
            <i class="fas fa-home mr-2"></i> Quay lại trang chủ
        </a>
    </div>
</div>
</body>
</html>
