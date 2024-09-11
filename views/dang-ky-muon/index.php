<?php
$Id = $_SESSION['user']['Id'];
$dangKyMuonController = new DangKyMuonController();
$registrationForms = $dangKyMuonController->getDanhSachDangKy($Id);

$groupedForms = [];
foreach ($registrationForms as $form) {
    $groupedForms[$form['Id']]['info'] = $form;
    $groupedForms[$form['Id']]['books'][] = [
        'TuaSach' => $form['TuaSach'],
        'SoLuong' => $form['SoLuong'],
    ];
}

foreach ($groupedForms as $id => $form) {
    $totalBooks = 0;
    foreach ($form['books'] as $book) {
        $totalBooks += $book['SoLuong'];
    }
    $groupedForms[$id]['totalBooks'] = $totalBooks;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once dirname(__FILE__).'/../layouts/head.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 p-8">
<?php include_once dirname(__FILE__).'/../layouts/header.php'; ?>

<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Danh Sách Phiếu Đăng Ký</h1>
        <a href="?url=index" class="text-white bg-gray-500 hover:bg-gray-700 py-2 px-4 rounded flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-gray-800 text-white">
            <tr>
                <th class="py-3 px-6 text-left">Mã Đăng Ký</th>
                <th class="py-3 px-6 text-left">Tên Độc Giả</th>
                <th class="py-3 px-6 text-left">Ngày Đăng Ký</th>
                <th class="py-3 px-6 text-left">Sách</th>
                <th class="py-3 px-6 text-left">Ngày Mượn</th>
                <th class="py-3 px-6 text-left">Ngày Trả</th>
                <th class="py-3 px-6 text-left">Tổng Số Sách</th>
                <th class="py-3 px-6 text-left">Trạng Thái</th>
            </tr>
            </thead>
            <tbody class="text-gray-700">
            <?php if (!empty($groupedForms)): ?>
                <?php foreach ($groupedForms as $id => $form): ?>
                    <?php
                    $statusClass = '';
                    $statusIcon = '';
                    $form['info']['Id']="DK" . str_pad($form['info']['Id'], 5, '0', STR_PAD_LEFT);
                    if ($form['info']['TenTrangThai'] == 'đã duyệt') {
                        $statusClass = 'bg-green-200';
                        $statusIcon = '<i class="fas fa-check text-green-600"></i>';
                    } elseif ($form['info']['TenTrangThai'] == 'từ chối') {
                        $statusClass = 'bg-red-200';
                        $statusIcon = '<i class="fas fa-times text-red-600"></i>';
                    } elseif ($form['info']['TenTrangThai'] == 'đang chờ') {
                        $statusClass = 'bg-yellow-200';
                        $statusIcon = '<i class="fas fa-spinner fa-spin text-yellow-600"></i>';
                    }
                    ?>
                    <tr class="hover:bg-gray-100 <?= $statusClass ?>">
                        <td class="py-4 px-6"><?php echo $form['info']['Id']; ?></td>
                        <td class="py-4 px-6"><?php echo $form['info']['HoTenDocGia']; ?></td>
                        <td class="py-4 px-6"><?php echo $form['info']['NgayDangKy']; ?></td>
                        <td class="py-4 px-6">
                            <div>
                                <div class="font-bold"><?php echo $form['books'][0]['TuaSach']; ?></div>
                                <div class="text-sm text-gray-600">Số lượng: <?php echo $form['books'][0]['SoLuong']; ?></div>
                            </div>
                        </td>
                        <td class="py-4 px-6"><?php echo $form['info']['NgayMuon']; ?></td>
                        <td class="py-4 px-6"><?php echo $form['info']['NgayTra']; ?></td>
                        <td class="py-4 px-6"><?php echo $form['totalBooks']; ?></td>
                        <td class="py-4 px-6 flex items-center"> <?php echo $statusIcon . ' &nbsp;&nbsp;' . $form['info']['TenTrangThai']; ?></td>
                    </tr>
                    <?php for ($i = 1; $i < count($form['books']); $i++): ?>
                        <tr class="hover:bg-gray-100 <?= $statusClass ?>">
                            <td class="py-4 px-6"></td>
                            <td class="py-4 px-6"></td>
                            <td class="py-4 px-6"></td>
                            <td class="py-4 px-6">
                                <div>
                                    <div class="font-bold"><?php echo $form['books'][$i]['TuaSach']; ?></div>
                                    <div class="text-sm text-gray-600">Số lượng: <?php echo $form['books'][$i]['SoLuong']; ?></div>
                                </div>
                            </td>
                            <td class="py-4 px-6"></td>
                            <td class="py-4 px-6"></td>
                            <td class="py-4 px-6"></td>
                            <td class="py-4 px-6 flex items-center"></td>
                        </tr>
                    <?php endfor; ?>
                    <tr class="border-t-2 border-gray-200"></tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="hover:bg-gray-100">
                    <td colspan="8" class="py-4 px-6 text-center">Không có phiếu đăng ký nào.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once dirname(__FILE__).'/../layouts/footer.php'; ?>
</body>
</html>
