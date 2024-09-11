<?php

class DiemController
{
    private $DiemModel;

    public function __construct()
    {
        $this->DiemModel = new Diem();
    }

    public function createDiem(array $data_diem)
    {
        $this->DiemModel->insertDiem($data_diem);
    }

    public function updateDiem(array $data_diem)
    {
        $this->DiemModel->updateDiem($data_diem);
    }

    public function getDiemByIdTheTV($Id)
    {
        return $this->DiemModel->getDiemByIdTheTV($Id);
    }
}