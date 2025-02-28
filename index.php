<?php
// include 'src/Routes.php';
use Ollyo\Task\Routes;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helper.php';
require 'config.php';
use YourNamespace\Controllers\PaymentController; // Update this to match your namespace

// Initializing the secret key
\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

define('BASE_PATH', dirname(__FILE__));
define('BASE_URL', baseUrl());

$products = [
    [
        'name' => 'Minimalist Leather Backpack',
        'image' => BASE_URL . '/resources/images/backpack.webp',
        'qty' => 1,
        'price' => 120,
    ],
    [
        'name' => 'Wireless Noise-Canceling Headphones',
        'image' => BASE_URL . '/resources/images/headphone.jpg',
        'qty' => 1,
        'price' => 250,
    ],
    [
        'name' => 'Smart Fitness Watch',
        'image' => BASE_URL . '/resources/images/watch.webp', 
        'qty' => 1,
        'price' => 199,
    ],
    [
        'name' => 'Portable Bluetooth Speaker',
        'image' => BASE_URL . '/resources/images/speaker.webp',
        'qty' => 1,
        'price' => 89,
    ],
];
$shippingCost = 10;

$data = [
    'products' => $products,
    'shipping_cost' => $shippingCost,
    'address' => [
        'name' => 'Sherlock Holmes',
        'email' => 'sherlock@example.com',
        'address' => '221B Baker Street, London, England',
        'city' => 'London',
        'post_code' => 'NW16XE',
    ]
];

// default route
Routes::get('/', function () {
    return view('app', []);
});

Routes::get('/checkout', function () use ($data) {
    return view('checkout', $data);
});

// Checkout route
Routes::post('/checkout', function ($request) use ($products) {

    // @todo: Implement PayPal payment gateway integration here
//     // 1. Initialize PayPal API client with credentials
//     // 2. Create payment with order details from $data
//     // 3. Execute payment and handle response
//     // 4. If payment successful, save order and redirect to thank you page
//     // 5. If payment fails, redirect to error payment page with message

//     // Consider creating a dedicated controller class to handle payment processing
//     // This helps separate payment logic from routing and keeps code organized

    $paymentController = new PaymentController();
    $totalAmount = 0;

    // Calculate total amount from products
    foreach ($products as $product) {
        $totalAmount += $product['price'] * $product['quantity'];
    }

    // Process payment with the calculated total amount
    $charge = $paymentController->processPayment($request, $totalAmount);

    // Handle the response
    if (isset($charge['error'])) {
        // Payment failed
        header("Location: failure.php?errorMessage=" . urlencode($charge['error']));
        exit;
    } else {
        // Payment was successful
        // Verify the payment
        $verificationResult = $paymentController->verifyPayment($charge, $totalAmount);
        
        if (isset($verificationResult['error'])) {
            // Verification failed
            header("Location: failure.php?errorMessage=" . urlencode($verificationResult['error']));
            exit;
        }

        // Prepare order details
        $orderData = [
            'products' => $products,
            'totalAmount' => $totalAmount,
            'currency' => 'usd',
        ];

        // Save the order
        $paymentController->saveOrder($orderData, $charge->id);

        // Redirect to success page
        header("Location: success.php?transactionId=" . $charge->id);
        exit;
    }
});

// Route for payment success callback
Routes::get('/payment-success', function () {
    return view('success');
});

// Route for payment failure callback
Routes::get('/payment-failure', function () {
    return view('failure');
});

// Route for payment verification (if needed)
Routes::get('/payment-verification', function () {
    if (isset($_GET['transactionId'])) {
        $transactionId = $_GET['transactionId']; // Get the transaction ID from the request
        $paymentController = new PaymentController();
        
        // Verify the transaction with Stripe
        $charge = $paymentController->verifyTransaction($transactionId);
        
        if (isset($charge['error'])) {
            // Handle error
            return view('verification', ['error' => $charge['error']]);
        } else {
            // Payment verification successful
            return view('verification', ['charge' => $charge]);
        }
    } else {
        // No transaction ID provided
        return view('verification', ['error' => 'No transaction ID provided.']);
    }
});

// Route for order confirmation (if needed)
Routes::get('/order-confirmation', function () {
    session_start(); // Start the session if not already started
    if (isset($_SESSION['orderData'])) {
        $orderData = $_SESSION['orderData']; // Retrieve order data from session
        return view('order-confirmation', ['orderData' => $orderData]);
    } else {
        return view('order-confirmation', ['error' => 'No order details found.']);
    }

});

// Register thank you & payment failed routes with corresponding views here.

$route = Routes::getInstance();
$route->dispatch();
?>
