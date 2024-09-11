<?php

class PhieuTraController{
    private $phieuTraModel;

    public function __construct()
    {
        $this->phieuTraModel = new PhieuTra();
    }

    public function create($data)
    {
        return $this->phieuTraModel->insert($data);
    }

    public function sosachtradunghan()
    {
        return $this->phieuTraModel->sosachtradunghan();
    }

}
