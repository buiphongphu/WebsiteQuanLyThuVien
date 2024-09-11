<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['trang_thai'])) {
        $id = $_POST['id'];
        if($_POST['trang_thai'] == 'Đã duyệt') {
            $trangThai = 7;
        } else {
            $trangThai = 8;
        }

        $theThuVienController = new TheThuVienController();
        $diemController= new DiemController();
        $docGiaController = new DocGiaController();

        $theThuVienController->capNhatTrangThaiThe($id, $trangThai);
        $data_diem=[
            'Id_TheTV'=> $id,
            'Diem' => 200,
        ];
        $diemController->createDiem($data_diem);
        header('Location: ?url=admin/quanlythethuvien');
        exit();
    } else {
        echo "Lỗi: Thiếu dữ liệu cần thiết.";
    }
} else {
    echo "Lỗi: Phương thức không được hỗ trợ.";
}

?>
