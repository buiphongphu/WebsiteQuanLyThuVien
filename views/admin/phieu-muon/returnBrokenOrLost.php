<?php
$chiTietDangKyMuonController = new ChiTietDangKyMuonController();
$dangKyMuonController = new DangKyMuonController();
$phieuMuonController = new PhieuMuonController();
$phieumuon_id = $_GET['id'];
$phieumuon = $phieuMuonController->getPhieuMuonById($phieumuon_id);

if (isset($phieumuon['books']) && is_array($phieumuon['books'])) {
    $books = $phieumuon['books'];
} else {
    $books = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trả Sách Bị Hỏng Hoặc Mất</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<?php
require_once dirname(__FILE__) . '/../layouts/head.php';
require_once dirname(__FILE__) . '/../layouts/header.php';
?>
<body class="bg-gray-100 p-6">
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Trả Sách Bị Hỏng Hoặc Mất</h1>
    <form action="?url=admin/quanlyphieumuon/returnBrokenOrLost/handle_return" method="post"
          class="bg-white p-6 rounded shadow-md">
        <input type="hidden" name="phieumuon_id"
               value="<?= htmlspecialchars($phieumuon['phieumuon_id']) ?>">
        <?php foreach ($books as $sach): ?>
            <div class="mb-4 p-4 border border-gray-300 rounded">
                <h2 class="text-xl font-semibold mb-2"><?= htmlspecialchars($sach['TuaSach']) ?></h2>
                <p class="mb-2">Số lượng mượn: <?= htmlspecialchars($sach['SoLuong']) ?> quyển</p>
                <div class="mb-2">
                    <label for="quantity_<?= htmlspecialchars($sach['Id_DauSach']) ?>"
                           class="block mb-1">Số lượng bị hỏng hoặc mất:</label>
                    <input type="number" id="quantity_<?= htmlspecialchars($sach['Id_DauSach']) ?>"
                           name="quantity_<?= htmlspecialchars($sach['Id_DauSach']) ?>" min="0"
                           max="<?= htmlspecialchars($sach['SoLuong']) ?>"
                           class="border border-gray-300 p-2 rounded w-full"
                           required
                           pattern="\d+"
                           oninput="validity.valid||(value='');">
                </div>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="status_<?= htmlspecialchars($sach['Id_DauSach']) ?>"
                               value="9" class="mr-2" onchange="handleStatusChange(<?= htmlspecialchars($sach['Id_DauSach']) ?>)"
                               required>
                        <i class="fas fa-ban mr-1"></i> Hỏng
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="status_<?= htmlspecialchars($sach['Id_DauSach']) ?>"
                               value="12" class="mr-2" onchange="handleStatusChange(<?= htmlspecialchars($sach['Id_DauSach']) ?>)"
                               required>
                        <i class="fas fa-trash-alt mr-1"></i> Mất
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="status_<?= htmlspecialchars($sach['Id_DauSach']) ?>"
                               value="1" class="mr-2" onchange="handleStatusChange(<?= htmlspecialchars($sach['Id_DauSach']) ?>)"
                               required>
                        <i class="fas fa-check-circle mr-1"></i> Đủ sách
                    </label>
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded">
            <i class="fas fa-paper-plane mr-2"></i> Gửi
        </button>
    </form>
</div>
</body>
<script>
    function handleStatusChange(id) {
        const input = document.getElementById('quantity_' + id);
        const label = document.querySelector('label[for="quantity_' + id + '"]');
        const radio = document.querySelector('input[name="status_' + id + '"]:checked');
        if (radio.value === '1') {
            input.style.display = 'none';
            label.style.display = 'none';
        } else {
            input.style.display = 'block';
            label.style.display = 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('input[type="number"]');
        inputs.forEach(input => {
            input.addEventListener('input', function () {
                if (!(/^\d*$/.test(this.value))) {
                    this.value = this.value.replace(/[^\d]/g, '');
                }
                const max = parseInt(this.getAttribute('max'));
                if (parseInt(this.value) > max) {
                    this.value = max.toString();
                }
            });
        });
    });
</script>
<?php
require_once dirname(__FILE__) . '/../layouts/footer.php';
?>
</html>
