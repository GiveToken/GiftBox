<?php
namespace Sizzle;

/**
 * This class is for scraping
 */
class Scraper {

  public $success = false;
  public $data = null;
  public $uniqueKey = null;

  public function generate_key($length) {
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
      $string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $string;
  }

  public function write_json($post, $name) {
    $url = $post;
    if (filter_var($url, FILTER_VALIDATE_URL)) {
      // generate key for collision protection
      $key = $this->generate_key(10);

      // write url to temp JSON file
      $fname = $name . '-' . $key . '.json';
      $fp = fopen('uploads/' . $fname, 'w+');
      fwrite($fp, json_encode(array('url'=>$url)));
      fclose($fp);

      $params = $name . ' ' . $fname;
      $command = 'cd .. ; cd ajax/scraper ; sh run.sh ' . $params;
      $this->data = shell_exec($command);
      $this->success = true;
      $this->uniqueKey = $key;
    }
  }

  public function clear_images($post, $images) {
    $key = $post;
    $this->success = true;
    if ($key == 'refresh') {
      $files = scandir('uploads/');
      for ($i = 0; $i < sizeof($files); $i++) {
        if (preg_match('/^[A-Za-z]+/', $files[$i])
            && strpos($files[$i], '.png') !== false) {
          $f = 'uploads/' . (string)$files[$i];
          unlink($f);
        }
      }
    } else {
      for ($i = 0; $i < sizeof($images); $i++) {
        $image = (string)$images[$i] . '-' . $key . '.png';
        if (file_exists($image)) {
          unlink($image);
        }
      }
    }
  }

  public function update_image_names() {
    $old_name = isset($_POST['oldName']) && !empty($_POST['oldName']);
    $new_name = isset($_POST['newName']) && !empty($_POST['newName']);

    if ($old_name && $new_name) {
      $old_image = $_POST['oldName'];
      $new_image = $_POST['newName'];

      // rename the images for database
      if (file_exists('uploads/' . $old_image)) {
        rename('uploads/' . $old_image, 'uploads/' . $new_image);
      }

      $this->success = true;
    }
  }

  public function getSuccess() {
    return $this->success;
  }

  public function getData() {
    return $this->data;
  }

  public function getUniqueKey() {
    return $this->uniqueKey;
  }

}
