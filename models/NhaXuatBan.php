<?php

class NhaXuatBan
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll()
    {
        $query = "SELECT * FROM nhaxuatban";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        $query = "INSERT INTO nhaxuatban (TenNXB, DiaChiNXB) VALUES (:TenNXB, :DiaChiNXB)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':TenNXB' => $data['TenNXB'],
            ':DiaChiNXB' => $data['DiaChiNXB']
        ]);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM nhaxuatban WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':Id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($data)
    {
        $query = "UPDATE nhaxuatban SET TenNXB = :TenNXB, DiaChiNXB = :DiaChiNXB WHERE Id = :Id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            ':TenNXB' => $data['TenNXB'],
            ':DiaChiNXB' => $data['DiaChiNXB'],
            ':Id' => $data['Id']
        ]);
    }

    public function delete($id)
    {
        try {
            $query = "DELETE FROM nhaxuatban WHERE Id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->execute([':id' => $id]);

            // Kiểm tra số bản ghi đã xóa
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                $_SESSION['delete_message'] = "Xóa nhà xuất bản thành công!";
                header("Location: ?url=admin/quanlynhaxuatban");
                exit();
            } else {
                $_SESSION['error_message'] = "Không tìm thấy nhà xuất bản để xóa.";
                header("Location: ?url=admin/quanlynhaxuatban");
                exit();
            }
        } catch (PDOException $e) {
            if ($e->errorInfo[1] == 1451 || $e->errorInfo[1] == 1452) {
                $_SESSION['error_message'] = "Không thể xóa nhà xuất bản vì còn tồn tại các đầu sách liên quan đến nhà xuất bản này.";
                header("Location: ?url=admin/quanlynhaxuatban");
                exit();
            } else {
                $_SESSION['error_message'] = "Lỗi khi xóa nhà xuất bản";
                Database::logError($e->getMessage());
                header("Location: ?url=admin/quanlynhaxuatban");
                exit();
            }
        }
    }

    public function existsByName($TenNXB)
    {
        $query = "SELECT COUNT(*) FROM nhaxuatban WHERE TenNXB = :TenNXB";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':TenNXB' => $TenNXB]);
        return $stmt->fetchColumn() > 0;
    }

    public function search($keyword)
    {
        $query = "SELECT * FROM nhaxuatban WHERE TenNXB LIKE :keyword";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
