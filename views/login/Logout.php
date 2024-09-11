<?php

session_start();

$_SESSION = array();
session_destroy();

if (isset($_COOKIE['user'])) {
    setcookie('user', '', time() - 3600, '/');
}

if (isset($_COOKIE['admin'])) {
    setcookie('admin', '', time() - 3600, '/');
}

header('Location: ?url=login');
exit();

?>
