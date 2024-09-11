<?php

class DangKyMuonController{
    private $dangkymuonModel;

    public function __construct()
    {
        $this->dangkymuonModel = new DangKyMuon();
    }

    public function create($data)
    {
        return $this->dangkymuonModel->insert($data);
    }
    public function layDanhSachChoDuyet($Id_DangKy)
    {
        return $this->dangkymuonModel->getChoDuyet($Id_DangKy);
    }

    public function updateStatus($Id_DangKy, $status)
    {
        return $this->dangkymuonModel->updateStatus($Id_DangKy, $status);
    }

    public function getDanhSachChoDuyet()
    {
        return $this->dangkymuonModel->getDanhSachChoDuyet();
    }

    public function updateDangKyMuon($data)
    {
        return $this->dangkymuonModel->updateDangKyMuon($data);
    }

    public function getDangKyMuonById($id)
    {
        return $this->dangkymuonModel->getDangKyMuonById($id);
    }

    public function getSoLuongSachDaMuon($idDocGia, $idSach, $idDauSach)
    {
        return $this->dangkymuonModel->getSoLuongSachDaMuon($idDocGia, $idSach, $idDauSach);
    }

    public function getSoLuongSachMuonTrongNgay($Id, $ngayHienTai)
    {
        return $this->dangkymuonModel->getSoLuongSachMuonTrongNgay($Id, $ngayHienTai);
    }

    public function getDanhSachDangKy($Id)
    {
        return $this->dangkymuonModel->getDanhSachDangKy($Id);
    }

    public function searchDanhSachChoDuyet($keyword)
    {
        return $this->dangkymuonModel->searchDanhSachChoDuyet($keyword);
    }

    public function getDangKyMuon($phieumuon_id)
    {
        return $this->dangkymuonModel->getDangKyMuon($phieumuon_id);
    }
}
