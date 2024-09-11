<?php

class ChiTietDangKyMuonController{
    private $chitietdangkymuonModel;

    public function __construct()
    {
        $this->chitietdangkymuonModel = new ChiTietDangKyMuon();
    }

    public function create($data)
    {
        return $this->chitietdangkymuonModel->insert($data);
    }

    public function getChiTietDangKyMuonById($phieumuon_id)
    {
        return $this->chitietdangkymuonModel->getChiTietDangKyMuonById($phieumuon_id);
    }



}
