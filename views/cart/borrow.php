<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['borrowDate']) && isset($data['returnDate'])) {
        $borrowDate = $data['borrowDate'];
        $returnDate = $data['returnDate'];
        $today = date("Y-m-d");
        $idDocGia = $_SESSION['user']['Id'];

        if ($borrowDate < $today) {
            echo json_encode(['success' => false, 'error' => 'Ngày mượn không được ở quá khứ.']);
            exit();
        }

        if ($returnDate <= $borrowDate) {
            echo json_encode(['success' => false, 'error' => 'Ngày trả phải sau ngày mượn.']);
            exit();
        }

        $borrowDateObj = new DateTime($borrowDate);
        $returnDateObj = new DateTime($returnDate);
        $interval = $borrowDateObj->diff($returnDateObj);
        if ($interval->days > 30) {
            echo json_encode(['success' => false, 'error' => 'Sách chỉ được mượn tối đa 30 ngày.']);
            exit();
        }

        $todayObj = new DateTime($today);
        $interval = $todayObj->diff($borrowDateObj);
        if ($interval->days > 3) {
            echo json_encode(['success' => false, 'error' => 'Chỉ được mượn sách tối đa 3 ngày trước ngày hiện tại.']);
            exit();
        }

        $totalQuantity = array_sum($_SESSION['cart']);
        if ($totalQuantity > 10) {
            echo json_encode(['success' => false, 'error' => 'Chỉ được mượn tối đa 10 cuốn sách.']);
            exit();
        }

        $docGiaController = new DocGiaController();
        $docGia = $docGiaController->getById($idDocGia);
        if (!$docGia['Id_TheTV']) {
            echo json_encode(['success' => false, 'error' => 'Độc giả chưa có thẻ thư viện.']);
            exit();
        }

        $theThuVienController = new TheThuVienController();
        $theThuVien = $theThuVienController->layTheChoDocGia($_SESSION['user']['Id']);
        if ($theThuVien['id_trangthai'] == 2) {
            echo json_encode(['success' => false, 'error' => 'Thẻ thư viện của bạn đã bị khóa.']);
            exit();
        }

        $sachController = new SachController();
        $dauSachController = new DauSachController();
        foreach ($_SESSION['cart'] as $bookId => $quantity) {
            $sach= $sachController->getById($bookId);
            $soLuongConLai = $dauSachController->getSoLuongKho($sach['Id_DauSach']);
            if ($soLuongConLai < $quantity) {
                echo json_encode(['success' => false, 'error' => 'Số lượng sách '.$sach['TuaSach'].' còn lại không đủ.']);
                exit();
            }
        }

        $dangKyData = [
            'NgayMuon' => $borrowDate,
            'NgayTra' => $returnDate,
            'NgayDangKy' => $today,
            'Id_DocGia' => $idDocGia,
        ];

        try {
            $dangKyMuonController = new DangKyMuonController();
            $chitietDangKyMuonController = new ChiTietDangKyMuonController();
            $dangKyId = $dangKyMuonController->create($dangKyData);
            if($dangKyId) {
                foreach ($_SESSION['cart'] as $bookId => $quantity) {
                    $chitietData = [
                        'Id_DangKy' => $dangKyId,
                        'Id_Sach' => $bookId,
                        'SoLuong' => $quantity
                    ];
                    $kq=$chitietDangKyMuonController->create($chitietData);
                }
                unset($_SESSION['cart']);
                echo json_encode(['success' => true]);
            } else {
               echo json_encode(['success' => false, 'error' => 'Mượn sách thất bại.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit();
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing required data.']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit();
}
?>
