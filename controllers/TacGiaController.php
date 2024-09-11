<?php

class TacGiaController
{
    private $tacGiaModel;

    public function __construct()
    {
        $this->tacGiaModel = new TacGia();
    }

    public function index()
    {
        return $this->tacGiaModel->getAll();
    }

    public function detail($id)
    {
        return $this->tacGiaModel->getById($id);
    }

    public function create($data)
    {
        return $this->tacGiaModel->insert($data);
    }

    public function update($data)
    {
        return $this->tacGiaModel->update($data);
    }

    public function delete($id)
    {
        return $this->tacGiaModel->delete($id);
    }


    public function searchTacGia($keyword)
    {
        return $this->tacGiaModel->search($keyword);
    }
}
?>
