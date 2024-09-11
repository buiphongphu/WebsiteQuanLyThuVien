<?php

class TacGia
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        try{
        $query= "SELECT * FROM tacgia";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy thông tin tác giả: ' . $e->getMessage());
            return [];
        }
    }

    public function insert($data)
    {
        try{
        $stmt = $this->db->prepare("INSERT INTO tacgia (Ho, Ten, quoctich) VALUES (:Ho, :Ten, :QuocTich)");
        return $stmt->execute([
            ':Ho' => $data['Ho'],
            ':Ten' => $data['Ten'],
            ':QuocTich' => $data['QuocTich'],
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi thêm tác giả: ' . $e->getMessage());
            return false;
        }
    }

    public function getById($id)
    {
        try{
        $stmt = $this->db->prepare("SELECT * FROM tacgia WHERE Id = :Id");
        $stmt->execute([':Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy thông tin tác giả: ' . $e->getMessage());
            return [];
        }
    }

    public function update($data)
    {
        try{
        $stmt = $this->db->prepare("UPDATE tacgia SET Ho = :Ho, Ten = :Ten, quoctich = :QuocTich WHERE Id = :Id");
        return $stmt->execute([
            ':Ho' => $data['Ho'],
            ':Ten' => $data['Ten'],
            ':QuocTich' => $data['QuocTich'],
            ':Id' => $data['Id']
        ]);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi cập nhật tác giả: ' . $e->getMessage());
            return false;
        }
    }

    public function delete($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM tacgia WHERE Id = :id");
            $stmt->execute([':id' => $id]);

            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                $_SESSION['delete_message'] = "Xóa tác giả thành công!";
                header("Location: ?url=admin/quanlytacgia");
                exit();
            } else {
                $_SESSION['error_message'] = "Không tìm thấy tác giả để xóa.";
                header("Location: ?url=admin/quanlytacgia");
                exit();
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1451 || $e->errorInfo[1] == 1452) {
                $_SESSION['error_message'] = "Không thể xóa tác giả vì tác giả này đã có sách hoặc thông tin khác liên quan.";
                header("Location: ?url=admin/quanlytacgia");
                exit();
            } else {
                $_SESSION['error_message'] = "Lỗi khi xóa tác giả";
                Database::logError('Lỗi khi xóa tác giả: ' . $e->getMessage());
                header("Location: ?url=admin/quanlytacgia");
                exit();
            }
        }
    }

    public function search($keyword)
    {
        try{
        $stmt = $this->db->prepare("SELECT * FROM tacgia WHERE Ho LIKE :keyword OR Ten LIKE :keyword OR quoctich LIKE :keyword");
        $stmt->execute([':keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi tìm kiếm tác giả: ' . $e->getMessage());
            return [];
        }
    }
}
?>
