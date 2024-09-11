<?php


class Login {
    private $db;

    public $error= '';

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function login($email, $password) {
        try{
        $stmt = $this->db->prepare("SELECT * FROM docgia WHERE Email = :Email");
        $stmt->execute([
            ':Email' => $email,
        ]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['Password'])) {
                return $user;
            } else {
                throw new Exception('Sai mật khẩu.');
            }
        } else {
            throw new Exception('Tài khoản không tồn tại.');
        }
        } catch (Exception $e) {
           Database::logError('Lỗi đăng nhập: ' . $e->getMessage());
        }
    }

    public function login_admin($email, $password) {
        try{
        $stmt = $this->db->prepare("SELECT * FROM quantrivien WHERE Email = :Email");
        $stmt->execute([
            ':Email' => $email,
        ]);

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            if (password_verify($password, $admin['Password'])) {
                return $admin;
            } else {
                throw new Exception('Sai mật khẩu quản trị viên.');
            }
        } else {
            throw new Exception('Tài khoản không tồn tại.');
        }
        } catch (Exception $e) {
           Database::logError('Lỗi đăng nhập: ' . $e->getMessage());
        }
    }



    public function get_docgia($id)
    {
        try{
        $stmt = $this->db->prepare("SELECT * FROM docgia WHERE Email = :Email");
        $stmt->execute([
            ':Email' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
           Database::logError('Lỗi lấy thông tin đăng nhập độc giả: ' . $e->getMessage());
        }
    }

    public function get_quantrivien($id)
    {
        try{
        $stmt = $this->db->prepare("SELECT * FROM quantrivien WHERE Email = :Email");
        $stmt->execute([
            ':Email' => $id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
           Database::logError('Lỗi lấy thông tin đăng nhập quản trị viên: ' . $e->getMessage());
        }
    }
}
?>
