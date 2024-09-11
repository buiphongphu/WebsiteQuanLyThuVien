<?php

class GiaHanController
{
    private $giaHanModel;

    public function __construct()
    {
        $this->giaHanModel = new GiaHan();
    }

    public function giaHanPhieuMuon(array $data)
    {
        $this->giaHanModel->giaHanPhieuMuon($data);
    }

    public function checkGiaHan(array $data)
    {
        return $this->giaHanModel->checkGiaHan($data);
    }




}
