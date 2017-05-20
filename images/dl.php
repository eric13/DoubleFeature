<?php
$file = $_GET['f'];
header ("Content-type: audio/m4a");
header ("Content-disposition: attachment; filename=".$file.";");
header("Content-Length: ".filesize($file));
$file = "http://media.blubrry.com/doublefeature/media.doublefeature.fm/".$file;
readfile($file);
exit;
?>
