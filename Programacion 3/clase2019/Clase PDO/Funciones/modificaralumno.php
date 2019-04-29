<?php   
    include_once "../Clases/alumno.php";

    $alumnoLeido = json_decode(file_get_contents("php://input"), true);

    
    $alumnosTxt = Alumno::traerAlumnosArchivo("elarchivo.txt");
    $alumnosJson = Alumno::traerAlumnosArchivo("json.json");
    $arrayModificadoTxt = array();
    $arrayModificadoJson = array();
    $alumnoEncontradoJson = false;
    $alumnoEncontradoTxt = false;
    foreach($alumnosJson as $auxAlumno)
    {
        if($auxAlumno->legajo == $alumnoLeido['legajo'])
        {
            $auxAlumno->nombre = $alumnoLeido['nombre'];
            $auxAlumno->edad = $alumnoLeido['edad'];
            $auxAlumno->dni = $alumnoLeido['dni'];
            $alumnoEncontradoJson = true;
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

    foreach($alumnosTxt as $auxAlumno)
    {
        $alumnoArchInt = (int)$auxAlumno->legajo;
        $alumnoLeidoInt = (int)$alumnoLeido['legajo'];
        if($alumnoArchInt == $alumnoLeidoInt)
        {
            $auxAlumno->nombre = $alumnoLeido['nombre'];
            $auxAlumno->dni = $alumnoLeido['dni'];
            $auxAlumno->edad = $alumnoLeido['edad'];
            $alumnoEncontradoTxt = true;
        }
        array_push($arrayModificadoTxt,$auxAlumno);
    }

    if($alumnoEncontradoTxt == true)
    {
        unlink("../Archivos/elarchivo.txt");
        foreach($arrayModificadoTxt as $auxAlumno)
        {
            $auxAlumno->guardarAlumno("../Archivos/elarchivo.txt");
        }
    }

        

    

?>