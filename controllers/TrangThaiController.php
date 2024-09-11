<?php

class TrangThaiController{
    private $TrangThaiModel;

    public function __construct() {
        $this->TrangThaiModel = new TrangThai();
    }

    public function getTrangThaiById($id_trangthai)
    {
        return $this->TrangThaiModel->getTrangThaiById($id_trangthai);
    }

    public function getAll()
    {
        return $this->TrangThaiModel->getAll();
    }

    public function getTrangThai($id)
    {
        return $this->TrangThaiModel->getTrangThai($id);
    }


}
