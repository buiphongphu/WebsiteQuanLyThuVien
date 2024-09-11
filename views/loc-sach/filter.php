<?php

$sachController = new SachController();
if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);

    $sachs = $sachController->filterSach($id);

    echo json_encode($sachs);
}
?>
