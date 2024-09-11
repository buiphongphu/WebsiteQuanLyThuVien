<?php

class DanhGiaController
{
    private $danhGiaModel;

    public function __construct()
    {
        $this->danhGiaModel = new DanhGia();
    }

    public function store($userId, $sachId, $diem, $noiDung, $ngayDanhGia)
    {
       $this->danhGiaModel->insert($userId, $sachId, $diem, $noiDung, $ngayDanhGia);
    }

    public function getAverageRating($sachId)
    {
        return $this->danhGiaModel->getAverageRating($sachId);
    }

    public function getAllRatings($sachId)
    {
        return $this->danhGiaModel->getAllRatings($sachId);
    }

    public function getFeaturedBooks()
    {
        return $this->danhGiaModel->getFeaturedBooks();
    }


}
