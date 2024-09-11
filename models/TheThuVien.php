<?php

class TheThuVien {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function layTheThuVienCuaDocGia($id) {
        try{
        $query = "SELECT * FROM thethuvien WHERE Id = (SELECT id_TheTV FROM docgia WHERE id = :Id)";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy thẻ thư viện của độc giả'. $e->getMessage());
            return false;
        }
    }

    public function layTheThuVienDangChoPheDuyet() {
        try{
        $query = "SELECT thethuvien.*, docgia.*, thethuvien.Id as IdTV
              FROM thethuvien
              INNER JOIN docgia ON thethuvien.id = docgia.id_TheTV
              WHERE thethuvien.id_trangthai = 6";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy thẻ thư viện đang chờ phê duyệt'. $e->getMessage());
            return false;
        }
    }


    public function capNhatTrangThaiThe($id, $trangThai) {
        try{
        $query = "UPDATE thethuvien SET id_trangthai = :TrangThai WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'TrangThai' => $trangThai,
            'Id' => $id
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi cập nhật trạng thái thẻ thư viện'. $e->getMessage());
            return false;
        }
    }

    public function dangKyThe($idDocGia, $loaiThe, $ngayHetHan) {
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO thethuvien (LoaiThe, NgayLapThe, NgayHetHan, id_trangthai)
                    VALUES (:loai_the, CURDATE(), :ngay_het_han, 6)";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':loai_the', $loaiThe, PDO::PARAM_STR);
            $stmt->bindParam(':ngay_het_han', $ngayHetHan, PDO::PARAM_STR);
            $stmt->execute();

            $idTheThuVien = $this->db->lastInsertId();

            $sqlUpdate = "UPDATE docgia SET id_TheTV = :id_TheTV WHERE id = :id_docgia";
            $stmtUpdate = $this->db->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':id_TheTV', $idTheThuVien, PDO::PARAM_INT);
            $stmtUpdate->bindParam(':id_docgia', $idDocGia, PDO::PARAM_INT);
            $stmtUpdate->execute();

            $this->db->commit();

            return $idTheThuVien;
        } catch (PDOException $e) {
            $this->db->rollBack();
            Database::logError('Lỗi khi đăng ký thẻ thư viện'. $e->getMessage());
            return false;
        }
    }

    public function getById($Id)
    {
        try{
        $query = "SELECT * FROM thethuvien WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Id' => $Id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy thẻ thư viện theo Id'. $e->getMessage());
            return false;
        }
    }

    public function layTheThuVienDaDuyet()
    {
        try{
        $query = "SELECT thethuvien.*, docgia.*, thethuvien.Id as IdTV
              FROM thethuvien
              INNER JOIN docgia ON thethuvien.id = docgia.id_TheTV
              WHERE thethuvien.id_trangthai = 7";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy thẻ thư viện đã duyệt'. $e->getMessage());
            return false;
        }
    }

    public function printCard($id) {
        $card = $this->getCardById($id);
        $card['NgayLapThe'] = date('d/m/Y', strtotime($card['NgayLapThe']));
        $card['NgayHetHan'] = date('d/m/Y', strtotime($card['NgayHetHan']));
        $url="public/images/2p.png";
        if ($card) {
            echo '
    <html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            body {
                font-family: "Times New Roman", sans-serif;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f4f4f9;
            }
            .card {
                width: 400px;
                padding: 20px;
                border: 2px solid #333;
                border-radius: 5px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                background-color: #fff;
                text-align: left;
                position: relative;
            }
            .card .logo {
                width: 60px;
                position: absolute;
                top: 20px;
                right: 20px;
            }
            .card h1 {
                font-size: 22px;
                margin-bottom: 15px;
                color: #333;
                border-bottom: 2px solid #333;
                padding-bottom: 10px;
                display: inline-block;
            }
            .card p {
                font-size: 14px;
                margin: 8px 0;
                color: #555;
                display: flex;
                align-items: center;
            }
            .card .note {
                font-size: 12px;
                margin-top: 20px;
                color: #888;
                border-top: 1px solid #ccc;
                padding-top: 10px;
            }
            .icon {
                font-size: 1.2em;
                vertical-align: middle;
                margin-right: 10px;
                color: #0073e6;
            }
        </style>
    </head>
    <body>
        <div class="card">
            <img src="'.$url.'" alt="logo" class="logo">
            <h1>Thẻ Thư Viện</h1>
            <p><i class="fas fa-user icon"></i><strong>Họ tên: </strong> ' . htmlspecialchars($card['Ho'].$card['Ten']) . '</p>
            <p><i class="fas fa-id-card icon"></i><strong>Loại thẻ: </strong> ' . htmlspecialchars($card['LoaiThe']) . '</p>
            <p><i class="fas fa-calendar-alt icon"></i><strong>Ngày tạo thẻ: </strong> ' . htmlspecialchars($card['NgayLapThe']) . '</p>
            <p><i class="fas fa-calendar-times icon"></i><strong>Ngày hết hạn: </strong> ' . htmlspecialchars($card['NgayHetHan']) . '</p>
            <p class="note"><i class="fas fa-exclamation-circle icon"></i>Lưu ý: Nếu độc giả bị vi phạm bị khóa thẻ, thì yêu cầu đến thư viện để mở lại. Yêu cầu độc giả đến thư viện để đổi lại trước ngày hết hạn.</p>
        </div>
    </body>
    </html>
    ';
        } else {
            echo 'Card does not exist';
        }
    }

        private function getCardById($id)
    {
        try{
        $query = "SELECT thethuvien.*, docgia.*, thethuvien.Id as IdTV
              FROM thethuvien
              INNER JOIN docgia ON thethuvien.id = docgia.id_TheTV
              WHERE thethuvien.Id = :Id";

        $stmt = $this->db->prepare($query);
        $stmt->execute(['Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy thẻ thư viện theo Id'. $e->getMessage());
            return false;
        }
    }

    public function timKiemTheThuVien($keyword)
    {
        try{
        $query = "SELECT thethuvien.LoaiThe,thethuvien.NgayLapThe,thethuvien.NgayHetHan, docgia.Ho,docgia.Ten, thethuvien.Id as IdTV
              FROM thethuvien
              INNER JOIN docgia ON thethuvien.id = docgia.id_TheTV
              WHERE docgia.Ho LIKE 't' OR id_trangthai = 6";

        $stmt = $this->db->prepare($query);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi tìm kiếm thẻ thư viện'. $e->getMessage());
            return false;
        }
    }

    public function layTheThuVienBiKhoa()
    {
        try{
        $query = "SELECT thethuvien.*, docgia.*, thethuvien.Id as IdTV
              FROM thethuvien
              INNER JOIN docgia ON thethuvien.id = docgia.id_TheTV
              WHERE thethuvien.id_trangthai = 2";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy thẻ thư viện bị khóa'. $e->getMessage());
            return false;
        }
    }

    public function updateTrangThaiThe($Id, int $int)
    {
        try{
        $query = "UPDATE thethuvien SET id_trangthai = :TrangThai WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'TrangThai' => $int,
            'Id' => $Id
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi cập nhật trạng thái thẻ thư viện'. $e->getMessage());
            return false;
        }
    }

    public function capNhatNgayHetHan($Id, $ngayHetHan)
    {
        try{
        $query = "UPDATE thethuvien SET NgayHetHan = :NgayHetHan WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'NgayHetHan' => $ngayHetHan,
            'Id' => $Id
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi cập nhật ngày hết hạn thẻ thư viện'. $e->getMessage());
            return false;
        }
    }

    public function getTopMembers()
    {
        try{
        $query = "SELECT thethuvien.*, docgia.*, thuhang,diem
              FROM thethuvien
              INNER JOIN docgia ON thethuvien.id = docgia.id_TheTV
              INNER JOIN diem ON thethuvien.Id=diem.Id_TheTV
              WHERE thethuvien.id_trangthai = 7
              ORDER BY diem DESC
              LIMIT 5";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy top thành viên'. $e->getMessage());
            return false;
        }
    }

    public function getDownsMembers()
    {
        try{
        $query = "SELECT thethuvien.*, docgia.*, thuhang,diem
              FROM thethuvien
              INNER JOIN docgia ON thethuvien.id = docgia.id_TheTV
              INNER JOIN diem ON thethuvien.Id=diem.Id_TheTV
              WHERE thethuvien.id_trangthai = 7
              ORDER BY diem ASC
              LIMIT 5";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy thành viên yếu'. $e->getMessage());
            return false;
        }
    }

    public function xoaTheThuVien($Id)
    {
        try{
        $query = "UPDATE docgia SET id_TheTV = NULL WHERE id_TheTV = :Id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Id' => $Id]);

        $query = "DELETE FROM diem WHERE Id_TheTV = :Id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Id' => $Id]);

        $query = "DELETE FROM thethuvien WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['Id' => $Id]);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi xóa thẻ thư viện'. $e->getMessage());
            return false;
        }
    }

    public function createTheThuVien($unit, $ngaytaothe, $ngayhethan, $activation_code)
    {
        try{
        $query = "INSERT INTO thethuvien (LoaiThe, NgayLapThe, NgayHetHan, id_trangthai, ma_kich_hoat)
                    VALUES (:LoaiThe, :NgayLapThe, :NgayHetHan, :id_trangthai, :ma_kich_hoat)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            'LoaiThe' => $unit,
            'NgayLapThe' => $ngaytaothe,
            'NgayHetHan' => $ngayhethan,
            'id_trangthai' => 6,
            'ma_kich_hoat' => $activation_code
        ]);
        return $this->db->lastInsertId();
        } catch (PDOException $e) {
            Database::logError('Lỗi khi tạo thẻ thư viện'. $e->getMessage());
            return false;
        }
    }

    public function kiemtra_makichhoat($activation_code)
    {
        try{
        $query = "SELECT * FROM thethuvien WHERE ma_kich_hoat = :ma_kich_hoat";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['ma_kich_hoat' => $activation_code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi kiểm tra mã kích hoạt'. $e->getMessage());
            return false;
        }
    }

    public function layThongTinTheThuVienById($id)
    {
        try{
        $query = "SELECT thethuvien.*, docgia.*
         FROM thethuvien
         JOIN docgia ON thethuvien.id = docgia.id_TheTV
         WHERE docgia.Id = :Id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy thông tin thẻ thư viện theo Id'. $e->getMessage());
            return false;
        }
    }
}
