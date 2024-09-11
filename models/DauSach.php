<?php

class DauSach
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        try{
        $stmt = $this->db->prepare("
        SELECT ds.Id, ds.TuaSach, ds.namxb, ds.soluong, ds.ngaynhap,
               ls.TenLoai AS TenLoaiSach,
               CONCAT(tg.Ho, ' ', tg.Ten) AS HoTenTacGia,
               nxb.TenNXB,
               GROUP_CONCAT(i.url) AS images
        FROM dausach ds
        LEFT JOIN loaisach ls ON ds.Id_LoaiSach = ls.Id
        LEFT JOIN tacgia tg ON ds.id_tacgia = tg.Id
        LEFT JOIN nhaxuatban nxb ON ds.id_nxb = nxb.Id
        LEFT JOIN image_sach i ON ds.Id = i.id_dausach
        GROUP BY ds.Id
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy dữ liệu đầu sách: ' . $e->getMessage());
            return false;
        }
    }


    public function getById($id)
    {
        try{
        $stmt = $this->db->prepare("SELECT ds.*, ls.TenLoai AS TenLoaiSach
                                    FROM dausach ds
                                    LEFT JOIN loaisach ls ON ds.Id_LoaiSach = ls.Id
                                    WHERE ds.Id = :Id");
        $stmt->execute([':Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy dữ liệu đầu sách: ' . $e->getMessage());
            return false;
        }
    }

    public function insert($data)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO dausach (TuaSach, Id_LoaiSach, id_nxb, id_tacgia, namxb, soluong,ngaynhap) VALUES (:TuaSach, :Id_LoaiSach, :Id_NhaXuatBan, :Id_TacGia, :NamSanXuat, :SoLuong,:NgayNhap)");
            $result = $stmt->execute([
                ':TuaSach' => $data['TuaSach'],
                ':Id_LoaiSach' => $data['Id_LoaiSach'],
                ':Id_NhaXuatBan' => $data['Id_NXB'],
                ':Id_TacGia' => $data['Id_TacGia'],
                ':NamSanXuat' => $data['NamXuatBan'],
                ':SoLuong' => $data['SoLuong'],
                ':NgayNhap' => $data['NgayNhap']
            ]);
            return $this->db->lastInsertId();

        } catch (PDOException $e) {
            Database::logError('Lỗi thêm đầu sách: ' . $e->getMessage());
            return false;
        }
    }


    public function delete($id)
    {
        $this->db->beginTransaction();

        try {
            $checkQuery = "SELECT COUNT(*) AS count
                        FROM dangky_chitiet
                        JOIN sach ON dangky_chitiet.id_sach = sach.Id
                        JOIN dausach ON sach.Id_DauSach = dausach.Id
                        WHERE dausach.Id = :id_dausach";
            $checkStmt = $this->db->prepare($checkQuery);
            $checkStmt->execute([':id_dausach' => $id]);
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {
                $this->db->rollBack();
                $_SESSION['error_message'] = "Không thể xóa đầu sách vì có sách đã được đăng ký mượn liên quan đến đầu sách này.";
                header("Location: ?url=admin/quanlydausach");
                exit();
            }

            $deleteImagesStmt = $this->db->prepare("DELETE FROM image_sach WHERE id_dausach = :Id");
            $deleteImagesStmt->execute([':Id' => $id]);

            $deleteSachStmt = $this->db->prepare("DELETE FROM sach WHERE Id_DauSach = :Id");
            $deleteSachStmt->execute([':Id' => $id]);

            $deleteDauSachStmt = $this->db->prepare("DELETE FROM dausach WHERE Id = :Id");
            $deleteDauSachStmt->execute([':Id' => $id]);

            $this->db->commit();
            $_SESSION['delete_message'] = "Xóa đầu sách thành công!";
            header("Location: ?url=admin/quanlydausach");
            exit();
        } catch (PDOException $e) {
            $this->db->rollBack();
            $_SESSION['error_message'] = "Lỗi khi xóa đầu sách";
            Database::logError('Lỗi xóa đầu sách: ' . $e->getMessage());
            header("Location: ?url=admin/quanlydausach");
            exit();
        }
    }




    public function findByName($TenDauSach)
    {
        try{
        $stmt = $this->db->prepare("SELECT * FROM dausach WHERE TenDauSach = :TenDauSach");
        $stmt->execute([':TenDauSach' => $TenDauSach]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi tìm kiếm đầu sách: ' . $e->getMessage());
            return false;
        }
    }

    public function findByTenCuon($TenCuon)
    {
        try{
        $stmt = $this->db->prepare("SELECT * FROM dausach WHERE TenCuon = :TenCuon");
        $stmt->execute([':TenCuon' => $TenCuon]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi tìm kiếm đầu sách: ' . $e->getMessage());
            return false;
        }
    }

    public function getDauSachById($Id_DauSach)
    {
        try{
        $stmt = $this->db->prepare("SELECT * FROM dausach WHERE Id = :Id");
        $stmt->execute([':Id' => $Id_DauSach]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi tìm kiếm đầu sách: ' . $e->getMessage());
            return false;
        }
    }

    public function searchDauSach($keyword)
    {
        try{
        $stmt = $this->db->prepare("SELECT ds.Id, ds.TuaSach, ds.namxb, ds.soluong, ds.ngaynhap,
               ls.TenLoai AS TenLoaiSach,
               CONCAT(tg.Ho, ' ', tg.Ten) AS HoTenTacGia,
               nxb.TenNXB,
               GROUP_CONCAT(i.url) AS images
        FROM dausach ds
        LEFT JOIN loaisach ls ON ds.Id_LoaiSach = ls.Id
        LEFT JOIN tacgia tg ON ds.id_tacgia = tg.Id
        LEFT JOIN nhaxuatban nxb ON ds.id_nxb = nxb.Id
        LEFT JOIN image_sach i ON ds.Id = i.id_dausach
        WHERE ds.TuaSach LIKE :keyword OR ds.namxb LIKE :keyword OR ds.soluong LIKE :keyword OR ds.ngaynhap LIKE :keyword OR ls.TenLoai LIKE :keyword OR tg.Ho LIKE :keyword OR tg.Ten LIKE :keyword OR nxb.TenNXB LIKE :keyword
        GROUP BY ds.Id");
        $stmt->execute([':keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi tìm kiếm đầu sách: ' . $e->getMessage());
            return false;
        }

    }

    public function update($id, array $bookData)
    {
        try {
            $stmt = $this->db->prepare("UPDATE dausach SET
                TuaSach = :TuaSach,
                Id_LoaiSach = :Id_LoaiSach,
                id_nxb = :Id_NXB,
                id_tacgia = :Id_TacGia,
                namxb = :NamXuatBan,
                soluong = :SoLuong,
                ngaynhap = :NgayNhap
                WHERE Id = :Id");

            $result = $stmt->execute([
                ':TuaSach' => $bookData['TuaSach'],
                ':Id_LoaiSach' => $bookData['Id_LoaiSach'],
                ':Id_NXB' => $bookData['Id_NhaXuatBan'],
                ':Id_TacGia' => $bookData['Id_TacGia'],
                ':NamXuatBan' => $bookData['NamXuatBan'],
                ':SoLuong' => $bookData['SoLuong'],
                ':NgayNhap' => $bookData['NgayNhap'],
                ':Id' => $id
            ]);

            return $result;
        } catch (PDOException $e) {
            Database::logError('Lỗi cập nhật đầu sách: ' . $e->getMessage());
            return false;
        }
    }

    public function getSoLuongKho($idDauSach)
    {
        try{
        $stmt = $this->db->prepare("SELECT soluong FROM dausach WHERE Id = :Id");
        $stmt->execute([':Id' => $idDauSach]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['soluong'];
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy số lượng kho: ' . $e->getMessage());
            return false;
        }
    }

}
?>
