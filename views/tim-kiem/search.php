<?php

$sachController = new SachController();

if (isset($_GET['q'])) {
    $keyword = htmlspecialchars($_GET['q']);

    $sachs = $sachController->searchSach($keyword);

    echo json_encode($sachs);
}
?>
