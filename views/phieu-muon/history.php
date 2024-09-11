<?php
if (!isset($_SESSION['user'])) {
    header("Location: ?url=login");
    exit();
}

$userId = $_SESSION['user']['Id'];

$phieuMuonController = new PhieuMuonController();
$history = $phieuMuonController->getPhieuMuonHistory($userId);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once dirname(__FILE__).'/../layouts/head.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .approved { background-color: #d4edda; }
        .rejected { background-color: #f8d7da; }
        .pending { background-color: #fff3cd; }
    </style>
</head>
<body class="bg-gray-100 p-8">
<?php include_once dirname(__FILE__).'/../layouts/header.php'; ?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">Lịch Sử Mượn Sách</h1>
    <a href="?url=phieu-muon" class="text-white bg-gray-500 hover:bg-gray-700 py-2 px-4 rounded">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead class="bg-gray-200 text-gray-600">
        <tr>
            <th class="py-3 px-6 text-left">Mã Phiếu Mượn</th>
            <th class="py-3 px-6 text-left">Tên Độc Giả</th>
            <th class="py-3 px-6 text-left">Ngày Mượn</th>
            <th class="py-3 px-6 text-left">Ngày Trả</th>
            <th class="py-3 px-6 text-left">Sách Mượn</th>
            <th class="py-3 px-6 text-left">Trạng Thái</th>
        </tr>
        </thead>
        <tbody class="text-gray-700">
        <?php if (!empty($history)): ?>
            <?php foreach ($history as $item): ?>
                <?php
                $statusClass = '';
                $statusIcon = '';
                if ($item['id_trangthai'] == 3) {
                    $statusClass = 'pending';
                    $statusIcon = '<i class="fas fa-clock text-yellow-600"></i>';
                } elseif ($item['id_trangthai'] == 1) {
                    $statusClass = 'approved';
                    $statusIcon = '<i class="fas fa-check text-green-600"></i>';
                } elseif ($item['id_trangthai'] == 4) {
                    $statusClass = 'rejected';
                    $statusIcon = '<i class="fas fa-times text-red-600"></i>';
                }
                ?>
                <tr class="border-b <?php echo $statusClass; ?>">
                    <td class="py-3 px-6 text-left"><?php echo "PM" . str_pad($item['phieumuon_id'], 5, '0', STR_PAD_LEFT);?></td>
                    <td class="py-3 px-6 text-left"><?php echo $item['HoTenDocGia']; ?></td>
                    <td class="py-3 px-6 text-left"><?php echo $item['NgayMuon']; ?></td>
                    <td class="py-3 px-6 text-left"><?php echo $item['NgayTra']; ?></td>
                    <td class="py-3 px-6 text-left">
                        <?php foreach ($item['books'] as $index => $book) : ?>
                            <div class="book-details">
                                <strong>Sách <?= $index + 1 ?>:</strong> <?= $book['TuaSach'] ?> (Số lượng: <?= $book['SoLuong'] ?>)
                            </div>
                        <?php endforeach; ?>
                    </td>
                    <td class="py-3 px-6 text-left"><?php echo $statusIcon; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="py-3 px-6 text-center">Không có lịch sử mượn sách.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include_once dirname(__FILE__).'/../layouts/footer.php'; ?>
</body>
</html>
