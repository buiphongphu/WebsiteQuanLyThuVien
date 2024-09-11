<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


function sendActivationEmail($toEmail, $activationCode) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'omerasutvail@gmail.com';
        $mail->Password = 'qses fwbc qdxo tkqh';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('your_email@gmail.com', 'Thư viện 2P');
        $mail->addAddress($toEmail);

        $mail->addEmbeddedImage('public/images/2p.png', 'library_logo');

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Mã Kích Hoạt Thẻ Thư Viện';

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
                    <h1>Mã Kích Hoạt Thẻ Thư Viện</h1>
                </div>
                <div class="content">
                    <p>Chào bạn,</p>
                    <p>Mã kích hoạt của bạn là:</p>
                    <p class="code">' . $activationCode . '</p>
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    $theThuVienController = new TheThuVienController();

    $theThuVien = $theThuVienController->layThongTinTheThuVienById($id);


    if ($theThuVien) {
        $email = $theThuVien['Email'];
        $activation_code = $theThuVien['ma_kich_hoat'];


        if (sendActivationEmail($email, $activation_code)) {
            $_SESSION['message'] = 'Mã kích hoạt đã được gửi đến email của bạn.';
            header('Location: ?url=admin/quanlythethuvien');
            exit();
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại.';
            header('Location: ?url=admin/quanlythethuvien');
            exit();
        }
    } else {
        $_SESSION['error'] = 'Không tìm thấy người dùng!';
        header('Location: ?url=admin/quanlythethuvien');
        exit();
    }
}
?>
