<?php

require_once '../Clases/alumno.php';
//var_dump($_GET);
//var_dump($_POST);
//var_dump($_REQUEST);

$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$dni = $_POST['dni'];
$legajo = $_POST['legajo'];
$path = $_POST['path'];
$pathjson = $_POST['pathjson'];
$alumnoPost = new alumno($nombre,$edad,$dni,$legajo);

echo $alumnoPost->jsonReturn();
//var_dump($alumnoPost);
$alumnoPost->guardarAlumno($path);
$alumnoPost->guardarAlumnoJson($pathjson);

//------------------------------------------------- FOTOS ----------------------------------////

$file = $_FILES['archivo'];
$filemarca = $_FILES['marca'];

$marca = $filemarca["name"];
$marcatmp = $filemarca["tmp_name"];
var_dump($file);

$filetmpname = $file["tmp_name"];
$filename = $file["name"];
$filecutname=explode(".",$filename);






if(file_exists("./fotos/$filename"))
{
    move_uploaded_file($marcatmp,"./fotos/$marca");
    $margen_dcho = 10;
    $margen_inf = 10;
    $sx = imagesx("./fotos/$marca");
    $sy = imagesy("./fotos/$marca");
    imagecopy($filename, $marca, imagesx($im) 
    - $sx - $margen_dcho, imagesy($filename) - $sy - $margen_inf, 0, 0, imagesx($marca), imagesy($marca));
    $dia = getdate();
    $filecutname=explode(".",$filename);
    $oldpath = "./fotos/$filename";
    var_dump($oldpath);
    $newpath = "./fotosbackup/$filecutname[0]". $dia["mday"]."-". $dia["mon"] . "-" . $dia["year"] . "." .$filecutname[1];
    var_dump($newpath);
    rename($oldpath,$newpath);
    move_uploaded_file($filetmpname,"./fotos/$filename");
}
else
{

    move_uploaded_file($filetmpname,"./fotos/$filename");
}




?>
