<?php
use google\appengine\api\log\LogService;
include_once "config.php";

$file_name = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
$content_type = null;
if ($file_name) {
	$file_data = file_get_contents('php://input');
	$pos = strpos($file_data, "base64");
	if ($pos) {
		$content_type = substr($file_data, 5, $pos-6);
		$file_data =  base64_decode(substr($file_data, $pos + 7));
	}
	if ($google_app_engine) {
		$content_type = $_SERVER['CONTENT_TYPE'];
		$ctx = stream_context_create(['gs'=>['acl'=>'public-read','Content-Type' => $content_type]]);
		file_put_contents($file_storage_path.$file_name, $file_data, 0, $ctx);
	} else {
		file_put_contents($file_storage_path.$file_name, $file_data);
	}
}	
?>