<?php
if ($_SERVER['SERVER_NAME'] == "giftbox.com") {
	$server = "localhost";
	$app_url = "http://giftbox.com";
	$use_google_mail = false;
} else if ($_SERVER['SERVER_NAME'] == "stone-timing-557.appspot.com") {
	$server = "173.194.244.175";
	$app_url = "http://stone-timing-557.appspot.com";
	$use_google_mail = true;
}
$user = "giftbox";
$password = "giftbox";
$database = "giftbox";
$app_root = "/";
$app_name = "Giftbox";
$sender_email = "john_hall@corridor-inc.com";
?>