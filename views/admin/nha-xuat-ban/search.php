<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keyword = $_POST['keyword'];
    $nhaXuatBanController= new NhaXuatBanController();
    $nxb= $nhaXuatBanController->search($keyword);

    echo json_encode($nxb);
}
