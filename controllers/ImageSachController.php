<?php

class ImageSachController
{
    private $imageSachModel;

    public function __construct()
    {
        $this->imageSachModel = new ImageSach();

    }

    public function index()
    {
        return $this->imageSachModel->getAll();
    }

    public function detail($id)
    {
        return $this->imageSachModel->getById($id);
    }

    public function create($data)
    {
        return $this->imageSachModel->insert($data);
    }

    public function update($data)
    {
        return $this->imageSachModel->update($data);
    }

    public function delete($id)
    {
        return $this->imageSachModel->delete($id);
    }

    public function getById($Id)
    {
        return $this->imageSachModel->getById($Id);
    }

    public function insert(array $imageData)
    {
        return $this->imageSachModel->insert($imageData);
    }

    public function layUrl($Id)
    {
        return $this->imageSachModel->layUrl($Id);
    }


}
?>
