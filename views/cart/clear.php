<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Clear the entire cart
    unset($_SESSION['cart']);
    echo json_encode(['success' => true]);
    exit();
}

echo json_encode(['success' => false]);
exit();
?>
