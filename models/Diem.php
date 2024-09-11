<?php

class Diem{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function insertDiem(array $data_diem)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
            INSERT INTO diem (Id_TheTV, Diem)
            VALUES (:Id_TheTV, :Diem)
        ");
            $stmt->execute([
                ':Id_TheTV' => $data_diem['Id_TheTV'],
                ':Diem' => $data_diem['Diem']
            ]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            Database::logError('Lỗi khi thêm điểm: ' . $e->getMessage());
            return false;
        }
    }

    public function updateDiem(array $data_diem)
    {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
            UPDATE diem
            SET Diem = Diem + :Diem
            WHERE Id_TheTV = :Id_TheTV
        ");
            $stmt->execute([
                ':Id_TheTV' => $data_diem['Id_TheTV'],
                ':Diem' => $data_diem['Diem']
            ]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            Database::logError('Lỗi khi cập nhật điểm: ' . $e->getMessage());
            return false;
        }
    }

    public function getDiemByIdTheTV($Id)
    {
        try{
        $stmt = $this->db->prepare("
            SELECT * FROM diem
            WHERE Id_TheTV = :Id
        ");
        $stmt->execute([':Id' => $Id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy điểm: ' . $e->getMessage());
            return false;
        }
    }
}
