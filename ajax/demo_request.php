<?php
use Sizzle\Bacon\Database\{
    Support
};
use Sizzle\Bacon\Service\MandrillEmail;

$status = 'ERROR';
if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $vars = array('email');
    foreach ($vars as $var) {
        $$var = $_POST[$var] ?? '';
    }
    $subject = "New demo request from {$email}";
    if (ENVIRONMENT != 'production') {
        $to = TEST_EMAIL;
    } else {
        $to = 'sales@GoSizzle.io';
    }
    $mandrill = new MandrillEmail();
    $mandrill->send(
        array(
            'to'=>array(array('email'=>$to)),
            'from_email'=>'demo.request@GoSizzle.io',
            'from_name'=>'S!zzle Demo Request',
            'subject'=>$subject,
            'html'=>$subject,
            'headers'=>array('Reply-To'=>$email)
        )
    );
    $status = 'SUCCESS';
    if (isset($_SESSION['landing_page']['id'], $_SESSION['landing_page']['script'])) {
        $message = $subject." on landing page {$_SESSION['landing_page']['id']}";
        $message .= " ({$_SESSION['landing_page']['script']}).";
    } elseif (isset($_SESSION['landing_page']['demo_request']['script'], $_SESSION['landing_page']['demo_request']['id'])) {
        $message = $subject." on landing page {$_SESSION['landing_page']['demo_request']['id']}";
        $message .= " ({$_SESSION['landing_page']['demo_request']['script']}).";
    } elseif (isset($_SESSION['landing_page']['learn_more']['script'], $_SESSION['landing_page']['learn_more']['id'])) {
        $message = $subject." on landing page {$_SESSION['landing_page']['learn_more']['id']}";
        $message .= " ({$_SESSION['landing_page']['learn_more']['script']}).";
    }
    (new Support())->create($email, $message ?? $subject);
}
header('Content-Type: application/json');
echo json_encode(array('status' => $status));

?>
