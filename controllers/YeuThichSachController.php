<?php

class YeuThichSachController{
    private $yeuThichSachModel;

    public function __construct() {
        $this->yeuThichSachModel = new YeuThichSach();
    }

    public function store($id_sach, $id_nguoidung){
        $this->yeuThichSachModel->store($id_sach, $id_nguoidung);
    }

    public function delete($id_sach, $id_nguoidung){
        $this->yeuThichSachModel->delete($id_sach, $id_nguoidung);
    }

    public function getFavoriteBooks($id_nguoidung){
        return $this->yeuThichSachModel->getFavoriteBooks($id_nguoidung);
    }
}
