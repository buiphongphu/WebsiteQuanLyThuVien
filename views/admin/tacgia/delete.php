<?php

$tacGiaController = new TacGiaController();
$tacGiaController->delete($_GET['id']);

header("Location: ?url=admin/quanlytacgia");
?>
