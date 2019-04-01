<?php
    $pathfile = "../Archivos/elarchivo.txt";
    $arraytest = array();
    if(file_exists($pathfile))
		{
            $resource = fopen($pathfile,"r");
            while(!feof($resource))
            {
                $datosAlumno = fgets($resource);
                echo "<br>";
                var_dump($datosAlumno);
                //echo "<br>";
                //$arraytest = explode(",",$datosAlumno);
                //echo "<br>";
                //var_dump($arraytest);
                echo "<br>";
                array_push($arraytest,$datosAlumno);
                var_dump($arraytest);
                }
            }
                
			fclose($resource);
        
?>