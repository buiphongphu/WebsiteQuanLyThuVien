<?php
if (isset($_GET['url']) && $_GET['url'] === 'admin/quanlythethuvien/print') {
$id = $_GET['id'];
$controller = new TheThuVienController();
$controller->printCard($id);
}
