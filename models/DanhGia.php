<?php

class DanhGia
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function insert($userId, $sachId, $diem, $noiDung, $ngayDanhGia)
    {
        try{
        $stmt = $this->db->prepare("
            INSERT INTO danhgia (Id_DocGia, Id_Sach, Diem, NoiDung, NgayDanhGia)
            VALUES (:Id_NguoiDung, :Id_Sach, :Diem, :NoiDung, :NgayDanhGia)
        ");
        $stmt->execute([
            ':Id_NguoiDung' => $userId,
            ':Id_Sach' => $sachId,
            ':Diem' => $diem,
            ':NoiDung' => $noiDung,
            ':NgayDanhGia' => $ngayDanhGia
        ]);
        return true;
        } catch (PDOException $e) {
            Database::logError('Lỗi khi thêm đánh giá:'. $e->getMessage());
            return false;
        }
    }

    public function getAverageRating($sachId)
    {
        try{
        $stmt = $this->db->prepare("
            SELECT AVG(Diem) as averageRating
            FROM danhgia
            WHERE Id_Sach = :Id_Sach
        ");
        $stmt->execute([':Id_Sach' => $sachId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? round($result['averageRating'], 1) : 0;
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy đánh giá trung bình:'. $e->getMessage());
            return 0;
        }
    }

    public function getAllRatings($sachId)
    {
        try{
        $stmt = $this->db->prepare("
            SELECT *
            FROM danhgia
            WHERE Id_Sach = :Id_Sach
        ");
        $stmt->execute([':Id_Sach' => $sachId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy tất cả đánh giá:'. $e->getMessage());
            return [];
        }
    }

    public function getFeaturedBooks()
    {
        try{
        $stmt= $this->db->prepare("
            SELECT Id_Sach
            FROM danhgia
            GROUP BY Id_Sach
            ORDER BY AVG(Diem) DESC
            LIMIT 4
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Database::logError('Lỗi khi lấy sách nổi bật:'. $e->getMessage());
            return [];
        }
    }

}

function displayStars($averageRating)
{
    $fullStars = floor($averageRating);
    $halfStar = ($averageRating - $fullStars >= 0.5) ? 1 : 0;
    $emptyStars = 5 - $fullStars - $halfStar;

    $starsHtml = str_repeat('<i class="fas fa-star text-yellow-500"></i>', $fullStars);
    if ($halfStar) {
        $starsHtml .= '<i class="fas fa-star-half-alt text-yellow-500"></i>';
    }
    $starsHtml .= str_repeat('<i class="far fa-star text-yellow-500"></i>', $emptyStars);

    return $starsHtml;
}
?>
