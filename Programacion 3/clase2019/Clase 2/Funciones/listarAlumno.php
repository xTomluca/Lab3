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
    //foreach($arraytest as $alumno)
   /// {
     ///   $alumno->mostrarAlumno();
    ///}    
       
    
    
    /*try
        {

        $db = new PDO('mysql:host=localhost;dbname=alumnos;charset=utf8', 'root', '', array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        $sql = $db->query('SELECT a.nombre,a.edad,a.dni,a.legajo,a.idLocalidad FROM alumno as a');

                          
        $catidadFilas = $sql->rowCount();


        echo "Cantidad de filas: ".$catidadFilas."<br>";

        $resultado = $sql->fetchall();           
                          
        foreach($resultado as $fila)
        {
            
            echo "Nombre: ".$fila[0];             
            echo " -- Edad: ".$fila[1];
            echo " -- Dni: ". $fila[2];
            echo " -- Legajo: ".$fila[3];
            echo " -- Id Localidad: ".$fila[4].'<br />';
        }          
         
        } 
        catch(PDOException $ex)
        {
            echo "error ocurrido!"; 
            echo $ex->getMessage();
        }*/
    
?>