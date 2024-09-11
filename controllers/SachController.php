<?php

class SachController
{
    private $db;
    private $sachModel;
    private $dauSachModel;
    private $nhaXuatBanModel;
    private $tacGiaModel;
    private $imageSachModel;

    private $trangThaiSachModel;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->sachModel = new Sach();
        $this->dauSachModel = new DauSach();
        $this->nhaXuatBanModel = new NhaXuatBan();
        $this->tacGiaModel = new TacGia();
        $this->imageSachModel = new ImageSach();
        $this->trangThaiSachModel = new TrangThai();
    }

    public function index()
    {
        return $this->sachModel->getAll();
    }

    public function detail($id)
    {
        $sach = $this->sachModel->getById($id);
        if (!$sach) {
            return false;
        }

        return $sach;
    }

    public function create($data)
    {
        $dausach = $this->dauSachModel->getById($data['Id_DauSach']);
        $nhaxuatban = $this->nhaXuatBanModel->getById($data['Id_NhaXuatBan']);
        $tacgia = $this->tacGiaModel->getById($data['Id_TacGia']);

        $data['TenDauSach'] = $dausach['TenDauSach'];
        $data['TenNXB'] = $nhaxuatban['TenNXB'];
        $data['HoTacGia'] = $tacgia['Ho'];
        $data['TenTacGia'] = $tacgia['Ten'];

        return $this->sachModel->insert($data);
    }

    public function update($data)
    {
        $dausach = $this->dauSachModel->getById($data['Id_DauSach']);
        $nhaxuatban = $this->nhaXuatBanModel->getById($data['Id_NhaXuatBan']);
        $tacgia = $this->tacGiaModel->getById($data['Id_TacGia']);

        $data['TenDauSach'] = $dausach['TenDauSach'];
        $data['TenNXB'] = $nhaxuatban['TenNXB'];
        $data['HoTacGia'] = $tacgia['Ho'];
        $data['TenTacGia'] = $tacgia['Ten'];

        return $this->sachModel->update($data);
    }

    public function delete($id)
    {
        return $this->sachModel->delete($id);
    }

    public function getAllDauSach()
    {
        return $this->dauSachModel->getAll();
    }

    public function getAllNhaXuatBan()
    {
        return $this->nhaXuatBanModel->getAll();
    }

    public function getAllTacGia()
    {
        return $this->tacGiaModel->getAll();
    }

    public function getAllImageSach()
    {
        return $this->imageSachModel->getAll();
    }

   public function searchSach($keyword)
    {
        return $this->sachModel->search($keyword);
    }

    public function filterSach($id)
    {
        return $this->sachModel->filter($id);
    }

    public function getChiTietSach($id) {
        return $this->sachModel->getChiTietSach($id);
    }

    public function tongsosach() {
        return $this->sachModel->tongsach();
    }

    public function findByTenSach(array $array)
    {
        return $this->sachModel->findByTenSach($array);
    }

    public function getSachById($Id_Sach)
    {
        return $this->sachModel->getById($Id_Sach);
    }

    public function getAllTrangThai()
    {
        return $this->trangThaiSachModel->getAll();
    }

    public function getDauSachById($id)
    {
        return $this->dauSachModel->getById($id);
    }

    public function getBooksByIds(array $bookIds)
    {
        return $this->sachModel->getBooksByIds($bookIds);
    }

    public function search($searchKeyword)
    {
        return $this->sachModel->search($searchKeyword);
    }

    public function getById(int $bookId)
    {
        return $this->sachModel->getById($bookId);
    }


}

?>
