<?php

class PhieuMuonController
{
    private $phieuMuonModel;

    public function __construct()
    {
        $this->phieuMuonModel = new PhieuMuon();
    }

    public function create($data)
    {
        return $this->phieuMuonModel->insert($data);
    }

    public function duyet($id)
    {
        return $this->phieuMuonModel->duyet($id);
    }

    public function getDanhSachPhieuMuon()
    {
        return $this->phieuMuonModel->getDanhSachPhieuMuon();
    }

    public function getPhieuMuonById($id)
    {
        return $this->phieuMuonModel->getPhieuMuonById($id);
    }

    public function cancelPhieuMuon($id)
    {
        return $this->phieuMuonModel->cancelPhieuMuon($id);
    }

    public function receivePhieuMuon($id)
    {
        return $this->phieuMuonModel->receivePhieuMuon($id);
    }

    public function getPhieuMuonByUserId($Id)
    {
        return $this->phieuMuonModel->getPhieuMuonByUserId($Id);
    }

    public function tongphieumuon()
    {
        return $this->phieuMuonModel->tongphieumuon();
    }

    public function sosachdangmuon()
    {
        return $this->phieuMuonModel->sosachdangmuon();
    }

    public function sosachdatra()
    {
        return $this->phieuMuonModel->sosachdatra();
    }

    public function sosachmuonquahan()
    {
        return $this->phieuMuonModel->sosachmuonquahan();
    }

    public function sosachmuondunghan()
    {
        return $this->phieuMuonModel->sosachmuondunghan();
    }

    public function sosachchuatra()
    {
        return $this->phieuMuonModel->sosachchuatra();
    }

    public function sosachdahuy()
    {
        return $this->phieuMuonModel->sosachdahuy();
    }

    public function phieumuontoiHanTra()
    {
        return $this->phieuMuonModel->phieumuontoiHanTra();
    }

    public function getPhieuMuonHistory($userId)
    {
        return $this->phieuMuonModel->getPhieuMuonHistory($userId);
    }

    public function phieumuonquahantra()
    {
        return $this->phieuMuonModel->phieumuonquahantra();
    }

    public function updateQuantity(array $data1)
    {
        return $this->phieuMuonModel->updateQuantity($data1);
    }

    public function updateSoLuong(array $data)
    {
        return $this->phieuMuonModel->updateSoLuong($data);
    }

    public function updateStatus($id, int $int)
    {
        return $this->phieuMuonModel->updateStatus($id, $int);
    }

    public function getSachByIdDauSach( $idDauSach)
    {
        return $this->phieuMuonModel->getSachByIdDauSach($idDauSach);
    }


}
