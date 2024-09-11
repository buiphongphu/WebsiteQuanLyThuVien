<?php
$phieuMuonController = new PhieuMuonController();
$sachHongHoacMatController = new SachHongHoacMatController();
$diemController = new DiemController();
$docGiaController = new DocGiaController();
$phieuTraController = new PhieuTraController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $phieumuon_id = $_POST['phieumuon_id'];
        $phieumuon = $phieuMuonController->getPhieuMuonById($phieumuon_id);

        if (!$phieumuon) {
            throw new Exception("Phiếu mượn không tồn tại!");
        }

        $NgayTra = date('Y-m-d');
        $data1 = [
            'Id_PhieuMuon' => $phieumuon_id,
            'Id_DocGia' => $phieumuon['Id_DocGia'],
            'NgayTra' => $NgayTra
        ];
        $phieutra = $phieuTraController->create($data1);
        if (!$phieutra) {
            throw new Exception("Trả sách thất bại!");
        }

        $returnedBooks = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'quantity_') === 0) {
                $idDauSach = str_replace('quantity_', '', $key);
                $quantity = (int)$value;
                $statusKey = 'status_' . $idDauSach;

                if (isset($_POST[$statusKey])) {
                    $status = $_POST[$statusKey];
                    $returnedBooks[] = [
                        'Id_DauSach' => $idDauSach,
                        'Quantity' => $quantity,
                        'Status' => $status
                    ];
                }

                $books = $phieumuon['books'];
                foreach ($books as $book) {
                    if ($book['Id_DauSach'] == $idDauSach) {
                        $soLuongConLai = $book['SoLuong'] - $quantity;
                        $data = [
                            'Id_DauSach' => $idDauSach,
                            'SoLuong' => $soLuongConLai
                        ];
                        $idSach = $phieuMuonController->getSachByIdDauSach($idDauSach);
                        $data1 = [
                            'Id_PhieuMuon' => $phieumuon_id,
                            'Id_Sach' => $idSach,
                            'SoLuong' => $quantity,
                            'Id_TrangThai' => $status
                        ];

                        if (!$phieuMuonController->updateSoLuong($data)) {
                            throw new Exception("Cập nhật số lượng sách thất bại!");
                        }

                        if ($quantity > 0) {
                            echo "<pre>".print_r($data1, true)."</pre>";
                            if (!$sachHongHoacMatController->create($data1)) {
                                throw new Exception("Trả sách thất bại!");
                            }
                        }

                        if (!$phieuMuonController->updateStatus($phieumuon_id, 1)) {
                            throw new Exception("Cập nhật trạng thái phiếu mượn thất bại!");
                        }

                        $docgia = $docGiaController->getDocGiaById($phieumuon['Id_DocGia']);
                        $NgayTra = date('Y-m-d');
                        $ngayTraPM = $phieumuon['NgayTra'];

                        if ($NgayTra > $ngayTraPM) {
                            $data_diem = [
                                'Id_TheTV' => $docgia['Id_TheTV'],
                                'Diem' => -100
                            ];
                            $diemController->updateDiem($data_diem);
                        } else {
                            $data_diem = [
                                'Id_TheTV' => $phieumuon['Id_DocGia'],
                                'Diem' => 50
                            ];
                            $diemController->updateDiem($data_diem);
                        }

                        if ($status == 9) {
                            $data_diem = [
                                'Id_TheTV' => $docgia['Id_TheTV'],
                                'Diem' => -400
                            ];
                            $diemController->updateDiem($data_diem);
                        }

                        if ($status == 12) {
                            $data_diem = [
                                'Id_TheTV' => $docgia['Id_TheTV'],
                                'Diem' => -500
                            ];
                            $diemController->updateDiem($data_diem);
                        }
                    }
                }
            }
        }

        $_SESSION['message'] = "Trả sách thành công!";
        header("Location: ?url=admin/quanlyphieumuon");
        exit();
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: ?url=admin/quanlyphieumuon");
        exit();
    }
}
?>
