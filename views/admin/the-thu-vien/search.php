<?php


if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}

$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';

$theThuVienController = new TheThuVienController();
$dsTheThuVien = $theThuVienController->timKiemTheThuVien($keyword);

$_SESSION['search_results'] = $dsTheThuVien;
$_SESSION['search_keyword'] = $keyword;

header('Location: ?url=admin/quanlythethuvien');
exit();
