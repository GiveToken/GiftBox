<?php

$success = false;
$data = null;

function generate_key($length) {
  $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
  $string = '';
  for ($i = 0; $i < $length; $i++) {
    $string .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $string;
}

if (isset($_POST['clear']) && !empty($_POST['clear'])) {
  $key = $_POST['clear'];
  $success = true;
  if (file_exists('uploads/glassdoor-' . $key . '.png')) {
    unlink('uploads/glassdoor-' . $key . '.png');
  }
}

if (isset($_POST['link']) && !empty($_POST['link'])) {
  $url = $_POST['link'];
  // this url is from glassdoor's API not user input
  if (filter_var($url, FILTER_VALIDATE_URL)) {
    $key = generate_key(10);

    $fname = 'tempurl-' . $key . '.json';
    $fp = fopen('uploads/' . $fname, 'w+');
    fwrite($fp, json_encode(array('url'=>$url)));
    fclose($fp);

    // shell_exec takes no POST variables
    $command = 'cd .. ; cd ajax/scraper ; sh glassdoor.sh ' . $key;
    $data = shell_exec($command);

    $success = true;
    $data = $key;
  }
}

$old_name = isset($_POST['oldName']) && !empty($_POST['oldName']);
$new_name = isset($_POST['newName']) && !empty($_POST['newName']);

if ($old_name && $new_name) {
  $old_image = $_POST['oldName'];
  $new_image = $_POST['newName'];

  // rename the images for database
  if (file_exists('uploads/' . $old_image)) {
    rename('uploads/' . $old_image, 'uploads/' . $new_image);
  }

  $success = true;
}

echo json_encode(array('success'=>$success, 'data'=>$data));

?>
