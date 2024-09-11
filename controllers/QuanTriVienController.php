<?php

class QuanTriVienController
{
    private $quanTriVienModel;

    public function __construct()
    {
        $this->quanTriVienModel = new QuanTriVien();
    }

    public function index()
    {
        return $this->quanTriVienModel->getAll();
    }

    public function detail($id)
    {
        return $this->quanTriVienModel->getById($id);
    }

    public function create($data)
    {
        return $this->quanTriVienModel->insert($data);
    }

    public function update($data)
    {
        return $this->quanTriVienModel->update($data);
    }

    public function delete($id)
    {
        return $this->quanTriVienModel->delete($id);
    }

    public function checkExistingEmail($Email)
    {
        $quanTriVien = $this->quanTriVienModel->getByEmail($Email);
        return $quanTriVien ? true : false;
    }

    public function searchDocGia($keyword)
    {
        return $this->quanTriVienModel->search($keyword);
    }

    public function getPassword($id)
    {
        $quanTriVien = $this->quanTriVienModel->getById($id);
        return $quanTriVien['Password'];
    }

    public function getEmail($id)
    {
        $quanTriVien = $this->quanTriVienModel->getById($id);
        return $quanTriVien['Email'];
    }

    public function updatePassword($email, $password_hash)
    {
        return $this->quanTriVienModel->updatePassword($email, $password_hash);
    }


}
?>
