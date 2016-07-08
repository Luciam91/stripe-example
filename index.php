<?php

require __DIR__ . '/vendor/autoload.php';

$stripeKey = getenv("STRIPE_KEY");

\Stripe\Stripe::setApiKey($stripeKey);

// Generate a token
$token = \Stripe\Token::create([
  'card' => [
      'number' => '4242424242424242',
      'exp_month' => 7,
      'exp_year' => 2017,
      'cvc' => '413'
    ]
]);


// Create a customer
$customer = \Stripe\Customer::create(
  [
    "description" => "Test customer",
    'source' => $token->id
  ]
);

// Create a plan
$plan = \Stripe\Plan::create(
  [
    'amount' => 2000,
    'interval' => 'month',
    'name' => 'Amazing Test Plan',
    'currency' => 'gbp',
    'id' => 'amazing-test-plan'
  ]
);

// Add sub to customer
$customer->subscriptions->create(
  [
    'plan' => 'amazing-test-plan'
  ]
);

$cu = \Stripe\Customer::retrieve($customer->id);

$invoices = \Stripe\Invoice::all(
  [
    'customer' => $cu->id
  ]
);

$invoiceIdentifier = $invoices->data[0]->id;

$invoiceFetched = \Stripe\Invoice::retrieve($invoiceIdentifier);

echo 'Invoice ID: ' . $invoiceFetched->id .' - Amount due: ' . number_format($invoiceFetched->amount_due);
