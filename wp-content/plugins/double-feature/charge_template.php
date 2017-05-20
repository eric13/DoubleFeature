<?php

// Allow access via plugin
require_once($_SERVER['DOCUMENT_ROOT']."/wp-load.php");

// Set your secret key: remember to change this to your live secret key in production
// See your keys here: https://dashboard.stripe.com/account/apikeys
\Stripe\Stripe::setApiKey("SECRETKEY");

// Get the credit card details submitted by the form
$token = $_POST['token'];

// Create a charge: this will charge the user's card
try {
  $charge = \Stripe\Charge::create(array(
	"amount" => 999, // Amount in cents
	"currency" => "usd",
    "source" => $token,
    "description" => "Double Feature"
	));
} catch(\Stripe\Error\Card $e) {
  // The card has been declined
}

?>
