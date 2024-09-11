<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

// Ensure $_GET['id'] exists and is valid
$idPhieu = $_GET['id'] ?? null;
if (!$idPhieu) {
    die('Invalid request');
}

$sachHongHoacMatController = new SachHongHoacMatController();
$phieuPhat = $sachHongHoacMatController->getDanhSachXuPhatById($idPhieu);
$trangThaiController= new TrangThaiController();

if (!$phieuPhat) {
    die('Phiếu phạt không tồn tại');
}

// Lấy tên người lập phiếu từ session
$admin = $_SESSION['admin'];
$tenNguoiLap = $admin['Ho'] . ' ' . $admin['Ten'];

$html = "
<html>
<head>
    <title>Phiếu phạt</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; margin: 0 auto; padding: 20px; max-width: 800px; border: 1px solid #000; }
        .header { text-align: center; margin-bottom: 20px; }
        .logo { width: 100px; margin: 0 auto; }
        .info, .books { margin-bottom: 20px; }
        .info table, .books table { width: 100%; border-collapse: collapse; }
        .info th, .info td, .books th, .books td { border: 1px solid #000; padding: 8px; text-align: left; }
        .info h2, .books h2 { margin-bottom: 10px; text-align: center; font-size: 1.2em; }
        .commitment { margin-bottom: 20px; }
        .footer { display: flex; justify-content: space-between; margin-top: 20px; }
        .signature, .reader-signature { text-align: center; }
        .signature div, .reader-signature div { margin-bottom: 60px; }
        .signature .line, .reader-signature .line { margin-top: 40px; border-top: 1px solid #000; width: 200px; margin: 40px auto 0; }

        @media print {
            body * { visibility: hidden; }
            .print-container, .print-container * { visibility: visible; }
            .print-container { position: absolute; left: 0; top: 0; width: 100%; }
        }
    </style>
</head>
<body>
    <div class='print-container'>
        <div class='container'>
            <div class='header'>
                <img src='public/images/2p.png' alt='2P Library Logo' class='logo'>
                <h1 class='text-2xl font-bold'>Thư Viện 2P</h1>
                <p class='text-sm'>Địa chỉ: 180 Cao Lỗ, phường 4, quận 8, TP.HCM</p>
                <p class='text-sm'>Số điện thoại: +84388193175</p>
            </div>
            <h2 class='text-xl font-semibold text-center'>Phiếu phạt</h2>
            <div class='info'>
                <h2 class='text-lg font-semibold text-center'>Thông tin phiếu phạt</h2>
                <table class='table-auto'>
                    <thead>
                        <tr>
                            <th class='px-4 py-2'>Độc Giả</th>
                            <th class='px-4 py-2'>SĐT</th>
                        </tr>
                    </thead>
                    <tbody>";
foreach ($phieuPhat as $phieu) {
    $html .= "
                        <tr>
                            <td class='border px-4 py-2'>{$phieu['Ho']} {$phieu['Ten']}</td>
                            <td class='border px-4 py-2'>{$phieu['sdt']}</td>
                        </tr>";
}
$html .= "
                    </tbody>
                </table>
            </div>
            
            <div class='books'>
                <h2 class='text-lg font-semibold text-center'>Danh sách sách</h2>
                <table class='table-auto'>
                    <thead>
                        <tr>
                            <th class='px-4 py-2'>Tựa Sách</th>
                            <th class='px-4 py-2'>Số Lượng</th>
                            <th class='px-4 py-2'>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>";

foreach ($phieu['books'] as $book) {
    $tentrangthai = $trangThaiController->getTrangThaiById($book['id_trangthai']);
    $book['id_trangthai'] = $tentrangthai['tentrangthai'];
    $tendocgia=$phieu['Ho'].' '.$phieu['Ten'];
    $html .= "
                        <tr>
                            <td class='border px-4 py-2'>{$book['TuaSach']}</td>
                            <td class='border px-4 py-2'>{$book['SoLuong']}</td>
                            <td class='border px-4 py-2'>Lý do: Sách bị {$book['id_trangthai']}</td>
                        </tr>";
}

$html .= "
                    </tbody>
                </table>
            </div>

            <div class='commitment'>
                <h2 class='text-lg font-semibold text-center'>Cam kết của độc giả</h2>
                <p>Tôi cam kết sẽ bồi thường cho thư viện những tổn thất do việc làm hư hại hoặc mất sách mà tôi đã mượn.</p>
                <p>Tôi sẽ chịu mọi trách nhiệm và hình phạt theo quy định của thư viện.</p>
            </div>

            <div class='footer'>
                <div class='signature'>
                    <div>Người lập phiếu</div>
                    <div>Ký tên</div>
                    <div class='line'></div>";
if ($tenNguoiLap) {
    $html .= "<div>$tenNguoiLap</div>";
} else {
    $html .= "<div>____________________</div>";
}
$html .= "
                </div>
                <div class='reader-signature'>
                    <div>Độc Giả</div>
                    <div>Ký tên</div>
                    <div class='line'></div>";
if ($tendocgia) {
    $html .= "<div>$tendocgia</div>";
} else {
    $html .= "<div>____________________</div>";
}
$html.="
                </div>
            </div>
        </div>
    </div>
</body>
</html>
";

echo "


<!-- Modal -->
<div class='modal fade' id='previewModal' tabindex='-1' role='dialog' aria-labelledby='previewModalLabel' aria-hidden='true'>
    <div class='modal-dialog modal-lg' role='document'>
        <div class='modal-content'>
            <div class='modal-body'>
                $html
            </div>
           <div class='modal-footer'>
    <button type='button' class='bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded'
            onclick='printPreview()'>
        <i class='fas fa-print mr-2'></i> In
    </button>
    <a href='?url=admin/quanlyxuphat' class='bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded'>
        <i class='fas fa-arrow-left mr-2'></i> Quay lại
    </a>
</div>

        </div>
    </div>
</div>
";

// JavaScript function for printing
echo "
<script>
    function printPreview() {
        window.print();
    }
</script>
";

require_once dirname(__FILE__) . '/../layouts/footer.php';
?>
