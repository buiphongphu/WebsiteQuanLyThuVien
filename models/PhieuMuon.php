<?php

class PhieuMuon {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function insert($data) {
        $this->db->beginTransaction();
        try{
            $stmt = $this->db->prepare("
                INSERT INTO phieumuonsach (Id_QTV,Id_DocGia, id_DangKy, id_trangthai)
                VALUES (:Id_QTV,:Id_DocGia, :id_DangKy, 0)
            ");
            $stmt->execute([
                ':Id_QTV' => $data['Id_QTV'],
                ':Id_DocGia' => $data['Id_DocGia'],
                ':id_DangKy' => $data['id_DangKy']
            ]);
            $this->db->commit();
            return true;
        }catch (Exception $e){
            Database::logError('Lỗi thêm phiếu mượn sách'. $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }


    public function duyet($id) {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
                UPDATE phieumuonsach
                SET id_trangthai = 7
                WHERE Id = :Id
            ");
            $stmt->execute([
                ':Id' => $id
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi duyệt phiếu mượn sách'. $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }

    public function getDanhSachPhieuMuon()
    {
        try{
        $stmt = $this->db->prepare("
            SELECT pms.*, concat(dg.Ho,' ',dg.Ten) as TenDocGia, ds.TuaSach, dkct.SoLuong, dk.NgayMuon, dk.NgayTra, sach.Id as id_sach,pms.Id,pms.id_trangthai
            FROM phieumuonsach pms
            JOIN docgia dg ON pms.Id_DocGia = dg.Id
            JOIN dangky dk ON pms.id_DangKy = dk.Id
            JOIN dangky_chitiet dkct ON dk.Id= dkct.id_dangky
            JOIN sach ON dkct.id_sach=sach.Id
            JOIN dausach ds ON sach.Id_DauSach=ds.Id
            JOIN trangthai tt ON pms.id_trangthai = tt.Id
        ");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $groupedResults = [];
        foreach ($results as $row) {
            $phieumuonId = $row['Id'];
            if (!isset($groupedResults[$phieumuonId])) {
                $groupedResults[$phieumuonId] = [
                    'phieumuon_id' => $row['Id'],
                    'Id_DocGia' => $row['Id_DocGia'],
                    'HoTenDocGia' => $row['TenDocGia'],
                    'NgayMuon' => $row['NgayMuon'],
                    'NgayTra' => $row['NgayTra'],
                    'id_trangthai' => $row['id_trangthai'],
                    'books' => []
                ];
            }
            $groupedResults[$phieumuonId]['books'][] = [
                'id_sach' => $row['id_sach'],
                'TuaSach' => $row['TuaSach'],
                'SoLuong' => $row['SoLuong']
            ];
        }

        return $groupedResults;
        }catch (Exception $e){
            Database::logError('Lỗi lấy danh sách phiếu mượn sách'. $e->getMessage());
            return [];
        }
    }


    public function getPhieuMuonById($id)
    {
        try{
        $stmt = $this->db->prepare("
        SELECT pms.*, concat(dg.Ho,' ',dg.Ten) as TenDocGia, ds.TuaSach, dkct.SoLuong, dk.NgayMuon, dk.NgayTra, sach.Id as id_sach, ds.Id as Id_DauSach
        FROM phieumuonsach pms
        JOIN docgia dg ON pms.Id_DocGia = dg.Id
        JOIN dangky dk ON pms.id_DangKy = dk.Id
        JOIN dangky_chitiet dkct ON dk.Id = dkct.id_dangky
        JOIN sach ON dkct.id_sach = sach.Id
        JOIN dausach ds ON sach.Id_DauSach = ds.Id
        WHERE pms.Id = :Id
    ");
        $stmt->execute([':Id' => $id]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $groupedResults = [];
        foreach ($results as $row) {
            $phieumuonId = $row['Id'];
            if (!isset($groupedResults[$phieumuonId])) {
                $groupedResults[$phieumuonId] = [
                    'phieumuon_id' => $row['Id'],
                    'Id_DocGia' => $row['Id_DocGia'],
                    'HoTenDocGia' => $row['TenDocGia'],
                    'NgayMuon' => $row['NgayMuon'],
                    'NgayTra' => $row['NgayTra'],
                    'id_trangthai' => $row['id_trangthai'],
                    'books' => []
                ];
            }
            $groupedResults[$phieumuonId]['books'][] = [
                'Id_DauSach' => $row['Id_DauSach'],
                'TuaSach' => $row['TuaSach'],
                'SoLuong' => $row['SoLuong']
            ];
        }

        return !empty($groupedResults) ? array_shift($groupedResults) : null;
        }catch (Exception $e){
            Database::logError('Lỗi lấy phiếu mượn sách theo id'. $e->getMessage());
            return null;
        }
    }


    public function cancelPhieuMuon($id)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
                UPDATE phieumuonsach
                SET id_trangthai = 4
                WHERE Id = :Id
            ");
            $stmt->execute([
                ':Id' => $id
            ]);
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi hủy phiếu mượn sách'. $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }

    public function receivePhieuMuon($id)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
                UPDATE phieumuonsach
                SET id_trangthai = 3
                WHERE Id = :Id
            ");
            $stmt->execute([
                ':Id' => $id
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi nhận phiếu mượn sách'. $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }

    public function getPhieuMuonByUserId($Id)
    {
        try{
        $stmt = $this->db->prepare("
        SELECT pms.*, concat(dg.Ho,' ',dg.Ten) as TenDocGia, ds.TuaSach, dkct.soluong, dk.NgayMuon, dk.NgayTra, ds.Id as Id_DauSach
        FROM phieumuonsach pms
        JOIN docgia dg ON pms.Id_DocGia = dg.Id
        JOIN dangky dk ON pms.id_DangKy = dk.Id
        JOIN dangky_chitiet dkct ON dk.Id = dkct.id_dangky
        JOIN sach ON dkct.id_sach = sach.Id
        JOIN dausach ds ON sach.Id_DauSach = ds.Id
        WHERE dg.Id = :Id AND (pms.id_trangthai = 3 OR pms.id_trangthai = 0)
    ");
        $stmt->execute([
            ':Id' => $Id
        ]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $groupedResults = [];
        foreach ($results as $row) {
            $phieumuonId = $row['Id'];
            if (!isset($groupedResults[$phieumuonId])) {
                $groupedResults[$phieumuonId] = [
                    'phieumuon_id' => $row['Id'],
                    'Id_DocGia' => $row['Id_DocGia'],
                    'HoTenDocGia' => $row['TenDocGia'],
                    'NgayMuon' => $row['NgayMuon'],
                    'NgayTra' => $row['NgayTra'],
                    'id_trangthai' => $row['id_trangthai'],
                    'books' => []
                ];
            }
            $groupedResults[$phieumuonId]['books'][] = [
                'Id_DauSach' => $row['Id_DauSach'],
                'TuaSach' => $row['TuaSach'],
                'SoLuong' => $row['soluong']
            ];
        }

        return !empty($groupedResults) ? array_values($groupedResults) : [];
        }catch (Exception $e){
            Database::logError('Lỗi lấy phiếu mượn sách theo id người dùng'. $e->getMessage());
            return [];
        }
    }


    public function tongphieumuon()
    {
        try{
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as tongphieumuon
            FROM phieumuonsach
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['tongphieumuon'];
        }catch (Exception $e){
            Database::logError('Lỗi lấy tổng số phiếu mượn sách'. $e->getMessage());
            return 0;
        }
    }

    public function sosachdangmuon()
    {
        try{
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as sosachdangmuon
            FROM phieumuonsach
            WHERE id_trangthai = 0
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['sosachdangmuon'];
        }catch (Exception $e){
            Database::logError('Lỗi lấy số sách đang mượn'. $e->getMessage());
            return 0;
        }
    }

    public function sosachdatra()
    {
        try{
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as sosachdatra
            FROM phieumuonsach
            WHERE id_trangthai = 1
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['sosachdatra'];
        }catch (Exception $e){
            Database::logError('Lỗi lấy số sách đã trả'. $e->getMessage());
            return 0;
        }
    }



    public function sosachmuonquahan()
    {
        try{
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as sosachmuonquahan
            FROM phieumuonsach
            JOIN dangky dk ON phieumuonsach.id_DangKy = dk.Id
            WHERE dk.NgayTra < CURDATE() AND phieumuonsach.id_trangthai = 0 OR phieumuonsach.id_trangthai = 3
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['sosachmuonquahan'];
        }catch (Exception $e){
            Database::logError('Lỗi lấy số sách mượn quá hạn'. $e->getMessage());
            return 0;
        }
    }

    public function sosachmuondunghan()
    {
        try{
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as sosachmuondunghan
            FROM phieumuonsach
            JOIN dangky dk ON phieumuonsach.id_DangKy = dk.Id
            WHERE dk.NgayTra >= CURDATE() AND phieumuonsach.id_trangthai = 1
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['sosachmuondunghan'];
        }catch (Exception $e){
            Database::logError('Lỗi lấy số sách mượn đúng hạn'. $e->getMessage());
            return 0;
        }
    }

    public function sosachchuatra()
    {
        try{
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as sosachchuatra
            FROM phieumuonsach
            WHERE id_trangthai = 3 OR id_trangthai = 0
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['sosachchuatra'];
        }catch (Exception $e){
            Database::logError('Lỗi lấy số sách chưa trả'. $e->getMessage());
            return 0;
        }
    }

    public function sosachdahuy()
    {
        try{
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as sosachdahuy
            FROM phieumuonsach
            WHERE id_trangthai = 4
        ");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['sosachdahuy'];
        }catch (Exception $e){
            Database::logError('Lỗi lấy số sách đã hủy'. $e->getMessage());
            return 0;
        }
    }

    public function phieumuontoiHanTra()
    {
        try{
        $today = date('Y-m-d');
        $tomorrow = date('Y-m-d', strtotime('+1 day', strtotime($today)));

        $query = $this->db->query("
        SELECT
            phieumuonsach.id AS Id,
            dausach.TuaSach,
            dausach.id AS Id_DauSach,
            docgia.id AS Id_DocGia,
            concat(docgia.Ho,' ',docgia.Ten) AS TenDocGia,
            docgia.sdt,
            dangky.ngaymuon AS NgayMuon,
            dangky.ngaytra AS NgayTra,
            phieumuonsach.id_trangthai,
            dangky_chitiet.soluong
        FROM phieumuonsach
        JOIN dangky ON phieumuonsach.id_dangky = dangky.id
        JOIN dangky_chitiet ON dangky.id = dangky_chitiet.id_dangky
        JOIN sach ON dangky_chitiet.id_sach = sach.id
        JOIN dausach ON sach.Id_DauSach = dausach.id
        JOIN docgia ON phieumuonsach.id_docgia = docgia.id
        WHERE dangky.ngaytra = '{$tomorrow}' AND phieumuonsach.id_trangthai = 3
    ");

        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $groupedResults = [];
        foreach ($results as $row) {
            $phieumuonId = $row['Id'];
            if (!isset($groupedResults[$phieumuonId])) {
                $groupedResults[$phieumuonId] = [
                    'phieumuon_id' => $row['Id'],
                    'Id_DocGia' => $row['Id_DocGia'],
                    'HoTenDocGia' => $row['TenDocGia'],
                    'NgayMuon' => $row['NgayMuon'],
                    'NgayTra' => $row['NgayTra'],
                    'sdt'=> $row['sdt'],
                    'id_trangthai' => $row['id_trangthai'],
                    'books' => []
                ];
            }
            $groupedResults[$phieumuonId]['books'][] = [
                'Id_DauSach' => $row['Id_DauSach'],
                'TuaSach' => $row['TuaSach'],
                'SoLuong' => $row['soluong']
            ];
        }

        return $groupedResults;
        }catch (Exception $e){
            Database::logError('Lỗi lấy phiếu mượn sách quá hạn'. $e->getMessage());
            return [];
        }
    }



    public function getPhieuMuonHistory($userId)
    {
        try{
        $stmt = $this->db->prepare("
        SELECT pms.Id, dg.Id as Id_DocGia, concat(dg.Ho,' ',dg.Ten) as TenDocGia, dk.NgayMuon, dk.NgayTra, pms.id_trangthai, ds.Id as Id_DauSach, ds.TuaSach, dkct.SoLuong as soluong
        FROM phieumuonsach pms
        JOIN docgia dg ON pms.Id_DocGia = dg.Id
        JOIN dangky dk ON pms.id_DangKy = dk.Id
        JOIN dangky_chitiet dkct ON dk.Id = dkct.id_dangky
        JOIN sach ON dkct.id_sach = sach.Id
        JOIN dausach ds ON sach.Id_DauSach = ds.Id
        WHERE dg.Id = :userId AND (pms.id_trangthai = 1 OR pms.id_trangthai = 3 OR pms.id_trangthai = 4)
    ");
        $stmt->execute([':userId' => $userId]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $groupedResults = [];
        foreach ($results as $row) {
            $phieumuonId = $row['Id'];
            if (!isset($groupedResults[$phieumuonId])) {
                $groupedResults[$phieumuonId] = [
                    'phieumuon_id' => $row['Id'],
                    'Id_DocGia' => $row['Id_DocGia'],
                    'HoTenDocGia' => $row['TenDocGia'],
                    'NgayMuon' => $row['NgayMuon'],
                    'NgayTra' => $row['NgayTra'],
                    'id_trangthai' => $row['id_trangthai'],
                    'books' => []
                ];
            }
            $groupedResults[$phieumuonId]['books'][] = [
                'Id_DauSach' => $row['Id_DauSach'],
                'TuaSach' => $row['TuaSach'],
                'SoLuong' => $row['soluong']
            ];
        }

        return !empty($groupedResults) ? array_values($groupedResults) : [];
        }catch (Exception $e){
            Database::logError('Lỗi lấy lịch sử phiếu mượn sách'. $e->getMessage());
            return [];
        }
    }



    public function phieumuonquahantra()
    {
        try{
        $today = date('Y-m-d');
        $query = $this->db->query("
        SELECT
            phieumuonsach.id AS id_phieumuon,
            docgia.id AS id_docgia,
            concat(docgia.Ho,' ',docgia.Ten) AS ten_docgia,
            docgia.sdt,
            dangky.ngaymuon,
            dangky.ngaytra,
            dausach.id AS id_dausach,
            dausach.TuaSach AS tua_sach,
            dangky_chitiet.soluong,
            phieumuonsach.id_trangthai
        FROM phieumuonsach
        JOIN dangky ON phieumuonsach.id_dangky = dangky.id
        JOIN dangky_chitiet ON dangky.id = dangky_chitiet.id_dangky
        JOIN sach ON dangky_chitiet.id_sach = sach.id
        JOIN dausach ON sach.Id_DauSach = dausach.id
        JOIN docgia ON phieumuonsach.id_docgia = docgia.id
        WHERE dangky.ngaytra < '{$today}' AND phieumuonsach.id_trangthai = 3
    ");
        $results = $query->fetchAll(PDO::FETCH_ASSOC);

        $groupedResults = [];
        foreach ($results as $row) {
            $phieumuonId = $row['id_phieumuon'];
            if (!isset($groupedResults[$phieumuonId])) {
                $groupedResults[$phieumuonId] = [
                    'phieumuon_id' => $row['id_phieumuon'],
                    'Id_DocGia' => $row['id_docgia'],
                    'HoTenDocGia' => $row['ten_docgia'],
                    'NgayMuon' => $row['ngaymuon'],
                    'NgayTra' => $row['ngaytra'],
                    'sdt' => $row['sdt'],
                    'id_trangthai' => $row['id_trangthai'],
                    'books' => []
                ];
            }
            $groupedResults[$phieumuonId]['books'][] = [
                'Id_DauSach' => $row['id_dausach'],
                'TuaSach' => $row['tua_sach'],
                'SoLuong' => $row['soluong']
            ];
        }

        return $groupedResults;
        }catch (Exception $e){
            Database::logError('Lỗi lấy phiếu mượn sách quá hạn trả'. $e->getMessage());
            return [];
        }
    }




    public function updateQuantity(array $data1)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
            UPDATE dausach
            SET soluong = soluong - :SoLuong
            WHERE Id = :Id_DauSach
        ");
            $stmt->execute([
                ':SoLuong' => $data1['SoLuong'],
                ':Id_DauSach' => $data1['Id_DauSach']
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi cập nhật số lượng sách'. $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }

    public function updateSoLuong(array $data)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
            UPDATE dausach
            SET soluong = soluong + :SoLuong
            WHERE Id = :Id_DauSach
        ");
            $stmt->execute([
                ':SoLuong' => $data['SoLuong'],
                ':Id_DauSach' => $data['Id_DauSach']
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi cập nhật số lượng sách'. $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }

    public function updateStatus($id, int $int)
    {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("
            UPDATE phieumuonsach
            SET id_trangthai = :id_trangthai
            WHERE Id = :Id
        ");
            $stmt->execute([
                ':Id' => $id,
                ':id_trangthai' => $int
            ]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            Database::logError('Lỗi cập nhật trạng thái phiếu mượn sách'. $e->getMessage());
            $this->db->rollBack();
            return false;
        }
    }

    public function getSachByIdDauSach($idDauSach)
    {
        try{
        $stmt = $this->db->prepare("
        SELECT Id
        FROM sach
        WHERE Id_DauSach = :Id_DauSach
    ");
        $stmt->execute([':Id_DauSach' => $idDauSach]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['Id'];
        }catch (Exception $e){
            Database::logError('Lỗi lấy sách theo id đầu sách'. $e->getMessage());
            return null;
        }
    }


}
