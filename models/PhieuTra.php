<?php

class PhieuTra{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function insert($data)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
                INSERT INTO phieutra (Id_PhieuMuon, Id_DocGia, NgayTra)
                VALUES (:Id_PhieuMuon, :Id_DocGia, :NgayTra)
            ");
            $stmt->execute([
                ':Id_DocGia' => $data['Id_DocGia'],
                ':Id_PhieuMuon'=>$data['Id_PhieuMuon'],
                ':NgayTra' => $data['NgayTra']
            ]);
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi khi thêm phiếu trả: ' . $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }

    public function sosachtradunghan()
    {
        try{
        $stmt = $this->db->prepare("
             SELECT COUNT(*) as sosachtradunghan
            FROM phieutra
            JOIN phieumuonsach ON phieumuonsach.Id = phieutra.Id_PhieuMuon
            JOIN dangky ON phieumuonsach.id_DangKy=dangky.Id
            WHERE  phieutra.NgayTra < dangky.NgayTra OR phieutra.NgayTra = dangky.NgayTra
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['sosachtradunghan'];
        } catch (Exception $e) {
            Database::logError('Lỗi khi lấy số sách trả đúng hạn: ' . $e->getMessage());
            return false;
        }
    }
}
