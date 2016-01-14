<?php
use \GiveToken\EventLogger;
use \GiveToken\Service\GoogleMail;

$email_address = $_POST["email"];
$preview_link = $_POST["preview-link"];
$event = EventLogger::SEND_GIFTBOX;
$user_id = $_SESSION["user_id"];

$event = new EventLogger($user_id, $event);
$event->log();

// Send the email
$message = '<a href="'.$preview_link.'">Click here to open your Token!</a>';
$GoogleMail = new GoogleMail();
$GoogleMail->sendMail($email_address, 'You have a Token to open!!!', $message, $sender_email);
?>
