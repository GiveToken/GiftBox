<?php
use Sizzle\Bacon\Database\{
    RecruitingCompanyImage
};

$success = 'false';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (isset($_POST['id'])) {
        $image = new RecruitingCompanyImage($_POST['id']);
        if (isset($image->recruiting_company_id)) {
            $allImages = $image->getByCompanyId($image->recruiting_company_id);
            foreach ($allImages as $img) {
                $omg = new RecruitingCompanyImage($img['id']);
                $omg->unmarkLogo();
            }
            $success = $image->markLogo() ? 'true' : 'false';
        }
    }
}
header('Content-Type: application/json');
echo json_encode(array('success'=>$success));
