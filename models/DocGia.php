<?php

class DocGia
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        try{
        $query = "SELECT * FROM docgia";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy thông tin độc giả'. $e->getMessage());
            return [];
        }
    }

    public function getById($id)
    {
        try{
        $query = "SELECT * FROM docgia WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy thông tin độc giả'. $e->getMessage());
            return [];
        }
    }

    public function insert($data)
    {
        try{
        $query = "INSERT INTO docgia (Ho, Ten, NgaySinh, GioiTinh, DiaChi, DonVi, MaSo, SDT, Password, Email, Id_TheTV)
                  VALUES (:Ho,:Ten, :NgaySinh, :GioiTinh, :DiaChi, :DonVi, :MaSo, :SDT, :Password, :Email, :Id_TheTV)";
        $stmt = $this->db->prepare($query);
        $data['Password'] = password_hash($data['Password'], PASSWORD_DEFAULT);
        return $stmt->execute($data);
        } catch (PDOException $e) {
            Database::logError('Lỗi thêm độc giả'. $e->getMessage());
            return false;
        }
    }

    public function update($data)
    {
        try{
        $query = "UPDATE docgia SET Ho = :Ho, Ten = :Ten, NgaySinh = :NgaySinh, GioiTinh = :GioiTinh, DiaChi = :DiaChi,
                  DonVi = :DonVi, MaSo = :MaSo, SDT = :SDT, Password = :Password, Email = :Email WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        $data['Password'] = password_hash($data['Password'], PASSWORD_DEFAULT);
        return $stmt->execute($data);
        } catch (PDOException $e) {
            Database::logError('Lỗi cập nhật độc giả'. $e->getMessage());
            return false;
        }
    }

    public function updateuser($data)
    {
        try{
        $query = "UPDATE docgia SET  Ho = :Ho, Ten =:Ten, NgaySinh = :NgaySinh, GioiTinh = :GioiTinh, DiaChi = :DiaChi,MaSo = :MaSo,
                  DonVi = :DonVi, SDT = :SDT, Email = :Email WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
        } catch (PDOException $e) {
            Database::logError('Lỗi cập nhật độc giả'. $e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        try{
        $query = "DELETE FROM docgia WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['Id' => $id]);
        } catch (PDOException $e) {
            Database::logError('Lỗi xóa độc giả'. $e->getMessage());
            return false;
        }
    }

    public function tong()
    {
        try{
        $query = "SELECT COUNT(*) AS Total FROM docgia";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['Total'];
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy thông tin độc giả'. $e->getMessage());
            return 0;
        }
    }

    public function checkExistingMaSo($MaSo)
    {
        try{
        $query = "SELECT COUNT(*) AS Total FROM docgia WHERE MaSo = :MaSo";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['MaSo' => $MaSo]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['Total'] > 0;
        } catch (PDOException $e) {
            Database::logError('Lỗi kiểm tra mã số độc giả'. $e->getMessage());
            return false;
        }
    }

    public function checkExistingEmail($Email)
    {
        try{
        $query = "SELECT COUNT(*) AS Total FROM docgia WHERE Email = :Email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Email' => $Email]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['Total'] > 0;
        } catch (PDOException $e) {
            Database::logError('Lỗi kiểm tra email độc giả'. $e->getMessage());
            return false;
        }
    }

    public function getDocGiaById($Id_DocGia)
    {
        try{
        $query = "SELECT * FROM docgia WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Id' => $Id_DocGia]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy thông tin độc giả'. $e->getMessage());
            return [];
        }
    }

    public function searchDocGia($keyword)
    {
        try{
        $query = "SELECT * FROM docgia WHERE Ho LIKE :keyword OR Ten LIKE :keyword OR MaSo LIKE :keyword OR Email LIKE :keyword";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi tìm kiếm độc giả'. $e->getMessage());
            return [];
        }
    }

    public function checkEmail($email)
    {
        try{
        $query = "SELECT * FROM docgia WHERE Email = :Email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi kiểm tra email độc giả'. $e->getMessage());
            return [];
        }
    }

    public function updatePassword($email, $password_hash)
    {
        try{
        $query = "UPDATE docgia SET Password = :Password WHERE Email = :Email";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['Password' => $password_hash, 'Email' => $email]);
        } catch (PDOException $e) {
            Database::logError('Lỗi cập nhật mật khẩu độc giả'. $e->getMessage());
            return false;
        }
    }

    public function getPassword($id)
    {
        try{
        $query = "SELECT Password FROM docgia WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['Password'];
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy mật khẩu độc giả'. $e->getMessage());
            return '';
        }
    }

    public function getEmail($id)
    {
        try{
        $query = "SELECT Email FROM docgia WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['Email'];
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy email độc giả'. $e->getMessage());
            return '';
        }
    }

    public function getDocGiaByIdTheTV($Id)
    {
        try{
        $query = "SELECT * FROM docgia WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Id' => $Id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi lấy thông tin độc giả'. $e->getMessage());
            return [];
        }
    }
}
?>
