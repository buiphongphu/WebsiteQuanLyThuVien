<?php


class Register{
    private $db;

        public function __construct()
        {
            $this->db = Database::getInstance()->getConnection();
        }

    public function register($data) {
            try{
            $stmt = $this->db->prepare("INSERT INTO docgia(Ho,Ten, NgaySinh, GioiTinh, DiaChi, DonVi, MaSo, SDT, Password, Email,Id_TheTV) VALUES (:Ho,:Ten, :NgaySinh, :GioiTinh, :DiaChi, :DonVi, :MaSo, :SDT, :Password, :Email, :Id_TheTV)");
            $stmt->execute([
                'Ho' => $data['Ho'],
                'Ten' => $data['Ten'],
                'NgaySinh' => $data['NgaySinh'],
                'GioiTinh' => $data['GioiTinh'],
                'DiaChi' => $data['DiaChi'],
                'DonVi' => $data['DonVi'],
                'MaSo' => $data['MaSo'],
                'SDT' => $data['SDT'],
                'Password' => $data['Password'],
                'Email' => $data['Email'],
                'Id_TheTV' => $data['Id_TheTV']
            ]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi thêm mới độc giả'. $e->getMessage());
            return false;
        }
}

    public function kiemtra_email($email) {
        try{
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM docgia WHERE Email = :Email");
            $stmt->bindParam(":Email", $email);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            Database::logError('Lỗi khi kiểm tra email'. $e->getMessage());
            return false;
        }
    }

    public function kiemtra_masodocgia($id_number) {
        try{
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM docgia WHERE MaSo = :MaSo");
            $stmt->bindParam(":MaSo", $id_number);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            Database::logError('Lỗi khi kiểm tra mã số độc giả'. $e->getMessage());
            return false;
        }
    }

    public function getDocGiaByEmail(string $email)
    {
        try{
            $stmt = $this->db->prepare("SELECT * FROM docgia WHERE Email = :Email");
            $stmt->bindParam(":Email", $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy thông tin độc giả'. $e->getMessage());
            return false;
        }
    }

}
