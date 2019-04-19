<?php
    include '../Clases/alumno.php';

    /*function traerAlumnosArchivo($nombreArchivo)
	{
		$pathfile = "../Archivos/".$nombreArchivo;
        $arrayAlumnos = array();

        if(file_exists($pathfile))
        {
            $resource = fopen($pathfile,"r");
            while(!feof($resource))
            {
                $datosAlumno = explode(",",fgets($resource));
                $auxAlumno = new Alumno($datosAlumno[0],$datosAlumno[1],$datosAlumno[2],$datosAlumno[3]);
                array_push($arrayAlumnos,$auxAlumno);
            }
        }
        fclose($resource);
        return $arrayAlumnos;
	}*/

    function traerAlumnosArchivo($nombreArchivo)
	{
		$pathfile = "../Archivos/".$nombreArchivo;
        $arrayAlumnos = array();

        if(file_exists($pathfile))
        {
            $extArchivo = explode(".",$nombreArchivo);
            if(strcmp($extArchivo[1],"txt") ==0)
            {
                $resource = fopen($pathfile,"r");
                while(!feof($resource))
                {
                    $datosAlumno = explode(",",fgets($resource));
                    $auxAlumno = new Alumno($datosAlumno[0],$datosAlumno[1],$datosAlumno[2],$datosAlumno[3]);
                    array_push($arrayAlumnos,$auxAlumno);
                }
            }
            else if(strcmp($extArchivo[1],"json") ==0)
            {
                $resource = fopen($pathfile,"r");
                while(!feof($resource))
                {
                    $jsonDatos = json_decode(fgets($resource));
                    if($jsonDatos == NULL){}
                    else
                    {
                        $arrayJson = ((array)$jsonDatos);
                        $auxAlumno = new Alumno($arrayJson["nombre"],$arrayJson["edad"],$arrayJson["dni"],$arrayJson["legajo"]);
                        array_push($arrayAlumnos,$auxAlumno);
                    }
                }
            }
        }
        fclose($resource);
        return $arrayAlumnos;
	}
    function mostrarTodosLosAlumnosArchivo($arrayAlumnos)
    {
        foreach($arrayAlumnos as $auxAlumno)
        {
            $auxAlumno->mostrarAlumno();
        }
    }

    echo "<b>DESDE ARCHIVO</b> </br></br>";
    //Muestro todos los alumnos desde archivo
    mostrarTodosLosAlumnosArchivo(traerAlumnosArchivo("elarchivo.txt"));

    echo "<b>DESDE ARCHIVO JSON</b> </br></br>";
    mostrarTodosLosAlumnosArchivo(traerAlumnosArchivo("json.json"));
    echo "<b>DESDE SQL</b> </br></br>";

    $Alumno = new Alumno();
    $resultado = $Alumno->TraerTodoLosCds();
    //var_dump($resultado);
    foreach($resultado as $unAlumno)
    {
        $unAlumno->mostrarAlumno();
   }

?>