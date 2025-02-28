<?php

namespace YourNamespace\Controllers; // Update this to match your namespace

use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Exception\CardException;

class PaymentController
{
    public function __construct()
    {
        Stripe::setApiKey(STRIPE_SECRET_KEY);
    }

    public function createPayment($amount, $currency, $token)
    {
        try {
            $charge = Charge::create([
                'amount' => $amount,
                'currency' => $currency,
                'description' => 'Payment for order',
                'source' => $token,
            ]);
            return $charge;
        } catch (CardException $e) {
            // Handle error
            return ['error' => $e->getMessage()];
        }
    }

    public function processPayment($request, $totalAmount)
    {
        $currency = 'usd';
        $token = $request['stripeToken']; // Get the token from the request

        $charge = $this->createPayment($totalAmount, $currency, $token);
        
        if (isset($charge['error'])) {
            // Handle failure
            return ['error' => $charge['error']];
        } else {
            // Payment was successful
            return $charge;
        }
    }

    public function verifyPayment($charge, $expectedAmount)
    {
        // Verify payment amount matches cart total
        if ($charge->amount !== $expectedAmount) {
            return ['error' => 'Payment amount does not match the expected total.'];
        }
    
        // Check payment status
        if ($charge->status !== 'succeeded') {
            return ['error' => 'Payment was not successful.'];
        }
    
        // Validate transaction ID (this could be additional logic as needed)
        return $charge; // Return the charge object if everything is valid
    }
    public function saveOrder($orderData, $transactionId)
    {
        // Implement your database logic here to save the order
        // Example: Insert into orders table with $orderData and $transactionId
    }
}