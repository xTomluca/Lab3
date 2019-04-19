<?php

$file = $_FILES['archivo'];

var_dump($file);

$filetmpname = $file["tmp_name"];
$filename = $file["name"];

move_uploaded_file($filetmpname,"./fotos/$filename");
var_dump($filename);

?>