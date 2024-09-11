<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keyword = $_POST['keyword'];
    $docGiaController = new DocGiaController();

    $docGias = $docGiaController->searchDocGia($keyword);

    echo json_encode($docGias);
}
