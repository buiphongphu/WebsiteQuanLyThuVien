<?php


class SachHongHoacMat{
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function insert(array $data)
    {
        try{
        $stmt = $this->db->prepare("
            INSERT INTO sach_mat_hong (id_phieumuon, id_sach, soluong, id_trangthai)
            VALUES (:Id_PhieuMuon, :Id_Sach, :SoLuong, :Id_TrangThai)
        ");
        $stmt->execute([
            ':Id_PhieuMuon' => $data['Id_PhieuMuon'],
            ':Id_Sach' => $data['Id_Sach'],
            ':SoLuong' => $data['SoLuong'],
            ':Id_TrangThai' => $data['Id_TrangThai']
        ]);
        return $this->db->lastInsertId();
        } catch (PDOException $e) {
            Database::logError('Lỗi khi thêm sách hỏng hoặc mất'. $e->getMessage());
            return false;
        }
    }

    public function getAll()
    {
        try{
        $query = $this->db->query("
        SELECT
            sach_mat_hong.id AS id,
            sach_mat_hong.id_phieumuon,
            docgia.sdt,
            docgia.Ho,
            docgia.Ten,
            sach.id AS id_sach,
            dausach.id AS id_dausach,
            dausach.TuaSach AS tua_sach,
            sach_mat_hong.soluong,
            phieumuonsach.Id_DocGia,
            sach_mat_hong.id_trangthai
        FROM sach_mat_hong
        JOIN phieumuonsach ON sach_mat_hong.id_phieumuon=phieumuonsach.Id
        JOIN docgia ON phieumuonsach.Id_DocGia = docgia.id
        JOIN sach ON sach_mat_hong.id_sach = sach.id
        JOIN dausach ON sach.Id_DauSach = dausach.id
    ");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $groupedResults = [];
        foreach ($results as $row) {
            $phieumuonId = $row['id_phieumuon'];
            if (!isset($groupedResults[$phieumuonId])) {
                $groupedResults[$phieumuonId] = [
                    'id' => $row['id'],
                    'phieumuon_id' => $row['id_phieumuon'],
                    'Id_DocGia' => $row['Id_DocGia'],
                    'Ho' => $row['Ho'],
                    'Ten' => $row['Ten'],
                    'sdt' => $row['sdt'],
                    'books' => []
                ];
            }
            $groupedResults[$phieumuonId]['books'][] = [
                'Id_Sach' => $row['id_sach'],
                'Id_DauSach' => $row['id_dausach'],
                'TuaSach' => $row['tua_sach'],
                'SoLuong' => $row['soluong'],
                'id_trangthai' => $row['id_trangthai']
            ];
        }

        return $groupedResults;
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy danh sách sách hỏng hoặc mất'. $e->getMessage());
            return false;
        }
    }

    public function getById($idPhieu)
    {
        try{
        $query = $this->db->query("
        SELECT
            sach_mat_hong.id AS id,
            sach_mat_hong.id_phieumuon,
            docgia.sdt,
            docgia.Ho,
            docgia.Ten,
            sach.id AS id_sach,
            dausach.id AS id_dausach,
            dausach.TuaSach AS tua_sach,
            sach_mat_hong.soluong,
            phieumuonsach.Id_DocGia,
            sach_mat_hong.id_trangthai
        FROM sach_mat_hong
        JOIN phieumuonsach ON sach_mat_hong.id_phieumuon=phieumuonsach.Id
        JOIN docgia ON phieumuonsach.Id_DocGia = docgia.id
        JOIN sach ON sach_mat_hong.id_sach = sach.id
        JOIN dausach ON sach.Id_DauSach = dausach.id
        WHERE sach_mat_hong.id_phieumuon = $idPhieu
    ");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $groupedResults = [];
        foreach ($results as $row) {
            $phieumuonId = $row['id_phieumuon'];
            if (!isset($groupedResults[$phieumuonId])) {
                $groupedResults[$phieumuonId] = [
                    'id' => $row['id'],
                    'phieumuon_id' => $row['id_phieumuon'],
                    'Id_DocGia' => $row['Id_DocGia'],
                    'Ho' => $row['Ho'],
                    'Ten' => $row['Ten'],
                    'sdt' => $row['sdt'],
                    'books' => []
                ];
            }
            $groupedResults[$phieumuonId]['books'][] = [
                'Id_Sach' => $row['id_sach'],
                'Id_DauSach' => $row['id_dausach'],
                'TuaSach' => $row['tua_sach'],
                'SoLuong' => $row['soluong'],
                'id_trangthai' => $row['id_trangthai']
            ];
        }

        return $groupedResults;
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy sách hỏng hoặc mất theo id phiếu mượn'. $e->getMessage());
            return false;
        }
    }

    public function updateStatus($id)
    {
        try{
        $stmt = $this->db->prepare("
            UPDATE sach_mat_hong
            SET id_trangthai = :id_trangthai
            WHERE id_phieumuon = :id_phieumuon
        ");
        return $stmt->execute([
            ':id_trangthai' => 1,
            ':id_phieumuon' => $id
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi cập nhật trạng thái sách hỏng hoặc mất'. $e->getMessage());
            return false;
        }
    }
}