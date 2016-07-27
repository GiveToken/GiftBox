<?php
use \Sizzle\Bacon\Database\{
    Organization,
    User,
    UserMilestone
};

date_default_timezone_set('America/Chicago');

$user = null;
$event_type = null;
$response['status'] = "ERROR";
$response['message'] = "Unable to log in at this time.";
$response['app_root'] = '/';

$email = $_POST['login_email'] ?? '';
$login_type = $_POST['login_type'] ?? 'EMAIL';

if ((new User())->exists($email)) {
    $user = (new User())->fetch($email);
    //$expires = $user->active_until ?? date('Y-m-d');
    $expires = date('Y-m-d');
    $DateTime1 = new \DateTime($expires);
    $DateTime2 = new \DateTime(date('Y-m-d'));
    if (0 <= date_diff($DateTime2, $DateTime1)->format('%R%a')) {
        if ($login_type == 'EMAIL') {
            if (!$user->password) {
                $response['status'] = "ERROR";
                $response['message'] = "There is no password set for this account. Please confirm your email before logging in.";
            } else if (!password_verify($_POST['password'] ?? '', $user->password)) {
                $response['status'] = "ERROR";
                $response['message'] = 'The password you entered is incorrect.';
            } else {
                if ($user->activation_key) {
                    $response['status'] = "ERROR";
                    $response['message'] = 'Please confirm email to activate account.';
                } else {
                    $response['status'] = 'SUCCESS';
                    $response['message'] = "Log in with email successful.";
                }
            }
        }
        if ($response['status'] == 'SUCCESS') {
            $_SESSION['user_id'] = $user->id;
            $_SESSION['admin'] = $user->admin;
            $_SESSION['login_type'] = $login_type;
            $_SESSION['app_root'] = '/';
            $_SESSION['app_url'] = APP_URL;
            $_SESSION['email'] = $email;
            if (isset($user->stripe_id)) {
                $_SESSION['stripe_id'] = $user->stripe_id;
            } elseif (isset($user->organization_id)) {
                $org = new Organization($user->organization_id);
                $paying_user = new User($org->paying_user ?? null);
                $_SESSION['stripe_id'] = $paying_user->stripe_id ?? null;
            }
            $UserMilestone = new UserMilestone($user->id, 'Log In');
        }
    } else {
        $response['status'] = "ERROR";
        $response['message'] = "This account is no longer active.";
    }
} else {
    $response['status'] = "ERROR";
    $response['message'] = "The email address \"".$email."\" does not belong to any S!zzle account. Please use the signup button to register!";
}

header('Content-Type: application/json');
echo json_encode($response);
