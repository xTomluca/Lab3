<?php
    include_once "../Clases/alumno.php";
    include_once "../Clases/AccesoDatos.php";
    
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $dni = $_POST['dni'];
    //$legajo = $_POST['legajo'];
    $idLocalidad = $_POST['idLocalidad'];

    $alumno = new Alumno($nombre,$edad,$dni,0,$idLocalidad);

    $alumno->InsertarElAlumno();
?>