<?php

require __DIR__ . '/vendor/autoload.php';

$stripeKey = getenv("STRIPE_KEY");

\Stripe\Stripe::setApiKey($stripeKey);

// Create a customer
$customer = \Stripe\Customer::create(
  [
    "description" => "Test customer",
    'source' => [
      'object' => 'card',
      'exp_month' => 12,
      'exp_year' => 2018,
      'number' => 4242424242424242,
      'cvc' => 123
    ]
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
