<?php

if (!isset($_SESSION['admin'])) {
    header('Location: ?url=login');
    exit();
}


$dangKyMuonController = new DangKyMuonController();

if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
    $dsDangKyMuon = $dangKyMuonController->searchDanhSachChoDuyet($keyword);
    $_SESSION['search_results'] = $dsDangKyMuon;
    $_SESSION['search_keyword'] = $keyword;
    header('Location: ?url=admin/quanlydangkymuon');
    exit();
}
?>
