<?php

include "alumno.php";
//var_dump($_GET);
//var_dump($_POST);
//var_dump($_REQUEST);

$nombre = $_POST['nombre'];
$edad = $_POST['edad'];
$dni = $_POST['dni'];
$legajo = $_POST['legajo'];

$alumnoPost = new alumno($nombre,$edad,$dni,$legajo);
echo $alumnoPost->jsonReturn();
//var_dump($alumnoPost);
?>
