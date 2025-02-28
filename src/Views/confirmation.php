<?php
// order-confirmation.php
if (isset($error)) {
    echo "<h1>Order Confirmation Error</h1>";
    echo "<p>Error: " . htmlspecialchars($error) . "</p>";
} else {
    echo "<h1>Order Confirmation</h1>";
    echo "<p>Thank you for your order!</p>";
    echo "<h2>Order Details:</h2>";
    echo "<ul>";
    foreach ($orderData['products'] as $product) {
        echo "<li>" . htmlspecialchars($product['name']) . " - " . htmlspecialchars($product['quantity']) . " x $" . htmlspecialchars($product['price'] / 100) . "</li>";
    }
    echo "</ul>";
    echo "<p>Total Amount: $" . htmlspecialchars($orderData['totalAmount'] / 100) . "</p>";
}
?>