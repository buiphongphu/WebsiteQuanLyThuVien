<?php

class YeuThichSach{

    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function store($id_sach, $id_nguoidung)
    {
        try{
        $sql = "INSERT INTO yeuthichsach (id_Sach, id_DocGia) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_sach, $id_nguoidung]);
        } catch (PDOException $e) {
            Database::logError('Lỗi thêm sách yêu thích'. $e->getMessage());
            return false;
        }
    }

    public function delete($id_sach, $id_nguoidung)
    {
        try{
        $sql = "DELETE FROM yeuthichsach WHERE id_Sach = ? AND id_DocGia = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id_sach, $id_nguoidung]);
        } catch (PDOException $e) {
            Database::logError('Lỗi xóa sách yêu thích'. $e->getMessage());
            return false;
        }
    }

    public function getFavoriteBooks($id_nguoidung)
    {
        try{
        $sql = "SELECT s.id AS book_id, ds.TuaSach, COALESCE(h.Url, '') AS Url, t.Ho, t.Ten, n.TenNXB
            FROM yeuthichsach yt
            JOIN sach s ON yt.id_sach = s.id
            JOIN dausach ds ON s.Id_DauSach = ds.Id
            LEFT JOIN (
                SELECT id_dausach, MIN(Url) AS Url
                FROM image_sach
                GROUP BY id_dausach
            ) h ON ds.Id = h.id_dausach
            JOIN tacgia t ON ds.id_tacgia = t.id
            JOIN nhaxuatban n ON ds.id_nxb = n.id
            WHERE yt.id_DocGia = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_nguoidung]);
        return $stmt->fetchAll();
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy sách yêu thích'. $e->getMessage());
            return false;
        }
    }
}
