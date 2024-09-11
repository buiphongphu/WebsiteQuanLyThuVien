<?php


class BinhLuan{

    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getBinhLuanBySach($Id)
    {
        try{
        $stmt = $this->db->prepare("
            SELECT * FROM binhluan
            WHERE Id_Sach = :Id
        ");
        $stmt->execute([
            ':Id' => $Id
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);}
        catch (PDOException $e) {
            Database::logError('Lỗi khi lấy bình luận: ' . $e->getMessage());
            return [];
        }
    }

    public function insert(array $data): bool {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
            INSERT INTO binhluan (Id_DocGia, Id_Sach, NoiDung, NgayBinhLuan)
            VALUES (:Id_DocGia, :Id_Sach, :NoiDung, :NgayBinhLuan)
        ");
            $stmt->execute([
                ':Id_DocGia' => $data['Id_DocGia'],
                ':Id_Sach' => $data['Id_Sach'],
                ':NoiDung' => $data['NoiDung'],
                ':NgayBinhLuan' => $data['NgayBinhLuan']
            ]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            Database::logError('Lỗi khi thêm bình luận: ' . $e->getMessage());
            return false;
        }
    }



}
