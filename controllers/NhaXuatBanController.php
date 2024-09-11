<?php

class NhaXuatBanController
{
    private $nxbModel;

    public function __construct()
    {
        $this->nxbModel = new NhaXuatBan();
    }

    public function index()
    {
        return $this->nxbModel->getAll();
    }

    public function add()
    {
        require_once '../views/add.php';
    }

    public function store()
    {
        $data = [
            'TenNXB' => $_POST['TenNXB'],
            'DiaChiNXB' => $_POST['DiaChiNXB']
        ];
        $this->nxbModel->insert($data);
        $_SESSION['success_message'] = "Thêm nhà xuất bản thành công!";
        header("Location: index.php");
    }

    public function edit()
    {
        $id = $_GET['id'];
        $nxb = $this->nxbModel->getById($id);
        require_once '../views/edit.php';
    }

    public function update()
    {
        $data = [
            'Id' => $_POST['Id'],
            'TenNXB' => $_POST['TenNXB'],
            'DiaChiNXB' => $_POST['DiaChiNXB']
        ];
        $this->nxbModel->update($data);
        $_SESSION['success_message'] = "Cập nhật nhà xuất bản thành công!";
        header("Location: index.php");
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->nxbModel->delete($id);
        $_SESSION['delete_message'] = "Xóa nhà xuất bản thành công!";
        header("Location: index.php");
    }

    public function search($keyword)
    {
        return $this->nxbModel->search($keyword);
    }
}
?>
