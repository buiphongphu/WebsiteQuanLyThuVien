<?php

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $keyword = $_POST['keyword'];
       $tacGiaController = new TacGiaController();

         $tacGias = $tacGiaController->searchTacGia($keyword);

            echo json_encode($tacGias);

}
