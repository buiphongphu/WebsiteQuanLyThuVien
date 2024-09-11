<?php

class BinhLuanController {
    private $BinhLuanModel;

    public function __construct() {
        $this->BinhLuanModel = new BinhLuan();
    }

    public function getBinhLuanBySach($Id) {
        return $this->BinhLuanModel->getBinhLuanBySach($Id);
    }

    public function storeBinhLuan($Id_DocGia, $Id_Sach, $NoiDung, $NgayBinhLuan) {
        $this->BinhLuanModel->insert([
            'Id_DocGia' => $Id_DocGia,
            'Id_Sach' => $Id_Sach,
            'NoiDung' => $NoiDung,
            'NgayBinhLuan' => $NgayBinhLuan
        ]);
    }
}

