<?php
// success.php
if (isset($_GET['transactionId'])) {
    $transactionId = htmlspecialchars($_GET['transactionId']);
} else {
    $transactionId = 'Unknown';
}
?>

<h1>Order Confirmation</h1>
<p>Thank you for your order!</p>
<p>Transaction ID: <?php echo $transactionId; ?></p>
<p>Your order has been successfully processed.</p>