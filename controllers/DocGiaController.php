<?php

class DocGiaController
{
    private $docGiaModel;

    public function __construct()
    {
        $this->docGiaModel = new DocGia();
    }

    public function index()
    {
        return $this->docGiaModel->getAll();
    }

    public function detail($id)
    {
        return $this->docGiaModel->getById($id);
    }

    public function create($data)
    {
        return $this->docGiaModel->insert($data);
    }

    public function update($data)
    {
        return $this->docGiaModel->update($data);
    }


    public function delete($id)
    {
        return $this->docGiaModel->delete($id);
    }

    public function tongdocgia()
    {
        return $this->docGiaModel->tong();
    }

    public function getById($id)
    {
        return $this->docGiaModel->getById($id);
    }

    public function checkExistingMaSo($MaSo)
    {
        return $this->docGiaModel->checkExistingMaSo($MaSo);
    }

    public function checkExistingEmail($Email)
    {
        return $this->docGiaModel->checkExistingEmail($Email);
    }

    public function getDocGiaById($Id_DocGia)
    {
        return $this->docGiaModel->getDocGiaById($Id_DocGia);
    }

    public function searchDocGia($keyword)
    {
        return $this->docGiaModel->searchDocGia($keyword);
    }

    public function checkEmail($email)
    {
        return $this->docGiaModel->checkEmail($email);
    }

    public function updatePassword($email, $password_hash)
    {
        return $this->docGiaModel->updatePassword($email, $password_hash);
    }

    public function getPassword($id)
    {
        return $this->docGiaModel->getPassword($id);
    }

    public function getEmail($id)
    {
        return $this->docGiaModel->getEmail($id);
    }

    public function getDocGiaByIdTheTV($Id)
    {
        return $this->docGiaModel->getDocGiaByIdTheTV($Id);
    }
}
?>
