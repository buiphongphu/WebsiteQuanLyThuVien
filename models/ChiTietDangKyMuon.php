<?php

class ChiTietDangKyMuon{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function insert($data)
    {
        try {
            $stmt = $this->db->prepare("
            INSERT INTO dangky_chitiet (id_dangky, id_sach, SoLuong)
            VALUES (:Id_DangKy, :Id_Sach, :SoLuong)
        ");
            $stmt->execute([
                ':Id_DangKy' => $data['Id_DangKy'],
                ':Id_Sach' => $data['Id_Sach'],
                ':SoLuong' => $data['SoLuong']
            ]);
            return $this->db->lastInsertId();
        }
        catch (PDOException $e) {
            Database::logError("Lỗi thêm chi tiết đăng ký mượn: " . $e->getMessage());
            return false;
        }
    }

    public function getChiTietDangKyMuonById($phieumuon_id)
    {
        try {
            $stmt = $this->db->prepare("
            SELECT * FROM dangky_chitiet WHERE id_dangky = :id_dangky
        ");
            $stmt->execute([':id_dangky' => $phieumuon_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result === false) {
                return [];
            }

            return $result;
        } catch (PDOException $e) {
            Database::logError("Lỗi lấy chi tiết đăng ký mượn theo id: " . $e->getMessage());
            return [];
        }
    }




}
