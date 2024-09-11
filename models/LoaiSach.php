<?php

class LoaiSach
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        try{
        $query = $this->db->query("SELECT * FROM loaisach");
        return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy thông tin loại sách'. $e->getMessage());
        }
    }

    public function insert($data)
    {
        try{
        $stmt = $this->db->prepare("INSERT INTO loaisach (TenLoai) VALUES (:TenLoai)");
        return $stmt->execute([
            ':TenLoai' => $data['TenLoai']
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi thêm loại sách'. $e->getMessage());
        }
    }

    public function getById($id)
    {
        try{
        $stmt = $this->db->prepare("SELECT * FROM loaisach WHERE Id = :Id");
        $stmt->execute([':Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy thông tin loại sách'. $e->getMessage());
        }
    }

    public function update($data)
    {
        try{
        $stmt = $this->db->prepare("UPDATE loaisach SET TenLoai = :TenLoai WHERE Id = :Id");
        return $stmt->execute([
            ':TenLoai' => $data['TenLoai'],
            ':Id' => $data['Id']
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi cập nhật loại sách'. $e->getMessage());
        }
    }

    public function delete($id)
    {
        try{
        $stmt = $this->db->prepare("DELETE FROM loaisach WHERE Id = :Id");
        return $stmt->execute([':Id' => $id]);
        } catch (PDOException $e) {
            Database::logError('Lỗi xóa loại sách'. $e->getMessage());
        }
    }

    public function existsByName($TenLoai)
    {
        try{
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM loaisach WHERE TenLoai = :TenLoai");
        $stmt->execute([':TenLoai' => $TenLoai]);
        return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            Database::logError('Lỗi kiểm tra loại sách'. $e->getMessage());
        }
    }
}
?>
