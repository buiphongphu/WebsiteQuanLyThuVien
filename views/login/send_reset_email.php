<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Predis\Client;

require 'vendor/autoload.php';


function sendResetEmail($toEmail, $resetCode) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'omerasutvail@gmail.com';
        $mail->Password = 'qses fwbc qdxo tkqh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('omerasutvail@gmail.com', 'Thư viện 2P');
        $mail->addAddress($toEmail);

        $mail->addEmbeddedImage('public/images/2p.png', 'library_logo');

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Yêu cầu cập nhật mật khẩu';

        $mail->SMTPDebug = 0;


        $mail->Body = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f7f7f7;
                }
                .container {
                    width: 100%;
                    padding: 20px;
                    background-color: #ffffff;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    max-width: 600px;
                    margin: 20px auto;
                }
                .header {
                    text-align: center;
                    padding-bottom: 20px;
                }
                .header img {
                    width: 100px;
                    height: 100px;
                }
                .header img, .header h1 {
                    display: block;
                    margin: 0 auto;
                }
                .header img {
                    margin-bottom: 10px;
                }
                .header img {
                    border-radius: 50%;
                }
                .header h1 {
                    font-size: 24px;
                    margin: 0;
                }
                .content {
                    padding: 20px 0;
                }
                .content p {
                    font-size: 16px;
                    line-height: 1.5;
                    margin: 0;
                }
                .content .code {
                    font-size: 20px;
                    font-weight: bold;
                    color: #ff0000;
                    margin: 20px 0;
                }
                .footer {
                    text-align: center;
                    padding-top: 20px;
                    font-size: 12px;
                    color: #888888;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <img src="cid:library_logo" alt="Library Logo">
                    <h1>Yêu cầu cập nhật mật khẩu</h1>
                </div>
                <div class="content">
                    <p>Chào bạn,</p>
                    <p>Chúng tôi đã nhận được yêu cầu cập nhật mật khẩu cho tài khoản của bạn. Mã xác nhận của bạn là:</p>
                    <p class="code">' . $resetCode . '</p>
                    <p>Nếu bạn không yêu cầu cập nhật mật khẩu, vui lòng bỏ qua email này.</p>
                </div>
                <div class="footer">
                    <p>Thư viện 2P</p>
                </div>
            </div>
        </body>
        </html>';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function generateResetCode() {
    function generateResetCode($redis) {
        $code = $redis->get('reset_code');
        if ($code === null) {
            $code = random_int(100000, 999999);
            $redis->set('reset_code', $code, 'EX', 3600);
        }
        return $code;
    }

    $redis = new Client();
    $resetCode = generateResetCode($redis);
    return $resetCode;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    $docGiaController = new DocGiaController();
    $docGia = $docGiaController->checkEmail($email);



    if ($docGia) {
        $resetCode = $_SESSION['reset_code'] ?? 0;
        $_SESSION['reset_code'] = $resetCode;
        $_SESSION['reset_email'] = $email;

        var_dump($_SESSION['reset_code']);

        if (sendResetEmail($email, $resetCode)) {
            $_SESSION['success'] = 'Mã xác nhận đã được gửi đến email của bạn.';
            header('Location: ?url=check-code');
            exit();
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại.';
            header('Location: ?url=forgot-password');
            exit();
        }

    } else {
        $_SESSION['error'] = 'Email không tồn tại trong hệ thống.';
        header('Location: ?url=forgot-password');
        exit();
    }
}
?>