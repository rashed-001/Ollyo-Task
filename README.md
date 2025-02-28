# Ollyo-Task
This is for solving the task of Ollyo given in PHP Dev position as day long assessment

# PHP Shopping Cart Checkout System

## Overview
This project implements a simple checkout system with Stripe payment gateway integration using vanilla PHP (no frameworks). The system processes a predefined cart of products through Stripe checkout.

## Features
- Product listing with prices
- Stripe payment integration
- Success and failure handling for payments
- Transaction verification

## Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/rashed-001/Ollyo-Task.git
   2. Install Dependencies Make sure you have Composer installed. Then run: composer install

   3. Set Up Configuration Create a config.php file in the root directory and add your Stripe API keys:
   <?php
define('STRIPE_SECRET_KEY', 'your_secret_key'); // Replace with your Stripe secret key
define('STRIPE_PUBLIC_KEY', 'your_public_key'); // Replace with your Stripe public key
   ?>
   I have used mine in config.php file. You can create a new file and add the keys there.

   ## Directory Structure:

   /your-repo
   ├── /src
   │   ├── /Controllers
   │   │   └── PaymentController.php
   │   ├── /Views
   │   │   ├── confirmation.php
   │   │   ├── failure.php
   │   │   └── success.php
   ├── index.php
   ├── config.php
   └── composer.json

## Usage
Start the Server Use a local server to run your PHP application. You can use the built-in PHP server:
bash

php -S localhost:5000
I use this localhost, can varries 
Access the Application Open your web browser and navigate to:
http://localhost:5000
Checkout Process

Select products and click the "Pay Now" button.
You will be redirected to the Stripe payment form.
After completing the payment, you will be redirected to either the success page or the failure page based on the payment outcome.
PaymentController Class


## The PaymentController class handles the payment logic:

createPayment($amount, $currency, $token): Creates a payment charge using Stripe.
processPayment($request): Processes the payment and redirects to success or failure based on the result.
verifyTransaction($transactionId): Verifies a transaction with Stripe.


## Success and Failure Handling
success.php: Displays a confirmation message and the transaction ID upon successful payment.
failure.php: Displays an error message if the payment fails.

## Testing:
Use Stripe's test card numbers to simulate payments during development. Ensure that your application handles both success and failure scenarios correctly.

Conclusion
This project demonstrates a basic implementation of a shopping cart checkout system using Stripe for payment processing. You can extend the functionality by adding more features such as product management, user authentication, and order history.

Thank you!
