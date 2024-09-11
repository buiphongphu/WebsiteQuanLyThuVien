<?php



class LoginController
{
    private $loginModel;

    public function __construct()
    {
        $this->loginModel = new Login();
    }



    public function handleLogin($email, $password)
    {
        function encryptData($data, $key)
        {
            $encryption_key = base64_decode($key);
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
            return base64_encode($encrypted . '::' . $iv);
        }

        function decryptData($data, $key)
        {
            $encryption_key = base64_decode($key);
            list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2), 2, null);
            return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
        }

        $secret_key = 'a8b7c6d5e4f3a2b1c0d9e8f7g6h5i4j3k2l1m0n9o8p7q6r5';

        $admin = $this->loginModel->login_admin($email, $password);
        $user = $this->loginModel->login($email, $password);
        if ($admin) {
            try {
                $encrypted_admin = encryptData(serialize($admin), $secret_key);
                setcookie('admin', $encrypted_admin, time() + 60 * 60 * 24 * 30, '/');

                header('Location: ?url=admin/dashboard');
                exit();
            } catch (Exception $eAdmin) {
                Database::logError('Lỗi đăng nhập: ' . $eAdmin->getMessage());
                $errorMessage = $eAdmin->getMessage() === 'Sai mật khẩu quản trị viên.' ? 'Sai mật khẩu' : 'Tài khoản không tồn tại.';
                $_SESSION['error'] = $errorMessage;
            }
        } else {
            try {
                $encrypted_user = encryptData(serialize($user), $secret_key);
                setcookie('user', $encrypted_user, time() + 60 * 60 * 24 * 30, '/');

                header('Location: ?url=index');
                exit();
            } catch (Exception $eUser) {
                Database::logError('Lỗi đăng nhập: ' . $eUser->getMessage());
                $errorMessage = $eUser->getMessage() === 'Sai mật khẩu.' ? 'Sai mật khẩu' : 'Tài khoản không' . ' tồn tại.';
                $_SESSION['error'] = $errorMessage;

            }
        }
    }

    public function checkLoginCookie() {
        function encryptData($data, $key) {
            $encryption_key = base64_decode($key);
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
            return base64_encode($encrypted . '::' . $iv);
        }

        function decryptData($data, $key) {
            $encryption_key = base64_decode($key);
            list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2), 2, null);
            return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
        }
        $secret_key = 'a8b7c6d5e4f3a2b1c0d9e8f7g6h5i4j3k2l1m0n9o8p7q6r5';

        if (isset($_COOKIE['user'])) {
            $user = unserialize(decryptData($_COOKIE['user'], $secret_key));
            $_SESSION['user'] = $user;
        }

        if (isset($_COOKIE['admin'])) {
            $admin = unserialize(decryptData($_COOKIE['admin'], $secret_key));
            $_SESSION['admin'] = $admin;
        }
    }

    public function get_docgia($id)
    {
        return $this->loginModel->get_docgia($id);
    }

    public function get_quantrivien($id)
    {
        return $this->loginModel->get_quantrivien($id);
    }
}
