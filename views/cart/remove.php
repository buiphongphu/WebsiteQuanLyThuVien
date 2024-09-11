<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['bookId'])) {
        $bookId = $data['bookId'];

        // Remove a single book from the cart
        if (isset($_SESSION['cart'][$bookId])) {
            unset($_SESSION['cart'][$bookId]);
        }

        echo json_encode(['success' => true]);
        exit();
    }
}

echo json_encode(['success' => false]);
exit();
?>
