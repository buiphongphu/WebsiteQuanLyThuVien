<?php

class ImageSach
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        try{
        $query = $this->db->query("SELECT * FROM image_sach");
        return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy thông tin hình ảnh:', $e->getMessage());
        }
    }

    public function getById($id)
    {
        try{
        $stmt = $this->db->prepare("SELECT * FROM image_sach WHERE id_dausach = :Id");
        $stmt->execute([':Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy thông tin hình ảnh:', $e->getMessage());
        }
    }

    public function insert($data)
    {
        try{
        $stmt = $this->db->prepare("INSERT INTO image_sach (TenHinh, Url, id_dausach) VALUES (:TenHinh, :Url, :id_dausach)");
        return $stmt->execute([
            ':TenHinh' => $data['TenHinh'],
            ':Url' => $data['Url'],
            ':id_dausach' => $data['id_dausach']
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi thêm hình ảnh:', $e->getMessage());
        }
    }

    public function update($data)
    {
        try{
        $stmt = $this->db->prepare("UPDATE image_sach SET TenHinh = :TenHinh, Url = :Url WHERE Id_Sach = :Id_Sach");
        return $stmt->execute([
            ':TenHinh' => $data['TenHinh'],
            ':Url' => $data['Url'],
            ':Id_Sach' => $data['Id_Sach']
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi cập nhật hình ảnh:', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try{
        $stmt = $this->db->prepare("DELETE FROM image_sach WHERE id_dausach = :Id");
        return $stmt->execute([':Id' => $id]);
        } catch (PDOException $e) {
            Database::logError('Lỗi xóa hình ảnh:', $e->getMessage());
        }
    }

    public function layUrl($Id)
    {
        try{
        $stmt = $this->db->prepare("SELECT Id,Url FROM image_sach WHERE id_dausach = :Id");
        $stmt->execute([':Id' => $Id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy thông tin hình ảnh:', $e->getMessage());
        }
    }
}
?>
