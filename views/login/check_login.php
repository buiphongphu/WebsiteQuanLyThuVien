<?php


$loginController = new LoginController();

$email = $_POST['username'];
$password = $_POST['password'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Email không hợp lệ.";
    header('Location: ?url=login');
    exit();
}
$password = md5($password);

$loginController->handleLogin($email, $password);
if (isset($_SESSION['error'])) {
    header('Location: ?url=login');
    exit();
}

$docgia = $loginController->get_docgia($email);
$quantrivien = $loginController->get_quantrivien($email);

?>
