<?php
use Monolog\{
    ErrorHandler,
    Handler\SlackHandler,
    Logger
};
use Sizzle\Bacon\{
    Connection,
    Database\WebRequest
};

// set release version in /version file
define('VERSION', trim(file_get_contents(__DIR__.'/version')));

// autoload classes
require_once __DIR__.'/src/autoload.php';
require_once __DIR__.'/vendor/autoload.php';

//load functions
require_once __DIR__.'/util.php';

// Determine environment & fix URL as needed
$server = $_SERVER['SERVER_NAME'] ?? null;
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'production');
}


// setup Monolog error handler to report to Slack
// this causes a 500 error on AWS (is PHP 7 issue?)
if (!defined('SLACK_TOKEN')) {
    define('SLACK_TOKEN', 'xoxb-17521146128-nHU6t4aSx7NE0PYLxKRYqmjG');
}
$logger = new Logger('bugs');
if (ENVIRONMENT != 'local') {
  if (ENVIRONMENT != 'production') {
      $name = 'Dev Application: '.$_SERVER['REQUEST_URI'];
      $slackHandler = new SlackHandler(SLACK_TOKEN, '#bugs-staging', $name, false);
  } else {
      $name = 'Web Application: '.$_SERVER['REQUEST_URI'];
      $slackHandler = new SlackHandler(SLACK_TOKEN, '#bugs', $name, false);
  }
  $slackHandler->setLevel(Logger::DEBUG);
  $logger->pushHandler($slackHandler);
  ErrorHandler::register($logger);
}

$prefix = "http://";
$use_https = false;
$socket = null;
if (isset($_SERVER['HTTPS'])) {
    if ($_SERVER['HTTPS'] === "on") {
        $prefix = "https://";
        $use_https = true;
    } else {
        if('www.gosizzle.io' == $server) {
            $url = 'https://www.gosizzle.io'.$_SERVER['REQUEST_URI'];
            header("Location: $url ", true, 301);
        }
    }
}
$file_storage_path = 'uploads/';

if (!defined('STRIPE_SECRET_KEY')) {
    define('STRIPE_SECRET_KEY', $stripe_secret_key);
}
if (!defined('STRIPE_PUBLISHABLE_KEY')) {
    define('STRIPE_PUBLISHABLE_KEY', $stripe_publishable_key);
}
if (!defined('FILE_STORAGE_PATH')) {
    define('FILE_STORAGE_PATH', $file_storage_path);
}

if (!defined('APP_URL')) {
    define('APP_URL', $prefix.$server.'/');
}

// start session
session_start();

// record website hit
if (isset($_COOKIE, $_COOKIE['visitor'])) {
    $visitor_cookie = $_COOKIE['visitor'];
} else {
    $visitor_cookie = substr(md5(microtime()), rand(0, 26), 20);
}
