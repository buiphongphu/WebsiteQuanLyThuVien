<?php


if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}

$Id_DangKy = $_GET['id'];
$status = $_GET['status'];

$dangKyMuonController = new DangKyMuonController();
$phieuMuonController = new PhieuMuonController();
$diemController = new DiemController();
$dauSachController= new DauSachController();
$docGiaController = new DocGiaController();

try {
  if ($status == 'da_duyet') {
      $dangKyList = $dangKyMuonController->layDanhSachChoDuyet($Id_DangKy);
      if ($dangKyList) {
            $dangKy = $dangKyList[0];
            $idDocGia = isset($dangKy['Id_DocGia']) ? $dangKy['Id_DocGia'] : null;
            $idDangKy = isset($dangKy['id_dangky']) ? $dangKy['id_dangky'] : null;
            $idQTV = isset($dangKy['Id_QTV']) ? $dangKy['Id_QTV'] : null;

            $data= [
                'Id_QTV' => $_SESSION['admin']['Id'],
                'Id_DocGia' => $idDocGia,
                'id_DangKy' => $idDangKy,
            ];

            foreach ($dangKyList as $dangKy) {
                $idDauSach = isset($dangKy['sach_id']) ? $dangKy['sach_id'] : null;
                $soLuong = isset($dangKy['SoLuong']) ? $dangKy['SoLuong'] : null;
                $soLuongKho=$dauSachController->getSoLuongKho($idDauSach);
                $soLuongConLai = $soLuongKho-$soLuong;
                if ($soLuongConLai < 0) {
                   $message = "Số lượng sách trong kho không đủ!";
                   header("Location: ?url=admin/quanlydangkymuon&message=" . urlencode($message));
                     exit();
                }
            }


          $pm=$phieuMuonController->create($data);
          if($pm) {
              foreach ($dangKyList as $dangKy) {
                  $idDauSach = isset($dangKy['sach_id']) ? $dangKy['sach_id'] : null;
                  $soLuong = isset($dangKy['SoLuong']) ? $dangKy['SoLuong'] : null;

                  $data1 = [
                      'SoLuong' => $soLuong,
                      'Id_DauSach' => $idDauSach
                  ];
                  $phieuMuonController->updateQuantity($data1);
                  $dangKyMuonController->updateStatus($Id_DangKy, 7);
                  $docGia = $docGiaController->getDocGiaById($idDocGia);
                    $idTheTV = isset($docGia['Id_TheTV']) ? $docGia['Id_TheTV'] : null;
                  $data_diem=[
                      'Id_TheTV'=> $idTheTV,
                      'Diem' => $soLuong*10,
                  ];
                  $diemController->updateDiem($data_diem);
                  $message = "Duyệt đăng ký thành công!";
              }
          }


      }
  }else {
        $status = 8;
        if ($dangKyMuonController->updateStatus($Id_DangKy, $status)) {
            $message = "Cập nhật trạng thái thành công!";
        } else {
            throw new Exception("Cập nhật trạng thái thất bại!");
        }
    }
} catch (Exception $e) {
    $message = $e->getMessage();
}
header("Location: ?url=admin/quanlydangkymuon&message=" . urlencode($message));
exit();

?>
