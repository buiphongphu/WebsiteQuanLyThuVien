<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thẻ Thư Viện</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="public/images/2p.png" type="image/x-icon">
    <style>
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        .highlight {
            background: linear-gradient(90deg, rgba(29, 78, 216, 0.1), rgba(29, 78, 216, 0.2));
        }
    </style>
</head>
<body class="bg-gray-100">

<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';

if (!isset($_SESSION['user'])) {
    header('Location: ?url=login');
    exit();
}

$theThuVienController = new TheThuVienController();
$theThuVien = $theThuVienController->layTheChoDocGia($_SESSION['user']['Id']);
$trangThaiController = new TrangThaiController();
if ($theThuVien) {
    $trangThai = $trangThaiController->getTrangThaiById($theThuVien['id_trangthai']);
    $trangThai = $trangThai['tentrangthai'];
} else {
    $trangThai = '';
}

$diemController= new DiemController();
$diem = $diemController->getDiemByIdTheTV($_SESSION['user']['Id_TheTV']);


function formatDate($date)
{
    return date('d/m/Y', strtotime($date));
}
?>

<div class="container mx-auto mt-8">
    <h1 class="text-4xl font-bold text-center mb-8 text-blue-600">Thẻ Thư Viện Của Bạn</h1>
    <div class="bg-white p-8 rounded-lg shadow-lg grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="card transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-105">
            <?php if ($theThuVien): ?>
                <div class="border-b pb-4 mb-4">
                    <p class="flex items-center mb-2"><i class="fas fa-id-card mr-2 text-blue-600"></i> Loại Thẻ: <span class="font-bold ml-2 text-gray-700"><?php echo htmlspecialchars($theThuVien['LoaiThe']); ?></span></p>
                    <p class="flex items-center mb-2"><i class="fas fa-calendar-alt mr-2 text-blue-600"></i> Ngày Lập Thẻ: <span class="font-bold ml-2 text-gray-700"><?php echo htmlspecialchars(formatDate($theThuVien['NgayLapThe'])); ?></span></p>
                    <p class="flex items-center mb-2"><i class="fas fa-calendar-check mr-2 text-blue-600"></i> Ngày Hết Hạn: <span class="font-bold ml-2 text-gray-700"><?php echo htmlspecialchars(formatDate($theThuVien['NgayHetHan'])); ?></span></p>
                    <p class="flex items-center mb-4"><i class="fas fa-info-circle mr-2 text-blue-600"></i> Trạng Thái: <span class="font-bold ml-2 text-gray-700"><?php echo htmlspecialchars($trangThai); ?></span></p>
                    <?php if ($diem): ?>
                        <p class="flex items-center mb-2"><i class="fas fa-star mr-2 text-blue-600"></i> Điểm: <span class="font-bold ml-2 text-gray-700"><?php echo htmlspecialchars($diem['diem']); ?> Point</span></p>
                        <p class="flex items-center mb-2"><i class="fas fa-medal mr-2 text-blue-600"></i> Xếp Hạng: <span class="font-bold ml-2 text-gray-700"><?php echo htmlspecialchars($diem['thuhang']); ?></span></p>
                    <?php endif; ?>
                </div>
                <?php
                $expirationDate = strtotime($theThuVien['NgayHetHan']);
                $currentDate = strtotime(date('Y-m-d'));
                $daysRemaining = ($expirationDate - $currentDate) / 86400;
                $ngayhethan = $theThuVien['NgayHetHan'];
                $ngayhientai = date('Y-m-d');
                if (strtotime($ngayhethan) === strtotime($ngayhientai)) {
                    if (isset($theThuVienController)) {
                        $theThuVienController->xoaTheThuVien($theThuVien['Id']);
                        $theThuVien = null;
                    } else {
                        echo 'Không thể xóa thẻ thư viện. Đối tượng không tồn tại.';
                    }
                } else {
                    echo 'Thẻ thư viện vẫn còn hạn.';
                }

                $daysRemaining = abs((int)$daysRemaining);
                if ($daysRemaining <= 7): ?>
                    <div class="highlight p-4 rounded-lg">
                        <p class="text-red-500 font-bold">Thẻ của bạn còn <?=$daysRemaining?> ngày sử dụng. Vui lòng gia hạn thẻ để tiếp tục sử dụng.</p>
                        <div class="mt-4 flex justify-center">
                            <a href="?url=the-thu-vien/giahan" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg"><i class="fas fa-sync-alt mr-2"></i> Gia Hạn Thẻ</a>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($trangThai == 'đã duyệt'): ?>
                    <p class="mt-4 text-green-500"><i class="fas fa-check-circle mr-2"></i> Thẻ của bạn đang hoạt động.</p>
                <?php elseif ($trangThai == 'từ chối'): ?>
                    <p class="mt-4 text-red-500"><i class="fas fa-times-circle mr-2"></i> Thẻ của bạn đã bị từ chối. Vui lòng liên hệ quản trị viên hoặc gặp trực tiếp để biết thêm chi tiết.</p>
                <?php elseif($trangThai == 'đã khóa'): ?>
                    <p class="mt-4 text-red-500"><i class="fas fa-hourglass-half mr-2"></i> Thẻ của bạn bị khóa. Vui lòng chờ quản trị viên để mở lại.</p>
                <?php else: ?>
                    <div class="mt-4 flex justify-center">
                        <a href="?url=the-thu-vien/active" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg"><i class="fas fa-check-circle mr-2"></i> Kích Hoạt Thẻ</a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-red-500"><i class="fas fa-exclamation-circle mr-2"></i> Bạn chưa có thẻ thư viện.</p>
                <div class="mt-4 flex justify-center">
                    <a href="?url=the-thu-vien/dangky" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg"><i class="fas fa-id-card mr-2"></i> Đăng Ký Thẻ Thư Viện</a>
                </div>
            <?php endif; ?>

        </div>

        <div>
            <h2 class="text-2xl font-bold mb-4 text-blue-600">Hướng Dẫn Sử Dụng Thẻ Khi Ở Thư Viện</h2>
            <ul class="list-disc list-inside text-gray-700">
                <li>Thẻ thư viện chỉ dành cho người muốn mượn sách tại thư viện 2P.</li>
                <li>Thẻ phải được bảo quản cẩn thận, tránh làm mất hoặc hư hỏng.</li>
                <li>Thẻ phải được gia hạn trước ngày hết hạn.</li>
                <li>Thẻ có thể được sử dụng để mượn sách và tài liệu tại thư viện.</li>
                <li>Nếu thẻ bị mất, vui lòng liên hệ ngay với quản trị viên để được cấp lại thẻ mới.</li>
                <li>Thẻ sẽ bị thu hồi nếu vi phạm quy định của thư viện.</li>
                <li>Vui lòng xuất trình thẻ khi mượn sách tại thư viện.</li>
                <li>Nếu bạn mới đăng ký sẽ được cấp 200 Point.</li>
                <li>Trả sách đúng hạn sẽ được cộng 50 Point, mỗi khi mượn sách sẽ +10 Point/ Số lượng sách mượn.</li>
                <li>Nếu trả sách trễ hạn sẽ bị -100 Point cho một lần mượn.</li>
                <li>Thứ hạn (50-999): 2P,(1000-4999): 2PSilver,(5000-9999): 2PGold,(10000 trở lên): 2PVIP</li>
            </ul>
        </div>
        <div class="mt-4 flex justify-center">
            <p>
                <i class="fas fa-exclamation-circle mr-2"></i>
                <strong> Lưu ý:</strong> Sau khi tạo thẻ thành công thì hãy đến gặp quản trị viên để nhận thẻ thư viện.
            </p>
        </div>
    </div>
</div>
<div class="container mx-auto mt-8">
    <div class="flex justify-center">
        <a href="?url=index" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-lg mt-8"><i class="fas fa-arrow-left mr-2"></i> Quay Lại Trang Chủ</a>
    </div>
</div>

<?php require_once dirname(__FILE__) . '/../layouts/footer.php'; ?>
</body>
</html>
