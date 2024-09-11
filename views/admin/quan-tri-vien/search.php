<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keyword = $_POST['keyword'];
    $quanTriVienController= new QuanTriVienController();

    $docGias = $quanTriVienController->searchDocGia($keyword);

    echo json_encode($docGias);
}