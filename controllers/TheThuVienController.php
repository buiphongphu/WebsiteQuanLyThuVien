<?php

class TheThuVienController
{
    private $theThuVienModel;

    public function __construct()
    {
        $this->theThuVienModel = new TheThuVien();
    }

    public function layTheChoDocGia($id)
    {
        return $this->theThuVienModel->layTheThuVienCuaDocGia($id);
    }

    public function layTheThuVienDangChoPheDuyet()
    {
        return $this->theThuVienModel->layTheThuVienDangChoPheDuyet();
    }

    public function capNhatTrangThaiThe($id, $trangThai)
    {
        return $this->theThuVienModel->capNhatTrangThaiThe($id, $trangThai);
    }

    public function dangKyThe($loaiThe, $ngayLapThe, $ngayHetHan)
    {
        $result = $this->theThuVienModel->dangKyThe($_SESSION['user']['Id'], $loaiThe, $ngayHetHan);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getById($Id)
    {
        return $this->theThuVienModel->getById($Id);
    }

    public function layTheThuVienDaDuyet()
    {
        return $this->theThuVienModel->layTheThuVienDaDuyet();
    }

    public function printCard($id)
    {
        return $this->theThuVienModel->printCard($id);
    }

    public function timKiemTheThuVien($keyword)
    {
        return $this->theThuVienModel->timKiemTheThuVien($keyword);
    }

    public function layTheThuVienBiKhoa()
    {
        return $this->theThuVienModel->layTheThuVienBiKhoa();
    }

    public function updateTrangThaiThe($Id, int $int)
    {
        return $this->theThuVienModel->updateTrangThaiThe($Id, $int);
    }

    public function capNhatNgayHetHan($Id, $ngayHetHan)
    {
        return $this->theThuVienModel->capNhatNgayHetHan($Id, $ngayHetHan);
    }

    public function getTopMembers()
    {
        return $this->theThuVienModel->getTopMembers();
    }
    public function getDownsMembers()
    {
        return $this->theThuVienModel->getDownsMembers();
    }

    public function xoaTheThuVien($Id)
    {
        return $this->theThuVienModel->xoaTheThuVien($Id);
    }

    public function createTheThuVien($unit,  $ngaytaothe, $ngayhethan, $activation_code)
    {
        return $this->theThuVienModel->createTheThuVien($unit, $ngaytaothe, $ngayhethan, $activation_code);
    }

    public function kiemtra_makichhoat($activation_code)
    {
        return $this->theThuVienModel->kiemtra_makichhoat($activation_code);
    }

    public function layThongTinTheThuVienById($id)
    {
        return $this->theThuVienModel->layThongTinTheThuVienById($id);
    }
}


?>
