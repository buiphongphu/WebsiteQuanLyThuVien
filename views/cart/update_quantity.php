<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['bookId']) && isset($data['quantity'])) {
        $bookId = $data['bookId'];
        $quantity = $data['quantity'];

        if (isset($_SESSION['cart'][$bookId]) && $quantity > 0) {
            $_SESSION['cart'][$bookId] = $quantity;
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        exit();
    }
}
?>
