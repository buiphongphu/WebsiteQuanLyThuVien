<?php

class DangKyMuon {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function insert($data) {
        try {
            $stmt = $this->db->prepare("
            INSERT INTO dangky (Id_DocGia, NgayMuon, NgayTra, NgayDangKy, id_trangthai)
            VALUES (:Id_DocGia, :NgayMuon, :NgayTra, :NgayDangKy, 6)
        ");
            $stmt->execute([
                ':Id_DocGia' => $data['Id_DocGia'],
                ':NgayMuon' => $data['NgayMuon'],
                ':NgayTra' => $data['NgayTra'],
                ':NgayDangKy' => $data['NgayDangKy']
            ]);
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            Database::logError('Lỗi khi thêm phiếu mượn: ' . $e->getMessage());
            return false;
        }
    }

    public function getChoDuyet($Id_DangKy)
    {
        try{
        $stmt = $this->db->prepare("
       SELECT dk.*, dkct.*, ds.Id as sach_id, ds.TuaSach
        FROM dangky dk
        LEFT JOIN dangky_chitiet dkct ON dk.Id = dkct.id_dangky
        LEFT JOIN sach s ON dkct.id_sach = s.Id
        LEFT JOIN dausach ds ON s.Id_DauSach = ds.Id
        WHERE dk.Id = :Id AND dk.id_trangthai = 6;
    ");
        $stmt->execute([':Id' => $Id_DangKy]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            Database::logError('Lỗi khi lấy phiếu mượn: ' . $e->getMessage());
            return [];
        }
    }

    public function updateStatus($Id_DangKy, $status)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
            UPDATE dangky
            SET id_trangthai = :TrangThai
            WHERE Id = :Id
        ");
            $stmt->execute([
                ':TrangThai' => $status,
                ':Id' => $Id_DangKy
            ]);

            if ($status == 8) {
                $stmt = $this->db->prepare("
                SELECT dkct.*, s.Id_DauSach
                FROM dangky_chitiet dkct
                JOIN sach s ON dkct.id_sach = s.Id
                WHERE dkct.id_dangky = :Id
            ");
                $stmt->execute([
                    ':Id' => $Id_DangKy
                ]);
               $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi khi cập nhật trạng thái phiếu mượn: ' . $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }

    public function getDanhSachChoDuyet()
    {
        try{
        $stmt = $this->db->prepare("
        SELECT dk.Id as dangky_id, dk.Id_DocGia, dk.NgayDangKy, dk.id_trangthai,
               dkct.id_sach, dkct.SoLuong,
               ds.TuaSach, concat(dg.Ho,' ',dg.Ten) as HoTenDocGia, tt.tentrangthai
        FROM dangky dk
        LEFT JOIN dangky_chitiet dkct ON dk.Id = dkct.id_dangky
        LEFT JOIN sach s ON dkct.id_sach = s.Id
        LEFT JOIN dausach ds ON s.Id_DauSach = ds.Id
        LEFT JOIN docgia dg ON dk.Id_DocGia = dg.Id
        LEFT JOIN trangthai tt ON dk.id_trangthai = tt.Id
        WHERE dk.id_trangthai = 6
    ");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $groupedResults = [];
        foreach ($results as $row) {
            $dangkyId = $row['dangky_id'];
            if (!isset($groupedResults[$dangkyId])) {
                $groupedResults[$dangkyId] = [
                    'dangky_id' => $row['dangky_id'],
                    'Id_DocGia' => $row['Id_DocGia'],
                    'HoTenDocGia' => $row['HoTenDocGia'],
                    'NgayDangKy' => $row['NgayDangKy'],
                    'id_trangthai' => $row['id_trangthai'],
                    'tentrangthai' => $row['tentrangthai'],
                    'books' => []
                ];
            }
            $groupedResults[$dangkyId]['books'][] = [
                'id_sach' => $row['id_sach'],
                'TuaSach' => $row['TuaSach'],
                'SoLuong' => $row['SoLuong']
            ];
        }

        return $groupedResults;
        }
        catch (PDOException $e) {
            Database::logError('Lỗi khi lấy danh sách phiếu mượn: ' . $e->getMessage());
            return [];
        }
    }


    public function updateDangKyMuon($data) {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
            SELECT * FROM dangky WHERE Id = :Id
        ");
            $stmt->execute([
                ':Id' => $data['id']
            ]);
            $dangKyMuon = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$dangKyMuon) {
                throw new Exception("Phiếu mượn không tồn tại.");
            }

            $chenhLech = $data['soLuong'] - $dangKyMuon['SoLuong'];

            $stmt = $this->db->prepare("
            UPDATE sach
            SET SoLuong = SoLuong - :ChenhLech
            WHERE Id = :Id_Sach
        ");
            $stmt->execute([
                ':ChenhLech' => $chenhLech,
                ':Id_Sach' => $dangKyMuon['Id_sach']
            ]);

            $stmt = $this->db->prepare("
            UPDATE dangky
            SET SoLuong = :SoLuong, NgayTra = :NgayTra
            WHERE Id = :Id
        ");
            $stmt->execute([
                ':SoLuong' => $data['soLuong'],
                ':NgayTra' => $data['ngayTra'],
                ':Id' => $data['id']
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi khi cập nhật phiếu mượn: ' . $e->getMessage());
            $this->db->rollBack();
            throw $e;
        }
    }

    public function getDangKyMuonById($id)
    {
        try{
        $stmt = $this->db->prepare("
            SELECT * FROM dangky
            WHERE Id = :Id
        ");
        $stmt->execute([
            ':Id' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            Database::logError('Lỗi khi lấy phiếu mượn: ' . $e->getMessage());
            return [];
        }
    }

    public function getSoLuongSachDaMuon($idDocGia, $idSach, $idDauSach)
    {
        try{
        $stmt = $this->db->prepare("
            SELECT SUM(SoLuong) as SoLuong
            FROM dangky
            WHERE Id_DocGia = :Id_DocGia AND Id_Sach = :Id_Sach AND Id_DauSach = :Id_DauSach
        ");
        $stmt->execute([
            ':Id_DocGia' => $idDocGia,
            ':Id_Sach' => $idSach,
            ':Id_DauSach' => $idDauSach
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['SoLuong'] ? $result['SoLuong'] : 0;
        }
        catch (PDOException $e) {
            Database::logError('Lỗi khi lấy số lượng sách đã mượn: ' . $e->getMessage());
            return 0;
        }
    }

    public function getSoLuongSachMuonTrongNgay($Id, $ngayHienTai) {
        try{
        if (!$ngayHienTai instanceof DateTime) {
            $ngayHienTai = new DateTime($ngayHienTai);
        }


        $stmt = $this->db->prepare("
        SELECT SUM(SoLuong) as SoLuong
        FROM dangky
        WHERE Id_DocGia = :Id AND NgayDangKy = :NgayDangKy
    ");
        $ngayHienTai = $ngayHienTai->format('Y-m-d');
        $stmt->execute([
            ':Id' => $Id,
            ':NgayDangKy' => $ngayHienTai
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['SoLuong'] ? $result['SoLuong'] : 0;
        }
        catch (PDOException $e) {
            Database::logError('Lỗi khi lấy số lượng sách mượn trong ngày: ' . $e->getMessage());
            return 0;
        }
    }

    public function getDanhSachDangKy($Id)
    {
        try{
        $stmt = $this->db->prepare("
            SELECT dangky.Id,concat(docgia.Ho,' ',docgia.Ten) as HoTenDocGia, dangky.NgayDangKy, dangky.NgayMuon, dangky.NgayTra, dausach.TuaSach, trangthai.TenTrangThai,dangky_chitiet.SoLuong
            FROM dangky
            JOIN docgia ON dangky.Id_DocGia = docgia.Id
            JOIN trangthai ON dangky.id_trangthai = trangthai.Id
            JOIN dangky_chitiet ON dangky.Id = dangky_chitiet.id_dangky
            JOIN sach ON dangky_chitiet.id_sach = sach.Id
            JOIN dausach ON sach.Id_DauSach = dausach.Id
            WHERE docgia.Id = :Id
        ");
        $stmt->execute(
            [':Id' => $Id]
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            Database::logError('Lỗi khi lấy danh sách đăng ký: ' . $e->getMessage());
            return [];
        }
    }

    public function searchDanhSachChoDuyet($keyword) {
        try{
        $keyword = "%" . $keyword . "%";
        $stmt = $this->db->prepare("
            SELECT dk.Id as dangky_id, dk.Id_DocGia, dk.NgayDangKy, dk.id_trangthai,
               dkct.id_sach, dkct.SoLuong,
               ds.TuaSach, concat(dg.Ho,' ',dg.Ten) as HoTenDocGia, tt.tentrangthai
            FROM dangky dk
            LEFT JOIN dangky_chitiet dkct ON dk.Id = dkct.id_dangky
            LEFT JOIN sach s ON dkct.id_sach = s.Id
            LEFT JOIN dausach ds ON s.Id_DauSach = ds.Id
            LEFT JOIN docgia dg ON dk.Id_DocGia = dg.Id
            LEFT JOIN trangthai tt ON dk.id_trangthai = tt.Id
            WHERE dk.id_trangthai = 6
            AND (
                Id_DocGia IN (SELECT Id FROM docgia WHERE Ho LIKE :Keyword OR Ten LIKE :Keyword)
                OR
                Id_Sach IN (
                    SELECT Id FROM sach
                    WHERE Id_DauSach IN (SELECT Id FROM dausach WHERE TuaSach LIKE :Keyword)
                )
            )

        ");
        $stmt->execute([
            ':Keyword' => $keyword
        ]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $groupedResults = [];
        foreach ($results as $row) {
            $dangkyId = $row['dangky_id'];
            if (!isset($groupedResults[$dangkyId])) {
                $groupedResults[$dangkyId] = [
                    'dangky_id' => $row['dangky_id'],
                    'Id_DocGia' => $row['Id_DocGia'],
                    'HoTenDocGia' => $row['HoTenDocGia'],
                    'NgayDangKy' => $row['NgayDangKy'],
                    'id_trangthai' => $row['id_trangthai'],
                    'tentrangthai' => $row['tentrangthai'],
                    'books' => []
                ];
            }
            $groupedResults[$dangkyId]['books'][] = [
                'id_sach' => $row['id_sach'],
                'TuaSach' => $row['TuaSach'],
                'SoLuong' => $row['SoLuong']
            ];
        }

        return $groupedResults;
        }
        catch (PDOException $e) {
            Database::logError('Lỗi khi tìm kiếm phiếu mượn: ' . $e->getMessage());
            return [];
        }
    }

    public function getDangKyMuon($phieumuon_id)
    {
        try{
        $stmt = $this->db->prepare("
            SELECT * FROM dangky
            WHERE Id_ = :Id
        ");
        $stmt->execute([
            ':Id' => $phieumuon_id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            Database::logError('Lỗi khi lấy phiếu mượn: ' . $e->getMessage());
            return [];
        }
    }


}
?>
