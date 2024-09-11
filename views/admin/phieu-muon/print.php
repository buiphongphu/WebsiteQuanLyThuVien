<?php
if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID phiếu mượn không hợp lệ.";
    exit();
}

$id = $_GET['id'];

$phieuMuonController = new PhieuMuonController();
$phieuMuon = $phieuMuonController->getPhieuMuonById($id);

if (!$phieuMuon) {
    echo "Không tìm thấy phiếu mượn!";
    exit();
}

$dangKyMuon['NgayMuon'] = date('d/m/Y', strtotime($phieuMuon['NgayMuon']));
$dangKyMuon['NgayTra'] = date('d/m/Y', strtotime($phieuMuon['NgayTra']));

$maPhieuMuon = "PM" . str_pad($phieuMuon['phieumuon_id'], 5, '0', STR_PAD_LEFT);

$libraryName = "Thư Viện 2P";
$adminName = $_SESSION['admin']['Ho'].' '.$_SESSION['admin']['Ten'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In phiếu mượn</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        function printDiv() {
            var divContents = document.getElementById("printableArea").innerHTML;
            var a = window.open('', '', 'height=800, width=800');
            a.document.write('<html>');
            a.document.write('<head><link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"></head>');
            a.document.write('<body>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
        }
    </script>
</head>
<?php require_once dirname(__FILE__).'/../layouts/head.php'; ?>
<?php require_once dirname(__FILE__).'/../layouts/header.php'; ?>
<body class="bg-gray-100">
<div id="printableArea" class="max-w-2xl mx-auto bg-white shadow-md rounded-md p-6 mt-10">
    <div class="flex items-center justify-between mb-6">
        <img src="public/images/2p.png" alt="Library Logo" class="h-16 rounded-full">
        <h1 class="text-2xl font-bold text-right flex-1"><?= htmlspecialchars($libraryName) ?></h1>
    </div>
    <h1 class="text-2xl font-bold text-center mb-6">Phiếu Mượn Sách</h1>
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <p class="font-semibold">Thông tin phiếu mượn:</p>
            <p><strong>Mã phiếu mượn:</strong> <?= htmlspecialchars($maPhieuMuon) ?></p>
            <p><strong>Ngày mượn:</strong> <?= htmlspecialchars($dangKyMuon['NgayMuon']) ?></p>
            <p><strong>Ngày trả:</strong> <?= htmlspecialchars($dangKyMuon['NgayTra']) ?></p>
        </div>
        <div>
            <p class="font-semibold">Thông tin độc giả:</p>
            <p><strong>Độc giả:</strong> <?= htmlspecialchars($phieuMuon['HoTenDocGia']) ?></p>
        </div>
    </div>
    <div class="mb-4">
        <p class="font-semibold">Thông tin sách:</p>
        <div class="grid grid-cols-2 gap-4">
            <?php
                $i=0;
            foreach ($phieuMuon['books'] as $book):
                $i++;
                ?>
                <div>
                    <p><strong>Sách <?= $i?>:</strong> <?= htmlspecialchars($book['TuaSach']) ?></p>
                </div>
                <div>
                    <p><strong>Số lượng:</strong> <?= htmlspecialchars($book['SoLuong']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="text-right mt-8">
        <p class="font-semibold">Người xác nhận:</p>
        <p class="inline-block"><?= htmlspecialchars($adminName) ?></p>
    </div>
    <div class="text-center mt-6">
        <p class="text-sm text-gray-500">
            <i class="fas fa-exclamation-triangle text-2xl text-yellow-500"></i>
            Lưu ý: Nhớ bảo quản sách tốt khi mượn và trả sách đúng hạn như trên phiếu mượn.</p>
    </div>
</div>
<div class="text-center mt-6">
    <button onclick="printDiv()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-check text-2xl text-yellow-500"></i>
        Xác nhận
    </button>
    <a href="?url=admin/quanlyphieumuon" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
        <i class="fas fa-times text-2xl text-yellow-500"></i>
        Hủy
    </a>
</div>
</body>
<?php require_once dirname(__FILE__).'/../layouts/footer.php'; ?>
</html>
