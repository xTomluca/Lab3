<?php

include_once "../Clases/alumno.php";

$alumnoaEliminar = json_decode(file_get_contents("php://input"), true);

    
//$alumnosTxt = Alumno::traerAlumnosArchivo("elarchivo.txt");
$alumnosJson = Alumno::traerAlumnosArchivo("json.json");


$arrayModificadoTxt = array();
$arrayModificadoJson = array();
$alumnoEncontradoJson = false;
$alumnoEncontradoTxt = false;

foreach($alumnosJson as $auxAlumno)
{
    $auxAlumno->mostrarAlumno();
    if($auxAlumno->legajo == $alumnoaEliminar['legajo'])
    {
        echo "Se borrara el alumno </br>";
        $auxAlumno->mostrarAlumno();
        $alumnoEncontradoJson = true;
        continue;
    }
    array_push($arrayModificadoJson,$auxAlumno);   
}

if($alumnoEncontradoJson == true)
{
    unlink("../Archivos/json.json");
    foreach($arrayModificadoJson as $auxAlumno)
    {
        $auxAlumno->guardarAlumnoJson("../Archivos/json.json");
    }
}




?>