<?php

class Sach
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
        SELECT
            sach.*,
            dausach.TuaSach,
            dausach.namxb,
            dausach.soluong,
            nhaxuatban.TenNXB,
            CONCAT(tacgia.Ho, ' ', tacgia.Ten) AS HoTenTacGia,
            GROUP_CONCAT(DISTINCT image_sach.Url ORDER BY image_sach.Id SEPARATOR ',') AS images
        FROM sach
        LEFT JOIN dausach ON sach.Id_DauSach = dausach.Id
        LEFT JOIN nhaxuatban ON dausach.id_nxb = nhaxuatban.Id
        LEFT JOIN tacgia ON dausach.id_tacgia = tacgia.Id
        LEFT JOIN image_sach ON dausach.Id = image_sach.id_dausach
        LEFT JOIN trangthai ON sach.id_trangthai = trangthai.Id
        GROUP BY sach.Id
    ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy dữ liệu sách: ' . $e->getMessage());
            return [];
        }
    }




    public function getById($id)
    {
        try{
        $stmt = $this->db->prepare("
     SELECT
    sach.Id AS SachId,
    sach.*,
    dausach.TuaSach,
    nhaxuatban.TenNXB,
    tacgia.Ho,
    tacgia.Ten,
    GROUP_CONCAT(DISTINCT image_sach.Url ORDER BY image_sach.Id SEPARATOR ',') AS images,
    trangthai.TenTrangThai
FROM sach
LEFT JOIN dausach ON sach.Id_DauSach = dausach.Id
LEFT JOIN nhaxuatban ON dausach.id_nxb = nhaxuatban.Id
LEFT JOIN tacgia ON dausach.id_tacgia = tacgia.Id
LEFT JOIN image_sach ON dausach.Id = image_sach.id_dausach
LEFT JOIN trangthai ON sach.Id_TrangThai = trangthai.Id
WHERE sach.Id = :Id
GROUP BY sach.Id, dausach.TuaSach, dausach.SoLuong, dausach.namxb, sach.Id_DauSach, dausach.id_tacgia, dausach.Id_nxb, sach.Id_TrangThai, nhaxuatban.TenNXB, tacgia.Ho, tacgia.Ten, trangthai.TenTrangThai

    ");
        $stmt->execute([':Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy dữ liệu sách: ' . $e->getMessage());
            return [];
        }
    }

    public function insert($data)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
            INSERT INTO sach (id_DauSach, id_trangthai)
            VALUES (:id_dausach, :id_trangthai)
        ");
            $stmt->execute([
                ':id_dausach' => $data['id_dausach'],
                ':id_trangthai' => $data['TrangThai']
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi khi thêm sách: ' . $e->getMessage());
            $this->db->rollBack();
            return false;
        }

    }

    public function update($data)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
            UPDATE sach
            SET TenSach = :TenSach,
                NamXB = :NamXB,
                SoLuong = :SoLuong,
                NgayNhap = :NgayNhap,
                Id_DauSach = :Id_DauSach,
                Id_NhaXuatBan = :Id_NhaXuatBan,
                Id_TacGia = :Id_TacGia
            WHERE Id = :Id
        ");
            $stmt->execute([
                ':TenSach' => $data['TenSach'],
                ':NamXB' => $data['NamXB'],
                ':SoLuong' => $data['SoLuong'],
                ':NgayNhap' => $data['NgayNhap'],
                ':Id_DauSach' => $data['Id_DauSach'],
                ':Id_NhaXuatBan' => $data['Id_NhaXuatBan'],
                ':Id_TacGia' => $data['Id_TacGia'],
                ':Id' => $data['Id']
            ]);
            if (isset($data['TenHinh']) && isset($data['Url'])) {
                $stmt = $this->db->prepare("
                SELECT * FROM image_sach WHERE Id_Sach = :Id
            ");
                $stmt->execute([':Id' => $data['Id']]);
                $imageSach = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($imageSach) {
                    $stmt = $this->db->prepare("
                    UPDATE image_sach
                    SET TenHinh = :TenHinh,
                        Url = :Url
                    WHERE Id_Sach = :Id
                ");
                    $stmt->execute([
                        ':TenHinh' => $data['TenHinh'],
                        ':Url' => $data['Url'],
                        ':Id' => $data['Id']
                    ]);
                } else {
                    $stmt = $this->db->prepare("
                    INSERT INTO image_sach (Id_Sach, TenHinh, Url)
                    VALUES (:Id, :TenHinh, :Url)
                ");
                    $stmt->execute([
                        ':TenHinh' => $data['TenHinh'],
                        ':Url' => $data['Url'],
                        ':Id' => $data['Id']
                    ]);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi khi cập nhật sách: ' . $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }


    public function delete($id)
    {
        $this->db->beginTransaction();

        try {
            $checkQuery = "SELECT COUNT(*) AS count FROM dangky_chitiet WHERE Id_Sach = :Id";
            $checkStmt = $this->db->prepare($checkQuery);
            $checkStmt->execute([':Id' => $id]);
            $result = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($result['count'] > 0) {
                $this->db->rollBack();
                $_SESSION['error_message'] = "Không thể xóa sách vì sách đã có trong đăng ký mượn.";
                header("Location: ?url=admin/quanlysach");
                exit();
            }

            $deleteStmt = $this->db->prepare("DELETE FROM sach WHERE Id = :Id");
            $deleteStmt->execute([':Id' => $id]);

            $rowCount = $deleteStmt->rowCount();
            if ($rowCount > 0) {
                $this->db->commit();
                $_SESSION['delete_message'] = "Xóa sách thành công!";
                header("Location: ?url=admin/quanlysach");
                exit();
            } else {
                $this->db->rollBack();
                $_SESSION['error_message'] = "Không tìm thấy sách để xóa.";
                header("Location: ?url=admin/quanlysach");
                exit();
            }
        } catch (PDOException $e) {
            $this->db->rollBack();
            $_SESSION['error_message'] = "Lỗi khi xóa sách";
            Database::logError('Lỗi khi xóa sách: ' . $e->getMessage());
            header("Location: ?url=admin/quanlysach");
            exit();
        }
    }


    public function getLastInsertId()
    {
        try{
        return $this->db->lastInsertId();
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy ID cuối cùng: ' . $e->getMessage());
            return 0;
        }
    }
    public function search($keyword)
    {
        try{
        $stmt = $this->db->prepare("
        SELECT
            sach.*,
            dausach.TuaSach,
            dausach.namxb,
            nhaxuatban.TenNXB,
            tacgia.Ho,
            tacgia.Ten,
            dausach.soluong,
            trangthai.TenTrangThai,
            GROUP_CONCAT(image_sach.Url) AS images
        FROM sach
        LEFT JOIN dausach ON sach.Id_DauSach = dausach.Id
        LEFT JOIN image_sach ON dausach.Id = image_sach.id_dausach
        LEFT JOIN trangthai ON sach.id_trangthai = trangthai.Id
        LEFT JOIN  nhaxuatban ON dausach.id_nxb = nhaxuatban.Id
        LEFT JOIN tacgia ON dausach.id_tacgia = tacgia.Id
        WHERE dausach.TuaSach LIKE :keyword OR dausach.namxb LIKE :keyword OR nhaxuatban.TenNXB LIKE :keyword OR tacgia.Ho LIKE :keyword OR tacgia.Ten LIKE :keyword
        GROUP BY sach.Id
    ");
        $stmt->execute([':keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi tìm kiếm sách: ' . $e->getMessage());
            return [];
        }
    }



    public function filter($id_loaisach)
    {
        try{
        $stmt = $this->db->prepare("
        SELECT
            sach.*,
            dausach.TuaSach,
            dausach.namxb,
            nhaxuatban.TenNXB,
            tacgia.Ho,
            tacgia.Ten,
            GROUP_CONCAT(image_sach.Url) AS images
        FROM sach
        LEFT JOIN dausach ON sach.Id_DauSach = dausach.Id
        LEFT JOIN image_sach ON dausach.Id = image_sach.id_dausach
        LEFT JOIN nhaxuatban ON dausach.id_nxb = nhaxuatban.Id
        LEFT JOIN tacgia ON dausach.id_tacgia = tacgia.Id
        LEFT JOIN loaisach ON dausach.id_loaisach = loaisach.Id
        WHERE loaisach.Id = :Id
        GROUP BY sach.Id
    ");
        $stmt->execute([':Id' => $id_loaisach]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lọc sách: ' . $e->getMessage());
            return [];
        }
    }



    public function getChiTietSach($id)
    {
        try{
        $stmt = $this->db->prepare("

        SELECT
            sach.Id AS SachId,
           sach.*,
            dausach.TuaSach,
            dausach.namxb,
            loaisach.TenLoai,
            nhaxuatban.TenNXB,
            tacgia.Ho,
            tacgia.Ten,
            GROUP_CONCAT(DISTINCT image_sach.Url ORDER BY image_sach.Id SEPARATOR ',') AS images,
            trangthai.TenTrangThai
        FROM sach
        LEFT JOIN dausach ON sach.Id_DauSach = dausach.Id
        LEFT JOIN nhaxuatban ON dausach.id_nxb = nhaxuatban.Id
        LEFT JOIN tacgia ON dausach.id_tacgia = tacgia.Id
        LEFT JOIN image_sach ON dausach.Id = image_sach.id_dausach
        LEFT JOIN trangthai ON sach.Id_TrangThai = trangthai.Id
        LEFT JOIN loaisach ON dausach.id_loaisach = loaisach.Id
        WHERE sach.Id = :Id
        GROUP BY sach.Id

        ");
        $stmt->execute([':Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy chi tiết sách: ' . $e->getMessage());
            return [];
        }
    }

    public function tongsach(){
        try{
        $query = "SELECT COUNT(*) AS Total FROM sach";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['Total'];
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy tổng sách: ' . $e->getMessage());
            return 0;
        }
    }

    public function findByTenSach(array $array)
    {
        try{
        $stmt = $this->db->prepare("SELECT * FROM sach WHERE TenSach = :TenSach");
        $stmt->execute($array);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi tìm sách theo tên: ' . $e->getMessage());
            return [];
        }
    }

    public function getBooksByIds(array $bookIds)
    {

        if (empty($bookIds)) {
            return [];
        }

        $inQuery = implode(',', array_fill(0, count($bookIds), '?'));
        try{
        $stmt = $this->db->prepare("
        SELECT
            sach.*,
            dausach.TuaSach,
            nhaxuatban.TenNXB,
            tacgia.Ho,
            tacgia.Ten,
            GROUP_CONCAT(DISTINCT image_sach.Url ORDER BY image_sach.Id SEPARATOR ',') AS images
        FROM sach
        LEFT JOIN dausach ON sach.Id_DauSach = dausach.Id
        LEFT JOIN nhaxuatban ON dausach.id_nxb = nhaxuatban.Id
        LEFT JOIN tacgia ON dausach.id_tacgia = tacgia.Id
        LEFT JOIN image_sach ON dausach.Id = image_sach.id_dausach
        WHERE sach.Id IN ($inQuery)
        GROUP BY sach.Id
    ");

        $stmt->execute($bookIds);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy sách theo ID: ' . $e->getMessage());
            return [];
        }
    }
}
?>
