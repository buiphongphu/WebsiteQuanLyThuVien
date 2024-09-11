<?php

class QuanTriVien
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        try{
        $query = "SELECT * FROM quantrivien";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy dữ liệu từ quản trị viên: '. $e->getMessage());
        }
    }

    public function getById($id)
    {
        try{
        $query = "SELECT * FROM quantrivien WHERE Id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy dữ liệu từ quản trị viên: '. $e->getMessage());
        }
    }

    public function insert($data)
    {
        try{
        $query = "INSERT INTO quantrivien(Ho, Ten, SDT, DiaChi, Email,Password) VALUES(:Ho, :Ten, :SDT, :DiaChi, :Email, :Password)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'Ho' => $data['Ho'],
            'Ten' => $data['Ten'],
            'SDT' => $data['SDT'],
            'DiaChi' => $data['DiaChi'],
            'Email' => $data['Email'],
            'Password' => $data['Password']
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi thêm dữ liệu quản trị viên: '. $e->getMessage());
        }
    }

    public function update($data)
    {
        try{
        $query = "UPDATE quantrivien SET Ho = :Ho,Ten = :Ten, SDT = :SDT, DiaChi = :DiaChi, Email = :Email WHERE Id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'Ho' => $data['Ho'],
            'Ten' => $data['Ten'],
            'SDT' => $data['SDT'],
            'DiaChi' => $data['DiaChi'],
            'Email' => $data['Email'],
            'id' => $data['Id']
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi cập nhật dữ liệu quản trị viên: '. $e->getMessage());
        }
    }

    public function delete($id)
    {
        try{
        $query = "DELETE FROM quantrivien WHERE Id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'id' => $id
            ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi xóa dữ liệu quản trị viên: '. $e->getMessage());
        }
    }

    public function getByEmail($Email)
    {
        try{
        $query = "SELECT * FROM quantrivien WHERE Email = :Email";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['Email' => $Email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy dữ liệu từ quản trị viên: '. $e->getMessage());
        }
    }

    public function search($keyword)
    {
        try{
        $query = "SELECT * FROM quantrivien WHERE Ho LIKE :keyword OR Ten LIKE :keyword OR Email LIKE :keyword";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi tìm kiếm quản trị viên: '. $e->getMessage());
        }
    }

    public function getPassword($id)
    {
        try{
        $query = "SELECT Password FROM quantrivien WHERE Id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['Password'];
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy mật khẩu quản trị viên: '. $e->getMessage());
        }
    }

    public function updatePassword($email, $password_hash)
    {
        try{
        $query = "UPDATE quantrivien SET Password = :Password WHERE Email = :Email";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'Password' => $password_hash,
            'Email' => $email
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi cập nhật mật khẩu quản trị viên: '. $e->getMessage());
        }
    }
}
?>
