<?php

$sachController = new SachController();
$phieuMuonController = new PhieuMuonController();
$phieuTraController= new PhieuTraController();
$docGiaController = new DocGiaController();

$tongSoSach = count($sachController->index());
$tongSoDocGia = count($docGiaController->index());
$tongPhieuMuon = $phieuMuonController->tongphieumuon();
$soSachDangMuon = $phieuMuonController->sosachdangmuon();
$soSachDaTra = $phieuMuonController->sosachdatra();
$soSachMuonQuaHan = $phieuMuonController->sosachmuonquahan();
$soSachTraDungHan = $phieuTraController->sosachtradunghan();
$soSachChuaTra = $phieuMuonController->sosachchuatra();
$soSachDaHuy = $phieuMuonController->sosachdahuy();
$phieuMuonToiHanTra = $phieuMuonController->phieumuontoiHanTra();
$PhieuMuonQuaHanTra = $phieuMuonController->phieumuonquahantra();
?>


<!DOCTYPE html>
<html>
<head>
    <?php require_once 'layouts/head.php'; ?>
</head>
<body class="bg-gray-100 font-sans">

<?php require_once 'layouts/header.php'; ?>

<div class="container mx-auto flex flex-wrap py-6">
    <?php require_once 'layouts/sidebar.php'; ?>

    <main class="w-full md:w-3/4 px-2">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold mb-4">Trang chủ</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div class="bg-blue-500 text-white p-4 rounded-lg flex items-center">
                    <i class="fas fa-book fa-2x mr-4"></i>
                    <div>
                        <p class="text-2xl font-bold"><?php echo $tongSoSach; ?></p>
                        <p class="text-sm">Tổng số sách</p>
                    </div>
                </div>
                <div class="bg-green-500 text-white p-4 rounded-lg flex items-center">
                    <i class="fas fa-users fa-2x mr-4"></i>
                    <div>
                        <p class="text-2xl font-bold"><?php echo $tongSoDocGia; ?></p>
                        <p class="text-sm">Tổng số độc giả</p>
                    </div>
                </div>
                <div class="bg-yellow-500 text-white p-4 rounded-lg flex items-center">
                    <i class="fas fa-file-alt fa-2x mr-4"></i>
                    <div>
                        <p class="text-2xl font-bold"><?php echo $tongPhieuMuon; ?></p>
                        <p class="text-sm">Tổng số phiếu mượn</p>
                    </div>
                </div>
            </div>
            <?php if (!empty($phieuMuonToiHanTra)): ?>
                <div class="mt-8">
                    <h3 class="text-xl font-bold mb-4">Phiếu mượn tới hạn trả</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-2 px-4">ID</th>
                                <th class="py-2 px-4">Tên Độc Giả</th>
                                <th class="py-2 px-4">Ngày Mượn</th>
                                <th class="py-2 px-4">Ngày Trả</th>
                                <th class="py-2 px-4">SĐT</th>
                                <th class="py-2 px-4">Sách Mượn</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($phieuMuonToiHanTra as $phieuMuon):
                                $ngayMuon = date('d/m/Y', strtotime($phieuMuon['NgayMuon']));
                                $ngayTra = date('d/m/Y', strtotime($phieuMuon['NgayTra']));
                                ?>
                                <tr>
                                    <td class="border px-4 py-2"><?php echo $phieuMuon['phieumuon_id']; ?></td>
                                    <td class="border px-4 py-2"><?php echo $phieuMuon['HoTenDocGia']; ?></td>
                                    <td class="border px-4 py-2"><?php echo $ngayMuon; ?></td>
                                    <td class="border px-4 py-2"><?php echo $ngayTra; ?></td>
                                    <td class="border px-4 py-2"><?php echo $phieuMuon['sdt']; ?></td>
                                    <td class="border px-4 py-2">
                                        <ul class="list-disc list-inside">
                                            <?php foreach ($phieuMuon['books'] as $book): ?>
                                                <li><?php echo $book['TuaSach'] . ' (' . $book['SoLuong'] . ')'; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>


            <?php if (!empty($PhieuMuonQuaHanTra)): ?>
                <div class="mt-8">
                    <h3 class="text-xl font-bold mb-4">Phiếu mượn quá hạn trả</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-800 text-white">
                            <tr>
                                <th class="py-2 px-4">ID</th>
                                <th class="py-2 px-4">Tên Độc Giả</th>
                                <th class="py-2 px-4">Ngày Mượn</th>
                                <th class="py-2 px-4">Ngày Trả</th>
                                <th class="py-2 px-4">SĐT</th>
                                <th class="py-2 px-4">Sách Mượn</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($PhieuMuonQuaHanTra as $phieuMuon):
                                $ngayMuon = date('d/m/Y', strtotime($phieuMuon['NgayMuon']));
                                $ngayTra = date('d/m/Y', strtotime($phieuMuon['NgayTra']));
                                ?>
                                <tr>
                                    <td class="border px-4 py-2"><?php echo $phieuMuon['phieumuon_id']; ?></td>
                                    <td class="border px-4 py-2"><?php echo $phieuMuon['HoTenDocGia']; ?></td>
                                    <td class="border px-4 py-2"><?php echo $ngayMuon; ?></td>
                                    <td class="border px-4 py-2"><?php echo $ngayTra; ?></td>
                                    <td class="border px-4 py-2"><?php echo $phieuMuon['sdt']; ?></td>
                                    <td class="border px-4 py-2">
                                        <ul class="list-disc list-inside">
                                            <?php foreach ($phieuMuon['books'] as $book): ?>
                                                <li><?php echo $book['TuaSach'] . ' (' . $book['SoLuong'] . ')'; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>



            <div class="mt-8">
                <h3 class="text-xl font-bold mb-4">Biểu đồ thống kê</h3>
                <canvas id="myChart"></canvas>
            </div>

        </div>
    </main>
</div>

<?php require_once 'layouts/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Đang Mượn', 'Đã Trả', 'Quá Hạn', 'Đúng Hạn', 'Chưa Trả', 'Đã Hủy'],
                datasets: [{
                    label: 'Số lượng sách',
                    data: [
                        <?php echo $soSachDangMuon; ?>,
                        <?php echo $soSachDaTra; ?>,
                        <?php echo $soSachMuonQuaHan; ?>,
                        <?php echo $soSachTraDungHan; ?>,
                        <?php echo $soSachChuaTra; ?>,
                        <?php echo $soSachDaHuy; ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        'rgba(255, 159, 64, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

</body>
</html>
