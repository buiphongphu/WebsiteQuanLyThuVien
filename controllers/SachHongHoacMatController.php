<?php


class SachHongHoacMatController{
    private $sachhonghoacmatModel;

    public function __construct()
    {
        $this->sachhonghoacmatModel = new SachHongHoacMat();
    }

    public function create(array $data)
    {
        return $this->sachhonghoacmatModel->insert($data);
    }

    public function getDanhSachXuPhat()
    {
        return $this->sachhonghoacmatModel->getAll();
    }

    public function getDanhSachXuPhatById($idPhieu)
    {
        return $this->sachhonghoacmatModel->getById($idPhieu);
    }

    public function updateStatus($id)
    {
        return $this->sachhonghoacmatModel->updateStatus($id);
    }


}