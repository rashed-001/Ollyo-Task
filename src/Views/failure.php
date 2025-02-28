<?php
// failure.php
if (isset($_GET['errorMessage'])) {
    $errorMessage = htmlspecialchars($_GET['errorMessage']);
} else {
    $errorMessage = 'An unknown error occurred.';
}
?>

<h1>Order Failed</h1>
<p>We're sorry, but your order could not be processed.</p>
<p>Error Message: <?php echo $errorMessage; ?></p>
<p><a href="javascript:history.back()">Try Again</a></p>