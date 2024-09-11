<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keyword = $_POST['keyword'];
    $sachController = new SachController();

    $sachs = $sachController->searchSach($keyword);

    echo json_encode($sachs);
}
?>
