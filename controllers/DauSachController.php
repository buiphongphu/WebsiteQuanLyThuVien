<?php

class DauSachController
{
    private $dauSachModel;
    protected $imageModel;

    public function __construct()
    {
        $this->dauSachModel = new DauSach();
        $this->imageModel = new ImageSach();
    }

    public function index()
    {
        return $this->dauSachModel->getAll();
    }

    public function detail($id)
    {
        return $this->dauSachModel->getById($id);
    }

    public function create($data)
    {
        return $this->dauSachModel->insert($data);
    }

    public function update($data)
    {
        $id = $data['Id'];
        $selectedImageId = $data['selectedImageId'];
        $newImage = $_FILES['newImage'];

        $bookData = [
            'TuaSach' => $data['TuaSach'],
            'Id_TacGia' => $data['Id_TacGia'],
            'Id_NhaXuatBan' => $data['Id_NhaXuatBan'],
            'NamXuatBan' => $data['NamXuatBan'],
            'SoLuong' => $data['SoLuong'],
            'NgayNhap' => $data['NgayNhap'],
            'Id_LoaiSach' => $data['Id_LoaiSach']
        ];

        $isBookUpdated = $this->dauSachModel->update($id, $bookData);

        $isImageUpdated = $this->updateImages($id, $selectedImageId, $newImage);

        return $isBookUpdated && $isImageUpdated;
    }

    private function updateImages($id, $selectedImageId, $newImage)
    {
        if ($selectedImageId) {
            $this->imageModel->delete($selectedImageId);
        }

        if ($newImage['name']) {
            $targetDir = "public/uploads/";
            $targetFile = $targetDir . basename($newImage["name"]);
            move_uploaded_file($newImage["tmp_name"], $targetFile);

            $this->imageModel->insert([
                'TenHinh' => $newImage['name'],
                'Url' => $targetFile,
                'id_dausach' => $id
            ]);
        }

        return true;
    }

    public function delete($id)
    {
        return $this->dauSachModel->delete($id);
    }

    public function findByName($TenDauSach)
    {
        return $this->dauSachModel->findByName($TenDauSach);
    }

    public function findByTenCuon($TenCuon)
    {
        return $this->dauSachModel->findByTenCuon($TenCuon);
    }

    public function getDauSachById($Id_DauSach)
    {
        return $this->dauSachModel->getDauSachById($Id_DauSach);
    }

    public function searchDauSach($keyword)
    {
        return $this->dauSachModel->searchDauSach($keyword);
    }

    public function addImages($data)
    {
        return $this->imageModel->insert($data);
    }

    public function getSoLuongKho($idDauSach)
    {
        return $this->dauSachModel->getSoLuongKho($idDauSach);
    }



}
?>
