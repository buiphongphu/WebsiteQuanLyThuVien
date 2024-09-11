<?php


class RegisterController
{
    private $registerModel;

    public function __construct()
    {
        $this->registerModel = new Register();
    }

    public function register($data)
    {
        return $this->registerModel->register($data);
    }

    public function kiemtra_email($email)
    {
        return $this->registerModel->kiemtra_email($email);
    }

    public function kiemtra_masodocgia($id_number)
    {
        return $this->registerModel->kiemtra_masodocgia($id_number);
    }

    public function getDocGiaByEmail(string $email)
    {
        return $this->registerModel->getDocGiaByEmail($email);
    }
}
