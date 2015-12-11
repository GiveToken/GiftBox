<?php
use \GiveToken\User;
use \GiveToken\EventLogger;

date_default_timezone_set('America/Chicago');

require_once __DIR__.'/../vendor/stripe/stripe-php/init.php';

$response['status'] = "ERROR";
$response['message'] = "Unable to upgrade at this time.";

// See your keys here https://dashboard.stripe.com/account
\Stripe\Stripe::setApiKey($stripe_secret_key);

// Get the credit card details submitted by the form
$token = $_POST['stripeToken'];
$email = $_POST['email'];
$new_level = $_POST['newLevel'];
$plan = $_POST['plan'];

// Retrieve the GiveToken user recored
$user = User::fetch($email);

try {
    // Create the customer with a plan, this will also charge the customer
    $customer = \Stripe\Customer::create(
        array(
        "source" => $token,
        "plan" => $plan,
        "email" => $email)
    );

    $response['status'] = "SUCCESS";
    $response['message'] = 'Successful upgrade';
} catch(Exception $e) {
    $response['status'] = "ERROR";
    $response['message'] = "Stripe error: ". $e->getMessage();
}

if ($response['status'] == "SUCCESS") {
    $active_until = new DateTime("now");
    $active_until->add(new DateInterval("P1M"));

    // Update the user properties
    $user->level = $new_level;
    $user->stripe_id = $customer->id;
    $user->active_until = $active_until->format("Y-m-d");

    // Save the user
    $user->save();

    // Log an event
    $event = new EventLogger($user->getId(), EventLogger::UPGRADE, 'Stripe Token: '.$token);
    $event->log();

    // Set the session variables
    if (isset($_SESSION['level'])) {
        $_SESSION['level'] = $new_level;
    }
    $_SESSION['strip_id'] = $customer->id;
}

header('Content-Type: application/json');
echo json_encode($response);
