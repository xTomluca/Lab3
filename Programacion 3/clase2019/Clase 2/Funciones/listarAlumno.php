<?php
    include '../Clases/alumno.php';
    $pathfile = "../Archivos/elarchivo.txt";
    $arraytest = array();
    if(file_exists($pathfile))
	{
        $resource = fopen($pathfile,"r");
        while(!feof($resource))
        {
            $datosAlumno = fgets($resource);
            // var_dump($datosAlumno);
            //echo "<br>";
            //$arraytest = explode(",",$datosAlumno);
            //echo "<br>";
            //var_dump($arraytest);
            array_push($arraytest,$datosAlumno);
            }
        }
        fclose($resource);

        // LE ESTOY PASANDO SOLO TEXTO Y NO ALUMNO
    foreach($arraytest as $alumno)
    {
        $alumno->mostrarAlumno();
    }    
        

    
?>