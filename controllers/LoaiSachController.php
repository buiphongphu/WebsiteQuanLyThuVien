<?php

class LoaiSachController
{
    private $loaiSachModel;

    public function __construct()
    {
        $this->loaiSachModel = new LoaiSach();
    }

    public function index()
    {
        return $this->loaiSachModel->getAll();
    }

    public function detail($id)
    {
        return $this->loaiSachModel->getById($id);
    }

    public function create($data)
    {
        return $this->loaiSachModel->insert($data);
    }

    public function update($data)
    {
        return $this->loaiSachModel->update($data);
    }

    public function delete($id)
    {
        return $this->loaiSachModel->delete($id);
    }

    public function existsByName($TenLoai)
    {
        return $this->loaiSachModel->existsByName($TenLoai);
    }
}
?>
