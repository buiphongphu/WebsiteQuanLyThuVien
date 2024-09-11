<?php


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

if (!isset($_POST['action']) || !isset($_POST['bookId']) || !isset($_SESSION['user'])) {
    http_response_code(400);
    exit('Missing parameters');
}

$action = $_POST['action'];
$bookId = $_POST['bookId'];
$userId = $_SESSION['user']['Id'];

$yeuThichSach= new YeuThichSachController();

$yeuThichSach->delete($bookId, $userId);

$response = array('success' => true, 'message' => 'Đã xóa sách khỏi danh sách yêu thích.');

header('Content-Type: application/json');
echo json_encode($response);
header('Location: ?url=index');
exit;
?>

