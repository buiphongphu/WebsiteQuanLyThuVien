<?php

class GiaHan {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function giaHanPhieuMuon(array $data) {
        try {
            $this->db->beginTransaction();

            $sql1 = "INSERT INTO giahan (id_PhieuMuon, ngaytramoi, id_DocGia) VALUES (:id_PhieuMuon, :NgayTraMoi, :id_DocGia)";
            $stmt1 = $this->db->prepare($sql1);
            $stmt1->bindParam(':id_PhieuMuon', $data['id_PhieuMuon'], PDO::PARAM_INT);
            $stmt1->bindParam(':NgayTraMoi', $data['NgayTraMoi'], PDO::PARAM_STR);
            $stmt1->bindParam(':id_DocGia', $data['id_DocGia'], PDO::PARAM_INT);
            $stmt1->execute();

            $sql2 = "SELECT id_dangky FROM phieumuonsach WHERE Id = :id_PhieuMuon";
            $stmt2 = $this->db->prepare($sql2);
            $stmt2->bindParam(':id_PhieuMuon', $data['id_PhieuMuon'], PDO::PARAM_INT);
            $stmt2->execute();
            $result = $stmt2->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $id_dangky = $result['id_dangky'];

                $sql3 = "UPDATE dangky SET NgayTra = :NgayTraMoi WHERE Id = :id_dangky";
                $stmt3 = $this->db->prepare($sql3);
                $stmt3->bindParam(':NgayTraMoi', $data['NgayTraMoi'], PDO::PARAM_STR);
                $stmt3->bindParam(':id_dangky', $id_dangky, PDO::PARAM_INT);
                $stmt3->execute();
            } else {
                $this->db->rollBack();
                return false;
            }

            $this->db->commit();

            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi gia hạn phiếu mượn: '.$e->getMessage());
            $this->db->rollBack();
            throw $e;
        }
    }

    public function checkGiaHan(array $data) {
        try{
        $sql = "SELECT COUNT(*) AS count FROM giahan WHERE id_PhieuMuon = :id_PhieuMuon AND id_DocGia = :id_DocGia";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_PhieuMuon', $data['id_PhieuMuon'], PDO::PARAM_INT);
        $stmt->bindParam(':id_DocGia', $data['id_DocGia'], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['count'] >= 1;
        } catch (Exception $e) {
            Database::logError('Lỗi kiểm tra gia hạn: '.$e->getMessage());
            throw $e;
        }
    }
}
?>
