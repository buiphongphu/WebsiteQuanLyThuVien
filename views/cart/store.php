<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $bookId = $data['bookId'];
    $quantity = $data['quantity'];

    // Initialize cart if not already done
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add or update book in the cart
    if (isset($_SESSION['cart'][$bookId])) {
        $_SESSION['cart'][$bookId] += $quantity;
    } else {
        $_SESSION['cart'][$bookId] = $quantity;
    }

    echo json_encode(['success' => true]);
    exit();
}
?>

