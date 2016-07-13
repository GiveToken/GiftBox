<?php
use Sizzle\Scraper;

$glassdoor = new Scraper();

if (isset($_POST['link']) && !empty($_POST['link'])) {
  $glassdoor->write_json($_POST['link'], 'glassdoor');
}

if (isset($_POST['clear']) && !empty($_POST['clear'])) {
  $images = array('uploads/glassdoor');
  $glassdoor->clear_images($_POST['clear'], $images);
}

$old_name = isset($_POST['oldName']) && !empty($_POST['oldName']);
$new_name = isset($_POST['newName']) && !empty($_POST['newName']);

if ($old_name && $new_name) {
  $glassdoor->update_image_names();
}

echo json_encode(
  array(
    'success'=>$glassdoor->getSuccess(),
    'data'=>$glassdoor->getData(),
    'key'=>$glassdoor->getUniqueKey()
  )
);

?>
