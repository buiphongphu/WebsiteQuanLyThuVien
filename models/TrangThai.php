<?php

class TrangThai{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getTrangThaiById($id_trangthai)
    {
        try{
        $sql = "SELECT * FROM trangthai WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_trangthai]);
        return $stmt->fetch();
        }catch(PDOException $e){
            Database::logError('Lỗi khi lấy trạng thái theo id'. $e->getMessage());
            return false;
        }
    }

    public function getAll()
    {
        try{
        $sql = "SELECT * FROM trangthai";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
        }catch(PDOException $e){
            Database::logError('Lỗi khi lấy tất cả trạng thái'. $e->getMessage());
            return false;
        }
    }

    public function getTrangThai($id)
    {
        try{
        $sql = "SELECT * FROM trangthai WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
        }catch(PDOException $e){
            Database::logError('Lỗi khi lấy trạng thái'. $e->getMessage());
            return false;
        }
    }


}
