<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keyword = $_POST['keyword'];
    $dauSachController = new DauSachController();

    $dauSachs = $dauSachController->searchDauSach($keyword);

    echo json_encode($dauSachs);
}
?>
